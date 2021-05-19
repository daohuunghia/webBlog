@extends('layouts.layout_backend')
@section('content')
    <div class="content-wrapper" style="min-height: 1200.88px;">
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12 mb-5 mt-5">
                        <h3>Bạn không có quyền trong tác vụ này</h3>
                        <img src="{{ asset('backend/images/loading.gif') }}" />
                    </div>
                </div>
            </div>
            <!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
@endsection




