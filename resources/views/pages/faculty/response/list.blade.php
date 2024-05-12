@extends('pages.faculty.inc.app')

@section('header')
    @include('layout.header', ['title' => 'Faculty | Evaluation Response | List'])
@endsection

@section('content-header')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">{{ __('Evaluation Response List') }}</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">{{ __('Home') }}</li>
                        <li class="breadcrumb-item">{{ __('Evaluation Response') }}</li>
                        <li class="breadcrumb-item active">{{ __('List') }}</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div>
    </div>
@endsection

@section('content')
    <section>
        <div class="container-fluid">

            <div class="card-default">
                <div class="card-header">
                    <h3 class="card-title">Response List</h3>
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


                    <div id="accordion">
                        <div class="card card-info">
                            <div class="card-header">
                                <h4 class="card-title w-100">
                                    <a class="w-20 @if (!$filter) collapsed @endif"
                                        data-toggle="collapse" href="#collapseOne" aria-expanded="false">
                                        <i class="fas fa-filter"></i>
                                        {{ __('Filter') }} @if ($filter)
                                            <span class="badge badge-success">{{ __('activated') }}</span>
                                        @endif
                                    </a>
                                    @if ($filter)
                                        <a href="{{ route('faculty.response.list') }}"
                                            class="btn btn-warning btn-xs float-right">
                                            {{ __('Reset') }}
                                        </a>
                                    @endif
                                </h4>
                            </div>
                            <div id="collapseOne" class="collapse @if ($filter) show @endif"
                                data-parent="#accordion" style="">
                                <div class="card-body">
                                    <form method="GET" action="{{ route('faculty.response.list') }}">
                                        <div class="row">
                                            <div class="col-3">
                                                {{-- filter by department --}}
                                                <div class="form-group">
                                                    <label>{{ __('Department') }}:</label>
                                                    <select class="form-control select2bs4" name="fdepartment_id">
                                                        <option value="">-- {{ __('Select Department') }} --</option>
                                                        @foreach ($departments as $department)
                                                            <option value="{{ $department->id }}"
                                                                @if (isset($filter['fdepartment_id']) && $filter['fdepartment_id'] == $department->id) selected @endif>
                                                                {{ $department->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            {{-- end --}}
                                            {{-- filter by evaluation form --}}
                                            <div class="col-3">
                                                <div class="form-group">
                                                    <label>{{ __('Evaluation') }}:</label>
                                                    <select class="form-control select2bs4" name="evaluation_id">
                                                        <option value="">-- {{ __('Select Evaluation') }} --</option>
                                                        @foreach ($evaluations as $evaluation)
                                                            <option value="{{ $evaluation->id }}"
                                                                @if (isset($filter['evaluation_id']) && $filter['evaluation_id'] == $evaluation->id) selected @endif>
                                                                {{ $evaluation->upper_title }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            {{-- end --}}
                                            <div class="col-3">
                                                <button type="submit" class="btn btn-flat btn-info"
                                                    style="margin-top: 2rem;">
                                                    <i class="fas fa-filter"></i>
                                                    {{ __('Filter') }}
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <table class="table table-bordered table-striped dataTable">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>{{ __('Department') }}</th>
                                <th>{{ __('Student') }}</th>
                                <th>{{ __('Company') }}</th>
                                <th>{{ __('Evaluation') }}</th>
                                <th>{{ __('Action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($responses as $response)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $response->evaluated->fdepartment->name }}</td>
                                    <td>{{ $response->evaluated->getName() }}</td>
                                    <td>{{ $response->company->name }}</td>
                                    <td>{{ $response->evaluation->upper_title }}</td>
                                    <td>
                                        <a href="{{ route('faculty.response.view', $response) }}">
                                            <button class="btn btn-info btn-xs btn-flat">
                                                <i class="fas fa-eye"></i>
                                                {{ __('View') }}
                                            </button>
                                        </a>
                                        <a href="{{ route('faculty.response.delete', $response) }}"
                                            onclick="if(confirm('Are you sure, you want to delete this Response? All related data will also be deleted!') == false){event.preventDefault()}">
                                            <button class="btn btn-danger btn-xs btn-flat">
                                                <i class="fas fa-trash"></i>
                                                {{ __('Delete') }}
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
    </section>
@endsection
