<form method="POST">
    @csrf @method('PATCH')
    @switch($request->status)
    @case('pending')
      <button title="Approve Request" type="submit" class="btn btn-sm btn-primary approve" formaction="{{ route('admin.cancel_orders.update', [$request->id, 'status' => 'approved']) }}">
        <span class="fa fa-check fa-fw"></span>
      </button>
      @break
    @case('approved')
      <button title="Refund Request" type="submit" class="btn btn-sm btn-success refuned" formaction="{{ route('admin.cancel_orders.update', [$request->id, 'status' => 'refunded']) }}">
        <span class="	fa fa-dollar fa-fw"></span>
      </button>
      @break
    @endswitch
    @if ($request->status == 'pending')
      <button title="Reject Request" type="submit" class="btn btn-sm btn-outline-danger reject" formaction="{{ route('admin.cancel_orders.update', [$request->id, 'status' => 'rejected']) }}">
        <span class="fa fa-times fa-fw"></span>
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