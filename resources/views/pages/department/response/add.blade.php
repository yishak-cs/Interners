@extends('pages.department.response.inc.app')

@section('title')
    @include('layout.header', ['title' => 'Evaluation Response'])
@endsection

@section('content')
    <div class="row mt-5">
        <div class="col-lg-2"></div>
        <div class="col-lg-8">
           

            <div class="card card-default collapsed-card">
                <div class="card-header ui-sortable-handle" style="cursor: move;">
                    <h3 class="card-title">{{ $internName." "."evaluation" }}</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-plus"></i>
                        </button>
                    </div>
                    <div class="card-tools">

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

                    <dl class="row">
                        <dt class="col-sm-3">{{ __('Evaluation Title') }}:</dt>
                        <dd class="col-sm-9">{{ $evaluation->title }}</dd>
                        <dt class="col-sm-3">{{ __('Intern') }}:</dt>
                        <dd class="col-sm-9">{{ $internName }}</dd>
                        <dt class="col-sm-3">{{ __('University') }}:</dt>
                        <dd class="col-sm-9">{{ $university }}</dd>
                        <dt class="col-sm-3">{{ __('Faculty') }}:</dt>
                        <dd class="col-sm-9">{{ $departmentName }}</dd>
                    </dl>
                </div>
            </div>

            <form method="POST" action="{{ route('response.store') }}" id="myForm">
                @csrf
                <input type="hidden" name="intern_id" value="{{ $userApplication->user->id }}">
                <input type="hidden" name="evaluation_id" value="{{ $evaluation->id }}">
                <input type="hidden" name="company_id" value="{{ auth()->user()->department->company->id }}">
                <div class="card-body">
                    <div class="row">
                        <div class="row">
                            <div class="col-2"></div>
                            <div id="renderForm" class="col-8"></div>
                            <input type="text" name="body_preview" id="bodyPreview" hidden>
                            <div class="col-2"></div>
                        </div>
                    </div>
                </div>

                <div class="card-footer">
                    <button type="submit" class="btn btn-primary" id="btnSubmit">{{ __('Submit') }}</button>
                </div>
            </form>
        </div>
    </div>
    <div class="col-lg-2"></div>
    </div>
@endsection

@push('script')
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

    $("#btnSubmit").on('click', function (e) {
            var x = JSON.stringify($("#renderForm").formRender('userData'));
            $("#bodyPreview").val(x);
            // $(':radio:not(:checked)').attr('disabled', true);
        });
</script>
@endpush
