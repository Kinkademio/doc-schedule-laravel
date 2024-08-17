@extends('layouts/contentNavbarLayout')

@section('vendor-script')
  <link rel="stylesheet" href="{{mix('assets/libs/datatable/datatables.css')}}">
  <script src="{{mix('assets/libs/datatable/datatables.min.js')}}"></script>
  <script src="{{mix('assets/libs/jQuery-Mask-Plugin-master/dist/jquery.mask.min.js')}}"></script>
@endsection

@section('content')

  <div class="card mb-4">
    <div class="card-body p-2">
      <div class="alert alert-warning m-0" role="alert">
        <h6 class="alert-heading mb-1"><i class='bx bx-info-square fs-3'></i> Требуется своевременная актуализация!</h6>
        Данные значения должны быть актуализированы в соответствии с месяцем генерации графика работы врачей
      </div>
    </div>
  </div>


  <!-- Modal -->
  <div class="modal fade" id="edit_notification" tabindex="-1" aria-labelledby="edit_notification" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title mb-1"><i class='bx bx-cog me-1 text-primary fs-3'></i>Редактирование параметра
          </h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form method="post" id="edit-notification" action="{{ route('month_constants-edit') }}">
          @csrf
          <input type="hidden" id="edit_constant_id" name="id" value="">
          <div class="modal-body">
            <div class="m-2">
              <label id="param_name" class="form-label" for="text">Значение</label>
              <div id="param-input-place"></div>
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


  @foreach($monthConstantsGroups as $group)
  <div class="card mb-4">
    <div class="card-header">
      <h5 class="mb-1"><i class='bx bx-calculator  me-1 text-primary fs-3'></i>{{$group['Название']}}</h5>
    </div>
    <div class="card-body">

      <div class="table-loader-modals_tables_grop">
        <div class="d-flex flex-column align-items-center justify-content-center h-px-250 w-100">
          <div class="spinner-border mb-2" style="width: 3rem; height: 3rem;" role="status"></div>
          <span class="text-muted">Идет загрузка данных</span>
        </div>
      </div>

      <table class="modals_tables_grop datatables-basic table border-top" width="100%" style="display: none">
        <thead>
        <tr>
          <th>Название нормы</th>
          <th>Значение</th>
          @if(App\Http\Controllers\Auth\User::userHasExtension('edit.refbook', ['read'=>true, 'write'=>true]))
            <th>Управление</th>
          @endif
        </tr>
        </thead>
        <tbody>
        @if(isset($group['Значение']))
          @foreach($group['Значение'] as $one)
            <tr>
              <td>{{$one['Название']}}</td>
              <td>{{$one['Значение']}}</td>
              @if(App\Http\Controllers\Auth\User::userHasExtension('edit.refbook', ['read'=>true, 'write'=>true]))
                <td>
                  <button class="btn btn-sm  btn-primary"
                          title="Редактировать"
                          type="button"
                          data-bs-toggle="modal"
                          data-bs-target="#edit_notification"
                          onclick="loadModalData('{{$one['Код']}}', '{{$one['Название']}}', {{$one['Значение']}})">
                    <i class='bx bx-edit-alt'></i>
                  </button>
                </td>
              @endif
            </tr>
          @endforeach
        @endif
        </tbody>
        <tfoot>
        <tr>
          <th>Название нормы</th>
          <th>Значение</th>
          @if(App\Http\Controllers\Auth\User::userHasExtension('edit.refbook', ['read'=>true, 'write'=>true]))
            <th>Управление</th>
          @endif
        </tr>
        </tfoot>
      </table>
    </div>
  </div>
@endforeach
  @section('page-script')
    <script>
      new DataTable('.modals_tables_grop', {
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


              $('<input class="form-control" type="text" placeholder="Поиск ' + title + '" />')
                .appendTo($(column.footer()).empty())
                .on('keyup change clear', function () {
                  if (column.search() !== this.value) {
                    column.search(this.value).draw();
                  }
                });
            });
          $('.table-loader-modals_tables_grop').hide();
          $('.modals_tables_grop').show();
        },
      });

      function loadModalData(id, name, value) {
        $('#edit_constant_id').val(id);
        $('#param_name').html(name);
        let strValue = value.toString();
        const hasColon = strValue.match(/:/);
        let isnum = !isNaN(parseFloat(value)) && isFinite(value);
        let input = '';
        if(hasColon){
          input = '<input class="form-control" type="text" required data-mask="99:99:99" id="const-value" name="value" placeholder="" value="'+value+'">';
        }else if(isnum){
          input = '<input class="form-control" required type="number" id="const-value" name="value" placeholder="" value="'+value+'">';
        }else{
          input = '<input class="form-control" required type="text" id="const-value" name="value" placeholder="" value="'+value+'">';
        }
        $('#param-input-place').html(input);
        if(hasColon){
          $('#const-value').mask('999:99:99');
        }
      }

    </script>
  @endsection
@endsection
