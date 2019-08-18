@extends('layouts.app')

@section('content')
    <company-page :api-list=@json($apiList)></company-page>
@endsection
