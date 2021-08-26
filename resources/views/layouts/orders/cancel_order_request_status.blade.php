@switch($request->status)
@case('pending')
    <span class="badge badge-warning">Pending</span>
    @break
@case('approved')
    <span class="badge badge-primary">Approved</span>
    @break
@case('refunded')
    <span class="badge badge-success">Refunded</span>
    @break
@case('rejected')
    <span class="badge badge-danger">Rejected</span>
    @break
@endswitch
