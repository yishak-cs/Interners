@extends('pages.admin.inc.app')

@section('header')
    @include('layout.header', ['title' => 'Admin | University | List'])
@endsection

@section('content-header')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">University List</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">Home</li>
                        <li class="breadcrumb-item">University</li>
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
                            <h3 class="card-title">University List</h3>
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
                                    {{ session('success') }}
                                </div>
                            @endif
                            <table id="dataTable" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>University Name</th>
                                        <th>University Admin</th>
                                        <th>Department Count</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($universities as $university)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $university->name }}</td>
                                            <td class="@if ($university->head) @if($university->head->trashed()) text-danger @endif @endif">
                                                @if ($university->head)
                                                <a href="{{ route('admin.staff.view', $university->head->id) }}">
                                                    {{ $university->getHeadName() }}
                                                </a>
                                                @else
                                                {{ $university->getHeadName() }}
                                                @endif
                                            </td>
                                            <td>{{ count($university->departments) }}</td>
                                            <td>
                                                <a href="{{ route('admin.university.view', $university->id) }}">
                                                    <button class="btn btn-info btn-xs btn-flat">
                                                        <i class="fas fa-eye"></i>
                                                        View
                                                    </button>
                                                </a>
                                                <a href="{{ route('admin.university.edit', $university->id) }}">
                                                    <button class="btn btn-primary btn-xs btn-flat">
                                                        <i class="fas fa-edit"></i>
                                                        Edit
                                                    </button>
                                                </a>
                                                <a href="{{ route('admin.university.delete', $university->id) }}" onclick="if(confirm('Are you sure, you want to delete {{ $university->name }}?') == false){event.preventDefault()}">
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
