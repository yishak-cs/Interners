@extends('pages.faculty.inc.app')

@section('header')
    @include('layout.header', ['title' => 'Faculty | Evaluation | Add'])
@endsection

@section('content-header')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Add Evaluation</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">Home</li>
                        <li class="breadcrumb-item">Evaluation</li>
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
                    <form method="POST" action="{{ route('faculty.evaluation.store') }}" id="myFormBuilder">
                        @csrf
                        <div class="card card-default">
                            <div class="card-header">
                                <h3 class="card-title">Evaluation Information</h3>
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
                                        {{ $success }}
                                    </div>
                                @endif
                                <div class="bs-stepper linear">
                                    <div class="bs-stepper-header" role="tablist">
                                        <!-- your steps here -->
                                        <div class="step active" data-target="#first-step">
                                            <button type="button" class="step-trigger" role="tab"
                                                aria-controls="first-step" id="first-step-trigger" aria-selected="true">
                                                <span class="bs-stepper-circle">1</span>
                                                <span class="bs-stepper-label">Create Evaluation Template</span>
                                            </button>
                                        </div>
                                        <div class="line"></div>
                                        <div class="step" data-target="#second-step">
                                            <button type="button" class="step-trigger" role="tab"
                                                aria-controls="second-step" id="second-step-trigger" aria-selected="false"
                                                disabled="disabled">
                                                <span class="bs-stepper-circle">2</span>
                                                <span class="bs-stepper-label">Evaluation Detail</span>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="bs-stepper-content">
                                        <!-- your steps content here -->
                                        <div id="first-step" class="content active dstepper-block" role="tabpanel"
                                            aria-labelledby="first-step-trigger">
                                            <div class="row">
                                                <input name="department_id" type="text"
                                                    value="{{ auth()->user()->department->id }}" hidden>
                                                <div class="col-12">
                                                    <label>{{ __('Form Body') }}</label> <i
                                                        class="text-danger font-weight-bold">*</i>
                                                    <div id="formBuilder"></div>
                                                    <span class="text-danger" role="alert" id="errorBody"></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="second-step" class="content" role="tabpanel"
                                            aria-labelledby="second-step-trigger">

                                            <div class="row">
                                                <div class="col-md-3"></div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>{{ __('Title') }}</label> <i
                                                            class="text-danger font-weight-bold">*</i>
                                                        <input name="title" id="evaluationTitle"
                                                            value="{{ old('title') }}"
                                                            class="form-control @error('title') is-invalid @enderror">
                                                        @error('title')
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
                                                    <div class="form-group">
                                                        <label>{{ __('Status') }}</label> <i
                                                            class="text-danger font-weight-bold">*</i>
                                                        <div class="form-group form-inline"
                                                            style="display: flex!important;">
                                                            <div class="form-check">
                                                                <input class="form-check-input"
                                                                    {{ !(old('status') == '1') ?: 'checked' }}
                                                                    value="1" id="r1" type="radio"
                                                                    name="status">
                                                                <label class="form-check-label"
                                                                    for="r1">Active</label>
                                                            </div>
                                                            <div class="form-check ml-3">
                                                                <input class="form-check-input"
                                                                    {{ !(old('status') == '0') ?: 'checked' }}
                                                                    id="r2" value="0" type="radio"
                                                                    name="status">
                                                                <label class="form-check-label"
                                                                    for="r2">Inactive</label>
                                                            </div>
                                                        </div>
                                                        @error('status')
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
                                <!-- /.card-body -->
                                <div class="card-footer ">
                                    <p class=" float-left"><i class="text-danger font-weight-bold">*</i> are
                                        required fields</p>
                                    <button type="button" class="btn btn-primary float-right nextBtn"
                                        onclick="nextHandler()">
                                        Next
                                        <i class="fas fa-arrow-right ml-1"></i> </button>
                                    <button type="submit" hidden
                                        class="btn btn-success float-right ml-2 submitBtn">Submit</button>
                                    <button type="button" class="btn btn-primary float-right prevBtn" hidden
                                        onclick="previousHandler()"> <i
                                            class="fas fa-arrow-left mr-1"></i>Previous</button>
                                </div>
                            </div>
                    </form>
                </div>
            </div>
        </div>

        </div>
    </section>
@endsection
@push('scripts')
    <script src="{{ asset('assets/bs-stepper/js/bs-stepper.min.js') }}"></script>
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
    <script src="{{ asset('assets/form-builder/form-builder.min.js') }}"></script>
    <script>
        let form_builder = {};

        $(function() {
            let builder_option = {
                disableFields: [
                    'autocomplete',
                    'button',
                    'date',
                    'file',
                    'hidden',
                    'number',
                    'starRating'
                ],
                editOnAdd: true,
                controlOrder: [
                    'header',
                    'paragraph',
                    'text',
                    'textarea',
                    'checkbox-group',
                    'radio-group',
                    'select',
                ],
                disabledActionButtons: ['data', 'save']
            };

            // initialize form builder
            form_builder = $("#formBuilder").formBuilder(builder_option);
            $("#myFormBuilder").submit(function(e) {
                e.preventDefault(); // Prevent the default form submission

                // spin
                let btn = $(`#myFormBuilder :input[type="submit"]`);
                btn.attr('disabled', true);
                btn.html('Loading...');

                // get elements
                let etitle = $("#errorTitle");
                let entitle = $(`input[name="title"]`);
                let ebody = $("#errorBody");
                let emess = $("#errorMessage");
                let smess = $("#successMessage");

                // clear errors
                etitle.html('');
                ebody.html('');
                entitle.removeClass('is-invalid');
                emess.addClass('d-none');
                emess.html('');
                smess.addClass('d-none');
                smess.html('');

                // get data
                let title = $(`#myFormBuilder :input[name="title"]`).val();
                let _token = $(`#myFormBuilder :input[name="_token"]`).val();
                let department_id = $(`#myFormBuilder :input[name="department_id"]`).val();
                let body = form_builder.actions.getData('json');
                let description = $(`#description`).val();;
                let status = $(`#myFormBuilder :input[name="status"]:checked`).val();

                // validation
                if (title === undefined || title === "") {
                    btn.html(`{{ __('Enter Title') }}`);
                    btn.attr('disabled', false);
                    etitle.html('Template Title is required!');
                    entitle.addClass('is-invalid');
                    return false;
                }
                if (body === undefined || body === "[]") {
                    btn.html(`{{ __('Create Template') }}`);
                    btn.attr('disabled', false);
                    ebody.html('Template Body is required!');
                    return false;
                }
                // organize data
                let values = {
                    title,
                    _token,
                    body,
                    department_id,
                    description,
                    status
                };

                let url = `{{ route('faculty.evaluation.add') }}`

                // Send the data via AJAX
                $.post(`${url}`, values).then((response) => {
                    btn.html(`{{ __('Submit') }}`);
                    btn.attr('disabled', false);
                    $(`#myFormBuilder :input[name="title"]`).val('');
                    form_builder.actions.clearFields();
                    smess.removeClass('d-none');
                    smess.html(`<i class="icon fas fa-check"></i> ${response[0].message}`);
                    $(`#description`).val('');
                }).catch((error) => {
                    btn.html(`{{ __('Submit') }}`);
                    btn.attr('disabled', false);
                    emess.removeClass('d-none');
                    emess.html(`<i class="icon fas fa-ban"></i> ${error.responseJSON.message}`);
                });
            });
        });
    </script>
@endpush
