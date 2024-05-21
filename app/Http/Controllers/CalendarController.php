<?php

namespace App\Http\Controllers;

use App\Models\CardObjectMain;
use App\Models\HistoryCardCalendar;
use Carbon\Carbon;
use Illuminate\Http\Request;
use DaveJamesMiller\Breadcrumbs\Facades\Breadcrumbs;
use App\Models\CardCalendar;
use Illuminate\Support\Facades\Auth;

//контроллер для отображения данных на страницы
class CalendarController extends Controller
{

    public function reestrCalendarView()
    {
        // Получаем текущего пользователя
        $currentUser = Auth::user();

        // Проверяем, авторизован ли пользователь
        if ($currentUser) {
            // Получаем роль текущего пользователя
            $userRole = $currentUser->role;

            // Получаем календари с их объектами и сервисами
            $calendars = CardCalendar::with('objects.services')->get();

            // Создаем массив для хранения всех данных
            $formattedCalendars = [];

            foreach ($calendars as $cardCalendar) {
                // Проходим по каждому объекту в коллекции объектов
                foreach ($cardCalendar->objects as $object) {
                    // Инициализируем флаг для добавления объекта
                    $shouldAddObject = false;

                    // Проверяем роль текущего пользователя и фильтруем записи соответствующим образом
                    if ($userRole == 'executor') {
                        // Проверяем, если текущий пользователь исполнитель
                        foreach ($object->services as $service) {
                            if ($service->performer == $currentUser->name) {
                                $shouldAddObject = true;
                                break;
                            }
                        }
                    } elseif ($userRole == 'responsible') {
                        // Проверяем, если текущий пользователь ответственный
                        foreach ($object->services as $service) {
                            if ($service->responsible == $currentUser->name) {
                                $shouldAddObject = true;
                                break;
                            }
                        }
                    } elseif ($userRole == 'curator' || $userRole == 'admin') {
                        // Если текущий пользователь куратор или администратор, добавляем все объекты
                        $shouldAddObject = true;
                    }

                    // Если объект должен быть добавлен, формируем данные для одного объекта инфраструктуры и его сервисов
                    if ($shouldAddObject) {
                        $shortNames = $object->services->pluck('short_name')->toArray();
                        $formattedCalendar = [
                            'id' => $cardCalendar->id,
                            'infrastructure' => $object->infrastructure,
                            'name' => $object->name,
                            'number' => $object->number,
                            'location' => $object->location,
                            'short_name' => implode(', ', $shortNames),
                            'year' => $cardCalendar->year,
                            'date_create' => $cardCalendar->date_create,
                            'date_archive' => $cardCalendar->date_archive,
                            'curator' => $object->curator,
                        ];

                        // Добавляем данные объекта к массиву с отформатированными данными
                        $formattedCalendars[] = $formattedCalendar;
                    }
                }
            }

            return response()->json($formattedCalendars);
        }

        // Если пользователь не авторизован, возвращаем пустой ответ или сообщение об ошибке
        return response()->json([], 403);
    }


    public function create($id)
    {
        // Находим выбранный CardObjectMain
        $cardObjectMain = CardObjectMain::with('services')->find($id);

        $calendarEntries = CardCalendar::where('card_id', $id)->get();
        $isInCalendar = $calendarEntries->isNotEmpty();

        // Передаем выбранный объект и информацию о его наличии в календаре в представление
        return view('cards/card-calendar-create', compact('cardObjectMain', 'isInCalendar'));
    }




    public function store(Request $request)
    {

        // Создание новой записи карточки календаря
        $calendar = new cardCalendar();
        $calendar->card_id = $request->input('card_id');
        $calendar->date_create = $request->input('date_create');
        $calendar->date_archive = $request->input('date_archive');
        $calendar->year = $request->input('year');
        $calendar->save();

        // Получение ID созданной записи
        $createdId = $calendar->id;

        $history_card = new HistoryCardCalendar();
        $history_card->card_id = $request->input('card_id');
        $history_card->date_create = $request->input('date_create');
        $history_card->date_archive = $request->input('date_archive');
        $history_card->year = $request->input('year');
        $history_card->card_calendar_id = $createdId;
        $history_card->save();

        // Возвращение ответа с ID созданной записи
        return response()->json(['success' => true, 'id' => $createdId]);
    }

    public function index($id)
    {
        // Находим карточку календаря по переданному ID
        $cardCalendar = CardCalendar::with('objects.services')->find($id);

        // Проверяем, найдена ли карточка
        if (!$cardCalendar) {
            // Если карточка не найдена, возвращаем ошибку или редирект
            return response()->json(['error' => 'Карточка календаря не найдена'], 404);
        }

        // Находим связанную с карточкой календаря карточку объекта
        $cardObjectMain = CardObjectMain::find($cardCalendar->card_id);

        // Проверяем, найдена ли карточка объекта
        if (!$cardObjectMain) {
            // Если карточка объекта не найдена, возвращаем ошибку или редирект
            return response()->json(['error' => 'Карточка объекта не найдена'], 404);
        }

        // Определяем массив месяцев
        $months = ['Янв', 'Фев', 'Мар', 'Апр', 'Май', 'Июн', 'Июл', 'Авг', 'Сен', 'Окт', 'Ноя', 'Дек'];

        // Собираем все услуги для календаря
        $services = [];
        foreach ($cardCalendar->objects as $object) {
            foreach ($object->services as $service) {
                $services[] = [
                    'planned_maintenance_date' => $service->planned_maintenance_date,
                    'short_name' => $service->short_name,
                    'calendar_color' => $service->calendar_color,
                ];
            }
        }

        // Передаем найденные данные в представление
        return view('cards/card-calendar', compact('cardCalendar', 'cardObjectMain', 'services', 'months'));
    }


    public function archiveCalendarDateButt(Request $request)
    {

        $dateArchive = Carbon::now()->format('Y-m-d');
        $calendarId = $request->id;
        $calendar = cardCalendar::find($calendarId);
        // Проверяем, найдена ли карточка
        if (!$calendar) {
            // Если карточка не найдена, возвращаем ошибку или редирект на страницу ошибки
            return response()->json(['error' => 'Карточка календаря не найдена'], 404);
        }
        $calendar->date_archive = $dateArchive;
        $calendar->save();

        return response()->json(['message' => 'Карточка календаря успешно заархивирована'], 200);
    }

    public function view()
    {
        // Возвращение представления с передачей хлебных крошек
        return view('reestrs/reestrCalendar');
    }

    // --------------- удаление карточки заказ-наряда ---------------
    public function deleteCardCalendar(Request $request)
    {
        $ids = $request->ids;
        // Обновляем записи, устанавливая значение deleted в 1
        foreach ($ids as $id) {
            // Удалить записи из связанных таблиц
            CardCalendar::find($id)->delete();
        }

        return response()->json(['success' => true], 200);
    }

    // ------------------  РЕДАКТИРОВАНИЕ карточки графика TPM (переход на страницу) ------------------
    public function edit($id)
    {
        $cardCalendar = CardCalendar::find($id);

        // Проверяем, найдена ли карточка
        if (!$cardCalendar) {
            // Если карточка не найдена, возвращаем ошибку или редирект
            return response()->json(['error' => 'Карточка календаря не найдена'], 404);
        }

        // Находим связанную с карточкой календаря карточку объекта
        $cardObjectMain = CardObjectMain::find($cardCalendar->card_id);

        // Проверяем, найдена ли карточка объекта
        if (!$cardObjectMain) {
            // Если карточка объекта не найдена, возвращаем ошибку или редирект
            return response()->json(['error' => 'Карточка объекта не найдена'], 404);
        }

        // Определяем массив месяцев
        $months = ['Янв', 'Фев', 'Мар', 'Апр', 'Май', 'Июн', 'Июл', 'Авг', 'Сен', 'Окт', 'Ноя', 'Дек'];

        // Собираем все услуги для календаря
        $services = [];
        foreach ($cardCalendar->objects as $object) {
            foreach ($object->services as $service) {
                $services[] = [
                    'planned_maintenance_date' => $service->planned_maintenance_date,
                    'short_name' => $service->short_name,
                    'calendar_color' => $service->calendar_color,
                ];
            }
        }


        // Передаем данные в представление
        return view('cards/card-calendar-edit', compact('cardCalendar', 'cardObjectMain'));
    }

    public function editSave(Request $request, $id)
    {
        // Находим карточку календаря по переданному идентификатору
        $cardCalendar = CardCalendar::find($id);
        // Проверяем, найдена ли карточка
        if (!$cardCalendar) {
            // Если карточка не найдена, возвращаем ошибку или редирект на страницу ошибки
            return response()->json(['error' => 'Карточка календаря не найдена'], 404);
        }

        // Обновляем основные данные карточки календаря
        $cardCalendar->date_create = $request->date_create;
        $cardCalendar->date_archive = $request->date_archive;
        $cardCalendar->year = $request->year;


        // Сохраняем изменения
        $cardCalendar->save();

//        $history_card = new HistoryCardCalendar();
//        $history_card->name =  $cardCalendar->name;
//        $history_card->infrastructure_type = $cardCalendar->infrastructure_type;
//        $history_card->curator = $request->curator;
//        $history_card->year_action = $request->year_action;
//        $history_card->date_create = $request->date_create;
//        $history_card->date_last_save = $request->date_last_save;
//        $history_card->date_archive = $request->date_archive;
//        $history_card->cards_ids =  $cardCalendar->cards_ids;
//        $history_card->card_graph_id = $cardCalendar->card_graph_id;
//        $history_card->save();


        // Возвращаем успешный ответ или редирект на страницу карточки объекта
        return response()->json(['success' => 'Данные карточки календаря успешно обновлены'], 200);
    }

}
