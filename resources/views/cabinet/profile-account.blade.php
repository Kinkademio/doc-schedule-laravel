@extends('cabinet/layouts/profile')

@section('cabinet-vendor-script')
  <script src="{{ mix('assets/libs/FullCalendar/dist/index.global.min.js') }}"></script>
  <script src="{{ mix('assets/libs/moments/moments.js') }}"></script>
@endsection
@php
    $month = ["Январь", "Февраль", "Март", "Апрель", "Май", "Июнь", "Июль", "Август", "Сентябрь", "Октябрь", "Ноябрь", "Декабрь"];
    // Получить текущий месяц в виде числа
    $monthNumber = date('m');
    // Увеличить номер месяца на 1
    $nextMonthNumber = $monthNumber == 12 ? 1 : $monthNumber + 1;
    // Получить название месяца по номеру
    $nextMonthName = $month[$nextMonthNumber - 1];
@endphp

@section('content-cabinet')

  <style>
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
  </style>


  <div id="contextMenu" class="dropdown clearfix"></div>

  <div class="card mb-2">
    <div class="card-header pb-2">
      <h5><i class='bx bx-timer text-primary fs-3'></i> Рабочие нормы за {{$nextMonthName}}
        <script>document.write(new Date().getFullYear())</script>
      </h5>
    </div>
    <div class="card-body d-flex justify-content-between flex-wrap">

      <div class="col-12 col-sm-3  p-2 d-flex flex-column align-items-center justify-content-between">
        <div class="mb-2">
          Норма выработки часов в месяц:
        </div>
        <div>
          {{substr(Auth::user()->workNorm['НормаЧасов'], 0, strlen(Auth::user()->workNorm['НормаЧасов']) - 3)}}
        </div>
      </div>
      <div class="vr my-2 d-none d-sm-block"></div>

      <div class="col-12 col-sm-3 p-2 d-flex flex-column align-items-center justify-content-between">
        <div class="mb-2">
          Минимальное кол-во исследований:
        </div>
        <div>{{Auth::user()->workNorm['МинКолИсследований']}}</div>
      </div>

      <div class="vr my-2  d-none d-sm-block"></div>

      <div class="col-12 col-sm-3  p-2 d-flex flex-column align-items-center justify-content-between">
        <div class="mb-2"> Максимальное кол-во исследований:</div>
        <div>{{Auth::user()->workNorm['МаксКолИсследований']}}</div>
      </div>

    </div>
  </div>

  <div class="card mb-2">
    <div class="card-body p-2">
      <div class="alert alert-warning m-0" role="alert">
        <h6 class="alert-heading mb-1"><i class='bx bx-info-square fs-3'></i> Внимание!</h6>
        <ul>
          <li>Желаемый график, является рекомендацией для системы исходя их которой будет сформирован ваш основной
            график работы.
          </li>
          <li>Если желаемый график не будет заполнен система сформирует ваш основной график работы в автоматическом
            режиме.
          </li>
          <li>Ваш основной график работы может не совпадать с желаемым.</li>
        </ul>
      </div>
    </div>
  </div>

  <div class="card mb-4">
    <div class="card-header d-flex justify-content-between">
      <h5 class="mb-1"><i class='bx bxs-calendar me-1 text-primary fs-3'></i>Желаемый график работы</h5>
      <h6>Заполнено: <span id="calckWorkHours">0</span> из <span
          id="normWorkHours">{{substr(Auth::user()->workNorm['НормаЧасов'], 0, strlen(Auth::user()->workNorm['НормаЧасов']) - 3)}}</span>
      </h6>
    </div>

    <div class="card-body">
      <div id="calendar-alert" class="alert alert-danger m-0 mb-2" role="alert" style="display: none">
        <h6 class="alert-heading mb-1"><i class='bx bx-info-square fs-3'></i> Допущены ошибки!</h6>
        <ul id="calendar-alert-list">
        </ul>
      </div>
      <div id="calendar-alert-save-success" class="alert alert-success m-0 mb-2" role="alert" style="display: none">
        <h6 class="alert-heading mb-1"><i class='bx bx-check fs-3'></i> Сохранено</h6>
        <ul id="calendar-alert-list">
          График работы сохранен!
        </ul>
      </div>


      <div id="calendar"></div>
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
                          Время работы: {{substr($type['ВремяНачала'], 0, strlen($type['ВремяНачала']) - 3)}} - {{substr($type['ВремяОкончания'], 0, strlen($type['ВремяОкончания']) - 3)}}
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
                          Время работы: {{substr($type['ВремяНачала'], 0, strlen($type['ВремяНачала']) - 3)}} - {{substr($type['ВремяОкончания'], 0, strlen($type['ВремяОкончания']) - 3)}}
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

@endsection

@section('cabinet-page-script')
  <script>

    let eventList = [];

    //Заносим данные из php
    @if(isset(Auth::user()->hrInfo->Отпуска ))
    @foreach (Auth::user()->hrInfo->Отпуска as $key => $value)
    @if($value['Активно'])
    createEventOtpusk('{{$value['ТипОтпуска']['Название']}}', '{{$value['ДатаНачала']}}', '{{$value['ДатаОкончания']}}', eventList);
    @endif
    @endforeach
    @endif

    @if(isset($preferSchedule))
    @foreach($preferSchedule as $one)
      createWorkDay('{{$one['Дата']}}','{{$one['ДатаОкончания']}}', '{{json_encode($one->ТипРабочейСмены)}}', eventList);
    @endforeach
    @endif

    let calendar;
    let firstDayOfMouth;
    let lastDayOfMouth;
    let workModifier = parseFloat('{{Auth::user()->hrInfo->Ставка}}');

    $('#starts-at').on('change', function () {
      $('#ends-at').attr('min', $('#starts-at').val())
    })

    $(document).click(function(event) {
      if (!$(event.target).closest('.fc-scrollgrid tbody td').length) {
        // Скрываем модальное окно
        $('#contextMenu').hide();
      }
    });

    $(function () {
      moment.updateLocale('en', {
        week: {
          dow: 1 // понедельник - первый день недели
        }
      });

      let calendarEl = document.getElementById('calendar');
      calendar = new FullCalendar.Calendar(calendarEl, {
        views: {
          month: {
            type: 'onemonth',
            duration: {months: 1}
          },
        },
        locale: 'ru',
        themeSystem: 'bootstrap5',
        firstDay: '1',
        multiMonthMaxColumns: 1,
        headerToolbar: {
          end: '',
          right: 'myCustomButton'
        },
        customButtons: {
          myCustomButton: {
            text: 'Сохранить',
            class: 'btn btn-primary',
            click: function() {
              saveSchedule();
            }
          },
        },
        eventContent: function (info) {

          let start = moment(info.event.start).format('HH:mm');
          let end = moment(info.event.end).format('HH:mm');
          let durationFrom = '';
          let durationTo = '';
          let eatTime = '';
          if (start !== end) {
            durationFrom = '<div> с: ' + moment(info.event.start).format('HH:mm') + '</div>';
            durationTo = '<div> по: ' + moment(info.event.end).format('HH:mm') + '</div>';
            eatTime = '<div> Обед: ' + info.event.extendedProps.description['Перерыв'].substr(0, 5) + ' ч. </div>';
          }

          let title = '<div>' + info.event.title + '</div>';
          let content = '<div class="d-flex flex-column p-1">' + title + durationFrom + durationTo + eatTime + '</div>';
          return {html: content}
        },
        buttonText: {
          today: 'Сегодня',
          month: 'Месяц',
          week: 'Неделя',
          day: 'День',
          list: 'Список',
        },
        selectAllow: function (info) {
          $('#contextMenu').hide();
          //Ограничиваем только текущим месяцем
          if (info.start < firstDayOfMouth || info.end > lastDayOfMouth) {
            return false;
          }
          //Проверяем чтобы пользователь не выбирал диапазон более 1 дня
          if (info.end - info.start <= 86400000) {
            return true;
          }

          return false;
        },

        timeZone: 'local',
        displayEventTime: true,
        displayEventEnd: true,
        selectable: true,
        unselectAuto: true,
        longPressDelay: 0,
        selectOverlap: true,
        events: eventList,
        select: function (selectInfo) {
          let HTMLContent = '<ul class="dropdown-menu dropdown-menu-end p-0 m-0 show" data-bs-popper="static">' +
            '<li onclick="newEvent(\'' + selectInfo.startStr + '\', \'' + selectInfo.endStr + '\')"> <a class="dropdown-item" tabindex="-1" href="#">Добавить рабочий день</a></li>' +
            '</ul>';

          let rect = selectInfo.jsEvent.changedTouches ? selectInfo.jsEvent.changedTouches[0] : selectInfo.jsEvent;

          $('#contextMenu').css({
            left:  rect.pageX,
            top: rect.pageY
          });
          $('#contextMenu').html(HTMLContent);
          $('#contextMenu').show();

        },
        editable: true,
        eventStartEditable: false,
        eventClick: function(eventData) {
          if(eventData.event.title == 'Рабочий день'){
            editEvent(eventData);
          }
        }
      });

      calendar.render();
      calendar.next();
      //Сохраняем дату текущего месяца
      firstDayOfMouth = new Date(calendar.currentData.dateProfile.currentRange.start);
      firstDayOfMouth.setHours(0, 0, 0, 0);
      lastDayOfMouth = new Date(calendar.currentData.dateProfile.currentRange.end);
      lastDayOfMouth.setHours(0, 0, 0, 0);
      calckWorkTime();
      checkEvents();

      $('.fc-myCustomButton-button').removeClass('fc-button fc-button-primary');
      $('.fc-myCustomButton-button').addClass('btn btn-success');
    });

    function newEvent(start) {

      $("#contextMenu").hide();
      $('#newEventModal').modal('show');

      $('#addEventForm').unbind();
      $('#addEventForm').on('submit', function (event) {
        event.preventDefault();

        let selectedOption = $("#workTimeSelect option:selected");
        let startWorkTime = selectedOption.data("info");
        if (!startWorkTime) return;

        // Преобразовать длительность в секунды
        const durationInSeconds = (duration) => {
          const timeArray = duration.split(":");
          return parseInt(timeArray[0]) * 3600 + parseInt(timeArray[1]) * 60 + parseInt(timeArray[2]);
        };

        let startDate = new Date(start + 'T' + startWorkTime['ВремяНачала']);

        let end = new Date();
        end.setTime(startDate.getTime() + (durationInSeconds(startWorkTime['Продолжительность']) + durationInSeconds(startWorkTime['Перерыв'])) * 1000);

        let eventData = {
          title: 'Рабочий день',
          display: 'block',
          start: startDate,
          end: end,
          className: 'd-flex flex-column',
          backgroundColor: '#3788d8',
          description: startWorkTime
        };

        calendar.addEvent(eventData);
        calckWorkTime();
        checkEvents();
        $('#newEventModal').modal('hide');
      });
    }

    function hideMenu(){}



    function editEvent(eventData) {
      $("#contextMenu").hide();
      $('#workTimeSelect-edit').val(eventData.event.extendedProps.description['Код']);
      $('#editEventModal').modal('show');


      $('#editEventForm').unbind();
      $('#editEventForm').on('submit', function (event) {
        event.preventDefault();

        let selectedOption = $("#workTimeSelect-edit option:selected");
        let startWorkTime = selectedOption.data("info");
        if (!startWorkTime) return;


        // Преобразовать длительность в секунды
        const durationInSeconds = (duration) => {
          const timeArray = duration.split(":");
          return parseInt(timeArray[0]) * 3600 + parseInt(timeArray[1]) * 60 + parseInt(timeArray[2]);
        };

        let startDateStr = moment(eventData.event.start).format('YYYY-MM-DD');
        let startDate = new Date(startDateStr + 'T' + startWorkTime['ВремяНачала']);

        let end = new Date();
        end.setTime(startDate.getTime() + (durationInSeconds(startWorkTime['Продолжительность']) + durationInSeconds(startWorkTime['Перерыв'])) * 1000);

        let newEventData = {
          title: 'Рабочий день',
          display: 'block',
          start: startDate,
          end: end,
          className: 'd-flex flex-column',
          backgroundColor: '#3788d8',
          description: startWorkTime
        };

        eventData.event.remove();
        calendar.addEvent(newEventData);
        calendar.render();
        calckWorkTime();
        checkEvents();
        $('#editEventModal').modal('hide');
      });

      $('#deleteEvent').unbind();
      $('#deleteEvent').on('click', function() {
        eventData.event.remove();
        calckWorkTime();
        checkEvents();
        $('#editEventModal').modal('hide');
      });

    }


    function calckWorkTime() {
      let totalSeconds = 0;
      let eventList = getEventsForCurrentMonth();
      for (let i = 0; i < eventList.length; i++) {
        if (eventList[i].title == 'Рабочий день') {
          // Найти общее время в секундах
          totalSeconds += toSeconds(splitTime(eventList[i].extendedProps.description['Продолжительность']));
        }
      }
      const hours = Math.floor(totalSeconds / 3600);
      const minutes = Math.floor((totalSeconds % 3600) / 60);
      const formattedTime = hours.toString() + ':' + minutes.toString().padStart(2, '0');

      let tableValueHtml = $('#normWorkHours').html();
      let [tableHours, tableMinutes] = tableValueHtml.split(':');
      let tableHoursInt = parseInt(tableHours);
      let tableMinutesInt = parseInt(tableMinutes);
      let totalTableSeconds = tableHoursInt * 3600 + tableMinutesInt * 60;
      if(totalSeconds >= totalTableSeconds){
        $('#calckWorkHours').removeClass('text-warning');
        $('#calckWorkHours').addClass('text-success');
        //Тут показать кнопку сохранить или сохранять автоматически
      }else{
        $('#calckWorkHours').removeClass('text-success');
        $('#calckWorkHours').addClass('text-warning');
      }
      $('#calckWorkHours').html(formattedTime);

    }


    function createEventOtpusk(eventName, dateStart, dateEnd, eventList) {
      eventList.push({
        title: eventName,
        start: dateStart,
        end: dateEnd,
        display: 'block',
        backgroundColor: '#afe872',
      });
    }

    function createWorkDay(dateStart, dateEnd, startWorkTime,  eventList){
      startWorkTime = startWorkTime.replaceAll('&quot;','"');
      startWorkTime = startWorkTime.replaceAll('\'','');

      eventList.push(
        {
          title: 'Рабочий день',
          display: 'block',
          start: dateStart,
          end: dateEnd,
          className: 'd-flex flex-column',
          backgroundColor: '#3788d8',
          description: JSON.parse(startWorkTime)
        }
      )
    }

    // Разбить время на часы, минуты и секунды
    function splitTime(time) {
      const [hours, minutes, seconds] = time.split(':');
      return [parseInt(hours), parseInt(minutes), parseInt(seconds)];
    }

    // Преобразовать в секунды
    function toSeconds(time) {
      const [hours, minutes, seconds] = time;
      return hours * 3600 + minutes * 60 + seconds;
    }

    function getEventsForCurrentMonth(types = []) {

      const view = calendar.currentData.dateProfile.currentRange;
      const intervalStart = view.start;
      intervalStart.setHours(0, 0, 0, 0);

      const intervalEnd = view.end;
      intervalEnd.setHours(24, 0, 0, 0);

      const events = calendar.getEvents();
      const eventsInCurrentMonth = [];
      events.forEach(event => {
        const startDate = moment(event.start);
        const endDate = moment(event.end);

        if (startDate >= intervalStart && endDate <= intervalEnd) {

          if(types.length == 0){
            eventsInCurrentMonth.push(event);
          }else{
              if(types.includes(event.title)){
                eventsInCurrentMonth.push(event);
              }
          }
        }
      });
      eventsInCurrentMonth.sort((a, b) => a.start.valueOf() - b.start.valueOf());
      return eventsInCurrentMonth;
    }


    function checkEvents() {
      let errors = [];
      // Получаем все события текущего месяца
      let events = getEventsForCurrentMonth();

      // 1. Проверка на одновременность "Рабочий день" и "Отпуск"
      events.forEach(event => {
        if (event.title === 'Рабочий день') {
          events.forEach(otherEvent => {
            if (otherEvent.title === 'Отпуск' &&
              event.start < otherEvent.end &&
              otherEvent.start < event.end) {
              errors.push('Ошибка: Событие "Рабочий день" пересекается с событием "Отпуск".');
              event.setProp('backgroundColor', 'red');
            }
          });
        }
      });

      //Получаем только рабочие дни
      events = getEventsForCurrentMonth(['Рабочий день']);

      //Сбрасываем цвет всех событий в синий
      changeAllEventsColor(events, '#3788d8');
      const weeks = getWeeks(events);

      // 3. Проверка суммарной длительности событий в неделе
      let weekCount = 1;
      for (let key in weeks) {
        if(weekCount > 5) break;
        let totalDuration = 0;
        weeks[key].forEach(event => {
          totalDuration += toSeconds(splitTime(event.extendedProps.description['Продолжительность']));
        });

        let week = moment().week(key)
        let weekStart = week.startOf('week');
        let endofWeek = weekStart.clone().add(7, 'days');
        let endOfMounth = moment(lastDayOfMouth);
        if(endOfMounth < endofWeek){
          endofWeek = endOfMounth;
        }

        let rateWorkHours = 7.8;
        let countOfWeekDays = endofWeek.diff(weekStart, 'days');
        let countOfFreeDays = countOfWeekDays <= 5 ? 0 : countOfWeekDays == 6 ? 1: countOfWeekDays == 7 ? 2 : 0;

        let hoursAtWeek = ((countOfWeekDays - countOfFreeDays) * rateWorkHours) * workModifier;
        let extraHours = 15 * workModifier;

        const totalDurationHours = Math.floor(totalDuration / 3600);
        if (!(0 <= (totalDurationHours - (hoursAtWeek)) && (totalDurationHours - (hoursAtWeek)) <= (extraHours))) {
          errors.push('Ошибка: Неверная суммарная длительность рабочих смен на неделе ' + weekCount + ', заполнено часов: ' + totalDurationHours + ' из '+(hoursAtWeek)+' + '+(extraHours)+' возможных на ставку '+ workModifier + '<i data-toggle="tooltip" data-placement="bottom" title="Часы расчитаны по формуле: (('+countOfWeekDays+' - ' +countOfFreeDays+') * '+rateWorkHours+') * '+workModifier+'" class="bx bx-info-circle mb-1 ms-1 fs-6"></i>');
          weeks[key].forEach(event => {
            event.setProp('backgroundColor', 'red');
          });
        }
        weekCount++;

      }


      // 5. Проверка на три подряд события длительностью 11 и 12 часов
      for (let i = 0; i < events.length - 2; i++) {
        const duration1 = Math.floor(toSeconds(splitTime(events[i].extendedProps.description['Продолжительность'])) / 3600);
        const duration2 = Math.floor(toSeconds(splitTime(events[i + 1].extendedProps.description['Продолжительность'])) / 3600);
        const duration3 = Math.floor(toSeconds(splitTime(events[i + 2].extendedProps.description['Продолжительность'])) / 3600);

        let currentDay = moment(events[i].start);
        let nextDay = moment(events[i+ 1].start);
        let nextNextDay = moment(events[i + 2].start);


        if ((duration1 >= 11) && (duration2 >= 11) && (duration3 >= 11) && nextDay.diff(currentDay, 'days') <= 1 && nextNextDay.diff(nextDay, 'days') <= 1) {
          errors.push('Ошибка: Три рабочие смены с длительностью 11 или 12 часов подряд.' + events[i].start);
          events[i].setProp('backgroundColor', 'red');
          events[i + 1].setProp('backgroundColor', 'red');
          events[i + 2].setProp('backgroundColor', 'red');
        }
      }

      // 6. Проверка на событие после ночного события
      events.forEach((event, index) => {
        if (event.extendedProps.description['Ночная']) {
          if(index + 1 < events.length){
            let currentEvent = moment(event.start);
            let nextEvent = moment(events[index + 1].start);

            if(nextEvent.diff(currentEvent, 'days') <= 1 && events[index + 1].extendedProps.description['Ночная'] == false){
              errors.push('Ошибка: После ночной смены ставить дневную недопустимо.' + event.start + '  ' + events[index + 1].start + '   '+ nextEvent.diff(currentEvent, 'days'));
              event.setProp('backgroundColor', 'red');
              events[index + 1].setProp('backgroundColor', 'red');
            }
          }
        }
      });

      // 6. Проверка на событие после ночного события
      events.forEach((event, index) => {
        if (index + 1 < events.length && events[index + 1].start.getTime() < event.end.getTime()) {
          errors.push('Ошибка: Смены накладываются друг на друга');
          event.setProp('backgroundColor', 'red');
          events[index + 1].setProp('backgroundColor', 'red');
        }
      });

      freeHours(events, errors)

      // 4. Проверка баланса событий в первой и второй половине месяца
      const firstHalfEvents = events.filter(event => {
        return event.start.getDate() <= 15;
      });
      const secondHalfEvents = events.filter(event => {
        return event.start.getDate() > 15;
      });
      let firstHalfDuration = 0;
      let secondHalfDuration = 0;
      firstHalfEvents.forEach(event => {
        firstHalfDuration += event.end - event.start;
      });
      secondHalfEvents.forEach(event => {
        secondHalfDuration += event.end - event.start;
      });
      const firstHalfDurationHours = firstHalfDuration / (1000 * 60 * 60);
      const secondHalfDurationHours = secondHalfDuration / (1000 * 60 * 60);
      if (Math.abs(firstHalfDurationHours - secondHalfDurationHours) > 10) {
        errors.push('Ошибка: Несбалансированное распределение рабочих смен по половинам месяца.');
      }


      formErrors(errors);
      return errors;
    }

    // Вспомогательная функция для группировки событий по неделям
    function getWeeks(events) {
      const weeks = {}; // Используем объект вместо массива
      events.forEach(event => {
        const weekNumber = getWeekNumber(event.startStr);
        // Проверяем, существует ли ключ weekNumber в объекте weeks
        if (!weeks[weekNumber]) {
          weeks[weekNumber] = []; // Создаем новый массив для этой недели, если ее еще нет
        }
        weeks[weekNumber].push(event); // Добавляем событие в соответствующий массив
      });
      return weeks;
    }

    function getWeekNumber(dateString) {
      // Преобразуем строку в объект Date
      const date = moment(dateString);
      // Получаем номер недели
      const weekNumber = date.locale('ru').week();
      // Возвращаем номер недели
      return weekNumber;
    }


    function formErrors(errors) {
      $('#calendar-alert').hide();
      let content = '';
      for (let i = 0; i < errors.length; i++) {
        content += '<li>' + errors[i] + '</li>';
      }
      $('#calendar-alert-list').html(content);
      if (errors.length > 0) {
        $('#calendar-alert').show();
      }
    }


    function freeHours(events, errors) {

      // Определяем начало и конец недели, исходя из 1 дня месяца
      const currentMonth = moment(firstDayOfMouth).month();

      let weekCount = 1;
      let startWeek = moment().month(currentMonth).date(1).startOf('week');
      let endWeek = startWeek.clone().add(7, 'days');
      while (moment(lastDayOfMouth) > endWeek) {
        // Инициализируем текущее время
        let currentTime = startWeek;

        let freeHoursOnWeek = false;

        let weeksEvents = [];

        for (let event of events) {
          // Если событие начинается раньше конца недели
          if (moment(event.start).isBefore(endWeek)) {
            // Если событие начинается после текущего времени
            if (moment(event.start).isAfter(currentTime)) {
              weeksEvents.push(event);
            }
          }
        }

        if(weeksEvents.length  == 0){
          freeHoursOnWeek = true;
        }

        // Проходим по каждому событию
        for (let wevent of weeksEvents) {
          // Если событие начинается раньше конца недели
          if (moment(wevent.start).isBefore(endWeek)) {
            // Если событие начинается после текущего времени
            if (moment(wevent.start).isAfter(currentTime)) {
              // Проверяем, достаточно ли времени между текущим временем и началом события
              const freeHours = moment(wevent.start).diff(currentTime, 'hours');
              if (freeHours >= 48) {
                freeHoursOnWeek = true;
                break;
              }
            }
            // Обновляем текущее время до конца события
            currentTime = wevent.end;
          }
        }

        let finalCheck =  moment(endWeek).diff(currentTime, 'hours');
        if(finalCheck >= 48){
          freeHoursOnWeek = true;
        }

        if(!freeHoursOnWeek){
          errors.push('Ошибка: Отсутствует перерыв 48ч на неделе ' + weekCount);
          weeksEvents.forEach(event=>{
              event.setProp('backgroundColor', 'red');
            }
          )
        }

        weekCount++;
        startWeek = endWeek;
        endWeek = startWeek.clone().add(7, 'days');
      }
    }

    function changeAllEventsColor(events, color){

      events.forEach(event => {
        event.setProp('backgroundColor', color);
      });
      calendar.render();
    }


    function saveSchedule(){
      let errors = checkEvents();

      if(errors.length > 0){
        alert('Перед сохранением графика необходимо устранить все ошибки!');
        return;
      }

      // Получаем CSRF-токен из мета-тега
      const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
      let events = calendar.getEvents();

      if(events.length == 0){
        alert('Перед сохранением необходимо заполнить расписание');
        return;
      }

      let data_arr = [];
      events.forEach((item, index)=>{
        data_arr.push({
          'title':item.title,
          'start':item.startStr.substring(0, 10),
          'description':item.extendedProps.description,
        })
      })

      fetch('/profile/save/prefer_schedule', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': csrfToken // Устанавливаем CSRF-токен
        },
        body: JSON.stringify({
          events: data_arr
        })
      })
        .then(response => response.json())
        .then(data => {
          $("#calendar-alert-save-success").show();
          setTimeout(function() {
            $("#calendar-alert-save-success").hide();
          }, 5000); // 5 секунд

        })
        .catch(error => {
          // Обработка ошибок
          console.error('Ошибка:', error);
        });
    }

  </script>

@endsection
