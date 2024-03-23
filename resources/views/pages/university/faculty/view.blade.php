@extends('pages.university.inc.app')

@section('header')
    @include('layout.header', ['title' => 'University | Faculty | View'])
@endsection

@section('content-header')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Faculty Detail</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">Home</li>
                        <li class="breadcrumb-item">Faculty</li>
                        <li class="breadcrumb-item"><a href="{{ route('university.faculty.list') }}">List</a></li>
                        <li class="breadcrumb-item active">Detail</li>
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

                <div class="col-md-12">

                    <div class="card card-default">
                        <div class="card-header">
                            <h3 class="card-title">Faculty Detail</h3>
                            <div class="card-tools mr-5">
                                <a href="{{ route('university.faculty.list') }}"><button type="button" class="btn btn-tool"><i
                                            class="fas fa-arrow-left"></i>
                                            Back
                                    </button></a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-2"></div>
                                <div class="col-md-10">
                                    <dl class="row">
                                        <dt class="col-sm-3">Faculty Id:</dt>
                                        <dd class="col-sm-9">{{ $faculty->id }}</dd>
                                        <dt class="col-sm-3">University Name:</dt>
                                        <dd class="col-sm-9 @if ($faculty->university->trashed()) text-danger @endif">{{ $faculty->university->name }}</dd>
                                        <dt class="col-sm-3">Faculty Head:</dt>
                                        <dd class="col-sm-9">{{ $faculty->getHeadName() }}</dd>
                                        <dt class="col-sm-3">Faculty Name:</dt>
                                        <dd class="col-sm-9">{{ $faculty->name }}</dd>
                                        <dt class="col-sm-3">Description:</dt>
                                        <dd class="col-sm-9">{{ $faculty->description }}</dd>
                                        <dt class="col-sm-3">Register Date:</dt>
                                        <dd class="col-sm-9">
                                            {{ \Carbon\Carbon::parse($faculty->created_at)->setTimezone('Africa/Addis_Ababa')->format('d/m/Y \a\t H:i a') }}
                                        </dd>
                                        <dt class="col-sm-3">Last Update:</dt>
                                        <dd class="col-sm-9">
                                            {{ \Carbon\Carbon::parse($faculty->updated_at)->setTimezone('Africa/Addis_Ababa')->format('d/m/Y \a\t H:i a') }}
                                        </dd>
                                    </dl>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </div>
        <!-- /.container-fluid -->
    </section>
@endsection
