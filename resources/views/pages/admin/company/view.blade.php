@extends('pages.admin.inc.app')

@section('header')
    @include('layout.header', ['title' => 'Admin | Company | View'])
@endsection

@section('content-header')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Company Detail</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">Home</li>
                        <li class="breadcrumb-item">Company</li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.company.list') }}">List</a></li>
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
                            <h3 class="card-title">Company Detail</h3>
                            <div class="card-tools mr-5">
                                <a href="{{ route('admin.company.list') }}"><button type="button" class="btn btn-tool"><i
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
                                        <dt class="col-sm-2">Company Id:</dt>
                                        <dd class="col-sm-10">{{ $company->id }}</dd>
                                        <dt class="col-sm-2">Company Name</dt>
                                        <dd class="col-sm-10">{{ $company->name }}</dd>
                                        <dt class="col-sm-2">Company Head:</dt>
                                        <dd class="col-sm-10 @if ($company->head) @if($company->head->trashed()) text-danger @endif @endif">{{ $company->getHeadName() }}</dd>
                                        <dt class="col-sm-2">Description:</dt>
                                        <dd class="col-sm-10">{{ $company->description }}</dd>
                                        <dt class="col-sm-2">Register Date:</dt>
                                        <dd class="col-sm-10">
                                            {{ \Carbon\Carbon::parse($company->created_at)->setTimezone('Africa/Addis_Ababa')->format('d/m/Y \a\t H:i a') }}
                                        </dd>
                                        <dt class="col-sm-2">Last Update:</dt>
                                        <dd class="col-sm-10">
                                            {{ \Carbon\Carbon::parse($company->updated_at)->setTimezone('Africa/Addis_Ababa')->format('d/m/Y \a\t H:i a') }}
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
