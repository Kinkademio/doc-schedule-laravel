@extends('statistics/layouts/statistics')

@section('content-statistics')

  <div class="mb-2 mt-2 order-0">
    <div class="card">
      <div class="card-body">
        <div id="test2"></div>
        <div id="test3"></div>
      </div>
    </div>
  </div>
{{--  <div class="card">
    <h5 class="card-header">Все врачи</h5>
    <div class="table-responsive text-nowrap">
      <table id="roles_table" class="table table-striped table-bordered">
        <thead>
        <tr>
          <th>Сотрудник</th>
          <th>Специальность</th>
          <th>Квалификация</th>
          <th>Статус</th>
          <th>Actions</th>
        </tr>
        </thead>
      </table>
    </div>
  </div>--}}
@endsection


@section('page-script')
  <script>(
      function (){
        /*new DataTable('#roles_table', {
          //Пагинация
          pagingType: 'simple_numbers',
          //Поиск по полям
          search: {
            return: true
          },
          //Откуда получаем данные
          ajax: '/admin/roles',
          //Форматирование данных
          //Если необходимо добавить или убрать столбец просто убирем его отсуда или добавляем сюда же
          columns: [{
            data: 'id'
          },
            {
              data: 'name'
            },
            {
              data: 'slug'
            },
            {
              data: 'permissions',
              render: function(data) {
                let result = '';
                if (!data) return result;
                for (let key in data) {
                  result += '<span data-id="' + data[key].id + '" class="badge badge-primary m-2">' + data[key].name + '</span>';
                }
                return result;
              }
            },
            {
              data: 'description'
            },
            {
              data: null,
              render: function(data, type, row) {
                let deleteButton = '<button onclick="deleteRole(' + row.id + ',\'' + row.name + '\')" title="Удалить роль" class="mr-1 mb-1 btn btn-danger btn-sm"><i class="fa fa-trash" aria-hidden="true"></i></button>';
                let editButton = '<button onclick="editRole(' + row.id + ')" title="Редактировать роль" data-toggle="modal" class="mr-1 mb-1 btn btn-primary btn-sm"><i class="fa fa-cogs fs-4" aria-hidden="true"></i></button>';
                return editButton + deleteButton;
              }
            }
          ],
          //Русификация интерфейса
          language: {
            info: 'Страница _PAGE_ из _PAGES_',
            infoEmpty: 'Записей не найдено',
            infoFiltered: '(отфильтровано из: _MAX_ записей)',
            lengthMenu: 'Отображать _MENU_ записей на странице',
            zeroRecords: 'Извините, ничего не найдено',
            search: 'Поиск'
          }
        })*/

        let data1 = [[1,76], [2,56], [3,45], [4,56], [5,34], [6,36], [7,73], [8,84]];
        let data2 = [[1,35], [2,34], [3,54], [4,45], [5,45], [6,24], [7,67], [8,76]];

        new ApexCharts(document.querySelector("#test2"),  {
          series: [{
            name: 'Flies',
            data: data1
          },{
            name: 'Spiders',
            data: data2
          }],
          chart: {
            id: 'chart2',
            type: 'line',
            height: 230,
            dropShadow: {
              enabled: true,
              enabledOnSeries: [1]
            },
            toolbar: {
              autoSelected: 'pan',
              show: false
            }
          },
          colors: ['#008FFB', '#00E396'],
          stroke: {
            width: 3
          },
          dataLabels: {
            enabled: false
          },
          stroke: {
            width: [2,6],
            curve: ['straight','monotoneCubic']
          },
          fill: {
            opacity: [1,0.75],
          },
          markers: {
            size: 0
          },
          yaxis: [
            {
              seriesName: 'Кол-во исследований',
              axisTicks: {
                show: true,
                color: '#008FFB'
              },
              axisBorder: {
                show: true,
                color: '#008FFB'
              },
              labels: {
                style: {
                  colors: '#008FFB',
                }
              },
              title: {
                text: "Количество исследований",
                style: {
                  color: '#008FFB'
                }
              },
            },
            /*{
              seriesName: 'Spiders',
              opposite: true,
              axisTicks: {
                show: true,
                color: '#00E396'
              },
              axisBorder: {
                show: true,
                color: '#00E396'
              },
              labels: {
                style: {
                  colors: '#00E396'
                }
              },
              title: {
                text: "Spiders",
                style: {
                  color: '#00E396'
                }
              },
            }*/
          ],
          xaxis: {
            categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul'],
            title: {
              text: 'Месяца'
            }
          }
        }).render();

        new ApexCharts(document.querySelector("#test3"),  {
          series: [{
            name: 'Flies',
            data: data1
          },{
            name: 'Spiders',
            data: data2
          }],
          chart: {
            id: 'chart1',
            height: 130,
            type: 'area',
            brush:{
              target: 'chart2',
              enabled: true
            },
            selection: {
              enabled: true,
              xaxis: {
                categories: ['1', '2', '3', '4', '5', '5', '7'],
                title: {
                  text: 'Month'
                }
              }
            },
          },
          colors: ['#008FFB', '#00E396'],
          stroke: {
            width: [1, 3],
            curve: ['straight', 'monotoneCubic']
          },
          fill: {
            type: 'gradient',
            gradient: {
              opacityFrom: 0.91,
              opacityTo: 0.1,
            }
          },
          xaxis: {
            categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul'],
            title: {
              text: 'Month'
            }
          },
          yaxis: {
            max: 100,
            tickAmount: 2
          }
        }).render();

      }
    )();
  </script>
@endsection
