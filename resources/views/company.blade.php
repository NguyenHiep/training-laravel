@extends('layouts.app')

@section('title', 'Review môi trường làm việc công ty ' . ucfirst($company->name))
@section('description', 'Review mức lương, qui trình phỏng vấn, môi trường làm việc, tuyển dụng, sếp và công việc tại ' . ucfirst($company->name))

@section('content')
    <company-page :api-list=@json($apiList)></company-page>
@endsection
