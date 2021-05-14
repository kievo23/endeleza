@extends('layouts.app')

@section('title')
Endeleza: Report
@endsection

@section('assets')

<link href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
<link href="https://cdn.datatables.net/buttons/1.5.6/css/buttons.dataTables.min.css">
<link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.css">
<link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css">

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
                    <h2>Report</h2>
                    <p class="mb-md-0">Your analytics dashboard</p>
                  </div>
                  <div class="d-flex">
                    <i class="mdi mdi-home text-muted hover-cursor"></i>
                    <!-- <p class="text-muted mb-0 hover-cursor">&nbsp;/&nbsp;Dashboard&nbsp;/&nbsp;</p>
                    <p class="text-primary mb-0 hover-cursor">Analytics</p> -->
                  </div>
                </div>
                <div class="d-flex justify-content-between align-items-end flex-wrap">

                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-xl-12 col-md-12">
              <div class="card">
                <div class="card-body">
                  <canvas id="myChart" width="400" height="200"></canvas>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12 stretch-card">
              <div class="card">
                <div class="card-body">
                  <hr>
                  <div class="table-responsive">
                            <table class="table display" id="report">
                                <thead class="success">
                                    <th>Year</th>
                                    <th>Month</th>
                                    <th>Amount Advanced</th>
                                    <th>Expected Repayment</th>
                                    <th>Actual Amount Paid</th>
                                    <th>Outstanding Principal</th>
                                    <th>P & L</th>
                                    <th>Pending Payments</th>
                                </thead>
                                <tbody>
                                @foreach($data as $d)
                                    <tr>
                                        <td>{{$d->year}}</td>
                                        <td>
                                        @php 
                                        echo date("F", strtotime('00-'.$d->month.'-01'));
                                        @endphp
                                        </td>
                                        <td>{{number_format($d->amount_advanced, 2, '.', ',')}}</td>
                                        <td>{{number_format($d->expected_amount, 2, '.', ',')}}</td>
                                        <td>{{number_format($d->amount_paid, 2, '.', ',')}}</td>
                                        <td>
                                        @if($d->amount_advanced > $d->amount_paid)
                                            {{abs($d->amount_advanced - $d->amount_paid)}}
                                        @else
                                            0
                                        @endif
                                        </td>
                                        <td>{{number_format(($d->amount_paid - $d->amount_advanced), 2, '.', ',')}}</td>
                                        <td>
                                          {{ number_format(($d->expected_amount - $d->amount_paid), 2, '.', ',') }}
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
  <!-- content-wrapper ends -->

  @endsection

  @section('js')

<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.6/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.flash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.print.min.js"></script>
<script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<!-- Latest compiled and minified JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.9/dist/js/bootstrap-select.min.js"></script>

<!-- (Optional) Latest compiled and minified JavaScript translation files -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.9/dist/js/i18n/defaults-*.min.js"></script>
<script src="https://www.chartjs.org/dist/2.9.2/Chart.min.js"></script>
<script src="https://www.chartjs.org/samples/latest/utils.js"></script>


<script>

$(document).ready( function () {
    let table = $('#report').DataTable({
      dom: 'Bfrtip',
      pageLength: 50,
      buttons: [
        'copy', 'csv', 'excel', 'print'
        ]
        //"order": [[ 6, "desc" ]]
    });

    $('a.toggle-vis').on( 'click', function (e) {
      e.preventDefault();

      // Get the column API object
      var column = table.column( $(this).attr('data-column') );

      // Toggle the visibility
      column.visible( ! column.visible() );
    });
});

var ctx = document.getElementById('myChart').getContext('2d');


  var myChart = new Chart(ctx, {
      type: 'bar',
      data: {
          labels: @json($dates),
          datasets: [{
              type: 'bar',
              label: 'Amount Advanced',
              borderColor: '#858585',
              backgroundColor: '#858585',            
              //borderWidth: 1,
              borderRadius: 5,
              fill: false,
              data: @json($graph_aa),
          },{
              type: 'bar',
              label: 'Expected Amount',
              borderColor: '#336ce8',
              backgroundColor: '#336ce8',            
              //borderWidth: 1,
              fill: false,
              data: @json($graph_ea),
          },{
              type: 'bar',
              label: 'Amount Paid',
              borderColor: '#1db525',
              backgroundColor: '#1db525',            
              //borderWidth: 1,
              fill: false,
              data: @json($graph_ap),
          },{
              type: 'line',
              label: 'Profit & Loss',
              borderColor: '#e8336c',
              backgroundColor: '#e8336c',            
              //borderWidth: 1,
              fill: false,
              data: @json($graph_pl),
          },{
              label: 'Outstanding Principal',
              borderColor: '#6c33e8',
              backgroundColor: '#6c33e8',            
              //borderWidth: 1,
              data: @json($graph_op),
          },{
              label: 'Pending Amount',
              borderColor: '#f5ba31',
              backgroundColor: '#f5ba31',            
              //borderWidth: 1,
              data: @json($graph_pa),
          }]
      },
      options: {
          responsive: true,
          title: {
            display: true,
            text: 'Performance from inception'
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
                  }
              }]
          }
      }
  });

</script>
@endsection