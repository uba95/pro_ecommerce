<div class="card col-lg-12 p-0">
    <h6 class="card-header">Return Order Reason</h6>
    <div class="card-body">
      <div class="p-2">
        <strong>Reason:</strong>
        <span>{{ $returnOrderRequest->reason }}.</span>
      </div>
      <hr>
     <div class="p-2">
        <strong>Details:</strong>
        <div>
          {{ $returnOrderRequest->details }}.
        </div>
    </div>
    </div>
  </div><!-- card -->
