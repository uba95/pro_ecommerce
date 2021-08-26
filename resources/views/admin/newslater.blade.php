@extends('admin.admin_layouts')


@section('admin_content')
    <!-- ########## START: MAIN PANEL ########## -->
    <div class="sl-mainpanel">
      <div class="sl-pagebody">
        <div class="sl-page-title">
          <h5>Newslaters Table</h5>
        </div><!-- sl-page-title -->

        <div class="card pd-20 pd-sm-40">
          <h6 class="card-body-title">
            Newslaters List
            <a href="" class="btn btn-sm btn-danger float-right" data-toggle="modal" data-target="#modaldemo3">Delete All</a>
        </h6>

          <div class="table-wrapper">
            <table id="datatable1" class="table display responsive nowrap">
              <thead>
                <tr>
                  <th class="wd-15p">ID</th>
                  <th class="wd-15p">Email</th>
                  <th class="wd-15p">Subscription Date</th>
                  @can('delete newslaters')
                    <th class="wd-20p">Action</th>
                  @endcan
                </tr>
              </thead>
              <tbody>
                @foreach ($newslaters as $key => $newslater)
                    <tr>
                        <td>
                            <input type="checkbox" name="delete[]" value="{{ $newslater->id }}">
                            {{ $newslater->id }}
                        </td>
                        <td>{{ $newslater->email }}</td>
                        <td>{{ $newslater->created_at->diffForHumans() }}</td>
                        @can('delete newslaters')
                          <td>
                            <form method="POST" action='{{ route('admin.newslaters.destroy', $newslater->id) }}' class="btn btn-sm btn-danger delete">
                              @csrf @method('DELETE') Delete
                            </form>
                          </td>
                        @endcan
                    </tr>
                @endforeach
              </tbody>
            </table>
          </div><!-- table-wrapper -->
        </div><!-- card -->
      </div><!-- sl-pagebody -->
    </div><!-- sl-mainpanel -->
    <!-- ########## END: MAIN PANEL ########## -->

            <!-- LARGE MODAL -->
            <div id="modaldemo3" class="modal fade">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content tx-size-sm">
                        <div class="modal-header pd-x-20">
                        <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">Add New Newslater</h6>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        </div>

                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    </div>
                </div><!-- modal-dialog -->
            </div><!-- modal -->
      
@endsection