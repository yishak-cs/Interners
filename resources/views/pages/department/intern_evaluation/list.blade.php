@extends('pages.department.inc.app')

@section('header')
    @include('layout.header', ['title' => 'Department | Intern Evaluation'])
@endsection

@section('content-header')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Intern Evaluation</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">Home</li>
                        <li class="breadcrumb-item">Intern Evaluation</li>
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
                            <h3 class="card-title">Intern Evaluation List</h3>
                        </div>
                        <div class="card-body">
                            @if (session('error'))
                                <div class="alert alert-danger alert-dismissible" role="alert">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                    <i class="icon fas fa-ban"></i>
                                    {{ session('error') }}
                                </div>
                            @endif
                            @if (session('success'))
                                <div class="alert alert-success alert-dismissible" role="alert">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                    <i class="icon fas fa-check"></i>
                                    {!! session('success') !!}
                                </div>
                            @endif
                            <table id="dataTable" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Full Name</th>
                                        <th>Internship</th>
                                        <th>Evaluation Forms</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($userApplications as $userApplication)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ ucwords($userApplication->user->getName()) }}</td>
                                            <td><a
                                                    href="{{ route('department.internship.view', $userApplication->internship->id) }}">{{ $userApplication->internship->title }}</a>
                                            </td>
                                            <td>
                                                <select name="evaluation_form" id="evaluation-dropdown"
                                                    class="form-control select2" autofocus required>
                                                    @foreach ($userApplication->evaluations as $evaluation)
                                                        <option value="{{ $evaluation->id }}">{{ $evaluation->title }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </td>

                                            <td>
                                                {{--  --}}
                                                <a href="{{ route('department.form.show', [
                                                    'type' => base64_encode(\App\Http\Controllers\Controller::INTERN_EVALUATION),
                                                    'userApplication' => $userApplication,
                                                    'evaluation_form' => '',
                                                ]) }}"
                                                    id="evaluation-form-link" target="_blank">
                                                    <button class="btn btn-success btn-xs btn-flat">
                                                        <i class="fas fa-share"></i>
                                                        {{ __('Evaluate') }}
                                                    </button>
                                                </a>
                                                {{--  --}}
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
@push('scripts')
    <script>
        document.getElementById('evaluation-dropdown').addEventListener('change', function() {
            var selectedEvaluationId = this.value; 

            var originalLink = document.getElementById('evaluation-form-link').getAttribute('href');
            var newLink = originalLink.replace(/evaluation_form=[^&]*/, 'evaluation_form=' + selectedEvaluationId);

            document.getElementById('evaluation-form-link').setAttribute('href', newLink);
        });
    </script>
@endpush
