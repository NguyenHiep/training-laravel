@extends('layouts.app')

@section('content')
    <home-page :api-list=@json($apiList)></home-page>
@endsection
