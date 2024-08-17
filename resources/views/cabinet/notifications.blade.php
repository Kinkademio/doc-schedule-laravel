@extends('layouts/contentNavbarLayout')

@section('title', 'Личный кабинет сотрудника')

@section('vendor-script')
  <link rel="stylesheet" href="{{mix('assets/libs/datatable/datatables.css')}}">
  <script src="{{mix('assets/libs/datatable/datatables.min.js')}}"></script>
@endsection

@section('content')

  <!-- Modal -->
  <div class="modal fade" id="create_notification" tabindex="-1" aria-labelledby="create_notification"
       aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title mb-1"><i class='bx bx-bell-plus me-1 text-primary fs-3'></i>Новое уведомление</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form method="post" id="create-notification" action="{{ route('notification-data-create-notification') }}">
          @csrf
          <div class="modal-body">
            <div class="m-2">
              <label class="form-label" for="title">Заголовок</label>
              <input class="form-control" required type="text" id="title" name="title" placeholder="">
            </div>

            <div class="m-2">
              <label class="form-label" for="text">Текст</label>
              <textarea class="form-control" required type="text" id="text" name="text" placeholder=""
                        style="height: 150px"></textarea>
            </div>

            <div class="d-flex flex-wrap mb-5 mt-2">
              <div class="m-2">
                <label class="form-label" for="for">Тип получателя</label>
                <select id="receiver_type_select" class="form-select" name="for">
                  @foreach($systemNotificationTypes as $type)
                    @if($type->active)
                      <option value="{{$type->id}}">{{$type->name}}</option>
                    @endif
                  @endforeach
                </select>
              </div>
              <div class="m-2" style="display: none">
                <label class="form-label" for="ids_role">Роль получателя</label>
                <select id="role_type_select" class="form-select" name="ids_role">
                  @foreach($notificationRoles as $role)
                    <option value="{{$role->id}}">{{$role->name}}</option>
                  @endforeach
                </select>
              </div>

            </div>
          </div>
          <div class="modal-footer">
            <div class="d-flex justify-content-end">
              <button id="create-new-notification"  class="btn btn-primary" type="submit">Создать</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>


  <!-- Modal -->
  <div class="modal fade" id="edit_notification" tabindex="-1" aria-labelledby="edit_notification" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title mb-1"><i class='bx bx-bell-plus me-1 text-primary fs-3'></i>Редактировать уведомление
          </h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form method="post" id="edit-notification" action="{{ route('notification-data-create-notification') }}">
          @csrf
          <input type="hidden" id="edit_notification_id" name="id" value="">
          <div class="modal-body">
            <div class="m-2">
              <label class="form-label" for="title">Заголовок</label>
              <input class="form-control" required type="text" id="edit_title" name="title" placeholder="">
            </div>

            <div class="m-2">
              <label class="form-label" for="text">Текст</label>
              <textarea class="form-control" required type="text" id="edit_text" name="text" placeholder=""
                        style="height: 150px"></textarea>
            </div>

            <div class="d-flex flex-wrap mb-5 mt-2">
              <div class="m-2">
                <label class="form-label" for="for">Тип получателя</label>
                <select id="edit_receiver_type_select" class="form-select" name="for"
                        aria-label="Default select example">
                  @foreach($systemNotificationTypes as $type)
                    @if($type->active)
                    <option value="{{$type->id}}">{{$type->name}}</option>
                    @endif
                  @endforeach
                </select>
              </div>

              <div class="m-2" style="display: none">
                <label class="form-label" for="ids_role">Роль получателя</label>
                <select id="edit_role_type_select" class="form-select" name="ids_role"
                        aria-label="Default select example">
                  @foreach($notificationRoles as $role)
                    <option value="{{$role->id}}">{{$role->name}}</option>
                  @endforeach
                </select>
              </div>

            </div>
          </div>
          <div class="modal-footer">
            <div class="d-flex justify-content-end">
              <button id="edit-new-notification" class="btn btn-primary" type="submit">Сохранить</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>


  <div class="row mb-4">
    <div class="col-12 p-2">
      <div class="card">
        <div class="card-header">
          <div class="d-flex justify-content-between">
            <h5 class="mb-1"><i class='bx bx-bell me-1 text-primary fs-3'></i>Управление системными уведомлениями</h5>
            @if(App\Http\Controllers\Auth\User::userHasExtension('notifications', ['read'=> true, 'write'=>true]))
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#create_notification">
              Добавить новое уведомление
            </button>
            @endif
          </div>

        </div>
        <div class="card-body">
          <div id="table-loader-notifications">
            <div class="d-flex flex-column align-items-center justify-content-center h-px-250 w-100">
              <div class="spinner-border mb-2" style="width: 3rem; height: 3rem;" role="status"></div>
              <span class="text-muted">Идет загрузка данных</span>
            </div>
          </div>

          @if(!empty($allNotificationsForDataTable))
            <table id="notifications_table" class="datatables-basic table border-top" width="100%" style="display: none">
              <thead>
              <tr>
                <th>Заголовок</th>
                <th>Текст</th>
                <th>Получатели</th>
                @if(App\Http\Controllers\Auth\User::userHasExtension('notifications', ['read'=> true, 'write'=>true]))
                <th>Управление</th>
                @endif
              </tr>
              </thead>
              <tbody>
              @foreach($allNotificationsForDataTable as $notificationData)
                <tr>
                  <td>{{$notificationData->title}}</td>
                  <td>{{$notificationData->text}}</td>
                  <td>{{$notificationData->receiver()}}</td>
                  @if(App\Http\Controllers\Auth\User::userHasExtension('notifications', ['read'=> true, 'write'=>true]))
                  <td>
                    <button class="btn btn-sm  btn-primary"
                            title="Редактировать"
                            type="button"
                            data-bs-toggle="modal"
                            data-bs-target="#edit_notification"
                            onclick="loadModalData({{$notificationData->id}}, '{{$notificationData->title}}', '{{$notificationData->text}}', {{$notificationData->for}}, {{$notificationData->ids}})">
                      <i class='bx bx-edit-alt'></i>
                    </button>
                    <button class="btn btn-sm btn-danger" title="Удалить" onclick="deleteNotification({{$notificationData->id}})">
                      <i class='bx bx-trash'></i>
                    </button>
                  </td>
                  @endif
                </tr>
              @endforeach
              </tbody>
              <tfoot>
              <tr>
                <th>Заголовок</th>
                <th>Текст</th>
                <th>Получатели</th>
                @if(App\Http\Controllers\Auth\User::userHasExtension('notifications', ['read'=> true, 'write'=>true]))
                  <th>Управление</th>
                @endif
              </tr>
              </tfoot>
            </table>
          @else
            <h5>Нет системных уведомлений</h5>
            <span>В системе еще не было создано ни одного уведомления</span>
          @endif
        </div>
      </div>
    </div>
  </div>
  @section('page-script')

    <script src="{{asset('assets/js/dashboards-analytics.js')}}"></script>
    <script>
      function loadModalData(id, title, text, receiver, receiver_id) {
        $('#edit_title').val(title);
        $('#edit_text').val(text);
        $('#edit_receiver_type_select').val(receiver);
        $('#edit_notification_id').val(id);

        receiver_id = JSON.parse(receiver_id)[0];
        switch (receiver) {
          case '2':
            $('#edit_person_type_select').val(receiver_id);
            break;
          case '3':
            $('#edit_role_type_select').val(receiver_id);
            break;
        }

      }

      function resetReceiverSelector(addSelector = '') {
        $('#' + addSelector + 'role_type_select').parent().hide();
        $('#' + addSelector + 'person_type_select').parent().hide()

        switch ($('#' + addSelector + 'receiver_type_select').val()) {
          //Роль
          case '3':
            $('#' + addSelector + 'role_type_select').parent().show();
            break;
          //Персона
          case '2':
            $('#' + addSelector + 'person_type_select').parent().show();
            break;
        }
      }

      function deleteNotification(id){
        fetch('/admin/system_notifications/delete/'+ id, {
          method: 'GET',
        }).then(data => {
          location.reload();
        }).catch(error => {
          console.error('Ошибка:', error);
          // Обработка ошибки, например, отображение сообщения пользователю
        });
      }

      $(function () {
        resetReceiverSelector();
        resetReceiverSelector('edit_');
      })

      new DataTable('#notifications_table', {
        responsive: true,
        language: {
          url: '/assets/libs/datatable/datatables.json',
        },
        layout: {
          top1: {
            searchPanes: {
              viewTotal: true,
              initCollapsed: true
            }
          }
        },
        columnDefs: [
          {
            searchPanes: {
              show: true
            },
            targets: [0, 1]
          },
        ],
        initComplete: function () {
          this.api()
            .columns()
            .every(function () {
              var column = this;
              var title = column.footer().textContent;

              // Create input element and add event listener
              $('<input class="form-control" type="text" placeholder="Поиск ' + title + '" />')
                .appendTo($(column.footer()).empty())
                .on('keyup change clear', function () {
                  if (column.search() !== this.value) {
                    column.search(this.value).draw();
                  }
                });
            });
          $('#table-loader-notifications').hide();
          $('#notifications_table').show();
        },

      });

      $('#receiver_type_select').change(function (value) {
        resetReceiverSelector();
      });
      $('#edit_receiver_type_select').change(function (value) {
        resetReceiverSelector('edit_');
      })

      const form = document.getElementById('create-notification');
      form.addEventListener('submit', (event) => {
        event.preventDefault(); // Предотвращаем стандартную отправку формы
        $('#create-new-notification').prop('disabled', true);
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
            // Обработка ошибки, например, отображение сообщения пользователю
          });
      });

      const editForm = document.getElementById('edit-notification');
      editForm.addEventListener('submit', (event) => {
        event.preventDefault(); // Предотвращаем стандартную отправку формы
        $('#edit-new-notification').prop('disabled', true);
        const formData = new FormData(editForm);

        fetch(editForm.action, {
          method: editForm.method,
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
            // Обработка ошибки, например, отображение сообщения пользователю
          });
      });

    </script>
  @endsection

@endsection
