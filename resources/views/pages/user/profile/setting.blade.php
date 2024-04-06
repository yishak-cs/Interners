@extends('pages.user.inc.app')

@section('header')
    @include('layout.header', ['title' => 'User | Account | Settings'])
    <!-- Include jQuery from a CDN in the head tag of your HTML -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
@endsection
@section('content-header')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Profile</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">Home</li>
                        <li class="breadcrumb-item">Profile</li>
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
                    <div class="card">
                        <div class="card-body">
                            <div class="tab-content">
                                <form method="POST" action="{{ route('user.profile.setting', Auth::user()->id) }}">
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
                                        @csrf
                                        <input type="hidden" value="{{ Auth::user()->id }}" name="user_id" />
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>First Name</label> <i class="text-danger font-weight-bold">*</i>
                                                <input id="first_name" placeholder="Enter First Name" type="text"
                                                    class="form-control @error('first_name') is-invalid @enderror"
                                                    name="first_name"
                                                    value="{{ Auth::user()->information && Auth::user()->information->first_name ? Auth::user()->information->first_name : '' }}"
                                                    required autocomplete="first_name">
                                                @error('first_name')
                                                    <span class="text-danger" role="alert">
                                                        {{ $message }}
                                                    </span>
                                                @enderror
                                            </div>

                                            <div class="form-group">
                                                <label>Student ID</label> <i class="text-danger font-weight-bold">*</i>
                                                <input id="student_id" placeholder="Enter ID" type="text"
                                                    class="form-control @error('student_id') is-invalid @enderror"
                                                    name="student_id"
                                                    value="{{ Auth::user()->information && Auth::user()->information->student_id ? Auth::user()->information->student_id : '' }}"
                                                    required autocomplete="student_id">
                                                @error('student_id')
                                                    <span class="text-danger" role="alert">
                                                        {{ $message }}
                                                    </span>
                                                @enderror
                                            </div>

                                            <div class="form-group">
                                                <label>Phone</label>
                                                <input id="phone_number" placeholder="Enter Phone" type="text"
                                                    class="form-control @error('phone_number') is-invalid @enderror"
                                                    name="phone_number"
                                                    value="{{ Auth::user()->information && Auth::user()->information->phone_number ? Auth::user()->information->phone_number : '' }}"
                                                    autocomplete="phone_number">
                                                @error('phone_number')
                                                    <span class="text-danger" role="alert">
                                                        {{ $message }}
                                                    </span>
                                                @enderror
                                            </div>

                                            <div class="form-group">
                                                <label>Faculty</label>
                                                <select name="department" id="department-dropdown"
                                                    class="form-control select2" required disabled>
                                                    <option value="">Select Faculty</option>
                                                </select>
                                                @error('department')
                                                    <span class="text-danger" role="alert">
                                                        {{ $message }}
                                                    </span>
                                                @enderror
                                            </div>

                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Middle Name</label> <i class="text-danger font-weight-bold">*</i>
                                                <input id="middle_name" placeholder="Enter Middle Name" type="text"
                                                    class="form-control @error('middle_name') is-invalid @enderror"
                                                    name="middle_name"
                                                    value="{{ Auth::user()->information && Auth::user()->information->middle_name ? Auth::user()->information->middle_name : '' }}"
                                                    required autocomplete="middle_name">
                                                @error('middle_name')
                                                    <span class="text-danger" role="alert">
                                                        {{ $message }}
                                                    </span>
                                                @enderror
                                            </div>

                                            <div class="form-group">
                                                <label>Comulative GPA</label> <i class="text-danger font-weight-bold">*</i>
                                                <input id="cgpa" placeholder="Enter CGPA" type="text"
                                                    class="form-control @error('cgpa') is-invalid @enderror" name="cgpa"
                                                    value="{{ Auth::user()->information && Auth::user()->information->cgpa ? Auth::user()->information->cgpa : '' }}"
                                                    required autocomplete="cgpa">
                                                @error('cgpa')
                                                    <span class="text-danger" role="alert">
                                                        {{ $message }}
                                                    </span>
                                                @enderror
                                            </div>

                                            <div class="form-group">
                                                <label>City</label>
                                                <input id="city" placeholder="Enter City" type="text"
                                                    class="form-control @error('city') is-invalid @enderror"
                                                    name="city"
                                                    value="{{ Auth::user()->information && Auth::user()->information->city ? Auth::user()->information->city : '' }}"
                                                    autocomplete="city">
                                                @error('city')
                                                    <span class="text-danger" role="alert">
                                                        {{ $message }}
                                                    </span>
                                                @enderror
                                            </div>
                                            {{-- department trial --}}
                                            <div class="form-group">
                                                <label>Department</label>
                                                <select name="faculty_department" id="FD-dropdown"
                                                    class="form-control select2" required disabled>
                                                    <option value="">Select Department</option>
                                                </select>
                                                @error('faculty_department')
                                                    <span class="text-danger" role="alert">
                                                        {{ $message }}
                                                    </span>
                                                @enderror
                                            </div>
                                            {{-- end trial --}}
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Last Name</label>
                                                <input id="last_name" placeholder="Enter Last Name" type="text"
                                                    class="form-control @error('last_name') is-invalid @enderror"
                                                    name="last_name"
                                                    value="{{ Auth::user()->information && Auth::user()->information->last_name ? Auth::user()->information->last_name : '' }}"
                                                    autocomplete="last_name">
                                                @error('last_name')
                                                    <span class="text-danger" role="alert">
                                                        {{ $message }}
                                                    </span>
                                                @enderror
                                            </div>

                                            <div class="form-group">
                                                <label>Year of study</label>
                                                <input id="year_of_study" placeholder="Enter Year" type="text"
                                                    class="form-control @error('year_of_study') is-invalid @enderror"
                                                    name="year_of_study"
                                                    value="{{ Auth::user()->information && Auth::user()->information->year_of_study ? Auth::user()->information->year_of_study : '' }}"
                                                    autocomplete="year_of_study">
                                                @error('year_of_study')
                                                    <span class="text-danger" role="alert">
                                                        {{ $message }}
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <label>University</label>
                                                <select name="university" id="university-dropdown"
                                                    class="form-control @error('degree') is-invalid @enderror select2"
                                                    autofocus required>
                                                    <option>None</option>
                                                    @foreach ($universities as $university)
                                                        <option value="{{ $university->id }}">{{ $university->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('degree')
                                                    <span class="text-danger" role="alert">
                                                        {{ $message }}
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-7">
                                            <div class="form-group">
                                                <label>About Me</label>
                                                <textarea id="about_me" type="text" class="form-control @error('about_me') is-invalid @enderror" name="about_me"
                                                    autocomplete="about_me" placeholder="Type semthing about you...">{{ Auth::user()->information && Auth::user()->information->about_me ? Auth::user()->information->about_me : '' }}</textarea>
                                            </div>
                                        </div>

                                        <hr>

                                        <div class="col-md-12">
                                            <p class=" float-left"><i class="text-danger font-weight-bold">*</i> are
                                                required fields</p>
                                            <button class="btn btn-primary float-right">Update</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
@endsection

@push('scripts')
    <!-- JavaScript to handle university dropdown change -->
    <script>
        $(document).ready(function() {
            // Function to load departments based on the selected university
            function loadDepartments(universityId) {
                if (universityId) {
                    $.ajax({
                        url: '/user/profile/get-departments/' + universityId,
                        type: 'GET',
                        success: function(departments) {
                            $('#department-dropdown').empty().removeAttr('disabled');
                            $('#FD-dropdown').append('<option value="">Select Faculty</option>');
                            $.each(departments, function(key, value) {
                                $('#department-dropdown').append('<option value="' +
                                    key + '">' + value + '</option>');
                            });
                        },
                        error: function(xhr, status, error) {
                            console.error('AJAX Error:', status, error);
                        }
                    });
                } else {
                    $('#department-dropdown').empty().attr('disabled', 'disabled');
                }
            }

            // Trigger change event on university dropdown if it has a value
            var selectedUniversity = $('#university-dropdown').val();
            if (selectedUniversity) {
                loadDepartments(selectedUniversity);
            }

            // Bind change event to university dropdown
            $('#university-dropdown').change(function() {
                var universityId = $(this).val();
                loadDepartments(universityId);
            });
        });
    </script>


    <script>
        $(window).on('load', function() {
            // Function to load faculty departments based on the selected faculty
            function loadFacultyDepartments(facultyId) {
                if (facultyId) {
                    $.ajax({
                        url: '/user/profile/get-facultydepartments/' + facultyId,
                        type: 'GET',
                        success: function(departments) {
                            $('#FD-dropdown').empty().removeAttr('disabled');

                            $.each(departments, function(key, value) {
                                $('#FD-dropdown').append('<option value="' + key + '">' +
                                    value + '</option>');
                            });
                        },
                        error: function(xhr, status, error) {
                            console.error('AJAX Error:', status, error);
                        }
                    });
                } else {
                    $('#FD-dropdown').empty().attr('disabled', 'disabled');
                }
            }

            // Trigger change event on department dropdown if it has a value
            var selectedFaculty = $('#department-dropdown').val();
            if (selectedFaculty) {
                loadFacultyDepartments(selectedFaculty);
            }

            /*
                    
               var selectedFaculty = $('#department-dropdown').val();
                if (selectedFaculty) {
                    $('#department-dropdown').trigger('change');
                }
               });
            
            */

            // Bind change event to department dropdown
            $('#department-dropdown').change(function() {
                var facultyId = $(this).val();
                loadFacultyDepartments(facultyId);
            });
        });
    </script>
@endpush
