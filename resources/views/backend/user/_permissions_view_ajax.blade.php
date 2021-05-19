@foreach ($permissions as $k => $permissionChunk)
    <div class="form-group clearfix">
        @foreach ($permissionChunk as $i => $item )
            <div class="icheck-success d-inline-block mr-3 mb-3" style="width: 20%">
                <input type="checkbox" name="permissions_id[]" class="check-permission" {{ $permissionsOfRole->contains($item->id) ? 'checked' : '' }} value="{{ $item->id }}" id="permission-{{ $item->id }}">
                <label for="permission-{{ $item->id }}">
                    {{ $item->name }}
                </label>
            </div>
        @endforeach
    </div>
@endforeach
