@extends('layouts.admin')
@section('title', __('Comments Management'))

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                @include('components.alert-success')
                <div class="toolbar mb-3 clearfix">
                    @if(!empty($companyId))
                        <div class="float-lg-left">
                            @if(count($comments) > 0)
                                <h1>Bình luận <strong>{{$comments->first()->company->name}}</strong></h1>
                            @endif
                        </div>
                        <div class="float-lg-right">
                            <a href="{{ route('manage.comments.create', request()->input()) }}" class="btn btn-success"><i class="fa fa-plus-circle"></i> Thêm mới</a>
                        </div>
                    @else
                        <div class="float-lg-left">
                            <h1>Manage Comments</h1>
                        </div>
                    @endif
                </div> <!-- End .toolbar -->
                <div class="filter mb-3">
                    <form action="" method="get">
                        <div class="input-group">
                            <input name="search" type="text" class="form-control" placeholder="Nhập nội dung muốn tìm" required/>
                            <div class="input-group-append">
                                <button class="btn btn-outline-secondary" type="submit">Tìm kiếm</button>
                            </div>
                        </div>
                    </form>
                </div> <!-- End .filter -->
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead>
                        <tr class="text-center">
                            <th scope="col">#</th>
                            <th class="d-none d-lg-table-cell text-left" scope="col">Bình luận</th>
                            <th scope="col" class="text-left">Công ty</th>
                            <th class="d-none d-lg-table-cell" scope="col" width="10%">Tên</th>
                            <th class="d-none d-lg-table-cell" scope="col" width="10%">Chức vụ</th>
                            <th class="d-none d-lg-table-cell" scope="col">Star</th>
                            <th scope="col" width="10%">Trạng thái</th>
                            <th scope="col" width="12%">Hành động</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if (count($comments) > 0)
                            @foreach ($comments as $comment)
                            <tr class="text-center">
                                <td>{{ $comment->id }}</td>
                                <td class="d-none d-lg-table-cell text-left">{{ $comment->content }}</td>
                                <td class="text-left">{{ $comment->company->name }}</td>
                                <td class="d-none d-lg-table-cell">{{ $comment->reviewer }}</td>
                                <td class="d-none d-lg-table-cell">{{ $comment->position }}</td>
                                <td class="d-none d-lg-table-cell">{{ $comment->star }}</td>
                                <td>
                                    @if ($comment->status == 1)
                                        <i class="fa fa-check-circle fa-2x text-success"></i>
                                    @else
                                        <i class="fa fa-lock fa-2x text-danger"></i>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('manage.comments.edit', array_merge(['id' => $comment->id], request()->input())) }}" class="btn btn-primary" title="Edit"><i class="fa fa-edit"></i></a>
                                    <form class="d-inline" action="{{ route('manage.comments.destroy', ['id' => $comment->id]) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger" title="Delete" onclick="return confirm('Bạn muốn xóa item này?')"><i class="fa fa-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        @else
                            <tr class="text-center">
                                <td colspan="8">Không có dữ liệu</td>
                            </tr>
                        @endif
                        </tbody>
                    </table>
                </div>
                @if($comments->count() > 0)
                    <nav aria-label="Page navigation List">
                        {{ $comments->appends(request()->input())->links() }}
                    </nav>
                @endif
            </div>
        </div>
    </div>
@endsection
