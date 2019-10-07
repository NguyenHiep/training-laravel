@extends('layouts.admin')
@section('title', __('Edit Role'))

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="toolbar mb-3 clearfix">
                    <div class="float-lg-left">
                        <h1>Edit Role</h1>
                    </div>
                    <div class="float-lg-right">
                        <a class="btn btn-primary" href="{{ route('manage.roles.index') }}"><i class="fa fa-arrow-left"></i> Quay lại</a></a>
                    </div>
                </div>
            </div>
        </div>
        {!! Form::model($role, ['method' => 'PATCH','route' => ['manage.roles.update', $role->id]]) !!}
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
                    <strong>Permission:</strong>
                    <br/>
                    @foreach($permission as $value)
                        <label>{{ Form::checkbox('permission[]', $value->id, in_array($value->id, $rolePermissions) ? true : false, array('class' => 'name')) }}
                            {{ $value->name }}</label>
                        <br/>
                    @endforeach
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
