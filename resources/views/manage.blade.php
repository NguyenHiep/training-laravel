@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            @include('components.alert-success')
            <div class="card">
                <div class="card-header">Dashboard</div>
                    You are logged in!
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
