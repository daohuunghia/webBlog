@extends('layouts.layout_backend')
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>{{ trans('backend.User') }}</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">User Profile</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        @if (auth()->check())
            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-5">
                            <div class="card card-primary card-outline">
                                <div class="card-body box-profile">
                                    <div class="text-center">
                                        <img class="profile-user-img img-fluid img-circle" src="{{ auth()->user()->avatar }}" style="width: 75px;height:75px" alt="User profile picture">
                                    </div>

                                    <h3 class="profile-username text-center">{{ auth()->user()->name }}</h3>

                                    <ul class="list-group list-group-unbordered mb-3">
                                        <li class="list-group-item">
                                            <b>Email</b> <a class="float-right">{{ auth()->user()->email }}</a>
                                        </li>
                                        <li class="list-group-item">
                                            <b>{{ trans('backend.Nghề nghiệp') }}</b> <a class="float-right">{{ auth()->user()->job }}</a>
                                        </li>
                                        <li class="list-group-item">
                                            <b>{{ trans('backend.Số điện thoại') }}</b> <a class="float-right">{{ auth()->user()->phone }}</a>
                                        </li>
                                    </ul>

                                    <a href="{{ route('admin.user.update', auth()->user()->id) }}" class="btn btn-primary btn-block"><b>{{ trans('backend.Update') }}</b></a>
                                </div>
                                <!-- /.card-body -->
                            </div>
                        </div>

                    </div>
                    <!-- /.row -->
                </div><!-- /.container-fluid -->
            </section>
        @endif
    </div>
@endsection
@push('script')
    @include('backend.includes.script')
@endpush
