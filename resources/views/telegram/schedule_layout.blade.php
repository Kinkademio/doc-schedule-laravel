@extends('layouts/blankLayout')

@php
  $title ='График работы';
  $description = 'Ваш график работы всегда в кармане!';
@endphp
@section('vendor-script')
  <script src="https://telegram.org/js/telegram-web-app.js"></script>
  <script src="{{ mix('assets/libs/FullCalendar/dist/index.global.min.js') }}"></script>
  <script src="{{ mix('assets/libs/moments/moments.js') }}"></script>
@endsection

@section('content')

  <div class="container py-4">
    <div class="mb-4">
      <div class="card mb-3">
        <div class="card-body px-4 py-2">
          <img class="img-fluid h-px-75" src="/assets/img/logo/logo_blue.png">
        </div>
      </div>

      <div class="card mb-4">
        <div class="card-header">
          <h1 class="m-0"></i>График работы</h1>
        </div>
        <div class="card-body">
          <div id="loading-schedule">
            <div class="d-flex flex-column align-items-center justify-content-center h-px-500 w-100">
              <div class="spinner-border mb-2" style="width: 3rem; height: 3rem;" role="status"></div>
              <span class="text-muted text-center">Идет загрузка данных о вашем расписании</span>
            </div>
          </div>
          <div id="calendar"></div>
        </div>
      </div>

      <div id="schedule_content"></div>

      <div class="card">
        <div class="card-body d-flex flex-column justify-content-center align-items-center">
          <div class="mb-2 text-center text-"> Нужна дополнительная информация?</div>
          <a class="btn btn-sm btn-primary" href="/"><i class='bx bx-planet fs-4 me-2'></i> Перейти
            на сайт</a>
        </div>
      </div>
    </div>

    <div class="text-center">
      <span class="footer-text">©
         <script>
             document.write(new Date().getFullYear());
         </script>
         DECODE Predators
      </span>
    </div>
  </div>

@endsection

@section('page-script')
  <script>
    let userData = Telegram.WebApp.initDataUnsafe;
    let eventList = [];
    let calendar;

    fetch('/telegram/web/schedule/get/' + userData.user.id , {method: 'GET'})
      .then(response => response.json())
      .then(data => {
        initSchedule(data.preferSchedule);
        $('#loading-schedule').hide();
      })
      .catch(error => {
        // Обработка ошибок
        console.error('Ошибка:', error);
      });


    function initSchedule(workShift) {

      let workShiftObject = workShift;

      if(workShiftObject){
        workShiftObject.forEach(elment =>{
          createWorkDay(elment['Дата'],elment['ДатаОкончания'], elment['ТипРабочейСмены'], eventList);
        })
      }

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
          end: 'prev,today,next',
        },
        buttonText: {
          today: 'Сегодня',
          month: 'Месяц',
          week: 'Неделя',
          day: 'День',
          list: 'Список',
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
        timeZone: 'local',
        displayEventTime: true,
        displayEventEnd: true,
        selectable: false,
        events: eventList,
        editable: false,
        eventStartEditable: false,
      });

      calendar.render();
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

      eventList.push(
        {
          title: 'Рабочий день',
          display: 'block',
          start: dateStart,
          end: dateEnd,
          className: 'd-flex flex-column',
          backgroundColor: '#3788d8',
          description: startWorkTime
        }
      )
    }

  </script>

@endsection
