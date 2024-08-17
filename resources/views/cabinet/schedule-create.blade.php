@extends('layouts/contentNavbarLayout')
@section('vendor-script')
  <script src="{{ mix('assets/libs/moments/moments.js') }}"></script>
@endsection

@section('content')
  <style>
    @media (min-width: 767.98px) {
      td:first-child {
        position: sticky;
        background-color: white !important;;
        z-index: 1;
        left: 0;
        min-width: 300px;
      }

      th:last-child, td:last-child {
        min-width: 250px;
      }

      th {
        position: sticky;
        background-color: whitesmoke !important;
        z-index: 1;
        top: 0;;
      }

      th:first-child {
        position: sticky;
        background-color: whitesmoke !important;;
        z-index: 2;
        left: 0;
        min-width: 300px;
      }

      #contextMenu {
        position: absolute;
        display: none;
        z-index: 2;
      }

      #contextMenu .dropdown-menu {
        border: none;
      }

      .fc-event-main-frame {
        flex-wrap: wrap;
      }
    }


  </style>

  <div id="contextMenu" class="dropdown clearfix"></div>

  <!-- DAY STAT MODAL -->
  <div class="modal fade" id="dayStatistic" tabindex="-1" aria-labelledby="edit_notification" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title mb-1"><i class='bx bx-line-chart me-1 text-primary fs-3'></i>Дневная статистика по графику
          </h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
          <div class="modal-body" id="dayStatistic-modal-body">

          </div>
      </div>
    </div>
  </div>


  <!-- WEEK STAT MODAL -->
  <div class="modal fade" id="weekStatistic" tabindex="-1" aria-labelledby="edit_notification" aria-hidden="true">
    <div class="modal-dialog modal-xl">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title mb-1"><i class='bx bx-line-chart me-1 text-primary fs-3'></i>Статистика по неделям
          </h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body" id="weekStatistic-modal-body">

        </div>
      </div>
    </div>
  </div>



  <!-- ADD EVENT MODAL -->
  <div class="modal fade" id="newEventModal" tabindex="-1" aria-labelledby="edit_notification" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title mb-1"><i class='bx bx-bell-plus me-1 text-primary fs-3'></i>Добавление рабочего дня
          </h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form id="addEventForm">
          <div class="modal-body">
            <div class="row">
              <div class="col-xs-12">
                <label class="col-xs-4" for="starts-at">Выберете рабочее время:</label>
                <div>
                  <select class="form-control" id="workTimeSelect" required>
                    @foreach($workScheduleTypes as $type)
                      <option value="{{$type['Код']}}" data-info="{{json_encode($type)}}">
                        <div>
                          {{$type['Ночная'] ? '🌙' : '☀️'}}
                        </div>
                        <div>
                          Время работы: {{substr($type['ВремяНачала'], 0, strlen($type['ВремяНачала']) - 3)}}
                          - {{substr($type['ВремяОкончания'], 0, strlen($type['ВремяОкончания']) - 3)}}
                        </div>
                        <div>
                          Перерыв: {{substr($type['Перерыв'], 0, strlen($type['Перерыв']) - 3)}}
                        </div>
                      </option>
                    @endforeach
                  </select>
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <div class="d-flex justify-content-end">
              <button class="btn btn-primary" type="submit">Сохранить</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- EDIT EVENT MODAL -->
  <div class="modal fade" id="editEventModal" tabindex="-1" aria-labelledby="edit_notification" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title mb-1"><i class='bx bx-bell-plus me-1 text-primary fs-3'></i>Редактирование рабочего дня
          </h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form id="editEventForm">
          <div class="modal-body">
            <div class="row">
              <div class="col-xs-12">
                <label class="col-xs-4" for="starts-at">Выберете рабочее время:</label>
                <div>
                  <select class="form-control" id="workTimeSelect-edit" required>
                    @foreach($workScheduleTypes as $type)
                      <option value="{{$type['Код']}}" data-info="{{json_encode($type)}}">
                        <div>
                          {{$type['Ночная'] ? '🌙' : '☀️'}}
                        </div>
                        <div>
                          Время работы: {{substr($type['ВремяНачала'], 0, strlen($type['ВремяНачала']) - 3)}}
                          - {{substr($type['ВремяОкончания'], 0, strlen($type['ВремяОкончания']) - 3)}}
                        </div>
                        <div>
                          Перерыв: {{substr($type['Перерыв'], 0, strlen($type['Перерыв']) - 3)}}
                        </div>
                      </option>
                    @endforeach
                  </select>
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer d-flex justify-content-between">
            <button type="button" class="btn btn-danger" id="deleteEvent">Удалить</button>
            <button class="btn btn-primary" type="submit">Сохранить</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <div class="card mb-2">
    <div class="card-body p-2">
      <div class="alert alert-warning m-0" role="alert">
        <h6 class="alert-heading mb-1"><i class='bx bx-info-square fs-3'></i> Внимание!</h6>
        <div class="mb-2">
          Для формирования расписания будут использованы данные из <a href="/admin/month_constants">справочника</a> за
          выбранный период
        </div>

        <div>При изменении справочника необходимо создать новую версию графика работы врачей
          <button id="create-new-version-btn" class="btn btn-sm btn-primary ms-3" onclick="createNewVersion()">Создать
          </button>
        </div>
      </div>
    </div>
  </div>

  @if($scheduleVersionErrors &&  count($scheduleVersionErrors) > 0)
    <!-- Modal -->
    <div class="modal fade" id="schedule-errors" tabindex="-1" aria-labelledby="create_notification"
         aria-hidden="true">
      <div class="modal-dialog modal-xl">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title mb-1"><i class='bx bx-bug-alt me-1 text-primary fs-3'></i>При генерации появились
              следующие несоответствия</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            @foreach($scheduleVersionErrors as $error)
              <div class="mb-4">
                <h6>{{$error['Описание']}}</h6>
                <div class="row p-2">
                  @foreach( $error['Доктора'] as $oneDoc)
                    <div class="col-12 col-sm-6 col-md-4 p-2 border">
                      <div class="p-2">
                        <div class="d-flex flex-wrap">
                          <div class="text-muted me-2"> №{{$oneDoc['Доктор']['ТабНомер']}}</div>
                          {{$oneDoc['Доктор']['ФИО']}}
                        </div>
                        @if($oneDoc['Записи'])
                          <div>Даты несоответствий:</div>
                          <div class="d-flex flex-column">
                            @foreach($oneDoc['Записи'] as $zap)
                              <span>{{ date('d.m.y', strtotime($zap['Дата']))}}</span>
                            @endforeach
                          </div>
                        @endif
                      </div>
                    </div>
                  @endforeach
                </div>
              </div>
            @endforeach
          </div>
        </div>
      </div>
    </div>
  @endif

  <div class="card p-2">
    <div class="card-header d-flex justify-content-between flex-wrap">
      <h5 class="mb-1"><i class='bx bx-category-alt  me-1 text-primary fs-3'></i> Формирование графика работы врачей
      </h5>
      <input id="schedule-month-selector" class="form-control w-px-150" type="month" value="{{$date}}"/>
    </div>

    <div class="card-body position-relative">
      <div id="schedule-content-loading" class="h-100 w-100 position-absolute bg-white"
           style="z-index: 9999; opacity: 0.8; display: none">
        <div class="d-flex flex-column align-items-center justify-content-center h-100 w-100">
          <div class="spinner-border mb-2" style="width: 3rem; height: 3rem;" role="status"></div>
          <span class="text-muted">Идет загрузка расписания</span>
        </div>
      </div>

      @if($scheduleProject)
        <div id="schedule-create-process-handle" style="display: none">
          <div class="d-flex flex-column align-items-center justify-content-center h-px-350 w-100">
            <div class="spinner-border mb-2" style="width: 3rem; height: 3rem;" role="status"></div>
            <span class="text-muted">Идет формирование расписания</span>
          </div>
        </div>
        <div id="form-schedile-content">

          <input id="projectCode" value="{{$scheduleProject['Код']}}" class="d-none">
          <div class="d-flex justify-content-between flex-wrap mb-2">
            <div class="d-flex flex-column">
              <div class="d-flex mb-2">
                <div class="me-2">Текущий статус графика:</div>
                <div
                  class="badge {{$scheduleProject['КодСтатуса'] == 1 ? 'bg-warning text-dark' :  ($scheduleProject['КодСтатуса']  == 2 ? 'bg-success' : 'bg-secondary') }}">{{$scheduleStatuses[$scheduleProject['КодСтатуса']]['Название']}}</div>
              </div>
              <div class="d-flex align-items-center mb-2">
                <div class="me-2">Версии:</div>
                @if($scheduleVersions && !empty($scheduleVersions))
                  <select class="form-select" id="project-version-select">
                    @foreach($scheduleVersions as $version)
                      <option {{$version['Код'] == $currentVersionId ? 'selected' : ''}} value="{{$version['Код']}}">
                        №{{$version['Код']}}
                        от: {{ date('d-m-Y', strtotime($version['ДатаСоздания'])) }} {{$version['Утверждено'] ? ' ✅ - утвержденная' : '' }}
                      </option>
                    @endforeach
                  </select>
                @endif
              </div>
              @if($scheduleVersionErrors &&  count($scheduleVersionErrors) > 0)
                <div class="text-warning">В выбранной версии есть несоответствия:
                  <button class="btn btn-sm btn-link px-1" type="button" data-bs-toggle="modal"
                          data-bs-target="#schedule-errors">подробнее
                  </button>
                </div>
              @endif
            </div>
            <!--buttons-->
            <div>
              @if($scheduleProject['КодСтатуса'] == 1)
                <button id="button-change-schedule-status" class="btn btn-success" onclick="approve()">Утвердить
                </button>
              @elseif($scheduleProject['КодСтатуса']  == 2)
                <button id="button-change-schedule-status" class="btn btn-warning" onclick="forming()">Вернуть на
                  формирование
                </button>
              @endif
              <button id="download-version" class="btn btn-primary" title="Скачать" onclick="download()"><i
                  class='bx bx-download'></i>
              </button>
            </div>
          </div>

          <div class="d-flex flex-wrap justify-content-between align-items-center">
            <div class="col-auto border rounded border-dashed mb-3 p-1">
              <div class="d-flex flex-wrap">
                <div>
                  <div class=" badge bg-label-warning text-black m-1"> форс-мажор</div>
                </div>
                <div>
                  <div class="badge bg-label-primary text-white m-1"> рабочий день</div>
                </div>
                <div>
                  <div class="badge text-primary bg-label-gray m-1"> пустой день</div>
                </div>
              </div>
            </div>
            <div class="col-auto">
              Статистика по неделям:
              <button class="btn btn-sm btn-outline-light open-week-statistic-btn" title="Статистика по неделям"><div class="spinner-border spinner-border-sm text-primary" role="status"></div></button>
            </div>
          </div>



          @if($currentVersionId)
            <div id="created-schedule" class="overflow-auto w-100" style="height: 600px; overflow-y: scroll;">
              <table id="project-schedule" class="modals_tables_grop datatables-basic table border-top w-100">
                <thead>
                <th>Информация о враче</th>
                @php
                  // Разделяем дату на год и месяц
                  list($year, $month) = explode('-', $date);
                  // Получаем количество дней в месяце
                  $daysInMonth = date('t', strtotime($date));
                  // Выводим каждый день месяца
                  for ($day = 1; $day <= $daysInMonth; $day++) {
                  // Форматируем дату
                  $formattedDate = sprintf('%02d', $day);

                  $buttonToggleStat = '<button class="btn btn-sm btn-outline-light open-day-statistic-btn" data-day="'. $day .'" title="Статистика по дню"><div class="spinner-border spinner-border-sm text-primary" role="status"></div></button>';

                  echo '<th class="text-center"><div class="position-relative">'. $formattedDate . PHP_EOL. $buttonToggleStat.'</div> </th> ';
                  if($day == 15){
                          echo '<th>Итог за 1 половину:</th>';
                  }
                  }
                @endphp
                <th>Итог за 2 половину:</th>
                <th>Норма часов <br>
                  по графику / полный месяц
                </th>
                </thead>
                <tbody>
                @foreach($scheduleVersionData as $doc)
                  <tr>
                    <td class="no-click">
                      <div class="d-flex">
                        <div class="col-6 d-flex flex-column">
                         <span class="text-muted mb-2"
                               title="Табельный номер">№ {{$doc['ТабНомер'] ? $doc['ТабНомер'] : '-'}} </span>
                          <h6>{{$doc['ФИО']}}</h6>
                          <span>ставка: {{$doc['Ставка']}}</span>
                        </div>
                        <div class="col-6 d-flex flex-wrap">
                          @foreach($doc['Модальности'] as $modal)
                            <span class="{{$modal['Основная'] ? 'text-primary' : ''}} m-1 ms-0 mt-0"
                                  title="{{$modal['Основная'] ? 'Основная модальность' : ''}}">{{ $modal['Модальность']['Аббр'] ? $modal['Модальность']['Аббр'] : $modal['Модальность']['Название']}}</span>
                          @endforeach
                        </div>
                      </div>
                    </td>
                    @foreach($doc['СменыНаМесяц'] as $workDay)
                      <td class="p-1" data-doc="{{json_encode($workDay)}}"
                          data-doctor="{{json_encode($doc['КодДоктора'])}}">
                        @if($workDay['Смена'])
                          <div
                            class="d-flex flex-column align-items-center justify-content-center p-2 border rounded text-center w-px-150 h-px-100 {{$workDay['Запись']['Комментарий'] ? 'bg-label-warning text-black' : 'bg-label-primary text-white'}}">
                            @php
                              // Разделяем исходную дату и время
                               $time = $workDay['Смена']['ВремяНачала'];
                              // Разделяем время, которое нужно добавить
                              list($addHours, $addMinutes, $addSeconds) = explode(':',  $workDay['Смена']['Продолжительность']);
                              list($addHours2, $addMinutes2, $addSeconds2) = explode(':',  $workDay['Смена']['Перерыв']);

                              // Преобразуем время в секунды
                              $addSeconds = $addHours * 3600 + $addMinutes * 60 + $addSeconds;
                              $addSeconds2 = $addHours2 * 3600 + $addMinutes2 * 60 + $addSeconds2;
                              // Преобразуем исходное время в секунды
                              list($hours, $minutes, $seconds) = explode(':', $time);
                              $originalSeconds = $hours * 3600 + $minutes * 60 + $seconds;
                              // Складываем секунды
                              $totalSeconds = $originalSeconds + $addSeconds + $addSeconds2;
                              // Преобразуем секунды в часы, минуты и секунды
                              $newHours = floor($totalSeconds / 3600);
                              $newMinutes = floor(($totalSeconds % 3600) / 60);
                              $newSeconds = $totalSeconds % 60;
                              // Форматируем новое время
                              $newTime = sprintf('%02d:%02d:%02d', $newHours, $newMinutes, $newSeconds);
                            @endphp
                            <div
                              class="d-flex mb-2">{{substr($workDay['Смена']['ВремяНачала'],0, strlen($workDay['Смена']['ВремяНачала']) -3)}}
                              - {{substr($newTime,0, strlen($newTime) -3)}}</div>
                            <div class="d-flex"><i class='bx bx-bowl-hot'
                                                   title="Перерыв"></i> {{substr($workDay['Смена']['Перерыв'],0, strlen($workDay['Смена']['Перерыв']) -3)}}
                            </div>
                            <div class="d-flex"><i class='bx bx-time-five'
                                                   title="Отработано"></i>{{substr($workDay['Смена']['Продолжительность'],0, strlen($workDay['Смена']['Продолжительность']) -3)}}
                            </div>
                          </div>
                        @else
                          <div
                            class="d-flex flex-column justify-content-center align-items-center text-primary bg-label-gray p-3 border rounded text-center w-px-150 h-px-100">
                            -
                          </div>
                        @endif
                      </td>
                      @if(substr($workDay['Дата'], 8, 2) == '15')
                        <td class="no-click">{{$doc['Итог1']}}</td>
                      @endif
                    @endforeach
                    <td class="no-click">{{$doc['Итог2']}}</td>
                    <td
                      class="no-click">{{ substr($doc['НормаЧасовПоГрафику'],0, strlen($doc['НормаЧасовПоГрафику']) -3)}}
                      / {{ substr($doc['НормаЧасовЗаПолныйМесяц'],0, strlen($doc['НормаЧасовЗаПолныйМесяц']) -3)}}</td>
                  </tr>
                @endforeach
                </tbody>
              </table>
            </div>
          @endif
        </div>
      @else
        <div id="schedule-crate-project-label">
          <div class="d-flex flex-column justify-content-center align-items-center h-px-400">
            <h5>График работы врачей на выбранный месяц еще не сформирован</h5>
            <button class="btn btn-primary" onclick="createProject()">Сформировать</button>
          </div>
        </div>

        <div id="schedule-create-process" style="display: none">
          <div class="d-flex flex-column align-items-center justify-content-center h-px-350 w-100">
            <div class="spinner-border mb-2" style="width: 3rem; height: 3rem;" role="status"></div>
            <span class="text-muted">Идет формирование расписания</span>
          </div>
        </div>
      @endif
    </div>
  </div>
@endsection
@section('page-script')
  <script>

    $(function () {
      getDaysStatistic();
      getWeekStatistic();
    })

    $('#schedule-month-selector').on('change', function () {
      initLoadingContent();
      let scheduleDate = $('#schedule-month-selector').val();
      window.location.replace('/schedule/' + scheduleDate);
    })

    $('#project-version-select').on('change', function () {
      initLoadingContent();
      let scheduleDate = $('#schedule-month-selector').val();
      let version = $('#project-version-select').val();
      window.location.replace('/schedule/' + scheduleDate + '/' + version);
    })

    function createProject() {

      $('#schedule-crate-project-label').hide();
      $('#schedule-create-process').show();
      const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

      fetch('/schedule/create-project', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': csrfToken // Устанавливаем CSRF-токен
        },
        body: JSON.stringify({
          projectDate: $('#schedule-month-selector').val()
        })
      })
        .then(response => response.json())
        .then(data => {
          location.reload();
        })
        .catch(error => {
          // Обработка ошибок
          console.error('Ошибка:', error);
          contentLoaded();
        });
    }

    function approve() {
      $('#button-change-schedule-status').prop('disabled', true);
      let previousBtnContent = $('#button-change-schedule-status').html();
      let newButtontext = '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span> Утверждаем график ...';
      $('#button-change-schedule-status').html(newButtontext);
      initLoadingContent();
      const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
      fetch('/schedule/project-approve', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': csrfToken // Устанавливаем CSRF-токен
        },
        body: JSON.stringify({
          projectCode: $('#projectCode').val(),
          versionCode: $('#project-version-select').val()
        })
      })
        .then(response => response.json())
        .then(data => {
          location.reload();
        })
        .catch(error => {
          $('#button-change-schedule-status').html(previousBtnContent);
          $('#button-change-schedule-status').prop('disabled', false);
          // Обработка ошибок
          console.error('Ошибка:', error);
          contentLoaded();
        });
    }

    function download() {
      $('#download-version').prop('disabled', true);
      let previousBtnContent = $('#download-version').html();
      let newButtontext = '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span> Загружаем график...';
      $('#download-version').html(newButtontext);
      let version = $('#project-version-select').val();
      let fileName = '';
      fetch('/download/schedule/' + version)
        .then(response => {
          // Проверяем статус ответа
          if (!response.ok) {
            throw new Error(`Ошибка получения документа: ${response.status}`);
          }

          // Извлекаем имя файла и расширение из заголовков ответа
          const contentDisposition = response.headers.get('Content-Disposition');
          fileName = contentDisposition.split('filename=')[1];
          fileName = decodeURIComponent(escape(fileName));

          // Преобразуем ответ в Blob (двоичные данные)
          return response.blob();
        })
        .then(blob => {
          // Создаём ссылку для скачивания
          const url = window.URL.createObjectURL(blob);
          const link = document.createElement('a');
          link.href = url;
          link.download = fileName; // Используем имя файла из заголовков

          // Имитируем клик на ссылку для запуска скачивания
          document.body.appendChild(link);
          link.click();
          document.body.removeChild(link);

          // Освобождаем URL
          window.URL.revokeObjectURL(url);

          $('#download-version').html(previousBtnContent);
          $('#download-version').prop('disabled', false);
        })
        .catch(error => {
          console.error('Ошибка:', error);
          $('#download-version').html(previousBtnContent);
          $('#download-version').prop('disabled', false);
        });
    }

    function createNewVersion() {
      $('#create-new-version-btn').prop('disabled', true);
      let previousBtnContent = $('#create-new-version-btn').html();
      let newButtontext = '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span> Идет формирование графика...';
      $('#create-new-version-btn').html(newButtontext);
      $('#form-schedile-content').hide();
      $('#schedule-create-process-handle').show();
      initLoadingContent();
      const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
      fetch('/schedule/generate-new-version', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': csrfToken // Устанавливаем CSRF-токен
        },
        body: JSON.stringify({
          code: $('#projectCode').val()
        })
      })
        .then(response => response.json())
        .then(data => {
          location.reload();
        })
        .catch(error => {
          // Обработка ошибок
          $('#create-new-version-btn').html(previousBtnContent);
          $('#create-new-version-btn').prop('disabled', false);
          console.error('Ошибка:', error);
          contentLoaded();

        });
    }

    function forming() {
      $('#button-change-schedule-status').prop('disabled', true);
      let previousBtnContent = $('#button-change-schedule-status').html();
      let newButtontext = '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span> Возвращаем на формирование ...';
      $('#button-change-schedule-status').html(newButtontext);
      initLoadingContent();
      const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
      fetch('/schedule/project-forming', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': csrfToken // Устанавливаем CSRF-токен
        },
        body: JSON.stringify({
          projectCode: $('#projectCode').val()
        })
      })
        .then(response => response.json())
        .then(data => {
          location.reload();
        })
        .catch(error => {
          // Обработка ошибок
          $('#button-change-schedule-status').html(previousBtnContent);
          $('#button-change-schedule-status').prop('disabled', false);
          console.error('Ошибка:', error);
          contentLoaded();
        });
    }


    @if(isset($scheduleCurrentVersion) && !$scheduleCurrentVersion['Утверждено'])
    $(document).click(function (event) {
      if (!$(event.target).closest('#project-schedule tbody td').length) {
        // Скрываем модальное окно
        $('#contextMenu').hide();
      }
    });


    $('#project-schedule').on('click', 'tbody td', function (event) {

      if ($(event.currentTarget).hasClass('no-click')) {
        return;
      }

      let data = $(event.currentTarget).data('doc');
      let doctorId = $(event.currentTarget).data('doctor');
      //Добавить событие в пустое место
      if (this.textContent.trim() === '-') {
        let rect = this.getBoundingClientRect();

        let HTMLContent = `<ul class="dropdown-menu dropdown-menu-end p-0 m-0 show" data-bs-popper="static">` +
          `<li onclick="newEvent('${data['Дата']}', '${doctorId}')"> <a class="dropdown-item" tabindex="-1" href="#">Добавить рабочий день</a></li>` +
          `</ul>`;

        $('#contextMenu').css({
          left: rect.left + window.pageXOffset + 50,
          top: rect.top + window.pageYOffset + 50
        });
        $('#contextMenu').html(HTMLContent);
        $('#contextMenu').show();
      }
      //Редактировать событие
      else {
        editEvent(data, doctorId); //поменять в дальнейшем на индекс this.parentNode.rowIndex и this.cellIndex
      }
    })


    function newEvent(eventData, doctorId) {

      $("#contextMenu").hide();
      $('#newEventModal').modal('show');

      $('#addEventForm').unbind();
      $('#addEventForm').on('submit', function (event) {
        event.preventDefault();

        let selectedOption = $("#workTimeSelect option:selected");
        let startWorkTime = selectedOption.data("info");
        if (!startWorkTime) return;


        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        fetch('/forming/schedule/add-work-day', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken // Устанавливаем CSRF-токен
          },
          body: JSON.stringify({
            schVersion: $('#project-version-select').val(),
            docId: doctorId,
            date: eventData,
            eventCode: startWorkTime['Код']
          })
        })
          .then(response => response.json())
          .then(data => {
            $('#newEventModal').modal('hide');
            location.reload();
          })
          .catch(error => {
            // Обработка ошибок
            console.error('Ошибка:', error);
          });
      });
    }


    function getDaysStatistic() {
      let currentScheduleVersion = $('#project-version-select').val();
      fetch('/schedule/getDaysStatistic/' + currentScheduleVersion, {}).then(response => response.json())
        .then(data => {

          $('.open-day-statistic-btn').html('<i class="text-primary bx bx-receipt"></i>');
          $('.open-day-statistic-btn').on('click', function(event){
            let day = $(event.currentTarget).data('day');
            let currentDayData = data[day - 1];
            let momentDate = moment(currentDayData['Дата']);

            $formateStatistic = '<div class="fs-6 mb-4">Дата статистики: '+ momentDate.format("DD.MM.YYYY") +'</div>'

            $formateStatistic += '<div class="d-flex flex-wrap">';
            currentDayData['Значения'].forEach(modal => {
              $formateStatistic += '<div class="col-12 col-md-6 mb-4 p-2">';
              $formateStatistic += '<strong>'+modal['ТипИсследований']['Название']+'</strong> <br>';
              $formateStatistic += 'Кол-во врачей: ' + modal['КоличествоДокторвРеально'] + '<br>';
              $formateStatistic += 'Кол-во исследований: ' + modal['КоличествоИсследованийРеально'] + '<br>';
              $formateStatistic += 'Кол-во часов: ' + modal['КоличествоЧасовРеально'] + '<br>';
              $formateStatistic += '</div>';
            });
            $formateStatistic += '</div>';

            $('#dayStatistic-modal-body').html($formateStatistic);
            $('#dayStatistic').modal('show');
          });

        })
        .catch(error => {
          // Обработка ошибок
          console.error('Ошибка:', error);
        });

    }

    function getWeekStatistic(){
      let currentScheduleVersion = $('#project-version-select').val();
      fetch('/schedule/getWeeksStatistic/' + currentScheduleVersion, {}).then(response => response.json())
        .then(data => {
          $('.open-week-statistic-btn').html('<i class="text-primary bx bx-receipt"></i>');
          $('.open-week-statistic-btn').on('click', function(event){

            $formateStatistic = '';
            data.forEach(week=>{
              let startWeek = moment(week['ДатаНачалаНедели']);
              $formateStatistic += '<h5 class="my-4">Неделя: '+ startWeek.format("DD.MM.YYYY") + '</h5>'
              $formateStatistic += '<div class="d-flex flex-wrap">';

              week['Значения'].forEach(modal => {
                $formateStatistic += '<div class="col-12 col-md-6 p-2 border">';
                $formateStatistic += '<div class="mb-2"><strong>'+modal['ТипИсследований']['Название']+'</strong></div>';


                $formateStatistic += 'Мин. кол-во врачей для закрытия: ' + modal['МинКоличествоДокторвДляЗакрытия'] + '<br>';
                $formateStatistic += 'Макс. кол-во врачей для закрытия: ' + modal['МаксКоличествоДокторвДляЗакрытия'] + '<br>';
                $formateStatistic += 'Кол-во врачей для закрытия: ' + modal['КоличествоДокторвДляЗакрытия'] + '<br>';
                $formateStatistic += 'Фактическое кол-во врачей: ' + modal['КоличествоДокторвРеально'] + '<br>';
                $formateStatistic += '<hr>';

                $formateStatistic += 'Прогнозируемое кол-во исследований: ' + modal['КоличествоИсследованийПрогнозируемое'] + '<br>';
                $formateStatistic += 'Фактическое кол-во исследований: ' + modal['КоличествоИсследованийРеально'] + '<br>';
                $formateStatistic += '<hr>';

                $formateStatistic += 'Мин. кол-во часов для закрытия: ' + modal['МинЧасовДляЗакрытия'] + '<br>';
                $formateStatistic += 'Макс. кол-во часов для закрытия: ' + modal['МаксЧасовДляЗакрытия'] + '<br>';
                $formateStatistic += 'Кол-во часов для закрытия: ' + modal['ЧасовДляЗакрытия'] + '<br>';
                $formateStatistic += 'Фактическое кол-во часов: ' + modal['КоличествоЧасовРеально'] + '<br>';
                $formateStatistic += '</div>';
              });
              $formateStatistic += '</div>';
            })

            $('#weekStatistic-modal-body').html($formateStatistic);
            $('#weekStatistic').modal('show');
          });

        })
        .catch(error => {
          // Обработка ошибок
          console.error('Ошибка:', error);
        });
    }

    function editEvent(eventData, doctorId) {

      $("#contextMenu").hide();
      $('#workTimeSelect-edit').val(eventData['Смена']['Код']);
      $('#editEventModal').modal('show');


      $('#editEventForm').unbind();
      $('#editEventForm').on('submit', function (event) {
        event.preventDefault();

        let selectedOption = $("#workTimeSelect-edit option:selected");
        let startWorkTime = selectedOption.data("info");
        if (!startWorkTime) return;

        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        fetch('/forming/schedule/edit-work-day', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken // Устанавливаем CSRF-токен
          },
          body: JSON.stringify({
            schVersion: $('#project-version-select').val(),
            docId: doctorId,
            date: eventData['Дата'],
            eventCode: eventData['Смена']['Код'],
            newEventCode: startWorkTime['Код']
          })
        })
          .then(response => response.json())
          .then(data => {
            $('#editEventModal').modal('hide');
            location.reload();
          })
          .catch(error => {
            // Обработка ошибок
            console.error('Ошибка:', error);
          });

      });




      $('#deleteEvent').unbind();
      $('#deleteEvent').on('click', function () {
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        fetch('/forming/schedule/delete-work-day', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken // Устанавливаем CSRF-токен
          },
          body: JSON.stringify({
            schVersion: $('#project-version-select').val(),
            docId: doctorId,
            date: eventData['Дата'],
            eventCode: eventData['Смена']['Код']
          })
        })
          .then(response => response.json())
          .then(data => {
            $('#editEventModal').modal('hide');
            location.reload();
          })
          .catch(error => {
            // Обработка ошибок
            console.error('Ошибка:', error);
          });
      });

    }
    @endif

    function initLoadingContent() {
      $('#schedule-content-loading').show();
      $('#create-new-version-btn').prop('disabled', true);
      $('#schedule-month-selector').prop('disabled', true);
    }

    function contentLoaded() {
      $('#schedule-content-loading').hide();
      $('#create-new-version-btn').prop('disabled', false);
      $('#schedule-month-selector').prop('disabled', false);
    }
  </script>
@endsection
