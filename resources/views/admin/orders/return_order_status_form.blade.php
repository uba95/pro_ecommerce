<form method="POST">
    @csrf @method('PATCH')
    @switch($request->status)
    @case('pending')
      <button title="Approve Request" type="submit" class="btn btn-sm btn-primary approve" formaction="{{ route('admin.return_orders.update', [$request->id, 'status' => 'approved']) }}">    
        @if (Route::currentRouteName() == 'admin.return_orders.show')
          Approve Request
        @else
          <span class="fa fa-check fa-fw"></span>
        @endif
      </button>
      @break
    @case('approved')
      <button title="Start Shipping " type="submit" class="btn btn-sm btn-primary ship" formaction="{{ route('admin.return_orders.update', [$request->id, 'status' => 'shipped']) }}">
        @if (Route::currentRouteName() == 'admin.return_orders.show')
          Start Shipping 
        @else
        <span class="	fa fa-truck fa-fw"></span>
        @endif
      </button>
      @break
    @case('shipped')
      <button title="Order Is Returned" type="submit" class="btn btn-sm btn-primary deliver" formaction="{{ route('admin.return_orders.update', [$request->id, 'status' => 'returned']) }}">
        @if (Route::currentRouteName() == 'admin.return_orders.show')
          Order Is Returned
        @else
          <span class="fa fa-thermometer-full fa-fw"></span>
        @endif

      </button>
      @break
    @case('returned')
      <button title="Refund Request" type="submit" class="btn btn-sm btn-success refuned" formaction="{{ route('admin.return_orders.update', [$request->id, 'status' => 'refunded']) }}">
        @if (Route::currentRouteName() == 'admin.return_orders.show')
          Refund Request
        @else
          <span class="fa fa-dollar fa-fw"></span>
        @endif
      </button>
      @break
    @endswitch
    @if ($request->status == 'pending')
      <button title="Reject Request" type="submit" class="btn btn-sm btn-outline-danger reject" formaction="{{ route('admin.return_orders.update', [$request->id, 'status' => 'rejected']) }}">
        @if (Route::currentRouteName() == 'admin.return_orders.show')
          Reject Request
        @else
          <span class="fa fa-times fa-fw"></span>
        @endif
      </button>
    @endif
    
    @if ($errors->any())
    <div class="alert alert-danger mg-t-10">
        <ul>
            @foreach ($errors->all() as $error)
                <li class="mg-t-10"><strong>{{ $error }}</strong></li>
            @endforeach
        </ul>
    </div>
    @endif

</form>
