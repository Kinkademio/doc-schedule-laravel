@extends('layouts/contentNavbarLayout')

@section('title', 'Личный кабинет сотрудника')

@section('vendor-script')
  <script src="{{asset('assets/vendor/libs/apex-charts/apexcharts.js')}}"></script>
  <script src="{{ mix('assets/libs/FullCalendar/dist/index.global.min.js') }}"></script>
  <script src="{{ mix('assets/libs/moments/moments.js') }}"></script>
@endsection

@section('content')

  <!-- Modal -->
  <div class="modal fade" id="forece-majeure" tabindex="-1" aria-labelledby="create_notification"
       aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title mb-1"><i class='bx bx-calendar-edit me-1 text-primary fs-3'></i>Вы не можете выйти в этот день на работу?</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <form method="post" id="forece_majeure_notification" action="{{route('cabinet-add-forcemajor')}}">
            @csrf
            <div class="modal-body">
              <div class="alert alert-primary m-0 mb-4" role="alert">
                <h6 class="alert-heading mb-1"><i class='bx bx-info-square fs-3'></i> Внимание!</h6>
                Уведомление о вашей ситуации будет отправлено руководителю референс-центра для принятия дальнейшего решения.
              </div>

              <input id="forece_majeure_hr" class="d-none" name="hrId" value="{{isset(Auth::user()->hr_id) ? Auth::user()->hr_id : null}}">
              <input id="forece_majeure_data" class="d-none" name="dataEvent" value="0">
              <input class="d-none" name="scheduleVersion" value="">

            <div>
              <div class="d-flex flex-column">
                <label class="form-label">Опишите вашу ситуацию</label>
                <textarea required class="form-control" id="forece-majeure-text" name="text"></textarea>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <div class="d-flex justify-content-end">
              <button id="create-forece-majeure"  class="btn btn-primary" type="submit">Отправить</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>

      <div class="card mb-2">
        <div class="card-body p-2">
          <div class="alert alert-primary m-0" role="alert">
            <h6 class="alert-heading mb-1"><i class='bx bx-info-square fs-3'></i> Внимание!</h6>
            Если вы не можете выйти на работу в свой рабочий день, пожалуйста, выбери день и опишите причину твоего отсутствия в поле "Комментарий". ✍️
          </div>
        </div>
      </div>

      <div class="card">
        <div class="card-header">
          <h5 class=""><i class='bx bx-calendar fs-3 text-primary'></i> График работы</h5>
        </div>
        <div class="card-body">
          <div id="calendar"></div>
        </div>
      </div>
@endsection

@section('page-script')
  <script>
    $('#forece_majeure_notification').on('submit', (event) => {
      let form = event.target;
      event.preventDefault(); // Предотвращаем стандартную отправку формы
      $('#create-forece-majeure').prop('disabled', true);
      let previousBtnContent =  $('#create-forece-majeure').html();
      let newButtontext = '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span> Идет отправка ...';
      $('#create-forece-majeure').html(newButtontext);


      if(!confirm('Вы уверены, что хотите отправить данные о форс-мажорной ситуации?')){
        return;
      }
      const formData = new FormData(form);

      fetch(form.action, {
        method: form.method,
        body: formData
      })
        .then(response => {
          // Обработка ответа сервера (например, проверка на успех)
          if (!response.ok) {
            throw new Error('Ошибка отправки формы');
          }
          return response.text(); // Или response.json() если сервер возвращает JSON
        })
        .then(data => {
          // Действия после успешной отправки формы, например:
          console.log('Данные успешно отправлены:', data);
          // Перезагрузка страницы
          location.reload();
        })
        .catch(error => {
          console.error('Ошибка:', error);
          $('#create-forece-majeure').html(previousBtnContent);
          $('#create-forece-majeure').prop('disabled', false);
          // Обработка ошибки, например, отображение сообщения пользователю
        });
    });


    let eventList = [];

    @if(isset(Auth::user()->hrInfo->Отпуска ))
    @foreach (Auth::user()->hrInfo->Отпуска as $key => $value)
    @if($value['Активно'])
    createEventOtpusk('Отпуск', '{{$value['ДатаНачала']}}', '{{$value['ДатаОкончания']}}', eventList);
    @endif
    @endforeach
    @endif
    @if(isset($workShift))
    @foreach($workShift as $one)
    createWorkDay('{{$one['Дата']}}','{{$one['ДатаОкончания']}}', '{{json_encode($one['ТипРабочейСмены'])}}', eventList, '{{$one['Комментарий']}}' );
    @endforeach
    @endif

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
          end: 'prev,today,next',
        },
        eventClick: function(eventData) {
          const myInput = document.getElementById('forece_majeure_data');

          if(eventData.event.title == 'Рабочий день'){
            $('#forece-majeure').modal('show');
            let dateString = moment(eventData.event.start).format('YYYY-MM-DD');
            myInput.value = dateString;
            $('#forece-majeure-text').html(eventData.event.extendedProps.comment);
          }
        },
        eventContent: function (info) {

          let start = moment(info.event.start).format('HH:mm');
          let end = moment(info.event.end).format('HH:mm');
          let durationFrom = '';
          let durationTo = '';
          let eatTime = '';
          let extraEvent = '';
          if (start !== end) {
            durationFrom = '<div> с: ' + moment(info.event.start).format('HH:mm') + '</div>';
            durationTo = '<div> по: ' + moment(info.event.end).format('HH:mm') + '</div>';
            eatTime = '<div> Обед: ' + info.event.extendedProps.description['Перерыв'].substr(0, 5) + ' ч. </div>';
            extraEvent = info.event.extendedProps.comment ? '<strong class="mb-2"> Отмечен форс-мажор </strong>' : '';
          }

          let title = '<div>' + info.event.title + '</div>';
          let content = '<div class="d-flex flex-column p-1">' +extraEvent + title + durationFrom + durationTo + eatTime +'</div>';
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
    });

    function createEventOtpusk(eventName, dateStart, dateEnd, eventList) {
      eventList.push({
        title: eventName,
        start: dateStart,
        end: dateEnd,
        display: 'block',
        backgroundColor: '#afe872',
      });
    }

    function createWorkDay(dateStart, dateEnd, startWorkTime,  eventList, comment=null){
      startWorkTime = startWorkTime.replaceAll('&quot;','"');
      startWorkTime = startWorkTime.replaceAll('\'','');
      eventList.push(
        {
          title: 'Рабочий день',
          display: 'block',
          start: dateStart,
          end: dateEnd,
          className: 'd-flex flex-column',
          backgroundColor: comment ? '#706d68' : '#3788d8',
          description: JSON.parse(startWorkTime),
          comment: comment,
        }
      )
    }

  </script>
@endsection
