@extends('layouts.admin')
@section('title', __('Edit User'))

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="toolbar mb-3 clearfix">
                    <div class="float-lg-left">
                        <h1>Cập nhật tài khoản</h1>
                    </div>
                    <div class="float-lg-right">
                        <a class="btn btn-primary" href="{{ route('manage.admins.index') }}"><i class="fa fa-arrow-left"></i> Quay lại</a>
                    </div>
                </div>
            </div>
        </div>

        {!! Form::model($user, ['method' => 'PATCH','route' => ['manage.admins.update', $user->id]]) !!}
        <div class="row justify-content-center">
            <div class="col-xs-12 col-sm-12 col-md-8">
                @if (count($errors) > 0)
                    <div class="alert alert-danger">
                        <strong>Whoops!</strong> There were some problems with your input.<br><br>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>
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
                    {!! Form::select('roles[]', $roles,$userRole, array('class' => 'form-control','multiple')) !!}
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
