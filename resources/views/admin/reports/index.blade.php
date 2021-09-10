@extends('layouts.admin.index')


@section('admin_content')
    <!-- ########## START: MAIN PANEL ########## -->
    <div class="sl-mainpanel">
      <div class="sl-pagebody">
        <div class="sl-page-title">
          <h5>{{ $report['name'] }} Report</h5>
        </div><!-- sl-page-title -->

            <div class="row row-sm">
              @foreach ($report['value'] as $item)
                <div class="col-sm-12 col-xl-3">
                  <div class="card pd-20 {{ $item['class'] }}">
                    <div class="d-flex justify-content-between align-items-center mg-b-10">
                      <h5 class="tx-11 tx-uppercase mg-b-0 tx-spacing-1 tx-white">{{ $item['text'] }}</h5>
                    </div><!-- card-header -->
                    <div class="d-flex align-items-center justify-content-between">
                      <h3 class="mg-b-0 tx-white tx-lato tx-bold">{{ $item['value'] }}</h3>
                    </div><!-- card-body -->
                  </div><!-- card -->
                </div><!-- col-3 -->
              @endforeach
            </div><!-- row -->

      </div><!-- sl-pagebody -->
    </div><!-- sl-mainpanel -->
    <!-- ########## END: MAIN PANEL ########## -->
@endsection