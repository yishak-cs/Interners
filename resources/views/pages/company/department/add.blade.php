@extends('pages.company.inc.app')

@section('header')
    @include('layout.header', ['title' => 'Company | Department | Add'])
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
                    <form method="POST" action="{{ route('company.department.store') }}">
                        @csrf
                        <div class="card card-default">
                            <div class="card-header">
                                <h3 class="card-title">Department Information</h3>
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
                                <div class="bs-stepper linear">
                                    <div class="bs-stepper-header" role="tablist">
                                        <!-- your steps here -->
                                        <div class="step active" data-target="#first-step">
                                            <button type="button" class="step-trigger" role="tab"
                                                aria-controls="first-step" id="first-step-trigger" aria-selected="true">
                                                <span class="bs-stepper-circle">1</span>
                                                <span class="bs-stepper-label">Add The Department Head</span>
                                            </button>
                                        </div>
                                        <div class="line"></div>
                                        <div class="step" data-target="#second-step">
                                            <button type="button" class="step-trigger" role="tab"
                                                aria-controls="second-step" id="second-step-trigger" aria-selected="false"
                                                disabled="disabled">
                                                <span class="bs-stepper-circle">2</span>
                                                <span class="bs-stepper-label">Department Detail</span>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="bs-stepper-content">
                                        <!-- your steps content here -->
                                        <div id="first-step" class="content active dstepper-block" role="tabpanel"
                                            aria-labelledby="first-step-trigger">
                                            <div class="row">
                                                <div class="col-md-1"></div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label>First Name</label> <i
                                                            class="text-danger font-weight-bold">*</i>
                                                        <input id="first_name" placeholder="Enter First Name" type="text"
                                                            class="form-control @error('first_name') is-invalid @enderror"
                                                            name="first_name" value="{{ old('first_name') }}" required
                                                            autocomplete="first_name">
                                                        @error('first_name')
                                                            <span class="text-danger" role="alert">
                                                                {{ $message }}
                                                            </span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label>Middle Name</label> <i
                                                            class="text-danger font-weight-bold">*</i>
                                                        <input id="middle_name" placeholder="Enter Middle Name"
                                                            type="text"
                                                            class="form-control @error('middle_name') is-invalid @enderror"
                                                            name="middle_name" value="{{ old('middle_name') }}" required
                                                            autocomplete="middle_name">
                                                        @error('middle_name')
                                                            <span class="text-danger" role="alert">
                                                                {{ $message }}
                                                            </span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <input hidden name="staff_type" value="2">
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label>Last Name</label>
                                                        <input id="last_name" placeholder="Enter Last Name" type="text"
                                                            class="form-control @error('last_name') is-invalid @enderror"
                                                            name="last_name" value="{{ old('last_name') }}"
                                                            autocomplete="last_name">
                                                        @error('last_name')
                                                            <span class="text-danger" role="alert">
                                                                {{ $message }}
                                                            </span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-2"></div>
                                                <div class="col-md-3"></div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>Email</label> <i class="text-danger font-weight-bold">*</i>
                                                        <input id="email" placeholder="Enter Email" type="email"
                                                            class="form-control @error('email') is-invalid @enderror"
                                                            name="email" value="{{ old('email') }}" required
                                                            autocomplete="email">
                                                        @error('email')
                                                            <span class="text-danger" role="alert">
                                                                {{ $message }}
                                                            </span>
                                                        @enderror
                                                    </div>

                                                    <div class="form-group">
                                                        <label>Password</label> <i
                                                            class="text-danger font-weight-bold">*</i>
                                                        <input id="password" placeholder="Enter Password"
                                                            type="password"
                                                            class="form-control @error('password') is-invalid @enderror"
                                                            name="password" value="{{ old('password') }}" required
                                                            autocomplete="password">
                                                        @error('password')
                                                            <span class="text-danger" role="alert">
                                                                {{ $message }}
                                                            </span>
                                                        @enderror
                                                    </div>

                                                    <div class="form-group">
                                                        <label>Confirm Password</label> <i
                                                            class="text-danger font-weight-bold">*</i>
                                                        <input id="password_confirmation" placeholder="Confirm Password"
                                                            type="password"
                                                            class="form-control @error('password_confirmation') is-invalid @enderror"
                                                            name="password_confirmation"
                                                            value="{{ old('password_confirmation') }}" required
                                                            autocomplete="password_confirmation">
                                                        @error('password_confirmation')
                                                            <span class="text-danger" role="alert">
                                                                {{ $message }}
                                                            </span>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="second-step" class="content" role="tabpanel"
                                            aria-labelledby="second-step-trigger">
                                            <div class="row">
                                                <div class="col-md-3"></div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Company</label> :
                                                        <span>{{ Auth::user()->company->name }}</span>
                                                        <input hidden value="{{ Auth::user()->company->id }}"
                                                            name="company_id" id="company_id" />
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Department Name</label> <i
                                                            class="text-danger font-weight-bold">*</i>
                                                        <input id="name" placeholder="Enter Department Name"
                                                            type="text"
                                                            class="form-control @error('name') is-invalid @enderror"
                                                            name="name" value="{{ old('name') }}" required
                                                            autocomplete="name">
                                                        @error('name')
                                                            <span class="text-danger" role="alert">
                                                                {{ $message }}
                                                            </span>
                                                        @enderror
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Description</label>
                                                        <textarea name="description" id="description" class="form-control @error('description') is-invalid @enderror">{{ old('description') }}</textarea>
                                                        @error('description')
                                                            <span class="text-danger" role="alert">
                                                                {{ $message }}
                                                            </span>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer ">
                                <p class=" float-left"><i class="text-danger font-weight-bold">*</i> are
                                    required fields</p>
                                <button type="button" class="btn btn-primary float-right nextBtn"
                                    onclick="nextHandler()"> Next <i class="fas fa-arrow-right ml-1"></i> </button>
                                <button type="submit" hidden
                                    class="btn btn-success float-right ml-2 submitBtn">Register</button>
                                <button type="button" class="btn btn-primary float-right prevBtn" hidden
                                    onclick="previousHandler()"> <i class="fas fa-arrow-left mr-1"></i>Previous</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            window.stepper = new Stepper(document.querySelector('.bs-stepper'));
        })
        nextHandler = () => {
            stepper.next();
            $('.prevBtn').removeAttr('hidden');
            if (stepper._currentIndex == (stepper._steps.length - 1)) {
                $('.submitBtn').removeAttr('hidden');
                $('.nextBtn').attr('hidden', true);
            }
        }

        previousHandler = () => {
            stepper.previous();
            $('.nextBtn').removeAttr('hidden');
            $('.submitBtn').attr('hidden', true);
            if (stepper._currentIndex == 0) {
                $('.prevBtn').attr('hidden', true);
            }
        }
    </script>
@endsection
