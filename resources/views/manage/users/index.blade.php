@extends('layouts.admin')
@section('title', __('Users Management'))

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10 mb-3">
                <div class="toolbar clearfix">
                    <div class="float-lg-left">
                        <h1>Users Management</h1>
                    </div>
                    <div class="float-lg-right">
                        <a class="btn btn-success" href="{{ route('manage.users.create') }}"><i class="fa fa-plus-circle"></i> {{ __('Create New User') }}</a>
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
                            <th>Email</th>
                            <th>Roles</th>
                            <th>Action</th>
                        </tr>
                        @foreach ($data as $key => $user)
                            <tr>
                                <td>{{ ++$i }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>
                                    @if(!empty($user->getRoleNames()))
                                        @foreach($user->getRoleNames() as $v)
                                            <label class="badge badge-success">{{ $v }}</label>
                                        @endforeach
                                    @endif
                                </td>
                                <td>
                                    <a class="btn btn-info" href="{{ route('manage.users.show',$user->id) }}" title="Show"><i class="far fa-eye"></i></a>
                                    <a class="btn btn-primary" href="{{ route('manage.users.edit',$user->id) }}" title="Edit"><i class="fa fa-edit"></i></a>
                                    {!! Form::open(['method' => 'DELETE','route' => ['manage.users.destroy', $user->id],'class'=>'d-inline']) !!}
                                    <button type="submit" title="Delete" onclick="return confirm('Bạn muốn xóa item này?')" class="btn btn-danger"><i class="fa fa-trash"></i></button>
                                    {!! Form::close() !!}
                                </td>
                            </tr>
                        @endforeach
                    </table>
                    {!! $data->render() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
