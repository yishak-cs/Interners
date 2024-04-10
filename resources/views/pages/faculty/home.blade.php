@extends('pages.faculty.inc.app')

@section('header')
    @include('layout.header', ['title' => 'Faculty | Home'])
@endsection

@section('content-header')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Dashboard</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">Home</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
@endsection

@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="row">

                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <!-- small card -->
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3>{{ $stat_counts['Students'] }}</h3>

                            <p>Students</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-users"></i>
                        </div>
                        <a href="{{ route('faculty.student.list') }}" class="small-box-footer">
                            More info <i class="fas fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <!-- small card -->
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3>{{ $stat_counts['Faculty_departments'] }}</h3>

                            <p>Departments</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-user-graduate"></i>
                        </div>
                        <a href="{{ route('faculty.department.list') }}" class="small-box-footer">
                            More info <i class="fas fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <!-- small card -->
                    <div class="small-box bg-danger">
                        <div class="inner">
                            <h3>{{ $stat_counts['Accepted'] }}</h3>
                            <p>Accepted Stundent</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-users"></i>
                        </div>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <!-- small card -->
                    <div class="small-box bg-secondary">
                        <div class="inner">
                            <h3>{{ $stat_counts['Evaluation_response'] }}</h3>

                            <p>Evaluation Responses</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-user-graduate"></i>
                        </div>
                        </a>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header border-0">
                            <div class="d-flex justify-content-between">
                                <h3 class="card-title">Reports</h3>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="d-flex">
                                <p class="d-flex flex-column">
                                    <span
                                        class="text-bold text-lg">{{ array_sum(array_values($pending_application_count['thisWeek'])) }}</span>
                                    <span>This week pending applications</span>
                                </p>
                                <p class="ml-auto d-flex flex-column text-right">
                                    @if ($pending_application_count['percentage'] < 0)
                                        <span class="text-danger">
                                            <i class="fas fa-arrow-down"></i> {{ $pending_application_count['percentage'] }}%
                                        </span>
                                    @elseif ($pending_application_count['percentage'] == 0)
                                        <span class="text-warning">
                                            <i class="fas fa-angle-left"></i> {{ $pending_application_count['percentage'] }}%
                                        </span>
                                    @else
                                        <span class="text-success">
                                            <i class="fas fa-arrow-up"></i> {{ $pending_application_count['percentage'] }}%
                                        </span>
                                    @endif
                                    <span class="text-muted">Since last week</span>
                                </p>
                            </div>
                            <!-- /.d-flex -->

                            <div class="position-relative mb-4">
                                <canvas id="pending-applications-chart" height="200"></canvas>
                            </div>

                            <div class="d-flex flex-row justify-content-end">
                                <span class="mr-2">
                                    <i class="fas fa-square text-primary"></i> This Week
                                </span>

                                <span>
                                    <i class="fas fa-square text-gray"></i> Last Week
                                </span>
                            </div>
                        </div>
                    </div>
                    <!-- /.card -->
                    <div class="card">
                        <div class="card-header border-0">
                            <div class="d-flex justify-content-between">
                                <h3 class="card-title">Reports</h3>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="d-flex">
                                <p class="d-flex flex-column">
                                    <span
                                        class="text-bold text-lg">{{ array_sum(array_values($application_response_count['thisWeek'])) }}</span>
                                    <span>This week evaluation responses</span>
                                </p>
                                <p class="ml-auto d-flex flex-column text-right">
                                    @if ($application_response_count['percentage'] < 0)
                                        <span class="text-danger">
                                            <i class="fas fa-arrow-down"></i> {{ $application_response_count['percentage'] }}%
                                        </span>
                                    @elseif ($application_response_count['percentage'] == 0)
                                        <span class="text-warning">
                                            <i class="fas fa-angle-left"></i> {{ $application_response_count['percentage'] }}%
                                        </span>
                                    @else
                                        <span class="text-success">
                                            <i class="fas fa-arrow-up"></i> {{ $application_response_count['percentage'] }}%
                                        </span>
                                    @endif
                                    <span class="text-muted">Since last week</span>
                                </p>
                            </div>
                            <!-- /.d-flex -->

                            <div class="position-relative mb-4">
                                <canvas id="applications-response-chart" height="200"></canvas>
                            </div>

                            <div class="d-flex flex-row justify-content-end">
                                <span class="mr-2">
                                    <i class="fas fa-square text-primary"></i> This Week
                                </span>

                                <span>
                                    <i class="fas fa-square text-gray"></i> Last Week
                                </span>
                            </div>
                        </div>
                    </div>
                    <!-- /.card -->
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </section>
    @endsection
    @push('scripts')
    <script>
        @if (session('error'))
               Toast.fire({
                   icon: 'error',
                   title: {!! "'" . session('error') . "'" !!}
               })
           @endif
           var ticksStyle = {
               fontColor: '#495057',
               fontStyle: 'bold'
           }

           var mode = 'index'
           var intersect = true
           var $applicationsChart = $('#pending-applications-chart')
           // eslint-disable-next-line no-unused-vars
           var applicationsChart = new Chart($applicationsChart, {
               data: {
                   labels: {!! json_encode(array_keys($pending_application_count['lastWeek'])) !!},
                   datasets: [{
                           type: 'line',
                           data: {!! json_encode(array_values($pending_application_count['thisWeek'])) !!},
                           backgroundColor: 'transparent',
                           borderColor: '#007bff',
                           pointBorderColor: '#007bff',
                           pointBackgroundColor: '#007bff',
                           fill: false
                           // pointHoverBackgroundColor: '#007bff',
                           // pointHoverBorderColor    : '#007bff'
                       },
                       {
                           type: 'line',
                           data: {!! json_encode(array_values($pending_application_count['lastWeek'])) !!},
                           backgroundColor: 'tansparent',
                           borderColor: '#ced4da',
                           pointBorderColor: '#ced4da',
                           pointBackgroundColor: '#ced4da',
                           fill: false
                           // pointHoverBackgroundColor: '#ced4da',
                           // pointHoverBorderColor    : '#ced4da'
                       }
                   ]
               },
               options: {
                   maintainAspectRatio: false,
                   tooltips: {
                       mode: mode,
                       intersect: intersect
                   },
                   hover: {
                       mode: mode,
                       intersect: intersect
                   },
                   legend: {
                       display: false
                   },
                   scales: {
                       yAxes: [{
                           gridLines: {
                               display: true,
                               lineWidth: '4px',
                               color: 'rgba(0, 0, 0, .2)',
                               zeroLineColor: 'transparent'
                           },
                           ticks: $.extend({
                               beginAtZero: true
                           }, ticksStyle)
                       }],
                       xAxes: [{
                           display: true,
                           gridLines: {
                               display: false
                           },
                           ticks: ticksStyle
                       }]
                   }
               }
           })
   </script>
   <script>
         @if (session('error'))
                Toast.fire({
                    icon: 'error',
                    title: {!! "'" . session('error') . "'" !!}
                })
            @endif
            var ticksStyle = {
                fontColor: '#495057',
                fontStyle: 'bold'
            }

            var mode = 'index'
            var intersect = true
            var $applicationsChart = $('#applications-response-chart')
            // eslint-disable-next-line no-unused-vars
            var applicationsChart = new Chart($applicationsChart, {
                data: {
                    labels: {!! json_encode(array_keys($pending_application_count['lastWeek'])) !!},
                    datasets: [{
                            type: 'line',
                            data: {!! json_encode(array_values($application_response_count['thisWeek'])) !!},
                            backgroundColor: 'transparent',
                            borderColor: '#007bff',
                            pointBorderColor: '#007bff',
                            pointBackgroundColor: '#007bff',
                            fill: false
                            // pointHoverBackgroundColor: '#007bff',
                            // pointHoverBorderColor    : '#007bff'
                        },
                        {
                            type: 'line',
                            data: {!! json_encode(array_values($application_response_count['lastWeek'])) !!},
                            backgroundColor: 'tansparent',
                            borderColor: '#ced4da',
                            pointBorderColor: '#ced4da',
                            pointBackgroundColor: '#ced4da',
                            fill: false
                            // pointHoverBackgroundColor: '#ced4da',
                            // pointHoverBorderColor    : '#ced4da'
                        }
                    ]
                },
                options: {
                    maintainAspectRatio: false,
                    tooltips: {
                        mode: mode,
                        intersect: intersect
                    },
                    hover: {
                        mode: mode,
                        intersect: intersect
                    },
                    legend: {
                        display: false
                    },
                    scales: {
                        yAxes: [{
                            gridLines: {
                                display: true,
                                lineWidth: '4px',
                                color: 'rgba(0, 0, 0, .2)',
                                zeroLineColor: 'transparent'
                            },
                            ticks: $.extend({
                                beginAtZero: true
                            }, ticksStyle)
                        }],
                        xAxes: [{
                            display: true,
                            gridLines: {
                                display: false
                            },
                            ticks: ticksStyle
                        }]
                    }
                }
            })
    </script>

    @endpush
