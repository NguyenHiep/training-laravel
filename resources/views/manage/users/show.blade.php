@extends('layouts.admin')
@section('title', __('Show User'))

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10 mb-3">
                <div class="toolbar clearfix">
                    <div class="float-lg-left">
                        <h1> Show User</h1>
                    </div>
                    <div class="float-lg-right">
                        <a class="btn btn-primary" href="{{ route('manage.users.index') }}"><i class="fa fa-arrow-left"></i> Quay lại</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-xs-12 col-sm-12 col-md-10">
                <div class="form-group">
                    <strong>Name:</strong>
                    {{ $user->name }}
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-10">
                <div class="form-group">
                    <strong>Email:</strong>
                    {{ $user->email }}
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-10">
                <div class="form-group">
                    <strong>Roles:</strong>
                    @if(!empty($user->getRoleNames()))
                        @foreach($user->getRoleNames() as $v)
                            <label class="badge badge-success">{{ $v }}</label>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
