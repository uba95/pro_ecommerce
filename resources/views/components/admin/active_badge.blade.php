<div class="col-lg-4">
    <label>
        @if($active)
        <span class="badge badge-success">Active</span>
        @else
        <span class="badge badge-danger">Inactive</span>
        @endif
        <span>{{ $slot }}</span>
    </label>
</div> <!-- col-4 -->