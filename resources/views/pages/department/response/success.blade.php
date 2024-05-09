@extends('pages.response.inc.app')

@section('title')
    @include('layout.header', ['title' => 'Evaluation Response'])
@endsection

@section('content')
    <div class="row mt-5">
        <div class="col-lg-4"></div>
        <div class="col-lg-4">
            <h3 class="text-center">{{ env('APP_NAME') }}</h3>
            <div class="card card-default elevation-4">
                <div class="card-body">
                    <span class="text-success">{{ __("Thank You!") }}</span><br>
                    {{ __("Your response has been recorded, you can close this tab.") }}
                </div>
            </div>
        </div>
        <div class="col-lg-4"></div>
    </div>
@endsection

