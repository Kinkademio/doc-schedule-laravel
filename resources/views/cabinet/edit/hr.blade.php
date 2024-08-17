@extends('layouts/contentNavbarLayout')

@section('vendor-script')
  <link rel="stylesheet" href="{{mix('assets/libs/datatable/datatables.css')}}">
  <script src="{{mix('assets/libs/datatable/datatables.min.js')}}"></script>
@endsection

@section('content')

  <!-- Modal -->
  <div class="modal fade" id="create_hr" tabindex="-1" aria-labelledby="create_hr"
       aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title mb-1"><i class='bx bx-bell-plus me-1 text-primary fs-3'></i>Новый врач</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form method="post" id="create-hr" action="{{ route('hr-data-create-hr') }}">
          @csrf
          <div class="modal-body">
            <div class="m-2">
              <label class="form-label" for="tab_number">Табельный номер</label>
              <input class="form-control" required type="text" id="tab_number" name="tab_number" placeholder="">
            </div>

            <div class="m-2">
              <label class="form-label" for="fio">ФИО</label>
              <input class="form-control" required type="text" id="fio" name="fio" placeholder="">
            </div>

            <div class="m-2">
              <label class="form-label" for="stavka">Ставка</label>
              <input class="form-control" required type="number" id="stavka" name="stavka" placeholder="">
            </div>

            <div class="m-2">
              <label class="form-label" for="main_modal">Основная модальность</label>
              <select id="main_modal" class="form-select" name="main_modal">
                @foreach($modals as $modal)
                  <option value="{{$modal['Код']}}">{{$modal['Название']}}</option>
                @endforeach
              </select>
            </div>
            <div class="m-2">
              <label class="form-label" for="dop_modals">Доп. модальности</label>
              <select multiple="multiple" id="dop_modals" class="form-select" name="dop_modals[]">
                @foreach($modals as $modal)
                  <option value="{{$modal['Код']}}">{{$modal['Название']}}</option>
                @endforeach
              </select>
            </div>


          </div>
          <div class="modal-footer">
            <div class="d-flex justify-content-end">
              <button class="btn btn-primary" type="submit">Создать</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>

  <div class="modal fade" id="edit_hr" tabindex="-1" aria-labelledby="edit_hr" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title mb-1"><i class='bx bx-bell-plus me-1 text-primary fs-3'></i>Редактировать данные врача
          </h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form method="post" id="edit-hr" action="{{ route('hr-data-create-hr') }}">
          @csrf
          <input type="hidden" id="edit_hr_id" name="id" value="">
          <div class="modal-body">
            <div class="m-2">
              <label class="form-label" for="tab_number">Табельный номер</label>
              <input class="form-control" required type="text" id="edit_tab_number" name="tab_number" placeholder="">
            </div>

            <div class="m-2">
              <label class="form-label" for="fio">ФИО</label>
              <input class="form-control" required type="text" id="edit_fio" name="fio" placeholder="">
            </div>

            <div class="m-2">
              <label class="form-label" for="stavka">Ставка</label>
              <input class="form-control" required type="number" id="edit_stavka" name="stavka" placeholder="">
            </div>

            <div class="m-2">
              <label class="form-label" for="main_modal">Основная модальность</label>
              <select id="edit_main_modal" class="form-select" name="main_modal">
                @foreach($modals as $modal)
                  <option value="{{$modal['Код']}}">{{$modal['Название']}}</option>
                @endforeach
              </select>
            </div>
            <div class="m-2">
              <label class="form-label" for="dop_modals">Доп. модальности</label>
              <select multiple id="edit_dop_modals" class="form-select" name="dop_modals[]">
                @foreach($modals as $modal)
                  <option value="{{$modal['Код']}}">{{$modal['Название']}}</option>
                @endforeach
              </select>
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


  <div class="card">
    <div class="card-header">
      <div class="d-flex justify-content-between">
        <h5 class="mb-1"><i class='bx bxs-briefcase-alt  me-1 text-primary fs-3'></i>Кадровая информация</h5>
        @if(App\Http\Controllers\Auth\User::userHasExtension('edit.hr', ['read'=> true, 'write'=>true]))
          <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#create_hr">
            Добавить нового врача
          </button>
          @endif
      </div>
    </div>
    <div class="card-body">

      <div id="table-loader-hr">
        <div class="d-flex flex-column align-items-center justify-content-center h-px-250 w-100">
          <div class="spinner-border mb-2" style="width: 3rem; height: 3rem;" role="status"></div>
          <span class="text-muted">Идет загрузка данных</span>
        </div>
      </div>

      <table id="hr_table" class="datatables-basic table border-top" width="100%" style="display: none">
        <thead>
        <tr>
          <th>Табельный номер</th>
          <th>ФИО</th>
          <th>Ставка</th>
          <th>Модальности</th>
          <th>Отпуска</th>
          @if(App\Http\Controllers\Auth\User::userHasExtension('edit.hr', ['read'=>true, 'write'=>true]))
            <th>Управление</th>
          @endif
        </tr>
        </thead>
        <tbody>
        @if(isset($allDocs))
          @foreach($allDocs as $doc)
            <tr>
              <td>{{$doc['ТабНомер']}}</td>
              <td>{{$doc['ФИО']}}</td>
              <td>{{$doc['Ставка']}}</td>
              <td>
                @foreach($doc['Модальности'] as $one)
                  @if($one['Основная'])
                    <span class="text-primary"> {{$one['Модальность']['Название']}}<br></span>
                  @else
                    <span class="text-muted"> {{$one['Модальность']['Название']}}<br></span>
                @endif
                @endforeach

              <td>
                @if(!empty($doc['Отпуска']))
                  @foreach($doc['Отпуска'] as $one)
                    {{$one['ДатаНачала']}} - {{$one['ДатаОкончания']}}<br>
                  @endforeach
                @endif
              </td>
              @if(App\Http\Controllers\Auth\User::userHasExtension('edit.hr', ['read'=>true, 'write'=>true]))
                <td>
                  @php
                    $mainModal = null;
                    $subModals = [];

                    foreach($doc['Модальности'] as $oneModal){
                        if($oneModal['Основная']){
                             $mainModal = $oneModal;
                        }else{
                            $subModals[] = $oneModal;
                        }
                    }

                  @endphp
                  <button class="btn btn-sm  btn-primary"
                          title="Редактировать"
                          type="button"
                          data-bs-toggle="modal"
                          data-bs-target="#edit_hr"
                          onclick="loadHrData({{$doc['Код']}},{{$doc['ТабНомер']}},
                          '{{$doc['ФИО']}}',
                          {{$doc['Ставка']}},
                           {{json_encode($mainModal)}},
                           {{json_encode($subModals)}})">
                    <i class='bx bx-edit-alt'></i>
                  </button>
                  <button class="btn btn-sm btn-danger" title="Удалить" onclick="deleteHr({{$doc['Код']}})">
                    <i class='bx bx-trash'></i>
                  </button>
                </td>
              @endif
            </tr>
          @endforeach
        @endif
        </tbody>
        <tfoot>
        <tr>
          <th>Табельный номер</th>
          <th>ФИО</th>
          <th>Ставка</th>
          <th>Модальности</th>
          <th>Отпуска</th>
          @if(App\Http\Controllers\Auth\User::userHasExtension('edit.hr', ['read'=>true, 'write'=>true]))
            <th>
              Управление
            </th>
          @endif
        </tr>
        </tfoot>
      </table>
    </div>
  </div>
@endsection
@section('page-script')
  <script>

    function loadHrData(id, tab_number, fio, stavka, osn_mod, dop_mods) {
      $('#edit_tab_number').val(tab_number);
      $('#edit_fio').val(fio);
      $('#edit_stavka').val(stavka);
      $('#edit_main_modal').val(osn_mod['Модальность']['Код']);
      $('#edit_hr_id').val(id);

      let selectedValues = [];
      for(let modal in dop_mods){
        selectedValues.push(dop_mods[modal]['Модальность']['Код']);
      }
      // Выбираем все options в select
      const options = $('#edit_dop_modals option');

      // Проходимся по каждому option
      options.each(function() {
        const optionValue = $(this).val();
        // Если значение option есть в массиве selectedValues, то выделяем его
        if (selectedValues.includes(parseInt(optionValue))) {
          $(this).prop('selected', true);
        } else {
          // Иначе снимаем выделение
          $(this).prop('selected', false);
        }
      });

    }

    const form = document.getElementById('create-hr');
    form.addEventListener('submit', (event) => {
      event.preventDefault(); // Предотвращаем стандартную отправку формы

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

    const editForm = document.getElementById('edit-hr');
    editForm.addEventListener('submit', (event) => {
      event.preventDefault(); // Предотвращаем стандартную отправку формы

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

    function deleteHr(id){
      fetch('/admin/hr/delete/'+ id, {
        method: 'GET',
      }).then(data => {
        location.reload();
      }).catch(error => {
        console.error('Ошибка:', error);
        // Обработка ошибки, например, отображение сообщения пользователю
      });
    }



    new DataTable('#hr_table', {
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
          targets: [0, 1, 2, 3, 4]
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
        $('#table-loader-hr').hide();
        $('#hr_table').show();
      },

    });
  </script>
@endsection

