@extends('layouts.admin')
@section('title', __('Show Role'))

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="toolbar mb-3 clearfix">
                    <div class="float-lg-left">
                        <h1> Show Role</h1>
                    </div>
                    <div class="float-lg-right">
                        <a class="btn btn-primary" href="{{ route('manage.roles.index') }}"><i class="fa fa-arrow-left"></i> Quay lại</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-xs-12 col-sm-12 col-md-10">
                <div class="form-group">
                    <strong>Name:</strong>
                    {{ $role->name }}
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-10">
                <div class="form-group">
                    <strong>Permissions:</strong>
                    @if(!empty($rolePermissions))
                        @foreach($rolePermissions as $v)
                            <label class="badge badge-success">{{ $v->name }},</label>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
