@extends('layouts.layout_backend')
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>{{ trans('backend.Vai trò') }}</h1>
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
                    <!-- /.col -->
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-body">
                                <form class="form-horizontal" action="" method="POST">
                                    @csrf
                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label">{{ trans('backend.Vai trò') }} <i class="flag-icon flag-icon-vn mr-2"></i><span class="text-danger"> *</span></label>
                                        <div class="col-sm-10">
                                            <input type="text" name="vi_name" value="{{ old('vi_name', $role->translate('vi')->name) }}" class="form-control" placeholder="{{ trans('backend.Vai trò') }}">
                                            @if ($errors->has('vi_name'))
                                                <span class="text-danger">{{$errors->first('vi_name')}}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label">{{ trans('backend.Vai trò') }} <i class="flag-icon flag-icon-us mr-2"></i><span class="text-danger"> *</span></label>
                                        <div class="col-sm-10">
                                            <input type="text" name="en_name" value="{{ old('en_name', $role->translate('en')->name) }}" class="form-control" placeholder="{{ trans('backend.Vai trò') }}">
                                            @if ($errors->has('en_name'))
                                                <span class="text-danger">{{$errors->first('en_name')}}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label">{{ trans('backend.Quyền') }} <span class="text-danger"> *</span></label>
                                        <div class="col-sm-10">
                                            @foreach ($permissions as $k => $permissionChunk)
                                                <div class="form-group clearfix">
                                                    @foreach ($permissionChunk as $i => $item )
                                                        <div class="icheck-success d-inline-block mr-3 mb-3" style="width: 20%">
                                                            <input type="checkbox" name="permissions_id[]" {{ $permissionsOfRole->contains($item->id) ? 'checked' : '' }} class="check-permission" value="{{ $item->id }}" id="permission-{{ $item->id }}">
                                                            <label for="permission-{{ $item->id }}">
                                                                {{ $item->name }}
                                                            </label>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            @endforeach
                                            <hr>
                                            <div class="icheck-danger d-inline-block mr-3 mb-3">
                                                <input type="checkbox" name="check-all" value="check-all" id="permission-all">
                                                <label for="permission-all">
                                                    {{ trans('backend.Chọn tất cả quyền') }}
                                                </label>
                                            </div>
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
            $('#permission-all').click(function() {
                if ($(this).is(':checked')) {
                    $('.check-permission').attr('checked', true);
                } else {
                    $('.check-permission').attr('checked', false);
                }
            });
        });
    </script>
@endpush

