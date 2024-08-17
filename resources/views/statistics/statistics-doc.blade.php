@extends('statistics/layouts/statistics')

@section('content-statistics')
    <div class="row d-flex">
      <div class="mb-2 mt-2 order-1">
        <div class="card">
          <div class="card-body">
            <div id="modalsByDayWeek"></div>
          </div>
        </div>
      </div>
    </div>
@endsection

@section('page-script')
  <script>
    let modalsByDayWeek = [];
    let labels = [];
    let data = [];

    @if(isset($statistics))
    @foreach($statistics as $value)
    @if(isset($value->Исследования))
    @foreach(json_decode($value->Исследования) as $value2)
    data.push({{$value2->Значение}})
    labels.push('{{$value2->Дата}}')
    @endforeach
    @endif
    prepareModals('{{json_decode($value->ТипыИсследований)->Название}}', data);
    data = [];
    @endforeach
    @endif

    function prepareModals(name, data){
      modalsByDayWeek.push({
        name: name,
        data: data
      });
    }

    grapfInit();

    function grapfInit(){
      new ApexCharts(document.getElementById('modalsByDayWeek'),  {
        series: modalsByDayWeek,
        chart: {
          height: 350,
          type: 'line',
          zoom: {
            enabled: true
          },
          animations: {
            enabled: false
          }
        },
        stroke: {
          width: [5,5,4],
          curve: 'smooth'
        },
        colors: [
          "#b79958",
          "#30bda0",
          "#2440da",
          "#e83949",
          "#c7aa35",
          "#3e6e1f",
          "#4abb2f",
          "#e882cf",
          "#c22d2d",
          "#4d1912",
        ],
        labels: labels, //даты недели
        title: {
          text: 'Исследования по дням недели'
        },
        xaxis: {
        },
      }).render();

    };
  </script>
@endsection

