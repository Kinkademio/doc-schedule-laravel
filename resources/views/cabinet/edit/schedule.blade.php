@extends('layouts/contentNavbarLayout')

@section('vendor-script')
  <link rel="stylesheet" href="{{mix('assets/libs/datatable/datatables.css')}}">
  <script src="{{mix('assets/libs/datatable/datatables.min.js')}}"></script>
@endsection

@section('content')
  <div class="card">
    <div class="card-header">
      <h5 class="mb-1"><i class='bx bx-calendar me-1 text-primary fs-3'></i>Виды графиков работы врачей</h5>
    </div>
    <div class="card-body">

      <div id="table-loader-schedule">
        <div class="d-flex flex-column align-items-center justify-content-center h-px-250 w-100">
          <div class="spinner-border mb-2" style="width: 3rem; height: 3rem;" role="status"></div>
          <span class="text-muted">Идет загрузка данных</span>
        </div>
      </div>

      <table id="schedule_table" class="datatables-basic table border-top" width="100%" style="display: none">
        <thead>
        <tr>
          <th>Название вида рабочего графика</th>
          <th>Кол-во рабочих дней</th>
          <th>Кол-во выходных дней</th>
          @if(App\Http\Controllers\Auth\User::userHasExtension('edit.refbook', ['read'=>true, 'write'=>true]))
            <th>Управление</th>
          @endif
        </tr>
        </thead>
        <tbody>
        @if(isset($allScheduleTypes))
          @foreach($allScheduleTypes as $type)
            <tr>
              <td>{{$type['Название']}}</td>
              <td>{{$type['РабочихДней']}}</td>
              <td>{{$type['ВыходныхДней']}}</td>
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
          <th>Название типа рабочего графика</th>
          <th>Кол-во рабочих дней</th>
          <th>Кол-во выходных дней</th>
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
    new DataTable('#schedule_table', {
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
          targets: [0, 1, 2]
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
        $('#table-loader-schedule').hide();
        $('#schedule_table').show();
      },

    });

  </script>
@endsection
