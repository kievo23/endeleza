@extends('layouts.app')

@section('title')
M-Weza: System Audit
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
                    <h2>Audit Trail for</h2>
                    <p class="mb-md-0">{{$user->email}}</p>
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
            <div class="col-md-12 stretch-card">
                <section id="cd-timeline" class="cd-container">
                    @foreach($actions as $action)
                    <div class="cd-timeline-block">
                        <div class="cd-timeline-img cd-picture">
                        </div>

                        <div class="cd-timeline-content">
                            <h2>{{$action->description}}; {{$action->log_name}}</h2>
                            <div class="timeline-content-info">
                                <span class="timeline-content-info-date">
                                    <i class="fa fa-calendar-o" aria-hidden="true"></i>
                                    {{$action->created_at}}
                                </span>
                            </div>
                                <p>
                                    @php
                                        $data = $action->properties->toArray();
                                    @endphp 


                                    @if(isset($data['old']))
                                      <h4>Old Values</h4>
                                      @foreach($data['old'] as $key => $d)
                                        @if($key != "password")
                                          <p><strong>{{$key}}: </strong> {{$d}}</p>
                                        @endif
                                      @endforeach 
                                    @endif 

                                    <h4>New Values</h4>
                                    @foreach($data['attributes'] as $key => $d)
                                      @if($key != "password")
                                        <p><strong>{{$key}}: </strong> {{$d}}</p>
                                      @endif
                                    @endforeach                                   
                                </p>
                                <ul class="content-skills">
                                    <li></li>
                                </ul>
                        </div> <!-- cd-timeline-content -->
                    </div> <!-- cd-timeline-block -->

                    @endforeach
                </section>
            </div>
          </div>
        </div>
        <!-- content-wrapper ends -->

@endsection