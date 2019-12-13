@extends('layouts.admin')
@section('title', __('Create New Company'))

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="toolbar mb-3 clearfix">
                    <div class="float-lg-left">
                        <h1>Thêm mới công ty</h1>
                    </div>
                    <div class="float-lg-right">
                        <a href="{{ route('manage.companies.index') }}" class="btn btn-primary"><i class="fa fa-arrow-left"></i> Quay lại</a>
                    </div>
                </div>
                @include('components.alert-success')
                @includeIf('components.alert-errors', ['errors' => $errors])
                <form action="{{ route('manage.companies.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-row">
                        <div class="form-group col-md-12 ">
                            <label for="name">Công ty</label>
                            <input value="{{ old('name') }}" name="name" type="text" class="form-control" id="name" placeholder="Nhập tên công ty" required />
                        </div>
                        <div class="form-group col-md-6">
                            <label for="logo">Logo</label>
                            <div class="custom-file">
                                <input name="logo" type="file" class="custom-file-input" id="logo" accept="image/*" required />
                                <label class="custom-file-label" for="logo">Choose file</label>
                            </div>
                        </div>

                    </div>
                    <div class="form-group">
                        <label for="address">Địa chỉ</label>
                        <input value="{{ old('address') }}" name="address" type="text" class="form-control" id="address" placeholder="31 Ngo Be, Phuong 13, Quan Tan Binh" required />
                    </div>
                    <div class="form-row">
                        @php
                            $types = [
                                ''  => 'Choose...',
                                '1' => 'Sản phẩm',
                                '2' => 'Dịch vụ',
                            ];
                        @endphp
                        <div class="form-group col-md-6">
                            <label for="type">Mô hình</label>
                            <select name="type" id="type" class="form-control" required>
                                @foreach($types as $key => $type)
                                    <option value="{{ $key }}" {{ old('type') == $key ? 'selected' : '' }}>{{ $type }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="size">Nhân viên</label>
                            <input type="text" id="size" value="{{ old('size') }}" name="size" class="form-control" placeholder="0-50" required />
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="custom-control custom-switch">
                            <input name="status" type="checkbox" class="custom-control-input" id="status" value="1" {{ old('status') ? 'checked' : '' }}/>
                            <label class="custom-control-label" for="status">Hiển thị</label>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary" name="save" value="save">Save</button>
                    <button type="submit" class="btn btn-primary" name="save" value="save_close">Save & Close</button>
                </form>
            </div>
        </div>
    </div>
@endsection
