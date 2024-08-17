@extends('layouts/contentNavbarLayout')

@section('vendor-script')
  <link rel="stylesheet" href="{{mix('assets/libs/datatable/datatables.css')}}">
  <script src="{{mix('assets/libs/datatable/datatables.min.js')}}"></script>
@endsection

@section('content')
  <div class="card">
    <div class="card-header">
      <h5 class="mb-1"><i class='bx bx-shape-square  me-1 text-primary fs-3'></i>Модальности</h5>
    </div>
    <div class="card-body">

      <div id="table-loader-modals">
        <div class="d-flex flex-column align-items-center justify-content-center h-px-250 w-100">
          <div class="spinner-border mb-2" style="width: 3rem; height: 3rem;" role="status"></div>
          <span class="text-muted">Идет загрузка данных</span>
        </div>
      </div>

      <table id="modals_table" class="datatables-basic table border-top" width="100%" style="display: none">
        <thead>
        <tr>
          <th>Название модальности</th>
          <th>Аббревиатура</th>
          @if(App\Http\Controllers\Auth\User::userHasExtension('edit.refbook', ['read'=>true, 'write'=>true]))
            <th>Управление</th>
          @endif
        </tr>
        </thead>
        <tbody>
        @if(isset($allModals))
          @foreach($allModals as $modal)
            <tr>
              <td>{{$modal['Название']}}</td>
              <td>{{$modal['Аббр']}}</td>
              @if(App\Http\Controllers\Auth\User::userHasExtension('edit.refbook', ['read'=>true, 'write'=>true]))
                <td>
                  <!--Тут Управление CRUD-->
                </td>
              @endif
            </tr>
          @endforeach
        @endif
        </tbody>
        <tfoot>
        <tr>
          <th>Название модальности</th>
          <th>Аббревиатура</th>
          @if(App\Http\Controllers\Auth\User::userHasExtension('edit.refbook', ['read'=>true, 'write'=>true]))
            <th>Управление</th>
          @endif
        </tr>
        </tfoot>
      </table>
    </div>
  </div>


@endsection
@section('page-script')
  <script>
    new DataTable('#modals_table', {
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
        $('#table-loader-modals').hide();
        $('#modals_table').show();
      },

    });

  </script>
@endsection

