@extends('layouts.app')

@section('content')

      <!-- partial -->
      <div class="main-panel">
        <div class="content-wrapper">
          
          <div class="row">
            <div class="col-md-12 grid-margin">
              <div class="d-flex justify-content-between flex-wrap">
                <div class="d-flex align-items-end flex-wrap">
                  <div class="mr-md-3 mr-xl-5">
                    <h2>Welcome back,</h2>
                    <p class="mb-md-0">Your analytics dashboard.</p>
                  </div>
                  <div class="d-flex">
                    <i class="mdi mdi-home text-muted hover-cursor"></i>
                    <p class="text-muted mb-0 hover-cursor">&nbsp;/&nbsp;Dashboard&nbsp;/&nbsp;</p>
                    <p class="text-primary mb-0 hover-cursor">Analytics</p>
                  </div>
                </div>
                <div class="d-flex justify-content-between align-items-end flex-wrap">
                  <button type="button" class="btn btn-light bg-white btn-icon mr-3 d-none d-md-block ">
                    <i class="mdi mdi-download text-muted"></i>
                  </button>
                  <button type="button" class="btn btn-light bg-white btn-icon mr-3 mt-2 mt-xl-0">
                    <i class="mdi mdi-clock-outline text-muted"></i>
                  </button>
                  <button type="button" class="btn btn-light bg-white btn-icon mr-3 mt-2 mt-xl-0">
                    <i class="mdi mdi-plus text-muted"></i>
                  </button>
                  <button class="btn btn-primary mt-2 mt-xl-0">Generate report</button>
                </div>
              </div>
            </div>
          </div>
          <!-- <div class="row" id="proBanner">
            <div class="col-md-12 grid-margin">
              <div class="card bg-gradient-primary border-0">
                <div class="card-body py-3 px-4 d-flex align-items-center justify-content-between flex-wrap">
                  <p class="mb-0 text-white font-weight-medium">Like what you see? Checkout our premium version for more.</p>
                  <div class="d-flex">
                    <a href="https://github.com/Urbanui/MajesticAdmin-Free-Bootstrap-Admin-Template" target="_blank" class="btn btn-outline-light mr-2">Download free version</a>
                    <a href="http://www.urbanui.com/majestic-admin-pro/template/" target="_blank" class="btn btn-outline-light mr-2 bg-gradient-danger border-0">Upgrade to Pro</a>
                    <button id="bannerClose" class="btn border-0 p-0">
                      <i class="mdi mdi-close text-white"></i>
                    </button>
                  </div>
                </div>
              </div>
            </div>
          </div> -->
          <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
              <div class="card">
                <div class="card-body dashboard-tabs p-0">
                  <ul class="nav nav-tabs px-4" role="tablist">
                    <li class="nav-item">
                      <a class="nav-link active" id="overview-tab" data-toggle="tab" href="#overview" role="tab" aria-controls="overview" aria-selected="true">Overview</a>
                    </li>
                    <!-- <li class="nav-item">
                      <a class="nav-link" id="sales-tab" data-toggle="tab" href="#sales" role="tab" aria-controls="sales" aria-selected="false">Sales</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" id="purchases-tab" data-toggle="tab" href="#purchases" role="tab" aria-controls="purchases" aria-selected="false">Purchases</a>
                    </li> -->
                  </ul>
                  <div class="tab-content py-0 px-0">
                    <div class="tab-pane fade show active" id="overview" role="tabpanel" aria-labelledby="overview-tab">
                      <div class="d-flex flex-wrap justify-content-xl-between">
                        <!-- <div class="d-none d-xl-flex border-md-right flex-grow-1 align-items-center justify-content-center p-3 item">
                          <i class="mdi mdi-calendar-heart icon-lg mr-3 text-primary"></i>
                          <div class="d-flex flex-column justify-content-around">
                            <small class="mb-1 text-muted">Start date</small>
                            <div class="dropdown">
                              <a class="btn btn-secondary dropdown-toggle p-0 bg-transparent border-0 text-dark shadow-none font-weight-medium" href="#" role="button" id="dropdownMenuLinkA" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <h5 class="mb-0 d-inline-block">26 Jul 2018</h5>
                              </a>
                              <div class="dropdown-menu" aria-labelledby="dropdownMenuLinkA">
                                <a class="dropdown-item" href="#">12 Aug 2018</a>
                                <a class="dropdown-item" href="#">22 Sep 2018</a>
                                <a class="dropdown-item" href="#">21 Oct 2018</a>
                              </div>
                            </div>
                          </div>
                        </div> -->
                        <div class="d-flex border-md-right flex-grow-1 align-items-center justify-content-center p-3 item">
                          <!-- <i class="mdi mdi-currency-usd mr-3 icon-lg text-danger"></i> -->
                          <div class="d-flex flex-column justify-content-around">
                            <small class="mb-1 text-muted">Total number of transactions</small>
                            <h5 class="mr-2 mb-0">14042</h5>
                          </div>
                        </div>
                        <div class="d-flex border-md-right flex-grow-1 align-items-center justify-content-center p-3 item">
                          <!-- <i class="mdi mdi-eye mr-3 icon-lg text-success"></i> -->
                          <div class="d-flex flex-column justify-content-around">
                            <small class="mb-1 text-muted">Total value of transactions</small>
                            <h5 class="mr-2 mb-0">Ksh. 10,714,046</h5>
                          </div>
                        </div>
                        <div class="d-flex border-md-right flex-grow-1 align-items-center justify-content-center p-3 item">
                          <!-- <i class="mdi mdi-download mr-3 icon-lg text-warning"></i> -->
                          <div class="d-flex flex-column justify-content-around">
                            <small class="mb-1 text-muted">Average value of transaction</small>
                            <h5 class="mr-2 mb-0">Ksh. 763</h5>
                          </div>
                        </div>
                        <!-- <div class="d-flex py-3 border-md-right flex-grow-1 align-items-center justify-content-center p-3 item"> -->
                          <!-- <i class="mdi mdi-flag mr-3 icon-lg text-danger"></i> -->
                          <!-- <div class="d-flex flex-column justify-content-around">
                            <small class="mb-1 text-muted">Value of loans outstanding</small>
                            <h5 class="mr-2 mb-0">Ksh. 10,497,843</h5>
                          </div>
                        </div> -->
                      </div>
                    </div>
                    <div class="tab-pane fade" id="sales" role="tabpanel" aria-labelledby="sales-tab">
                      <div class="d-flex flex-wrap justify-content-xl-between">
                        <div class="d-none d-xl-flex border-md-right flex-grow-1 align-items-center justify-content-center p-3 item">
                          <i class="mdi mdi-calendar-heart icon-lg mr-3 text-primary"></i>
                          <div class="d-flex flex-column justify-content-around">
                            <small class="mb-1 text-muted">Start date</small>
                            <div class="dropdown">
                              <a class="btn btn-secondary dropdown-toggle p-0 bg-transparent border-0 text-dark shadow-none font-weight-medium" href="#" role="button" id="dropdownMenuLinkA" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <h5 class="mb-0 d-inline-block">26 Jul 2018</h5>
                              </a>
                              <div class="dropdown-menu" aria-labelledby="dropdownMenuLinkA">
                                <a class="dropdown-item" href="#">12 Aug 2018</a>
                                <a class="dropdown-item" href="#">22 Sep 2018</a>
                                <a class="dropdown-item" href="#">21 Oct 2018</a>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="d-flex border-md-right flex-grow-1 align-items-center justify-content-center p-3 item">
                          <i class="mdi mdi-download mr-3 icon-lg text-warning"></i>
                          <div class="d-flex flex-column justify-content-around">
                            <small class="mb-1 text-muted">Downloads</small>
                            <h5 class="mr-2 mb-0">2233783</h5>
                          </div>
                        </div>
                        <div class="d-flex border-md-right flex-grow-1 align-items-center justify-content-center p-3 item">
                          <i class="mdi mdi-eye mr-3 icon-lg text-success"></i>
                          <div class="d-flex flex-column justify-content-around">
                            <small class="mb-1 text-muted">Total views</small>
                            <h5 class="mr-2 mb-0">9833550</h5>
                          </div>
                        </div>
                        <div class="d-flex border-md-right flex-grow-1 align-items-center justify-content-center p-3 item">
                          <i class="mdi mdi-currency-usd mr-3 icon-lg text-danger"></i>
                          <div class="d-flex flex-column justify-content-around">
                            <small class="mb-1 text-muted">Revenue</small>
                            <h5 class="mr-2 mb-0">$577545</h5>
                          </div>
                        </div>
                        <div class="d-flex py-3 border-md-right flex-grow-1 align-items-center justify-content-center p-3 item">
                          <i class="mdi mdi-flag mr-3 icon-lg text-danger"></i>
                          <div class="d-flex flex-column justify-content-around">
                            <small class="mb-1 text-muted">Flagged</small>
                            <h5 class="mr-2 mb-0">3497843</h5>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="tab-pane fade" id="purchases" role="tabpanel" aria-labelledby="purchases-tab">
                      <div class="d-flex flex-wrap justify-content-xl-between">
                        <div class="d-none d-xl-flex border-md-right flex-grow-1 align-items-center justify-content-center p-3 item">
                          <i class="mdi mdi-calendar-heart icon-lg mr-3 text-primary"></i>
                          <div class="d-flex flex-column justify-content-around">
                            <small class="mb-1 text-muted">Start date</small>
                            <div class="dropdown">
                              <a class="btn btn-secondary dropdown-toggle p-0 bg-transparent border-0 text-dark shadow-none font-weight-medium" href="#" role="button" id="dropdownMenuLinkA" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <h5 class="mb-0 d-inline-block">26 Jul 2018</h5>
                              </a>
                              <div class="dropdown-menu" aria-labelledby="dropdownMenuLinkA">
                                <a class="dropdown-item" href="#">12 Aug 2018</a>
                                <a class="dropdown-item" href="#">22 Sep 2018</a>
                                <a class="dropdown-item" href="#">21 Oct 2018</a>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="d-flex border-md-right flex-grow-1 align-items-center justify-content-center p-3 item">
                          <i class="mdi mdi-currency-usd mr-3 icon-lg text-danger"></i>
                          <div class="d-flex flex-column justify-content-around">
                            <small class="mb-1 text-muted">Revenue</small>
                            <h5 class="mr-2 mb-0">$577545</h5>
                          </div>
                        </div>
                        <div class="d-flex border-md-right flex-grow-1 align-items-center justify-content-center p-3 item">
                          <i class="mdi mdi-eye mr-3 icon-lg text-success"></i>
                          <div class="d-flex flex-column justify-content-around">
                            <small class="mb-1 text-muted">Total views</small>
                            <h5 class="mr-2 mb-0">9833550</h5>
                          </div>
                        </div>
                        <div class="d-flex border-md-right flex-grow-1 align-items-center justify-content-center p-3 item">
                          <i class="mdi mdi-download mr-3 icon-lg text-warning"></i>
                          <div class="d-flex flex-column justify-content-around">
                            <small class="mb-1 text-muted">Downloads</small>
                            <h5 class="mr-2 mb-0">2233783</h5>
                          </div>
                        </div>
                        <div class="d-flex py-3 border-md-right flex-grow-1 align-items-center justify-content-center p-3 item">
                          <i class="mdi mdi-flag mr-3 icon-lg text-danger"></i>
                          <div class="d-flex flex-column justify-content-around">
                            <small class="mb-1 text-muted">Flagged</small>
                            <h5 class="mr-2 mb-0">3497843</h5>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- <div class="row">
            <div class="col-md-7 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <p class="card-title">Cash deposits</p>
                  <p class="mb-4">To start a blog, think of a topic about and first brainstorm party is ways to write details</p>
                  <div id="cash-deposits-chart-legend" class="d-flex justify-content-center pt-3"></div>
                  <canvas id="cash-deposits-chart"></canvas>
                </div>
              </div>
            </div>
            <div class="col-md-5 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <p class="card-title">Total sales</p>
                  <h1>$ 28835</h1>
                  <h4>Gross sales over the years</h4>
                  <p class="text-muted">Today, many people rely on computers to do homework, work, and create or store useful information. Therefore, it is important </p>
                  <div id="total-sales-chart-legend"></div>                  
                </div>
                <canvas id="total-sales-chart"></canvas>
              </div>
            </div>
          </div> -->
          <div class="row">
            <div class="col-md-12 stretch-card">
              <div class="card">
                <div class="card-body">
                  <p class="card-title">Loan Accounts</p>
                  <div class="table-responsive">
                    <table id="recent-purchases-listing" class="table">
                      <thead>
                        <tr>
                            <th>Product ID</th>
                            <th>Product Code</th>
                            <th>Product Name</th>
                            <th>Description</th>
                            <th>Period</th>
                            <th>Rate</th>
                            <th>Grace Period</th>
                            <th>Penalty Rate</th>
                            <th>Maximum Principal</th>
                            <th>Minimum Principal</th>
                            <th>Active</th>
                            <th>Delete</th>
                            <th>Created By</th>
                            <th>Updated By</th>
                            <th>Deleted By</th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach($products as $product)
                        <tr>
                            <th>{{$product->PRODUCT_ID}}</th>
                            <th>{{$product->PRODUCT_CODE}}</th>
                            <th>{{$product->PRODUCT_NAME}}</th>
                            <th>{{$product->DESCRIPTION}}</th>
                            <th>{{$product->PERIOD}}</th>
                            <th>{{$product->RATE}}</th>
                            <th>{{$product->GRACE_PERIOD}}</th>
                            <th>{{$product->PENALTY_RATE}}</th>
                            <th>{{$product->MAXIMUM_PRINCIPAL}}</th>
                            <th>{{$product->MINIMUM_PRINCIPAL}}</th>
                            <th>{{$product->ACTIVE}}</th>
                            <th>{{$product->DELETED}}</th>
                            <th>{{$product->CREATED_BY}}</th>
                            <th>{{$product->UPDATED_BY}}</th>
                            <th>{{$product->DELETED_BY}}</th>
                        </tr>
                        @endforeach                        
                      </tbody>
                    </table>
                    {{ $products->links() }}
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- content-wrapper ends -->

@endsection