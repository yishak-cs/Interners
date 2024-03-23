@extends('pages.university.inc.app')

@section('header')
    @include('layout.header', ['title' => 'University | Faculty | List'])
@endsection

@section('content-header')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Faculty List</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">Home</li>
                        <li class="breadcrumb-item">Faculty</li>
                        <li class="breadcrumb-item active">List</li>
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
                            <h3 class="card-title">Faculty List</h3>
                        </div>
                        <div class="card-body">
                            @if (session('error'))
                                <div class="alert alert-danger alert-dismissible" role="alert">
                                    <button type="button" class="close" data-dismiss="alert"
                                        aria-hidden="true">×</button>
                                    <i class="icon fas fa-ban"></i>
                                    {{ session('error') }}
                                </div>
                            @endif
                            @if (session('success'))
                                <div class="alert alert-success alert-dismissible" role="alert">
                                    <button type="button" class="close" data-dismiss="alert"
                                        aria-hidden="true">×</button>
                                    <i class="icon fas fa-check"></i>
                                    {!! session('success') !!}
                                </div>
                            @endif
                            <table id="dataTable" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Faculty Name</th>
                                        <th>University Name</th>
                                        <th>Faculty Admin</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($faculties as $faculty)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $faculty->name }}</td>
                                            <td class="@if ($faculty->university->trashed()) text-danger @endif">{{ $faculty->university->name }}</td>
                                            <td>{{ $faculty->getHeadName() }}</td>
                                            <td>
                                                <a href="{{ route('university.faculty.view', $faculty) }}">
                                                    <button class="btn btn-info btn-xs btn-flat">
                                                        <i class="fas fa-eye"></i>
                                                        View
                                                    </button>
                                                </a>
                                                <a href="{{ route('university.faculty.edit', $faculty) }}">
                                                    <button class="btn btn-primary btn-xs btn-flat">
                                                        <i class="fas fa-edit"></i>
                                                        Edit
                                                    </button>
                                                </a>
                                                <a href="{{ route('university.faculty.delete', $faculty) }}" onclick="if(confirm('Are you sure, you want to delete {{ $faculty->name }}?') == false){event.preventDefault()}">
                                                    <button class="btn btn-danger btn-xs btn-flat">
                                                        <i class="fas fa-trash"></i>
                                                        Delete
                                                    </button>
                                                </a>
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
        <!-- /.container-fluid -->
    </section>
@endsection
