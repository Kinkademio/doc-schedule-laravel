@extends('layouts/contentNavbarLayout')

@section('vendor-script')
  <script src="{{asset('assets/vendor/libs/apex-charts/apexcharts.js')}}"></script>
  <link rel="stylesheet" href="{{mix('assets/libs/datatable/datatables.css')}}">
  <script src="{{mix('assets/libs/datatable/datatables.min.js')}}"></script>
@endsection

@section('content')


<div class="card mb-4">
  <div class="card-header">
    <h5 class="mb-1"><i class='bx bx-line-chart  me-1 text-primary fs-3'></i>График прогнозов исследований по модальностям</h5>
  </div>
  <div class="card-body">
    <div id="forecasts-chart"></div>
  </div>
</div>

  <div class="card mb-4">
    <div class="card-header">
      <h5 class="mb-1"><i class='bx bx-scatter-chart  me-1 text-primary fs-3'></i>Прогнозы исследований по модальностям</h5>
    </div>
    <div class="card-body">


    <div id="table-loader">
      <div class="d-flex flex-column align-items-center justify-content-center h-px-250 w-100">
        <div class="spinner-border mb-2" style="width: 3rem; height: 3rem;" role="status"></div>
        <span class="text-muted">Идет загрузка данных</span>
      </div>
    </div>
    <div id="table-place" class="card-body">

      <table id="forecasts_table" class="datatables-basic table border-top" width="100%" style="display: none">
        <thead>
        <tr>
          <th>Тип исследования</th>
          <th>Год</th>
          <th>Номер недели</th>
          <th>Прогнозируемое кол-во исследований</th>
          @if(App\Http\Controllers\Auth\User::userHasExtension('edit.refbook', ['read'=>true, 'write'=>true]))
            <th>Управление</th>
          @endif
        </tr>
        </thead>
        <tbody>

          @foreach($forecastsData as $data)
            @foreach($data['Модальности'] as $modal)
              <tr>
                <td>{{$modal['Информация']['Название']}}</td>
                <td>{{$data['Год']}}</td>
                <td>{{$data['НомерНедели']}}</td>
                <td>{{$modal['Значение']}}</td>
              @if(App\Http\Controllers\Auth\User::userHasExtension('edit.refbook', ['read'=>true, 'write'=>true]))
                <td>
                  <!--Тут Управление CRUD-->
                </td>
              @endif
              </tr>
            @endforeach
          @endforeach

        </tbody>
        <tfoot>
        <tr>
          <th>Год</th>
          <th>Номер недели</th>
          <th>Тип исследования</th>
          <th>Прогнозируемое кол-во исследований</th>
          @if(App\Http\Controllers\Auth\User::userHasExtension('edit.refbook', ['read'=>true, 'write'=>true]))
            <th>
              <!--Тут Управление CRUD-->
            </th>
          @endif
        </tr>
        </tfoot>
      </table>
    </div>
    </div>
  </div>

@endsection

@section('page-script')
  <script>
    let categories = [];
    let tableData = [];

    categories = JSON.parse('{{json_encode($resultForGraphByModals['НомераНедель'])}}');
    @foreach($resultForGraphByModals['Данные'] as $oneGraphLine)
      prepareGraphData('{{$oneGraphLine["Название"]}}', '{{json_encode($oneGraphLine['Значения'])}}');
    @endforeach
      function prepareGraphData(name, values){
        tableData.push({
          name: name,
          data: JSON.parse(values)
        });
      }
    graphInit();
    function graphInit(){

      var options = {
        series: tableData,
        chart: {
          height: 350,
          type: 'line',
          zoom: {
            enabled: false
          }
        },
        dataLabels: {
          enabled: false
        },
        stroke: {
          curve: 'straight'
        },
        colors: [
          "#e03e28",
          "#c56b5c",
          "#d28130",
          "#c27a61",
          "#d2a348",
          "#eabc85",
          "#30bda0",
          "#6ddcdc",
          "#2440da",
          "#5a69d9",
          "#e83949",
          "#da415d",
          "#c7aa35",
          "#b6a665",
          "#67b732",
          "#9bce65",
          "#4abb2f",
          "#5cc564",
          "#e882cf",
          "#ea82c7"
        ],
        grid: {
          row: {
            colors: ['#f3f3f3', 'transparent'], // takes an array which will be repeated on columns
            opacity: 0.5
          },
        },
        xaxis: {
          categories: categories,
        }
      };

      var chart = new ApexCharts(document.querySelector("#forecasts-chart"), options);
      chart.render();
    }



    new DataTable('#forecasts_table', {
      responsive: true,
      language: {
        url: '/assets/libs/datatable/datatables.json',
      },
      order: [
        [1, 'desc'],
        [2, 'desc'],
        [0, 'asc'],
      ],
      rowGroup: {
        startRender: 0,
      },
      layout: {
        top1: {
          searchPanes: {
            viewTotal: true,
            initCollapsed: true
          }
        }
      },
      pageLength: tableData.length,
      lengthMenu: [tableData.length, 50, 100],
      columnDefs: [
        {
          searchPanes: {
            show: true,
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
            $('<input class="form-control"  type="text" placeholder="Поиск ' + title + '" />')
              .appendTo($(column.footer()).empty())
              .on('keyup change clear', function () {
                if (column.search() !== this.value) {
                  column.search(this.value).draw();
                }
              });
          });
        $('#table-loader').hide();
        $('#forecasts_table').show();
      },
    });
  </script>

@endsection
