@extends('layouts.admin')
@section('title', __('Create New User'))

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 mb-3">
                <div class="toolbar clearfix">
                    <div class="float-lg-left">
                        <h1>Thêm mới tài khoản</h1>
                    </div>
                    <div class="float-lg-right">
                        <a  href="{{ route('manage.admins.index') }}" class="btn btn-primary"> <i class="fa fa-arrow-left"></i> Quay lại</a>
                    </div>
                </div>
            </div>
        </div>

        {!! Form::open(array('route' => 'manage.admins.store','method'=>'POST')) !!}
        <div class="row justify-content-center">
            @if (count($errors) > 0)
                <div class="col-xs-12 col-sm-12 col-md-8">
                    <div class="alert alert-danger">
                        <strong>Whoops!</strong> There were some problems with your input.<br><br>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif
            <div class="col-xs-12 col-sm-12 col-md-8">
                <div class="form-group">
                    <strong>Name:</strong>
                    {!! Form::text('name', null, array('placeholder' => 'Name','class' => 'form-control')) !!}
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-8">
                <div class="form-group">
                    <strong>Email:</strong>
                    {!! Form::text('email', null, array('placeholder' => 'Email','class' => 'form-control')) !!}
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-8">
                <div class="form-group">
                    <strong>Password:</strong>
                    {!! Form::password('password', array('placeholder' => 'Password','class' => 'form-control')) !!}
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-8">
                <div class="form-group">
                    <strong>Confirm Password:</strong>
                    {!! Form::password('confirm-password', array('placeholder' => 'Confirm Password','class' => 'form-control')) !!}
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-8">
                <div class="form-group">
                    <strong>Role:</strong>
                    {!! Form::select('roles[]', $roles,[], array('class' => 'form-control','multiple')) !!}
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-8">
                <button type="submit" name="save" value="save" class="btn btn-primary">Save</button>
                <button type="submit" name="save" value="save_close" class="btn btn-primary">Save & Close</button>
            </div>
        </div>
        {!! Form::close() !!}
    </div>

@endsection
