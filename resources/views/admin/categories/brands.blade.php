@extends('admin.admin_layouts')


@section('admin_content')
    <!-- ########## START: MAIN PANEL ########## -->
    <div class="sl-mainpanel">
      <div class="sl-pagebody">
        <div class="sl-page-title">
          <h5>Brands Table</h5>
        </div><!-- sl-page-title -->

        <div class="card pd-20 pd-sm-40">
          <h6 class="card-body-title">
            Brands List
            <a href="" class="btn btn-sm btn-success float-right" data-toggle="modal" data-target="#modaldemo3">Add New Brand</a>
        </h6>

          <div class="table-wrapper">
            <table id="datatable1" class="table display responsive nowrap">
              <thead>
                <tr>
                  <th class="wd-15p">Brand ID</th>
                  <th class="wd-15p">Brand Name</th>
                  <th class="wd-15p">Brand Logo</th>
                  <th class="wd-20p">Action</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($brands as $key => $brand)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>{{ $brand->brand_name }}</td>
                        <td>
                            <img src="{{ $brand->brand_logo }}" alt="" width="100" height="40">
                            {{-- <img src="{{ $brand->getLogo() }}" alt=""> --}}
                        </td>
                        <td>
                            <a href ='{{ route('admin.brands.edit', $brand->id) }}' class="btn btn-sm btn-info">Edit</a>
                            <form method="POST" action='{{ route('admin.brands.destroy', $brand->id) }}' class="btn btn-sm btn-danger delete">
                              @csrf @method('DELETE') Delete
                            </form>
                          </td>
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
                        <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">Add New Brand</h6>
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

                        <form action ='{{ route('admin.brands.store') }}' method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="modal-body pd-20">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Brand Name</label>
                                    <input type="text" class="form-control" name="brand_name">
                                </div>
                                <div class="form-group">
                                    <label class="d-block" for="exampleInputEmail1">Brand Logo</label>
                                    <label class="custom-file">
                                      <input type="file"  id="file select2insidemodal" class="custom-file-input" name="brand_logo">
                                      <span class="custom-file-control"></span>
                                    </label>
                                </div>
                            </div><!-- modal-body -->
                            <div class="modal-footer">
                                    <button type="submit" class="btn btn-info pd-x-20">Add</button>
                                    <button type="button" class="btn btn-secondary pd-x-20" data-dismiss="modal">Close</button>
                            </div>
                            
                        </form>
                    </div>
                </div><!-- modal-dialog -->
            </div><!-- modal -->
      
@endsection