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
              <h2>Welcome back to the Endeleza Platform Summary</h2>
              <p class="mb-md-0">Your analytics dashboard.</p>
              <i class="mdi mdi-home text-muted hover-cursor"></i>
            </div>
          </div>

          <div class="">
            <div class="main-body">
              <div class="page-wrapper">
                <div class="page-body">
                  <div class="row">
                    <div class="card col-xl-12 p-2 col-md-12">
                      <div class="card-header">
                        <h4>Books of Accounts</h4>
                      </div>
                      <div class="card-block">
                        <div class="table-responsive">
                            <table class="table" id="report display">
                                <thead class="success">
                                    <th>Year</th>
                                    <th>Month</th>
                                    <th>Amount Advanced</th>
                                    <th>Expected Repayment</th>
                                    <th>Actual Amount Paid</th>
                                    <th>Outstanding Principal</th>
                                    <th>P & L</th>
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
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
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


</script>
@endsection