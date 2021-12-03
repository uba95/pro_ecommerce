<td>
  @if ($item->status == 'active')
  <span class="badge badge-success">ACTIVE</span>
  @else
  <span class="badge badge-dark">INACTIVE</span>
  @endif
</td>
@canany(['view landing page items', 'edit landing page items', 'delete landing page items'])
<td>

  <div class="dropdown " style="cursor: pointer">
    <a class="dropdown-button p-4" id="dropdown-menu-{{ $item->id }}" data-toggle="dropdown" data-boundary="viewport"
      aria-haspopup="true" aria-expanded="false">
      <i class="fa fa-ellipsis-v"></i>
    </a>
    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdown-menu-{{ $item->id }}">
      @can('view', $item)
      <a class="dropdown-item px-1" href='{{ route('admin.landing_page_items.show', $item->id) }}'>
        <i class="fa fa-eye fa-fw"></i> Show
      </a>
      @endcan

      @can('edit', $item)
      <a class="dropdown-item px-1" href='{{ route('admin.landing_page_items.edit', $item->id) }}'>
        <i class="fa fa-edit fa-fw"></i> Edit
      </a>
      <a class="dropdown-item px-1" href='{{ route('admin.landing_page_items.status', $item->id) }}'>
        <i class="fa fa-lightbulb-o fa-fw"></i> Change Status
      </a>
      @endcan

      @can('delete', $item)
      <form method="POST" action='{{ route('admin.landing_page_items.destroy', $item->id) }}' class="dropdown-item px-1 delete">
        @csrf @method('DELETE')
        <i class="fa fa-times fa-fw"></i> Delete
      </form>
      @endcan

    </div>
  </div>
</td>
@endcanany