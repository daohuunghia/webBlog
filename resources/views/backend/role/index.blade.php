@extends('layouts.layout_backend')
@section('content')
    <div class="content-wrapper" style="min-height: 1200.88px;">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <div class="d-flex">
                            <h1 class="mr-5">{{ trans('backend.Vai trò') }} / {{ trans('backend.List') }}</h1>
                            <a href="{{route('admin.role.create')}}" class="btn btn-primary">{{trans('backend.Create new')}}</a>
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
                                        <th>{{ trans('backend.Vai trò') }}</th>
                                        <th>{{ trans('backend.Quyền') }}</th>
                                        <th>{{ trans('backend.Action') }}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if (!empty($roles))
                                        @foreach($roles as $key =>$item)
                                            <tr>
                                                <td>{{ $item->id }}</td>
                                                <td>{{ $item->name }}</td>
                                                <td>
                                                    @foreach ($item->permissions as $permission)
                                                            <span class="badge bg-info">{{ $permission->name }}</span>
                                                    @endforeach
                                                </td>
                                                <td>
                                                    <a href="{{ route('admin.role.update', $item->id) }}" class="mr-3 text-blue"><i class="fas fa-edit"></i></a>
                                                    <a href="{{ route('admin.role.action', ['delete', $item->id]) }}" onclick="return confirm('Bạn muốn xóa ?')" class="text-danger">
                                                            <i class="fas fa-trash"></i></a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                    </tbody>
                                </table>
                            </div>
                            {{ $roles->links() }}
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
