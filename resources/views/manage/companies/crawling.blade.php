@extends('layouts.admin')
@section('title', __('Manage Crawling Data'))

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                @include('components.alert-success')
                <div class="toolbar mb-3 clearfix">
                    <div class="float-lg-left">
                        <h1>{{ __('Manage Crawling Data') }}</h1>
                    </div>
                </div> <!-- End .toolbar -->
                <company-crawling></company-crawling>
            </div>
        </div>
    </div>
@endsection
