@extends('layouts.layout_backend')
@section('content')
    <div class="content-wrapper" style="min-height: 1244.06px;">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>{{ trans('backend.Category') }}</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">{{ trans('backend.Category') }}</li>
                        </ol>
                    </div>
                </div>
            </div>
            <!-- /.container-fluid -->
        </section>
        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <form role="form" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card card-primary">
                                <div class="card-header">
                                    <h3 class="card-title">{{ trans('backend.Create new') }}</h3>
                                </div>
                                <div class="card-body row">
                                    <div class="form-group col-md-12 {{ $errors->first('vi_title') ? 'has-error' : '' }}">
                                        <label for="vi_title">{{ trans('backend.Title') }}<span class="text-danger"> Vi</span></label>
                                        <input type="text" name="vi_title" value="{{ old('vi_title') }}" class="form-control" id="vi_title" />
                                        @if ($errors->has('vi_title'))
                                            <span class="text-danger">{{$errors->first('vi_title')}}</span>
                                        @endif
                                    </div>
                                    <div class="form-group col-md-12 {{ $errors->first('en_title') ? 'has-error' : '' }}">
                                        <label for="en_title">{{ trans('backend.Title') }}<span class="text-danger"> En</span></label>
                                        <input type="text" name="en_title" value="{{ old('en_title') }}" class="form-control" id="en_title">
                                        @if ($errors->has('en_title'))
                                            <span class="text-danger">{{$errors->first('en_title')}}</span>
                                        @endif
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label for="parent_id">{{ trans('backend.Category parent') }}</label>
                                        <select name="parent_id" id="parent_id" class="form-control select2" style="width: 100%;">
                                            <option value="">--{{ trans('backend.Chọn danh mục') }}--</option>
                                            @if (!empty($categories))
                                                @foreach ($categories as $item)
                                                    <option {{ old('parent_id') == $item->id ? "selected" : "" }} value="{{ $item->id }}">{{$item->title}}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label>{{ trans('backend.Avatar') }}</label>
                                        <div class="row">
                                            <div class="col-md-8 mb-2">
                                                <input type="text" name="avatar" value="{{ old('avatar') ?? '/backend/images/default.jpg' }}"
                                                       id="avatar" class="form-control" />
                                            </div>
                                            <div class="col-md-4 mb-2">
                                                <div class=" input-group-append">
                                                    <button
                                                        onclick="open_popup('/filemanager/dialog.php?type=1&popup=1&field_id=avatar&akey={{ $keyAccessFileManagerBackend}}')"
                                                        class="btn btn-primary mr-1" type="button"><i class="fa fa-cloud-upload"></i> Chọn</button>
                                                    <button onclick="resetInput('avatar')" class="btn btn-danger reset" data-reset="avatar"
                                                            type="button"><i class="fa fa-trash"></i> Xóa</button>
                                                </div>
                                            </div>
                                        </div>
                                        <img id="image-preview-avatar" class="img-fluid"
                                                 src="{{ old('avatar') ?? '/backend/images/default.jpg' }}" style="max-width: 250px">
                                    </div>
                                    <div class="form-group col-md-12">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <label for="status" class="d-block">{{ trans('backend.Status') }}</label>
                                                <input type="checkbox" name="status" class="form-control" checked data-bootstrap-switch data-off-color="danger" data-on-color="success">
                                            </div>
                                            <div class="col-md-3">
                                                <label for="hot" class="d-block">{{ trans('backend.Hot') }}</label>
                                                <input type="checkbox" name="hot" id="hot" class="form-control" checked data-bootstrap-switch data-off-color="danger" data-on-color="success">
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card card-primary">
                                <div class="card-header">
                                    <h3 class="card-title">{{ trans('backend.Create new') }}</h3>
                                </div>
                                <div class="card-body row">
                                    <div class="form-group col-md-12 {{ $errors->first('vi_keyword') ? 'has-error' : '' }}">
                                        <label for="vi_keyword">{{ trans('backend.Keyword') }}<span class="text-danger"> Vi</span></label>
                                        <textarea name="vi_keyword" id="vi_keyword" class="form-control" rows="4">{{ old('vi_keyword') }}</textarea>
                                        @if ($errors->has('vi_keyword'))
                                            <span class="text-danger">{{$errors->first('vi_keyword')}}</span>
                                        @endif
                                    </div>
                                    <div class="form-group col-md-12 {{ $errors->first('en_keyword') ? 'has-error' : '' }}">
                                        <label for="en_keyword">{{ trans('backend.Keyword') }}<span class="text-danger"> En</span></label>
                                        <textarea name="en_keyword" id="en_keyword" class="form-control" rows="4">{{ old('en_keyword') }}</textarea>
                                        @if ($errors->has('en_keyword'))
                                            <span class="text-danger">{{$errors->first('en_keyword')}}</span>
                                        @endif
                                    </div>
                                    <div class="form-group col-md-12 {{ $errors->first('vi_description') ? 'has-error' : '' }}">
                                        <label for="vi_description">{{ trans('backend.Description') }}<span class="text-danger"> Vi</span></label>
                                        <textarea name="vi_description" id="vi_description" class="form-control" rows="4">{{ old('vi_description') }}</textarea>
                                        @if ($errors->has('vi_description'))
                                            <span class="text-danger">{{$errors->first('vi_description')}}</span>
                                        @endif
                                    </div>
                                    <div class="form-group col-md-12 {{ $errors->first('en_description') ? 'has-error' : '' }}">
                                        <label for="en_description">{{ trans('backend.Description') }}<span class="text-danger"> En</span></label>
                                        <textarea name="en_description" id="en_description" class="form-control" rows="4">{{ old('en_description') }}</textarea>
                                        @if ($errors->has('en_description'))
                                            <span class="text-danger">{{$errors->first('en_description')}}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary btn-lg">{{ trans('backend.Send')}}</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </section>
    </div>
@endsection
@push('script')
    @include('backend.includes.script')
@endpush
