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
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-9">
                        <div class="card">
                            <div class="card-body">
                                <form class="form-horizontal" action="" method="POST">
                                    @csrf
                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label">{{ trans('backend.Họ & tên') }} <span class="text-danger"> *</span></label>
                                        <div class="col-sm-10">
                                            <input type="text" name="name" value="{{ old('name', $user->name) }}" class="form-control" placeholder="{{ trans('backend.Họ & tên') }}">
                                            @if ($errors->has('name'))
                                                <span class="text-danger">{{$errors->first('name')}}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label">{{ trans('backend.Email') }} <span class="text-danger"> *</span></label>
                                        <div class="col-sm-10">
                                            <input type="email" name="email" value="{{ old('email', $user->email) }}" readonly class="form-control" placeholder="{{ trans('backend.Email') }}">
                                            @if ($errors->has('email'))
                                                <span class="text-danger">{{$errors->first('email')}}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label">{{ trans('backend.Cho phép đổi mật khẩu') }} <span class="text-danger"> *</span></label>
                                        <div class="col-sm-10 mt-3">
                                            <div class="icheck-success d-inline">
                                                <input type="checkbox" id="checkboxSuccess1" name="check_change_password" class="checkChangePassword">
                                                <label for="checkboxSuccess1">
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label">{{ trans('backend.Password') }} <span class="text-danger"> *</span></label>
                                        <div class="col-sm-10">
                                            <input type="password" name="password" id="password" disabled class="form-control" placeholder="{{ trans('backend.Password') }}">
                                            @if ($errors->has('password'))
                                                <span class="text-danger">{{$errors->first('password')}}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label">{{ trans('backend.Re password') }} <span class="text-danger"> *</span></label>
                                        <div class="col-sm-10">
                                            <input type="password" name="re_password" id="re_password" disabled class="form-control" placeholder="{{ trans('backend.Re password') }}">
                                            @if ($errors->has('re_password'))
                                                <span class="text-danger">{{$errors->first('re_password')}}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label">{{ trans('backend.Avatar') }}</label>
                                        <div class="col-sm-10">
                                            <div class="row">
                                                <div class="col-md-8 mb-2">
                                                    <input type="text" name="avatar" value="{{ old('avatar', $user->avatar) ?? '/backend/images/default.jpg' }}"
                                                           id="avatar" class="form-control" />
                                                </div>
                                                <div class="col-md-4 mb-2">
                                                    <div class=" input-group-append">
                                                        <button
                                                            onclick="open_popup('/filemanager/dialog.php?type=1&popup=1&field_id=avatar&akey={{ $keyAccessFileManagerBackend}}')"
                                                            class="btn btn-primary mr-1" type="button"><i class="fa fa-cloud-upload"></i> {{ trans('backend.Chọn') }}</button>
                                                        <button onclick="resetInput('avatar')" class="btn btn-danger reset" data-reset="avatar"
                                                                type="button"><i class="fa fa-trash"></i> {{ trans('backend.Xóa') }}</button>
                                                    </div>
                                                </div>
                                            </div>
                                            <div style="display: inline-block;border: 2px solid #ded8d8;border-radius: 100%;padding: 4px;">
                                                <img id="image-preview-avatar" class="img-fluid"
                                                     onclick="open_popup('/filemanager/dialog.php?type=1&popup=1&field_id=avatar&akey={{ $keyAccessFileManagerBackend}}')"
                                                     src="{{ old('avatar', $user->avatar) ?? '/backend/images/default.jpg' }}" style="max-width: 250px;width: 100px;height: 100px;border-radius:100%;">
                                            </div><br>
                                            @if ($errors->has('avatar'))
                                                <span class="text-danger">{{$errors->first('avatar')}}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label">{{ trans('backend.Status') }}</label>
                                        <div class="col-sm-10">
                                            <input type="checkbox" name="status" class="form-control" {{ $user->status == \App\User::STATUS_ACTIVE ? 'checked' : '' }} data-bootstrap-switch data-off-color="danger" data-on-color="success">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label">{{ trans('backend.Số điện thoại') }}</label>
                                        <div class="col-sm-10">
                                            <input type="number" name="phone" value="{{ old('phone', $user->phone) }}" class="form-control" placeholder="{{ trans('backend.Số điện thoại') }}">
                                            @if ($errors->has('phone'))
                                                <span class="text-danger">{{$errors->first('phone')}}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label">{{ trans('backend.Nghề nghiệp') }}</label>
                                        <div class="col-sm-10">
                                            <input type="text" name="job" value="{{ old('job', $user->job) }}" class="form-control" placeholder="{{ trans('backend.Nghề nghiệp') }}">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="offset-sm-2 col-sm-10">
                                            <button type="submit" class="btn btn-info">{{ trans('backend.Update') }}</button>
                                        </div>
                                    </div>
                                </form>
                            </div><!-- /.card-body -->
                        </div>
                        <!-- /.nav-tabs-custom -->
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
@endsection
@push('script')
    @include('backend.includes.script')
    <script type="text/javascript">
        $(document).ready(function() {
            $('.checkChangePassword').click(function () {
                if ($(this).is(':checked')) {
                    $('#password').attr('disabled', false);
                    $('#re_password').attr('disabled', false);
                } else {
                    $('#password').attr('disabled', true);
                    $('#re_password').attr('disabled', true);
                }
            });
        });
    </script>
@endpush
