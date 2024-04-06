@extends('pages.faculty.inc.app')

@section('header')
    @include('layout.header', ['title' => 'Faculty | Department | Add'])
@endsection

@section('content-header')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Add Department</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">Home</li>
                        <li class="breadcrumb-item">Department</li>
                        <li class="breadcrumb-item active">Add</li>
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
                            <h3 class="card-title">Department Information</h3>
                        </div>
                        <form method="POST" action="{{ route('faculty.department.store') }}">
                            @csrf
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
                                <div class="row">
                                    <div class="col-md-3"></div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Faculty</label> :
                                            <span>{{ Auth::user()->department->name }}</span>
                                            <input hidden value="{{ auth()->user()->department->id }}" name="faculty_id" id="faculty_id" />
                                        </div>
                                       
                                        <div class="form-group">
                                            <label>Department Name</label> <i class="text-danger font-weight-bold">*</i>
                                            <input id="name" placeholder="Enter Department Name" type="text"
                                                class="form-control @error('name') is-invalid @enderror" name="name"
                                                required autocomplete="name">
                                            @error('name')
                                                <span class="text-danger" role="alert">
                                                    {{ $message }}
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label>Description</label>
                                            <textarea name="description" id="description" class="form-control @error('description') is-invalid @enderror"></textarea>
                                            @error('description')
                                                <span class="text-danger" role="alert">
                                                    {{ $message }}
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="card-footer ">
                                <p class=" float-left"><i class="text-danger font-weight-bold">*</i> are
                                    required fields</p>
                                <button type="submit" class="btn btn-primary float-right">Register</button>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
        <!-- /.container-fluid -->
    </section>
@endsection
