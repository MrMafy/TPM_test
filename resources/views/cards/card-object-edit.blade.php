{{--страница РЕДАКТИРОВАНИЕ карточка объекта --}}
@extends('layouts.app')

@section('content')
    <div class="container custom_tab_style1_outer">
        <div class="row">
            {{-- ЗАГОЛОВОК С ПАНЕЛЬЮ КНОПОК --}}
            <div class="col-md-12 text-left">
            </div>
            <h1 class="mb-4"><strong>Редактирование карточки объекта "{{ $data_CardObjectMain->name ?? 'Название объекта не найдено' }}"</strong></h1>
        </div>
        <div class="btns d-flex mb-5">
            <div class="d-flex gap-2">
                <button type="button" class="btn btn-success saveEditObject">Сохранить изменения</button>
                <a href="{{ route('cardObject', ['id' => $data_CardObjectMain->_id]) }}" type="button" class="btn btn-secondary me-5">Отменить изменения</a>

                <a href="" type="button" class="btn btn-primary">Скопировать карточку объекта</a>

                <label for="imageUpload" class="btn btn-primary">Загрузить изображение</label>
                <input type="file" id="imageUpload" class="d-none" multiple accept="image/*">
            </div>
        </div>

        {{-- КАРТОЧКА С ВКЛАДКАМИ --}}
        <ul class="nav nav-tabs custom_tab_style1" id="cardObjectTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="main-tab" data-bs-toggle="tab" data-bs-target="#main"
                        type="button" role="tab" aria-controls="main" aria-selected="true">ОСНОВНАЯ
                </button>
            </li>
            @foreach ($data_CardObjectMain->services as $key => $service)
                <li class="nav-item" role="presentation">
                    <button class="nav-link @if ($key === 0) @endif" id="service_{{ $key + 1 }}-tab" data-bs-toggle="tab"
                            data-bs-target="#service_{{ $key + 1 }}" type="button" role="tab" aria-controls="service_{{ $key + 1 }}"
                            aria-selected="{{ $key === 0 ? 'true' : 'false' }}">Обслуживание {{ $key + 1 }}</button>
                </li>
            @endforeach
        </ul>

        <div class="tab-content" id="cardObjectTabContent">
            {{-- ВКЛАДКА "ОСНОВНАЯ" --}}
            <div class="tab-pane fade show active" id="main" role="tabpanel" aria-labelledby="main-tab">
                <div id="main__blocks" class="d-grid">
                    {{-- ОБЩИЕ ДАННЫЕ --}}
                    <div class="member_card_style general">
                        <div class="member-info">
                                <div class="d-flex justify-content-between mb-4">
                                    <h4>Общие данные</h4>
                                    <button class="btn btn-primary createService">Создать обслуживание</button>
                                </div>
                            <div class="member-info--inputs d-flex gap-5">
                                <div class="d-flex flex-column gap-3 w-50">
                                    <div class="d-flex justify-content-between align-items-center gap-3">
                                        <label class="w-100">Вид инфраструктуры</label>
                                        <select class="form-select" name="infrastructure">
                                            <option value="" disabled selected>Выберите вид</option>
                                            <option value="Технологическая" {{ isset($data_CardObjectMain) && $data_CardObjectMain->infrastructure === "Технологическая" ? 'selected' : '' }}>Технологическая</option>
                                            <option value="Информационная" {{ isset($data_CardObjectMain) && $data_CardObjectMain->infrastructure === "Информационная" ? 'selected' : '' }}>Информационная</option>
                                            <option value="Бытовая" {{ isset($data_CardObjectMain) && $data_CardObjectMain->infrastructure === "Бытовая" ? 'selected' : '' }}>Бытовая</option>
                                            <option value="Инженерная" {{ isset($data_CardObjectMain) && $data_CardObjectMain->infrastructure === "Инженерная" ? 'selected' : '' }}>Инженерная</option>
                                            <option value="Электротехническая" {{ isset($data_CardObjectMain) && $data_CardObjectMain->infrastructure === "Электротехническая" ? 'selected' : '' }}>Электротехническая</option>
                                            <option value="Безопасность" {{ isset($data_CardObjectMain) && $data_CardObjectMain->infrastructure === "Безопасность" ? 'selected' : '' }}>Безопасность</option>
                                        </select>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center gap-3">
                                        <label class="w-100">Наименование объекта</label>
                                        <input name="name" class="form-control w-100"
                                               value="{{ $data_CardObjectMain->name ?? 'нет данных' }}">
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center gap-3">
                                        <label class="w-100">Инв./заводской №</label>
                                        <input class="form-control w-100" name="number"
                                               value="{{ $data_CardObjectMain->number ?? 'нет данных' }}">
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center gap-3">
                                        <label class="w-100">Место установки</label>
                                        <select class="form-select" name="location">
                                            <option value="" disabled selected>Выберите место</option>
                                            <option value="Участок ЭОБ" {{ isset($data_CardObjectMain) && $data_CardObjectMain->location === "Участок ЭОБ" ? 'selected' : '' }}>Участок ЭОБ</option>
                                            <option value="Участок сборки" {{ isset($data_CardObjectMain) && $data_CardObjectMain->location === "Участок сборки" ? 'selected' : '' }}>Участок сборки</option>
                                            <option value="БВЗ (1 этаж)" {{ isset($data_CardObjectMain) && $data_CardObjectMain->location === "БВЗ (1 этаж)" ? 'selected' : '' }}>БВЗ (1 этаж)</option>
                                            <option value="БВЗ (2 этаж)" {{ isset($data_CardObjectMain) && $data_CardObjectMain->location === "БВЗ (2 этаж)" ? 'selected' : '' }}>БВЗ (2 этаж)</option>
                                            <option value="ЦУП (1 этаж)" {{ isset($data_CardObjectMain) && $data_CardObjectMain->location === "ЦУП (1 этаж)" ? 'selected' : '' }}>ЦУП (1 этаж)</option>
                                            <option value="ЦУП (2 этаж)" {{ isset($data_CardObjectMain) && $data_CardObjectMain->location === "ЦУП (2 этаж)" ? 'selected' : '' }}>ЦУП (2 этаж)</option>
                                            <option value="Офис (1 этаж)" {{ isset($data_CardObjectMain) && $data_CardObjectMain->location === "Офис (1 этаж)" ? 'selected' : '' }}>Офис (1 этаж)</option>
                                            <option value="Офис (2 этаж)" {{ isset($data_CardObjectMain) && $data_CardObjectMain->location === "Офис (2 этаж)" ? 'selected' : '' }}>Офис (2 этаж)</option>
                                            <option value="Офис (3 этаж)" {{ isset($data_CardObjectMain) && $data_CardObjectMain->location === "Офис (3 этаж)" ? 'selected' : '' }}>Офис (3 этаж)</option>
                                            <option value="Серверная" {{ isset($data_CardObjectMain) && $data_CardObjectMain->location === "Серверная" ? 'selected' : '' }}>Серверная</option>
                                            <option value="Основной склад" {{ isset($data_CardObjectMain) && $data_CardObjectMain->location === "Основной склад" ? 'selected' : '' }}>Основной склад</option>
                                            <option value="Мезонин" {{ isset($data_CardObjectMain) && $data_CardObjectMain->location === "Мезонин" ? 'selected' : '' }}>Мезонин</option>
                                        </select>

                                    </div>
                                </div>
                                <div class="d-flex flex-column gap-3 w-50">
                                    <div class="d-flex justify-content-between align-items-center gap-3">
                                        <label class="w-100">Дата прихода</label>
                                        <input class="form-control w-100" type="date" name="date_arrival"
                                               value="{{ isset($data_CardObjectMain->date_arrival) ? $data_CardObjectMain->date_arrival : 'нет данных' }}">
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center gap-3">
                                        <label class="w-100">Дата ввода в эксплуатацию</label>
                                        <input class="form-control w-100"  type="date" name="date_usage"
                                               value="{{ isset($data_CardObjectMain->date_usage) ? $data_CardObjectMain->date_usage : 'нет данных' }}">
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center gap-3">
                                        <label class="w-100">Дата окончания аттестации/гарантии</label>
                                        <input class="form-control w-100" type="date"  name="date_cert_end"
                                               value="{{ isset($data_CardObjectMain->date_cert_end) ? $data_CardObjectMain->date_cert_end : 'нет данных' }}">
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center gap-3">
                                        <label class="w-100">Дата вывода из эксплуатации</label>
                                        <input class="form-control  w-100" type="date" name="date_usage_end"
                                               value="{{ isset($data_CardObjectMain->date_usage_end) ?$data_CardObjectMain->date_usage_end : 'нет данных' }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- ДОКУМЕНТАЦИЯ --}}
                    <div class="member_card_style documentation">
                        <div class="member-info">
                            <div class="d-flex justify-content-between mb-4">
                                <h4>Документация</h4>
                                <label for="docUpload" class="btn btn-primary">Вложить документ</label>
                                <input type="file" id="docUpload" class="d-none" multiple
                                       accept=".pdf, .doc, .docx">
                            </div>
                            <div class="objectDocs" id="documentList">
                                    @if ($data_CardObjectMainDocs !== null)
                                        @foreach ($data_CardObjectMainDocs as $file)
                                            <div class="documentItem">
                                                <a href="{{ route('downloadDocument', $file->id) }}">{{ $file->file_name }}</a>
                                                <i class="bi bi-x-circle docDelete ms-3"></i>
                                            </div>
                                        @endforeach
                                    @else
                                        <p>Нет доступных документов</p>
                                    @endif
                            </div>
                        </div>
                    </div>
                    {{-- ИЗОБРАЖЕНИЕ --}}
                    <div class="member_card_style image">
                        <div class="member-info">
                            <div class="d-flex justify-content-between mb-4">
                                <h4>Изображение объекта</h4>
                                <label for="imageUpload" class="btn btn-primary">Загрузить</label>
                                <input type="file" id="imageUpload" class="d-none" multiple accept="image/*">
                            </div>
                            <div class="objectImage">
                                @if ($data_CardObjectMain)
                                    <img src="{{ route('getImage', ['id' => $data_CardObjectMain->id]) }}"
                                         alt="Image">
                                @else
                                    <p>Нет доступных изображений</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ВКЛАДКА "ОБСЛУЖИВАНИЕ" --}}
            @foreach ($data_CardObjectMain->services as $key => $service)
                <div class="tab-pane fade @if ($key === 0) @endif" id="service_{{ $key + 1 }}" role="tabpanel"
                     aria-labelledby="service_{{ $key + 1 }}-tab">
                    <div id="service__blocks" class="d-grid">
                        {{-- ОБСЛУЖИВАНИЕ ТРМ --}}
                        <div class="member_card_style services">
                            <div class="member-info">
                                <div class="d-flex justify-content-between mb-4">
                                    <h4>Обслуживание ТРМ {{ $key + 1 }}</h4>
                                    <button class="btn btn-primary">Обновить даты</button>
                                    <div>
                                        <input type="checkbox" class="form-check-input me-1" id="disableInTable">
                                        <label class="form-check-label disableInTable" for="disableInTable">Не
                                            выводить
                                            на основной
                                            экран, в график TPM и не отправлять уведомления</label>
                                    </div>
                                </div>
                                <div class="member-info--inputs d-flex gap-5">
                                    <div class="d-flex flex-column gap-3 w-50">
                                        <div class="d-flex justify-content-between align-items-center gap-3">
                                            <label class="w-100" for="service_type_{{ $key + 1 }}">Вид обслуживания</label>
                                            <select id="service_type_{{ $key + 1 }}" class="form-select" name="service_type">
                                                <option value="" disabled selected>Выберите вид</option>
                                                <option value="Регламентные работы" {{ $service->service_type == 'Регламентные работы' ? 'selected' : '' }}>Регламентные работы</option>
                                                <option value="Техническое обслуживание" {{ $service->service_type == 'Техническое обслуживание' ? 'selected' : '' }}>Техническое обслуживание</option>
                                                <option value="Сервисное техническое обслуживание" {{ $service->service_type == 'Сервисное техническое обслуживание' ? 'selected' : '' }}>Сервисное техническое обслуживание</option>
                                                <option value="Капитальный ремонт" {{ $service->service_type == 'Капитальный ремонт' ? 'selected' : '' }}>Капитальный ремонт</option>
                                                <option value="Аварийный ремонт" {{ $service->service_type == 'Аварийный ремонт' ? 'selected' : '' }}>Аварийный ремонт</option>
                                            </select>
                                        </div>
                                        <div class="d-flex justify-content-between align-items-center gap-3">
                                            <label class="w-100">Сокращенное название</label>
                                            <input id="short_name_{{ $key + 1 }}" name="short_name" class="form-control w-100" value="{{ $service->short_name }}" >
                                        </div>
                                        <div class="d-flex justify-content-between align-items-center gap-3">
                                            <label class="w-100">Исполнитель</label>
                                            <input id="performer_{{ $key + 1 }}" class="form-control w-100" name="performer" value="{{ $service->performer }}" >
                                        </div>
                                        <div class="d-flex justify-content-between align-items-center gap-3">
                                            <label class="w-100">Ответственный</label>
                                            <input id="responsible_{{ $key + 1 }}" class="form-control  w-100" name="responsible" value="{{ $service->responsible }}" >
                                        </div>
                                    </div>
                                    <div class="d-flex flex-column gap-3 w-50">
                                        <div class="d-flex justify-content-between align-items-center gap-3">
                                            <label class="w-100" for="frequency_{{ $key + 1 }}">Периодичность</label>
                                            <select id="frequency_{{ $key + 1 }}" class="form-select" name="frequency">
                                                <option value="" disabled selected>Выберите периодичность</option>
                                                <option value="Сменное" {{ $service->frequency == 'Сменное' ? 'selected' : '' }}>Сменное</option>
                                                <option value="Ежемесячное" {{ $service->frequency == 'Ежемесячное' ? 'selected' : '' }}>Ежемесячное</option>
                                                <option value="Ежеквартальное" {{ $service->frequency == 'Ежеквартальное' ? 'selected' : '' }}>Ежеквартальное</option>
                                                <option value="Полугодовое" {{ $service->frequency == 'Полугодовое' ? 'selected' : '' }}>Полугодовое</option>
                                                <option value="Ежегодное" {{ $service->frequency == 'Ежегодное' ? 'selected' : '' }}>Ежегодное</option>
                                            </select>
                                        </div>
                                        <div class="d-flex justify-content-between align-items-center gap-3">
                                            <label class="w-100">Дата предыдущего обслуживания</label>
                                            <input id="prev_maintenance_date_{{ $key + 1 }}" class="form-control w-100" name="prev_maintenance_date" value="{{ date('d-m-Y', strtotime($service->prev_maintenance_date)) }}" >
                                        </div>
                                        <div class="d-flex justify-content-between align-items-center gap-3">
                                            <label class="w-100">Плановая дата обслуживания</label>
                                            <input id="planned_maintenance_date_{{ $key + 1 }}" class="form-control w-100" name="planned_maintenance_date" value="{{ date('d-m-Y', strtotime($service->planned_maintenance_date)) }}" >
                                        </div>
                                        <div class="d-flex justify-content-between align-items-center gap-3">
                                            <label class="w-100">Цвет в календаре</label>
                                            <div class="color-options">
                                                <div class="color-option red" data-color="#ff0000"></div>
                                                <div class="color-option green" data-color="#00ff00"></div>
                                                <div class="color-option blue" data-color="#0000ff"></div>
                                            </div>
                                            <input type="hidden" id="selectedColor_{{ $key + 1 }}" name="selectedColor" value="{{ $service->calendar_color }}" >
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- ВИДЫ РАБОТ --}}
                        <div class="member_card_style types">
                            <div class="member-info">
                                <div class="d-flex justify-content-between mb-4">
                                    <h4>Виды работ</h4>
                                    <div class="tooltip-wrapper">
                                        <button class="btn btn-primary" data-bs-toggle="modal"
                                                data-bs-target="#typesModal">Добавить вид работ
                                        </button>
                                    </div>
                                </div>
                                <div class="typesOfWork" id="typesOfWork">
                                    <!-- Используем класс row для создания строки -->
                                    <div class="grid-container">
                                        @foreach ($service->services_types as $type)
                                            <div class="grid-item">
                                                <div class="form-check d-flex align-items-center gap-2">
                                                    <input class="form-control" name="types_of_work[]"
                                                           value="{{ $type->type_work }}">
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- РАСХОДНЫЕ МАТЕРИАЛЫ --}}
                        <div class="member_card_style materials">
                            <div class="member-info">
                                <div class="d-flex justify-content-between mb-4">
                                    <h4>Расходные материалы и ЗИП</h4>
                                </div>
                                <div class="material_text w-100">
                                    <textarea class="form-control materialsTextArea"  id="materialsTextArea_{{ $key + 1 }}">{{ $service->consumable_materials }}</textarea>
                                </div>
                            </div>
                        </div>
                        {{-- ИЗОБРАЖЕНИЕ --}}
                        <div class="member_card_style image">
                            <div class="member-info">
                                <div class="d-flex justify-content-between mb-4">
                                    <h4>Изображение объекта</h4>
                                    <label for="imageUpload" class="btn btn-primary">Загрузить</label>
                                    <input type="file" id="imageUpload" class="d-none" multiple accept="image/*">
                                </div>
                                <div class="objectImage">
                                    @if ($data_CardObjectMain)
                                        <img src="{{ route('getImage', ['id' => $data_CardObjectMain->id]) }}"
                                             alt="Image">
                                    @else
                                        <p>Нет доступных изображений</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Добавить виды работ модальное окно -->
    <div class="modal fade" id="typesModal" tabindex="-1" aria-labelledby="typesModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="typesModalLabel"><strong>Добавление вида работ</strong></h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="d-flex align-items-center gap-1">
                        <label class="w-50">Вид работы</label>
                        <input name="" placeholder="Введите название вида работы" class="form-control w-100"
                               id="typeOfWorkInput">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрыть</button>
                    <button type="button" class="btn btn-primary" id="addTypeOfWork">Добавить</button>
                </div>
            </div>
        </div>
    </div>

    @php
        $imageSrc = $data_CardObjectMain ? route('getImage', ['id' => $data_CardObjectMain->id]) : 'http://placehold.it/350x450';
    @endphp
    <script>
        let uploadedImageSrc = '{{ $imageSrc }}'; // Переменная для хранения пути к загруженному изображению

        document.addEventListener('DOMContentLoaded', function () {
            // Обработчик загрузки документов
            $('#docUpload').change(function () {
                let fileList = this.files;
                let documentList = $('#documentList');
                // documentList.empty(); // Очищаем список документов перед добавлением новых

                for (let i = 0; i < fileList.length; i++) {
                    let file = fileList[i];
                    let fileName = file.name;
                    let listItem = $('<a>').attr('href', '#').text(fileName);
                    let deleteButton = $('<i class="bi bi-x-circle docDelete ms-3"></i>');
                    let documentItem = $('<div class="documentItem">').append(listItem, deleteButton);
                    documentList.append(documentItem);
                }
            });

            $(document).on('click', '.docDelete', function () {
                // Находим родительский элемент строки документации, содержащий нажатую кнопку "Удалить документ"
                let parent = $(this).closest('.documentItem');
                // Удаляем эту строку документации
                parent.remove();
            });


            // Обработчик загрузки изображений
            $('#imageUpload').change(function () {
                let fileList = this.files;
                if (fileList.length > 0) {
                    let reader = new FileReader();
                    reader.onload = function (e) {
                        uploadedImageSrc = e.target.result; // Сохраняем путь к загруженному изображению
                        $('.objectImage img').attr('src', uploadedImageSrc); // Отображаем изображение на вкладке "Основная"
                        $('.member_card_style.image .objectImage img').attr('src', uploadedImageSrc); // Отображаем изображение на других вкладках
                        $('.member_card_style.image .member-info').append(
                            '<div class="objectImage__delete mt-4"><button class="btn btn-danger imageDelete">Удалить</button></div>'
                        );
                    }
                    reader.readAsDataURL(fileList[0]);
                }
            });
            $(document).on('click', '.imageDelete', function () {
                // Находим родительский элемент кнопки "Удалить"
                let parent = $(this).closest('.member_card_style.image .member-info');
                // Удаляем изображение из родительского элемента
                parent.find('.objectImage img').attr('src', 'http://placehold.it/350x450'); // Устанавливаем атрибут src пустой строкой
                // Удаляем кнопку "Удалить"
                $(this).closest('.objectImage__delete').remove();
            });


            // ------------ динамическое создание вкладок обслуживание  ------------

            // Находим максимальный номер вкладки обслуживания
            let maxServiceTabsCount = 0;
            $('.nav-link').each(function() {
                let tabId = $(this).attr('id');
                if (tabId && tabId.startsWith('service_')) {
                    let tabIndex = parseInt(tabId.split('_')[1]);
                    maxServiceTabsCount = Math.max(maxServiceTabsCount, tabIndex);
                }
            });
            // Определяем следующий номер для вкладки обслуживания
            let serviceTabsCount = maxServiceTabsCount + 1;
            // Обработчик нажатия на кнопку "Создать обслуживание"
            $('.createService').on('click', function () {
                // Генерируем id для новой вкладки и ее содержимого
                let tabId = 'service_' + serviceTabsCount + '-tab';
                let paneId = 'service_' + serviceTabsCount;

                // Создаем новую вкладку и ее содержимое
                let tab = $('<li class="nav-item" role="presentation"> \
                        <button class="nav-link" id="' + tabId + '" data-bs-toggle="tab" data-bs-target="#' + paneId + '" type="button" role="tab" aria-controls="' + paneId + '" aria-selected="false">ОБСЛУЖИВАНИЕ ' + serviceTabsCount + '</button> \
                    </li>');
                let tabContent = $('<div class="tab-pane fade" id="' + paneId + '" role="tabpanel" aria-labelledby="' + tabId + '"> \
                        <div id="service__blocks" class="d-grid"> \
                            {{-- ОБСЛУЖИВАНИЕ ТРМ --}} \
                            <div class="member_card_style services"> \
                                <div class="member-info"> \
                                    <div class="d-flex justify-content-between mb-4"> \
                                        <h4>Обслуживание ТРМ</h4> \
                                        <button class="btn btn-primary">Обновить даты</button> \
                                        <div> \
                                            <input type="checkbox" class="form-check-input me-1" id="disableInTable_' + serviceTabsCount + '"> \
                                            <label class="form-check-label disableInTable" for="disableInTable_' + serviceTabsCount + '">Не выводить \
                                                на основной \
                                                экран, в график TPM и не отправлять уведомления</label> \
                                        </div> \
                                    </div> \
                                    <div class="member-info--inputs d-flex gap-5"> \
                                        <div class="d-flex flex-column gap-3 w-50"> \
                                            <div class="d-flex justify-content-between align-items-center gap-3"> \
                                                <label class="w-100" for="service_type_' + serviceTabsCount + '">Вид обслуживания</label> \
                                                <select id="service_type_' + serviceTabsCount + '" class="form-select" name="service_type">\
                                                        <option value="" disabled selected>Выберите вид</option>\
                                                        <option value="Регламентные работы">Регламентные работы</option>\
                                                        <option value="Техническое обслуживание">Техническое обслуживание</option>\
                                                        <option value="Сервисное техническое обслуживание">Сервисное техническое обслуживание</option>\
                                                        <option value="Капитальный ремонт">Капитальный ремонт</option>\
                                                        <option value="Аварийный ремонт">Аварийный ремонт</option>\
                                                </select>\
                                            </div> \
                                            <div class="d-flex justify-content-between align-items-center gap-3"> \
                                                <label class="w-100" for="short_name_' + serviceTabsCount + '">Сокращенное название</label> \
                                                <input id="short_name_' + serviceTabsCount + '" name="short_name" placeholder="Введите сокращенное название" \
                                                    class="form-control w-100"> \
                                            </div> \
                                            <div class="d-flex justify-content-between align-items-center gap-3"> \
                                                <label class="w-100" for="performer_' + serviceTabsCount + '">Исполнитель</label> \
                                                <input id="performer_' + serviceTabsCount + '" name="performer" class="form-control w-100" \
                                                    placeholder="Введите исполнителя"> \
                                            </div> \
                                            <div class="d-flex justify-content-between align-items-center gap-3"> \
                                                <label class="w-100" for="responsible_' + serviceTabsCount + '">Ответственный</label> \
                                                <input id="responsible_' + serviceTabsCount + '" name="responsible" class="form-control  w-100" \
                                                    placeholder="Введите ответственного"> \
                                            </div> \
                                        </div> \
                                        <div class="d-flex flex-column gap-3 w-50"> \
                                            <div class="d-flex justify-content-between align-items-center gap-3"> \
                                                <label class="w-100" for="frequency_' + serviceTabsCount + '">Периодичность</label> \
                                                 <select id="frequency_' + serviceTabsCount + '"class="form-select" name="frequency">\
                                                        <option value="" disabled selected>Выберите периодичность</option>\
                                                        <option value="Сменное">Сменное</option>\
                                                        <option value="Ежемесячное">Ежемесячное</option>\
                                                        <option value="Ежеквартальное">Ежеквартальное</option>\
                                                        <option value="Полугодовое">Полугодовое</option>\
                                                        <option value="Ежегодное">Ежегодное</option>\
                                                </select>\
                                            </div> \
                                            <div class="d-flex justify-content-between align-items-center gap-3"> \
                                                <label class="w-100" for="prev_maintenance_date_' + serviceTabsCount + '">Дата предыдущего обслуживания</label> \
                                                <input type="date" id="prev_maintenance_date_' + serviceTabsCount + '" name="prev_maintenance_date" class="form-control w-100" \
                                                    placeholder="Введите дату предыдущего обслуживания"> \
                                            </div> \
                                            <div class="d-flex justify-content-between align-items-center gap-3"> \
                                                <label class="w-100" for="planned_maintenance_date_' + serviceTabsCount + '">Плановая дата обслуживания</label> \
                                                <input type="date" id="planned_maintenance_date_' + serviceTabsCount + '" name="planned_maintenance_date" class="form-control w-100" \
                                                    placeholder="Введите плановую дату обслуживания"> \
                                            </div> \
                                            <div class="d-flex justify-content-between align-items-center gap-3"> \
                                                <label class="w-100">Цвет в календаре</label> \
                                                <div class="color-options" data-toggle="tooltip" title="нажмите на выбранный цвет"> \
                                                    <div class="color-option red" data-color="#ff0000"></div> \
                                                    <div class="color-option green" data-color="#00ff00"></div> \
                                                    <div class="color-option blue" data-color="#0000ff"></div> \
                                                </div> \
                                                <input type="hidden" id="selectedColor_' + serviceTabsCount + '" name="selectedColor"> \
                                            </div> \
                                        </div> \
                                    </div> \
                                </div> \
                            </div> \
                            \
                            \
                             {{-- ВИДЫ РАБОТ --}}\
                             <div class="member_card_style types" data-service-id="' + paneId + '">\
                                    <div class="member-info">\
                                    <div class="d-flex justify-content-between mb-4">\
                                    <h4>Виды работ</h4>\
                                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#typesModal">Добавить вид работ</button>\
                            </div>\
                                        <div class="typesOfWork" id="typesOfWork">\
                                    <!-- Используем класс row для создания строки -->\
                                    <div class="grid-container">\
                                        <!-- Используем класс col-md-6 для создания двух столбцов на широких экранах -->\
                                        <div class="grid-item">\
                                            <div class="form-check d-flex align-items-center gap-2">\
                                            </div>\
                                        </div>\
                                    </div>\
                                </div>\
                            </div>\
                            </div>\
                            \
                            \
                            {{-- РАСХОДНЫЕ МАТЕРИАЛЫ --}}\
                            <div class="member_card_style materials">\
                                <div class="member-info">\
                                <div class="d-flex justify-content-between mb-4">\
                                <h4>Расходные материалы и ЗИП</h4>\
                                 </div>\
                                <div class="material_text w-100">\
                                <textarea id="materialsTextArea_' + serviceTabsCount + '" \
                                class="form-control materialsTextArea" \
                                placeholder="Введите расходные материалы и ЗИП"></textarea>\
                            </div>\
                            </div>\
                             </div>\
                            \
                            {{-- ИЗОБРАЖЕНИЕ --}}\
                            <div class="member_card_style image">\
                                <div class="member-info">\
                                 <div class="d-flex justify-content-between mb-4">\
                                    <h4>Изображение объекта</h4>\
                                <label for="imageUpload" class="btn btn-primary">Загрузить</label>\
                                <input type="file" id="imageUpload" class="d-none" multiple accept="image/*">\
                                </div>\
                            <div class="objectImage">\
                                  <img src="' + uploadedImageSrc + '"/>\
                            </div>\
                            </div>\
                            </div>\
                            </div>\
                            </div>\
                        </div> \
                    </div>');

                // Добавляем новую вкладку и ее содержимое к соответствующим элементам
                $('#cardObjectTab').append(tab);
                $('#cardObjectTabContent').append(tabContent);

                // Обновляем обработчик событий для выбора цвета
                updateColorPicker();

                // Увеличиваем счетчик вкладок для обслуживания
                serviceTabsCount++;
            });
            // Функция для обновления обработчика событий для выбора цвета
            function updateColorPicker() {
                // Получаем все блоки цветов
                const colorOptions = $('.color-option');
                // Добавляем обработчик события для каждого блока цвета
                colorOptions.on('click', function () {
                    // Убираем рамку у всех блоков цветов
                    colorOptions.removeClass('selected');
                    // Добавляем рамку только выбранному блоку цвета
                    $(this).addClass('selected');
                    // Получаем цвет выбранного блока
                    const selectedColor = $(this).data('color');
                    // Находим скрытое поле выбранного цвета для текущей вкладки
                    const selectedColorField = $(this).closest('.tab-pane').find('input[name="selectedColor"]');
                    // Устанавливаем значение цвета в скрытое поле ввода текущей вкладки
                    selectedColorField.val(selectedColor);
                });
            }
            // Вызываем функцию для обновления обработчика событий для выбора цвета
            updateColorPicker();

            // Инициализируем массив typesOfWork
            let typesOfWorkByService = {};
            let formData = new FormData();
            // Обработка клика по кнопке "Добавить вид работы"
            $("#addTypeOfWork").click(function() {
                let typeOfWork = $("#typeOfWorkInput").val().trim();
                console.log("Добавлен вид работы:", typeOfWork);
                if (typeOfWork !== '') {
                    let currentServiceId = $('.tab-pane.active').attr('id');
                    // if (!typesOfWorkByService[currentServiceId]) {
                    //     typesOfWorkByService[currentServiceId] = [];
                    // }
                    // typesOfWorkByService[currentServiceId].push(typeOfWork);
                    let listItem = '<input  class="form-control" name="types_of_work[]" value="' + typeOfWork + '">';
                    $("#" + currentServiceId + " .typesOfWork").append(listItem);
                    // formData.append('services[types_of_work][]', typeOfWork);
                    // console.log("текущие работы во вкладке",currentServiceId,": ",  typesOfWorkByService[currentServiceId]);
                }
            });


            //------------  обработчик сохранения данных  ------------

            $(".saveEditObject").click(function () {
                // Создаем объект FormData для отправки данных на сервер, включая файлы
                // let formData = new FormData();

                // Собираем данные с основной формы
                formData.append('infrastructure', $("select[name=infrastructure]").val());
                formData.append('name', $("input[name=name]").val());
                formData.append('number', $("input[name=number]").val());
                formData.append('location', $("select[name=location]").val());
                formData.append('date_arrival', $("input[name=date_arrival]").val());
                formData.append('date_usage', $("input[name=date_usage]").val());
                formData.append('date_cert_end', $("input[name=date_cert_end]").val());
                formData.append('date_usage_end', $("input[name=date_usage_end]").val());

                // Собираем данные о загруженных изображениях
                let imageFiles = $("#imageUpload")[0].files;
                for (let i = 0; i < imageFiles.length; i++) {
                    formData.append('images[]', imageFiles[i]);
                }

                // Собираем данные о загруженных файлах
                let docFiles = $("#docUpload")[0].files;
                for (let j = 0; j < docFiles.length; j++) {
                    formData.append('files[]', docFiles[j]);
                }

                let servicesData = [];
                let typesOfWorkValues = $("input[name='types_of_work[]']").map(function() {
                    return $(this).val();
                }).get();
                formData.append('types_of_work', typesOfWorkValues);
                // Собираем данные с каждой вкладки обслуживания
                for (let i = 1; i < serviceTabsCount; i++) {
                    let serviceData = {
                        service_type: $("#service_type_" + i).val(),
                        short_name: $("#short_name_" + i).val(),
                        performer: $("#performer_" + i).val(),
                        responsible: $("#responsible_" + i).val(),
                        frequency: $("#frequency_" + i).val(),
                        prev_maintenance_date: $("#prev_maintenance_date_" + i).val(),
                        planned_maintenance_date: $("#planned_maintenance_date_" + i).val(),
                        selectedColor: $("#selectedColor_" + i).val(),
                        materials: $("#materialsTextArea_" + i).val(),
                    };
                    // Добавляем данные в массив servicesData
                    servicesData.push(serviceData);
                }

                // Добавляем массив servicesData в formData
                formData.append("services", JSON.stringify(servicesData));

                // Отправляем данные на сервер
                $.ajax({
                    type: "POST",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: "/edit-card-object-save/{{ $data_CardObjectMain->id }}",
                    data: formData,
                    processData: false, // Не обрабатывать данные
                    contentType: false, // Не устанавливать тип содержимого
                    success: function (response) {
                        // Обработка успешного ответа от сервера (например, отображение сообщения об успешном сохранении)
                        alert("Данные для карточки объекта успешно обновлены!");
                        console.log(formData);
                    },
                    error: function (error) {
                        // Обработка ошибки при сохранении данных
                        alert("Ошибка при обновлении данных для карточки объекта!");
                        console.log(formData);
                    }
                });
            });
        });
    </script>
@endsection
