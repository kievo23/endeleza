@extends('layouts.'.$layout)

@section('title')
Endeleza: Dashboard
@endsection

@section('content')

<!-- partial -->
<div class="main-panel">
  <div class="content-wrapper">
    <div class="row">
      <div class="col-md-12 grid-margin">
        <div class="d-flex justify-content-between flex-wrap">
          <div class="d-flex align-items-end flex-wrap">
            <div class="mr-md-3 mr-xl-5">
              <h2>Welcome back to Endeleza Platform</h2>
              <p class="mb-md-0">Your analytics dashboard.</p>
              <i class="mdi mdi-home text-muted hover-cursor"></i>
            </div>
          </div>
          <div class="d-flex justify-content-between align-items-end flex-wrap">
          </div>

          <div class="pcoded-inner-content">
            <div class="main-body">
              <div class="page-wrapper">
                <div class="page-body">
                  <div class="row">
                    <div class="col-xl-3 col-md-6">
                      <div class="card bg-c-green update-card p-2">
                        <div class="card-block">
                          <div class="row align-items-end">
                            <div class="col-8">
                              <a href="{{ action('CustomersController@index')}}">
                                <h4 class="text-white">{{$customers}}</h4>
                                <h6 class="text-white m-b-0">Customers</h6>
                              </a>
                            </div>
                            <div class="col-4 text-right"><iframe class="chartjs-hidden-iframe" tabindex="-1" style="display: block; overflow: hidden; border: 0px; margin: 0px; top: 0px; left: 0px; bottom: 0px; right: 0px; height: 100%; width: 100%; position: absolute; pointer-events: none; z-index: -1;"></iframe><iframe class="chartjs-hidden-iframe" tabindex="-1" style="display: block; overflow: hidden; border: 0px; margin: 0px; top: 0px; left: 0px; bottom: 0px; right: 0px; height: 100%; width: 100%; position: absolute; pointer-events: none; z-index: -1;"></iframe>
                              <canvas id="update-chart-2" height="50" width="89" style="display: block; width: 89px; height: 50px;"></canvas>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>

                    <div class="col-xl-3 col-md-6">
                      <div class="card bg-c-green update-card p-2">
                        <div class="card-block">
                          <div class="row align-items-end">
                            <div class="col-8">
                              <a href="{{ action('LoanAccountsController@index')}}">
                                <h4 class="text-white">{{$loan_accounts}}</h4>
                                <h6 class="text-white m-b-0">Loans</h6>
                              </a>
                            </div>
                            <div class="col-4 text-right"><iframe class="chartjs-hidden-iframe" tabindex="-1" style="display: block; overflow: hidden; border: 0px; margin: 0px; top: 0px; left: 0px; bottom: 0px; right: 0px; height: 100%; width: 100%; position: absolute; pointer-events: none; z-index: -1;"></iframe><iframe class="chartjs-hidden-iframe" tabindex="-1" style="display: block; overflow: hidden; border: 0px; margin: 0px; top: 0px; left: 0px; bottom: 0px; right: 0px; height: 100%; width: 100%; position: absolute; pointer-events: none; z-index: -1;"></iframe>
                              <canvas id="update-chart-2" height="50" width="89" style="display: block; width: 89px; height: 50px;"></canvas>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>

                    <div class="col-xl-3 col-md-6">
                      <div class="card bg-c-green update-card">
                        <div class="card-block">
                          <div class="row align-items-end">
                            <div class="col-8">
                              <h4 class="text-white">{{$valueOfLoans}}</h4>
                              <h6 class="text-white m-b-0">Value of loans given</h6>
                            </div>
                            <div class="col-4 text-right"><iframe class="chartjs-hidden-iframe" tabindex="-1" style="display: block; overflow: hidden; border: 0px; margin: 0px; top: 0px; left: 0px; bottom: 0px; right: 0px; height: 100%; width: 100%; position: absolute; pointer-events: none; z-index: -1;"></iframe><iframe class="chartjs-hidden-iframe" tabindex="-1" style="display: block; overflow: hidden; border: 0px; margin: 0px; top: 0px; left: 0px; bottom: 0px; right: 0px; height: 100%; width: 100%; position: absolute; pointer-events: none; z-index: -1;"></iframe>
                              <canvas id="update-chart-2" height="50" width="89" style="display: block; width: 89px; height: 50px;"></canvas>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>

                    <div class="col-xl-3 col-md-6">
                      <div class="card bg-c-green update-card">
                        <div class="card-block">
                          <div class="row align-items-end">
                            <div class="col-8">
                              <h4 class="text-white">{{$valueOfOutstandingLoans}}</h4>
                              <h6 class="text-white m-b-0">Value of loans outstanding</h6>
                            </div>
                            <div class="col-4 text-right"><iframe class="chartjs-hidden-iframe" tabindex="-1" style="display: block; overflow: hidden; border: 0px; margin: 0px; top: 0px; left: 0px; bottom: 0px; right: 0px; height: 100%; width: 100%; position: absolute; pointer-events: none; z-index: -1;"></iframe><iframe class="chartjs-hidden-iframe" tabindex="-1" style="display: block; overflow: hidden; border: 0px; margin: 0px; top: 0px; left: 0px; bottom: 0px; right: 0px; height: 100%; width: 100%; position: absolute; pointer-events: none; z-index: -1;"></iframe>
                              <canvas id="update-chart-2" height="50" width="89" style="display: block; width: 89px; height: 50px;"></canvas>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>

                    <div class="col-xl-3 col-md-6">
                      <div class="card bg-c-green update-card">
                        <div class="card-block">
                          <div class="row align-items-end">
                            <div class="col-8">
                              <a href="{{ action('DeliveryNotificationsController@index')}}">
                                <h4 class="text-white">{{$delivery_notifications}}</h4>
                                <h6 class="text-white m-b-0">Number of loan requests</h6>
                              </a>
                            </div>
                            <div class="col-4 text-right"><iframe class="chartjs-hidden-iframe" tabindex="-1" style="display: block; overflow: hidden; border: 0px; margin: 0px; top: 0px; left: 0px; bottom: 0px; right: 0px; height: 100%; width: 100%; position: absolute; pointer-events: none; z-index: -1;"></iframe><iframe class="chartjs-hidden-iframe" tabindex="-1" style="display: block; overflow: hidden; border: 0px; margin: 0px; top: 0px; left: 0px; bottom: 0px; right: 0px; height: 100%; width: 100%; position: absolute; pointer-events: none; z-index: -1;"></iframe>
                              <canvas id="update-chart-2" height="50" width="89" style="display: block; width: 89px; height: 50px;"></canvas>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>

                    <div class="col-xl-3 col-md-6">
                      <div class="card bg-c-green update-card">
                        <div class="card-block">
                          <div class="row align-items-end">
                            <div class="col-8">
                              <h4 class="text-white">{{$valueOfAllDeliveries}}</h4>
                              <h6 class="text-white m-b-0">Value of all loan requests</h6>
                            </div>
                            <div class="col-4 text-right"><iframe class="chartjs-hidden-iframe" tabindex="-1" style="display: block; overflow: hidden; border: 0px; margin: 0px; top: 0px; left: 0px; bottom: 0px; right: 0px; height: 100%; width: 100%; position: absolute; pointer-events: none; z-index: -1;"></iframe><iframe class="chartjs-hidden-iframe" tabindex="-1" style="display: block; overflow: hidden; border: 0px; margin: 0px; top: 0px; left: 0px; bottom: 0px; right: 0px; height: 100%; width: 100%; position: absolute; pointer-events: none; z-index: -1;"></iframe>
                              <canvas id="update-chart-2" height="50" width="89" style="display: block; width: 89px; height: 50px;"></canvas>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>

                    <div class="col-xl-3 col-md-6">
                      <div class="card bg-c-green update-card">
                        <div class="card-block">
                          <div class="row align-items-end">
                            <div class="col-8">
                              <a href="{{ action('TransactionsController@index')}}">
                                <h4 class="text-white">{{$transactions}}</h4>
                                <h6 class="text-white m-b-0">Total number of transactions</h6>
                              </a>
                            </div>
                            <div class="col-4 text-right"><iframe class="chartjs-hidden-iframe" tabindex="-1" style="display: block; overflow: hidden; border: 0px; margin: 0px; top: 0px; left: 0px; bottom: 0px; right: 0px; height: 100%; width: 100%; position: absolute; pointer-events: none; z-index: -1;"></iframe><iframe class="chartjs-hidden-iframe" tabindex="-1" style="display: block; overflow: hidden; border: 0px; margin: 0px; top: 0px; left: 0px; bottom: 0px; right: 0px; height: 100%; width: 100%; position: absolute; pointer-events: none; z-index: -1;"></iframe>
                              <canvas id="update-chart-2" height="50" width="89" style="display: block; width: 89px; height: 50px;"></canvas>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>

                    <div class="col-xl-3 col-md-6">
                      <div class="card bg-c-green update-card">
                        <div class="card-block">
                          <div class="row align-items-end">
                            <div class="col-8">
                              <h4 class="text-white">{{$valueOfAllTransactions}}</h4>
                              <h6 class="text-white m-b-0">Total value of transactions</h6>
                            </div>
                            <div class="col-4 text-right"><iframe class="chartjs-hidden-iframe" tabindex="-1" style="display: block; overflow: hidden; border: 0px; margin: 0px; top: 0px; left: 0px; bottom: 0px; right: 0px; height: 100%; width: 100%; position: absolute; pointer-events: none; z-index: -1;"></iframe><iframe class="chartjs-hidden-iframe" tabindex="-1" style="display: block; overflow: hidden; border: 0px; margin: 0px; top: 0px; left: 0px; bottom: 0px; right: 0px; height: 100%; width: 100%; position: absolute; pointer-events: none; z-index: -1;"></iframe>
                              <canvas id="update-chart-2" height="50" width="89" style="display: block; width: 89px; height: 50px;"></canvas>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>

                    
                  </div>
                  <div class="row">
                    <div class="card col-xl-11 p-2 col-md-11">
                      <div class="card-header">
                        <h4>Search for Customer</h4>
                      </div>
                      <div class="card-block">
                        <form action="{{ route('customerSearch')}}" method="post">
                          <div class="form-group row">
                            @csrf
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="feather icon-phone"></i>
                                </span>
                                <input id="phone" name="phone" placeholder="For example +254710345130" class="form-control" required="true" value="" type="text">
                            </div>
                          </div>
                          <div class="form-group row">
                          <input type="submit" value="Send" class="btn btn-primary form-control">
                                <i class="icofont icofont-user-alt-3"></i>
                              </input>
                          </div>
                        </form>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-xl-11 col-md-11 p-2">
                    <canvas id="myChart" width="400" height="100"></canvas>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

        </div>
      </div>
    </div>

  </div>
  <!-- content-wrapper ends -->

  @endsection

@section('js')

<script src="https://www.chartjs.org/dist/2.9.2/Chart.min.js"></script>
<script src="https://www.chartjs.org/samples/latest/utils.js"></script>
<script>
  var ctx = document.getElementById('myChart').getContext('2d');
  console.log(@json($graph_r));
  console.log(@json($graph_l));
  var myChart = new Chart(ctx, {
      type: 'line',
      data: {
          labels: @json($dates),
          datasets: [{
              label: 'Repayments',
              borderColor: window.chartColors.green,
              backgroundColor: window.chartColors.green,            
              borderWidth: 1,
              data: @json($graph_r),
          },{
              label: 'Loans',
              borderColor: window.chartColors.blue,
              backgroundColor: window.chartColors.blue,            
              borderWidth: 1,
              data: @json($graph_l),
          },{
              label: 'Requests',
              borderColor: window.chartColors.yellow,
              backgroundColor: window.chartColors.yellow,            
              borderWidth: 1,
              data: @json($graph_d),
          }]
      },
      options: {
          responsive: true,
          title: {
            display: true,
            text: 'Repayments and Loans for the Last 30 Days'
          },
          tooltips: {
            mode: 'index',
          },
          hover: {
            mode: 'index'
          },
          scales: {
              yAxes: [{
                  ticks: {
                      beginAtZero: true
                  },
                  stacked: true
              }]
          }
      }
  });
</script>


@endsection