@extends('pages.faculty.inc.app')

@section('header')
    @include('layout.header', ['title' => 'Faculty | Evaluation | View'])
@endsection

@section('content-header')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Evaluation List</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">Home</li>
                        <li class="breadcrumb-item">Evaluation</li>
                        <li class="breadcrumb-item active"><a href="{{ route('faculty.evaluation.list') }}">List</a></li>
                        <li class="breadcrumb-item active">View</li>
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
                        <div class="card-header ui-sortable-handle" style="cursor: move;">
                            <h3 class="card-title">{{ __('Evaluation Detail') }}</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i
                                        class="fas fa-minus"></i>
                                </button>
                            </div>
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
                            <div class="row">
                                <div class="col-md-1"></div>
                                <div class="col-md-9">
                                    <dl class="row">
                                        <dt class="col-sm-3">{{ __('Evaluation Id') }}:</dt>
                                        <dd class="col-sm-9">{{ $evaluation->id }}</dd>
                                        <dt class="col-sm-3">{{ __('Evaluation Title') }}:</dt>
                                        <dd class="col-sm-9">{{ $evaluation->upper_title }}</dd>

                                        <dt class="col-sm-3">{{ __('Evaluation Status') }}:</dt>
                                        <dd
                                            class="col-sm-9 {{ $evaluation->status == '1' ? 'text-success' : 'text-danger' }}">
                                            {{ $evaluation->str_status }}</dd>
                                        <dt class="col-sm-3">{{ __('Description') }}:</dt>
                                        <dd class="col-sm-9">{{ $evaluation->description ?: '-' }}</dd>
                                        <dt class="col-sm-3">{{ __('Register Date') }}:</dt>
                                        <dd class="col-sm-9">
                                            {{ $evaluation->created_detail }}
                                        </dd>
                                        <dt class="col-sm-3">{{ __('Last Update') }}:</dt>
                                        <dd class="col-sm-9">
                                            {{ $evaluation->updated_detail }}
                                        </dd>
                                    </dl>
                                </div>
                                <div class="col-md-2">
                                    <button type="button" class="btn btn-success" data-toggle="modal"
                                        data-target="#modal-update-status">{{ __('Update Status') }}</button>
                                </div>
                            </div>


                        </div>
                    </div>

                    <div class="card card-default collapsed-card">
                        <div class="card-header ui-sortable-handle" style="cursor: move;">
                            <h3 class="card-title">{{ __('Evaluation Preview') }}</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i
                                        class="fas fa-plus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="row">
                                    <div class="col-2"></div>
                                    <div id="renderForm" class="col-8"></div>
                                    <div class="col-2"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card card-default collapsed-card">
                        <div class="card-header ui-sortable-handle" style="cursor: move;">
                            <h3 class="card-title">{{ __('Eligible Students') }}</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i
                                        class="fas fa-plus"></i>
                                </button>
                            </div>
                            <div class="card-tools">

                            </div>
                        </div>
                        <div class="card-body">
                            <table id="dataTable" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Full Name</th>
                                        <th>Department</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($applications as $application )
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $application->user->getName() }}</td>
                                    <td>{{ $application->user->fdepartment->name }}</td>
                                    @endforeach
                                </tbody>
                            </table>
                            <a href="{{ route('faculty.evaluation.send', $evaluation)  }}">
                                <div class="col-md-2">
                                    <button type="button" class="btn btn-success" data-toggle="modal"
                                        data-target="   ">{{ __('Send Evaluation') }}</button>
                                </div>
                            </a>

                        </div>
                    </div>
                </div>
                <!-- /.container-fluid -->
    </section>
    <!-- Modal -->
    <div class="modal fade" id="modal-update-status">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">{{ __('Update Status') }}</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="POST" action="{{ route('faculty.evaluation.update.status', $evaluation->id) }}">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-2"></div>
                            <div class="col-8">
                                <div class="form-group">
                                    <label>{{ __('Status') }}</label>
                                    <select class="form-control" name="status">
                                        <option {{ !($evaluation->status == '1') ?: 'selected' }} value="1">
                                            {{ __('active') }}</option>
                                        <option {{ !($evaluation->status == '0') ?: 'selected' }} value="0">
                                            {{ __('inactive') }}</option>
                                    </select>
                                    @error('status')
                                        <span class="text-danger" role="alert">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary float-right">{{ __('Update') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script src="{{ asset('assets/form-builder/form-render.min.js') }}"></script>
    <script>
        let form_render;
        $(function() {
            const wrap = $("#renderForm");
            form_render = wrap.formRender();
            renderForm(wrap, `{!! $evaluation->body !!}`)
        });

        function renderForm(wrap, json) {
            wrap.formRender({
                formData: json,
                dataType: 'json'
            })
        }
    </script>
@endpush
