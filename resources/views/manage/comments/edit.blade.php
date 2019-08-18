@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="toolbar mb-3">
                    <a href="{{ route('manage.companies.index') }}" class="btn btn-primary"><i class="fa fa-arrow-left"></i> Quay lại</a>
                </div>
                @if (session('status'))
                    <div class="alert alert-{{ session('status') ?? 'success' }} alert-dismissible fade show" role="alert">
                        {{ session('message') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <ul class="m-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <h1>Cập nhật công ty - {{ $company->name }}</h1>
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
                                'Dịch vụ' => 'Dịch vụ',
                                'Sản phẩm' => 'Sản phẩm'
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
                        @php
                            $sizes = [
                                ''     => 'Choose...',
                                '50'   => '< 50',
                                '100'  => '50 - 100',
                                '200'  => '150 - 200',
                                '500'  => '200 - 500',
                                '1000' => '500 - 1000',
                                '2000' => '> 1000'
                            ];
                        @endphp
                        <div class="form-group col-md-6">
                            <label for="size">Nhân viên</label>
                            <select name="size" id="size" class="form-control" required>
                                @foreach($sizes as $key => $size)
                                    <option value="{{ $key }}" {{ old('size', $company->size) == $key ? 'selected' : '' }}>{{ $size }}</option>
                                @endforeach
                            </select>
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
