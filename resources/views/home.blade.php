@extends('layouts.app')

@section('title', 'Review Công ty - Review lương bổng, đãi ngộ, HR, sếp và công việc,... gì cũng có')
@section('description', 'Review Công ty - Review lương bổng, đãi ngộ, HR, sếp và công việc,... gì cũng có')

@section('content')
    <home-page :api-list=@json($apiList)></home-page>
@endsection
