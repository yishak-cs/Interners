@extends('pages.faculty.inc.app')

@section('header')
    @include('layout.header', ['title' => 'Faculty | Evaluation Response | Detail'])
@endsection

@section('content-header')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">{{ __('Evaluation Response Detail') }}</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">{{ __('Home') }}</li>
                        <li class="breadcrumb-item">{{ __('Evaluation Response') }}</li>
                        <li class="breadcrumb-item"><a href="{{ route('faculty.response.list') }}">{{ __('List') }}</a>
                        </li>
                        <li class="breadcrumb-item active">{{ $response->evaluation->title }}</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div>
    </div>
@endsection

@section('content')
    <section class="content">
        <div class="container-fluid">

            <div class="card card-default collapsed-card">
                <div class="card-header">
                    <h3 class="card-title">{{ __('Response Detail') }}</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-plus"></i>
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
                        <div class="col-2"></div>
                        <div class="col-8">
                            <dl class="row">
                                <dt class="col-sm-3">{{ __('Student') }}:</dt>
                                <dd class="col-sm-9">{{ $response->evaluated->getName() }}</dd>
                                <dt class="col-sm-3">{{ __('Company') }}:</dt>
                                <dd class="col-sm-9">{{ $response->company->name }}</dd>
                                <dt class="col-sm-3">{{ __('Date') }}:</dt>
                                <dd class="col-sm-9">{{ $response->created_detail }}</dd>
                            </dl>
                        </div>
                        <div class="col-2"></div>
                    </div>

                </div>
            </div>

            <div class="card card-default">
                <div class="card-header">
                    <h3 class="card-title">{{ __('Response Preview') }}</h3>
                    <div class="card-tools mr-5">
                        <a href="{{ url()->previous() }}"><button type="button" class="btn btn-tool"><i
                                    class="fas fa-arrow-left"></i>
                                {{ __("Back") }}
                            </button></a>
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
        </div>
    </section>
@endsection

@push('scripts')
    <script src="{{ asset('assets/form-builder/form-render.min.js') }}"></script>
    <script>
        let form_render;
        $(function() {
            const wrap = $("#renderForm");
            form_render = wrap.formRender();
            renderForm(wrap, `{!! $response->body_preview !!}`)

            // setting all to readonly
            $(':radio:not(:checked)').attr('disabled', true);
            $(':checkbox:not(:checked)').attr('disabled', true);
            $('textarea, select').prop('disabled', true);
            $('input').prop('readonly', true);
        });

        function renderForm(wrap, json) {
            wrap.formRender({
                formData: json,
                dataType: 'json'
            })
        }
    </script>
@endpush
