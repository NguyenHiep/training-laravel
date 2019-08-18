@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                @if (session('status'))
                    <div class="alert alert-{{ session('status') ?? 'success' }} alert-dismissible fade show" role="alert">
                        {{ session('message') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif
                <div class="toolbar mb-3">
                    <a href="{{ route('manage.companies.create') }}" class="btn btn-primary"><i class="fa fa-plus-circle"></i> Thêm mới</a>
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead>
                        <tr class="text-center">
                            <th scope="col">#</th>
                            <th class="d-none d-lg-table-cell" scope="col" width="15%">Hình ảnh</th>
                            <th scope="col" class="text-left">Công ty</th>
                            <th class="d-none d-lg-table-cell" scope="col" width="10%">Loại</th>
                            <th class="d-none d-lg-table-cell" scope="col" width="10%">Size</th>
                            <th class="d-none d-lg-table-cell" scope="col">Địa chỉ</th>
                            <th scope="col" width="10%">Trạng thái</th>
                            <th scope="col" width="12%">Hành động</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if (count($companies) > 0)
                            @foreach ($companies as $company)
                                <tr class="text-center">
                                    <th scope="row">{{ $company->id }}</th>
                                    <th class="d-none d-lg-table-cell">
                                        @if(!empty($company->logo))
                                            <img src="{{ Storage::url($company->logo) }}" alt="log" class="img-thumbnail"/>
                                        @endif
                                    </th>
                                    <td class="text-left">{{ $company->name }}</td>
                                    <td class="d-none d-lg-table-cell">{{ $company->type }}</td>
                                    <td class="d-none d-lg-table-cell">{{ $company->size }}</td>
                                    <td class="d-none d-lg-table-cell text-left">{{ $company->address }}</td>
                                    <td>
                                        @if ($company->status == 1)
                                            <i class="fa fa-check-circle fa-2x text-success"></i>
                                        @else
                                            <i class="fa fa-lock fa-2x text-danger"></i>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('manage.companies.edit', ['id' => $company->id]) }}" class="btn btn-primary" title="Edit"><i class="fa fa-edit"></i></a>
                                        <form class="d-inline" action="{{ route('manage.companies.destroy', ['id' => $company->id]) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger" title="Delete" onclick="return confirm('Bạn muốn xóa item này?')"><i class="fa fa-trash"></i></button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr class="text-center">
                                <td colspan="7">Không có dữ liệu</td>
                            </tr>
                        @endif

                        </tbody>
                    </table>
                </div>
                @if($companies->count() > 0)
                    <nav aria-label="Page navigation List">
                        {{ $companies->links() }}
                    </nav>
                @endif
            </div>
        </div>
    </div>
@endsection
