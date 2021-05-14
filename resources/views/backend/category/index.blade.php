@extends('layouts.layout_backend')
@section('content')
<div class="content-wrapper" style="min-height: 1200.88px;">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <div class="d-flex">
                        <h1 class="mr-5">Category / List</h1>
                        <a href="{{route('admin.category.get.create')}}" class="btn btn-primary">Them moi</a>
                    </div>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Simple Tables</li>
                    </ol>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Responsive Hover Table</h3>
                            <div class="card-tools">
                                <div class="input-group input-group-sm" style="width: 150px;">
                                    <input type="text" name="table_search" class="form-control float-right" placeholder="Search">
                                    <div class="input-group-append">
                                        <button type="submit" class="btn btn-default"><i class="fas fa-search"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body table-responsive p-0">
                            <table class="table table-hover text-nowrap">
                                <thead>
                                <tr>
                                    <th>{{ trans('Id') }}</th>
                                    <th>{{ trans('backend.Title') }}</th>
                                    <th>{{ trans('backend.Avatar')  }}</th>
                                    <th>{{ trans('Parent') }}</th>
                                    <th>{{ trans('backend.Status') }}</th>
                                    <th>{{ trans('backend.Created at') }}</th>
                                    <th>{{ trans('backend.Created by') }}</th>
                                    <th>{{ trans('backend.Action') }}</th>
                                </tr>
                                </thead>
                                <tbody>
                                    @if (!empty($categories))
                                        @foreach($categories as $key =>$item)
                                            <tr>
                                                <td>{{ $item->id }}</td>
                                                <td>{{ str_repeat('--', $item->level) }} {{ $item->title }}</td>
                                                <td>
                                                    @if ($item->avatar)
                                                        <img src="{{ $item->avatar }}" style="width: 100px"/>
                                                    @else
                                                        <img src="/backend/images/default.jpg" style="width: 100px"/>
                                                    @endif
                                                </td>
                                                <td></td>
                                                <td>
                                                    <a href="{{ route('admin.category.action', ['status', $item->id]) }}" class="btn btn-{{ $item->getStatus($item->status)['class'] }} btn-xs" style="width: 80px;">
                                                        {{ trans($item->getStatus($item->status)['name'])  }}
                                                    </a>
                                                </td>
                                                <td>{{ $item->created_at }}</td>
                                                <td>
                                                    <strong>{{ $item->created_by }}</strong>
                                                </td>
                                                <td>
                                                    <a href="{{ route('admin.category.get.update', $item->id) }}" class="mr-3 text-blue"><i class="fas fa-edit"></i></a>
                                                    <a href="{{ route('admin.category.action', ['delete', $item->id]) }}" onclick="return confirm('Bạn muốn xóa ?')" class="text-danger">
                                                        <i class="fas fa-trash"></i></a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
{{--                        {{ $categories->links() }}--}}
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
@endsection
