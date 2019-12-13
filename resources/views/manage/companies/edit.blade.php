@extends('layouts.admin')
@section('title', __('Edit Company'))

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="toolbar mb-3 clearfix">
                    <div class="float-lg-left">
                        <h1>Cập nhật công ty - {{ $company->name }}</h1>
                    </div>
                    <div class="float-lg-right">
                        <a href="{{ route('manage.companies.index') }}" class="btn btn-primary"><i class="fa fa-arrow-left"></i> Quay lại</a>
                    </div>
                </div>
                @include('components.alert-success')
                @includeIf('components.alert-errors', ['errors' => $errors])
                <form action="{{ route('manage.companies.update', ['id' => $company->id]) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label for="name">Công ty</label>
                            <input name="name" type="text" class="form-control" id="name" placeholder="Nhập tên công ty" value="{{ old('name', $company->name) }}" required />
                        </div>
                        <div class="form-group col-md-6">
                            <label for="logo">Logo</label>
                            @if(!empty($company->logo))
                                <img src="{{ Storage::url($company->logo) }}" alt="log" class="img-thumbnail mb-3"/>
                            @endif
                            <div class="custom-file">
                                <input name="logo" type="file" class="custom-file-input" id="logo" accept="image/*" />
                                <label class="custom-file-label" for="logo">New image</label>
                            </div>
                        </div>

                    </div>
                    <div class="form-group">
                        <label for="address">Địa chỉ</label>
                        <input name="address" type="text" class="form-control" id="address" placeholder="31 Ngo Be, Phuong 13, Quan Tan Binh" value="{{ old('address', $company->address) }}" required />
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
                                    <option value="{{ $key }}" {{ old('type', $company->type) == $key ? 'selected' : '' }}>{{ $type }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="size">Nhân viên</label>
                            <input type="text" id="size" value="{{ old('size', $company->size) }}" name="size" class="form-control" placeholder="0-50" required />
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="custom-control custom-switch">
                            <input name="status" type="checkbox" class="custom-control-input" id="status" value="1" {{ old('status', $company->status) ? 'checked' : '' }}/>
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
