@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="toolbar mb-3">
                    <a href="" class="btn btn-primary"><i class="fa fa-arrow-left"></i> Quay lại</a>
                </div>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>Holy guacamole!</strong> You should check in on some of those fields below.
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <h1>Thêm mới công ty</h1>
                <form>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="name">Công ty</label>
                            <input name="name" type="text" class="form-control" id="name" placeholder="Nhập tên công ty" required />
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
                        <input name="address" type="text" class="form-control" id="address" placeholder="31 Ngo Be, Phuong 13, Quan Tan Binh" required />
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="type">Mô hình</label>
                            <select id="type" class="form-control" required>
                                <option>Choose...</option>
                                <option value="1" selected>Dịch vụ</option>
                                <option value="2">Sản phẩm</option>
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="size">Nhân viên</label>
                            <select id="size" class="form-control" required>
                                <option selected>Choose...</option>
                                <option>< 50</option>
                                <option selected>50 - 100</option>
                                <option>150 - 200</option>
                                <option>200 - 500</option>
                                <option>500 - 1000</option>
                                <option>> 1000</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="custom-control custom-switch">
                            <input name="status" type="checkbox" class="custom-control-input" id="status" value="1" />
                            <label class="custom-control-label" for="status">Hiển thị</label>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Save</button>
                    <button type="submit" class="btn btn-primary">Save & Close</button>
                </form>
            </div>
        </div>
    </div>
@endsection
