@if(Session::has('success'))
    <div class="alert alert-success" id="alert">
        <strong>{{ backend('backend.Success') }}:</strong> {{ \Session::get('success') }}
    </div>
@elseif(session('error'))
    <div class="alert alert-danger" id="alert">
        <strong>{{ trans('backend.Error') }}:</strong>{{ \Session::get('error') }}
    </div>
@endif
