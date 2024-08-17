@extends('statistics/layouts/statistics')

@section('content-statistics')

  @if(isset($statisticsMod))
  @foreach($statisticsMod as $key=>$value)
  <div class="mb-2 mt-2">
    <div class="card">
      <div class="card-header">
        <h5 class="mb-1"><i class='bx bxl-telegram me-1 text-primary fs-3'></i> График точности определения нагрузки</h5>
      </div>
      <div class="card-body">
        <div id="traffic-{{$key}}"/>
      </div>
    </div>
  </div>
  @endforeach
  @endif

@endsection

@section('page-script')
  <script>

    let modals = [];
    let labels = [];
    let real = [];
    let neuro = [];

    @if(isset($statisticsMod))
    @foreach($statisticsMod as $value)
    @if(isset($value->Исследования))
    @foreach(json_decode($value->Исследования) as $value1)
    labels.push('{{$value1->Дата}}');
    real.push({{$value1->Реальное}});
    neuro.push({{$value1->Нейронка}})
    @endforeach
    @endif
    createModals('{{$value->Название}}', labels, real, neuro)
    labels = [];
    real = [];
    neuro = [];
    @endforeach
    @endif

    function createModals(name, labels, real, neuro){
      modals.push({
        name: name,
        labels: labels,
        series: [{
              name: 'Проведенные исследования',
              type: 'column',
              data: real
            }, {
              name: 'Спрогнозированные исследования',
              type: 'line',
              data: neuro
            }]
      })
    };

    init();

    function init(){
      modals.forEach((item, key) => {
        new ApexCharts(document.querySelector("#traffic-"+key),  {
          series: item['series'],
          chart: {
            height: 350,
            type: 'line',
          },
          stroke: {
            width: [0, 4]
          },
          title: {
            text: item['name']
          },
          dataLabels: {
            enabled: true,
            enabledOnSeries: [1]
          },
          labels: item['labels'],
          xaxis: {
            type: 'datetime'
          },
          yaxis: [{
            title: {
              text: 'Проведенные исследования',
            },
          }, {
            opposite: true,
            title: {
              text: 'Запланированные исследования'
            }
          }]
        }).render();
      })
    }

  </script>
@endsection
