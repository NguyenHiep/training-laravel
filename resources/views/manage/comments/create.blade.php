@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="toolbar mb-3">
                    <a href="{{ route('manage.comments.index') }}" class="btn btn-primary"><i class="fa fa-arrow-left"></i> Quay lại</a>
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
                <h1>Thêm mới bình luận</h1>
                <form action="{{ route('manage.comments.store') }}" method="POST">
                    @csrf
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label for="company_name">Công ty</label>
                            <input value="{{ $company->name }}" type="text" class="form-control" id="company_name" placeholder="Nhập tên công ty" required disabled/>
                            <input type="hidden" name="company_id" value="{{ $company->id }}" />
                        </div>
                        <div class="form-group col-md-12">
                            <label for="reviewer">Họ tên</label>
                            <input value="{{ old('reviewer') }}" name="reviewer" type="text" class="form-control" id="reviewer" placeholder="Muốn xưng tên thật thì xưng không thì thui"/>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label for="position">Chức vụ</label>
                            <input value="{{ old('position') }}" name="position" type="text" class="form-control" id="position" placeholder="Dev quèn/HR hay Manager"/>
                        </div>
                        <div class="form-group col-md-12">
                            <label for="content">Review công ty</label>
                            <textarea rows="5" name="content" class="form-control" placeholder="Bức xúc hay gì thì viết dài dài vô (Tối thiểu 10 kí tự)" required>{{ old('content') }}</textarea>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="star">Cho điểm công ty</label>
                            <select name="star" id="star" class="form-control">
                                <option value="">Select</option>
                                @if(count(__('selector.star')) > 0)
                                    @foreach(__('selector.star') as $star => $value)
                                        <option value="{{ $star }}" {{ old('star', 3) == $star ? 'selected' : '' }}>{{  $value }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="reaction">Phản ứng</label>
                            <select name="reaction" id="reaction" class="form-control">
                                <option value="">Select</option>
                                @if(count(__('selector.reaction')) > 0)
                                    @foreach(__('selector.reaction') as $reaction => $value)
                                        <option value="{{ $reaction }}"  {{ old('reaction') == $reaction ? 'selected' : '' }}>{!! $value !!}</option>
                                    @endforeach
                                @endif
                            </select>
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
