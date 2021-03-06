@extends('layouts.admin')
@section('title', __('Companies Management'))

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                @include('components.alert-success')
                <div class="toolbar mb-3 clearfix">
                    <div class="float-lg-left">
                        <h1>Manage Companies</h1>
                    </div>
                   <div class="float-lg-right">
                       <a href="{{ route('manage.companies.create') }}" class="btn btn-success"><i class="fa fa-plus-circle"></i> {{ __('Thêm mới') }}</a>
                       <a href="javascript:void(0)" class="btn btn-primary js-action-import"><i class="fas fa-file-import"></i> {{ __('Import CSV') }}</a>
                       <a href="javascript:void(0)" class="btn btn-primary js-action-export"><i class="fas fa-file-download"></i> {{ __('Export CSV') }}</a>
                       <a href="{{ route('manage.companies.crawling') }}" class="btn btn-primary"><i class="fas fa-file-download"></i> {{ __('Crawling Data') }}</a>
                   </div>
                </div> <!-- End .toolbar -->
                <div class="filter mb-3">
                    <form action="" method="get">
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Nhập tên công ty" required />
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
                            <th class="d-none d-lg-table-cell" scope="col" width="15%">Hình ảnh</th>
                            <th scope="col" class="text-left">Công ty</th>
                            <th class="d-none d-lg-table-cell" scope="col" width="10%">Loại</th>
                            <th class="d-none d-lg-table-cell" scope="col" width="10%">Size</th>
                            <th class="d-none d-lg-table-cell" scope="col">Địa chỉ</th>
                            <th scope="col" width="10%" class="text-center">Bình luận</th>
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
                                    <td class="text-left"><a href="{{ route('manage.comments.index', ['company_id' => $company->id]) }}"><i class="fa fa-comments fa-2x"></i><span class="total-comment">{{$company->comments_count}}</span></a></td>
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
                                <td colspan="9">Không có dữ liệu</td>
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
