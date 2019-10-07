@extends('layouts.admin')
@section('title', __('Roles Management'))

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10 mb-3">
                <div class="toolbar mb-3 clearfix">
                    <div class="float-lg-left">
                        <h1>Role Management</h1>
                    </div>
                    <div class="float-lg-right">
                        @can('role-create')
                            <a class="btn btn-success" href="{{ route('manage.roles.create') }}"><i class="fa fa-plus-circle"></i> Create New Role</a>
                        @endcan
                    </div>
                </div>
                @if ($message = Session::get('success'))
                    <div class="alert alert-success">
                        <p>{{ $message }}</p>
                    </div>
                @endif
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <tr>
                            <th>No</th>
                            <th>Name</th>
                            <th width="280px">Action</th>
                        </tr>
                        @foreach ($roles as $key => $role)
                            <tr>
                                <td>{{ ++$i }}</td>
                                <td>{{ $role->name }}</td>
                                <td>
                                    <a class="btn btn-info" href="{{ route('manage.roles.show',$role->id) }}" title="Show"><i class="far fa-eye"></i></a>
                                    @can('role-edit')
                                        <a class="btn btn-primary" href="{{ route('manage.roles.edit',$role->id) }}" title="Edit"><i class="fa fa-edit"></i></a>
                                    @endcan
                                    @can('role-delete')
                                        {!! Form::open(['method' => 'DELETE','route' => ['manage.roles.destroy', $role->id],'class'=>'d-inline']) !!}
                                        <button type="submit" title="Delete" onclick="return confirm('Bạn muốn xóa item này?')" class="btn btn-danger"><i class="fa fa-trash"></i></button>
                                        {!! Form::close() !!}
                                    @endcan
                                </td>
                            </tr>
                        @endforeach
                    </table>
                    {!! $roles->render() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
