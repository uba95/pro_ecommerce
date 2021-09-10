@extends('layouts.admin.index')


@section('admin_content')
    <!-- ########## START: MAIN PANEL ########## -->
    <div class="sl-mainpanel">
      <div class="sl-pagebody">
        <div class="sl-page-title">
          <h5>Edit Subcategory</h5>
        </div><!-- sl-page-title -->

        <div class="card pd-20 pd-sm-40">
          <h6 class="card-body-title">Edit Subcategory</h6>
          <div class="table-wrapper">
            @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action ='{{ route('admin.subcategories.update', $subcategory->id) }}' method="POST">
            @csrf
            @method('PUT')
            <div class="modal-body pd-20">
              <div class="form-group">
                <label for="exampleInputEmail1">Subcategory Name</label>
                <input type="text" class="form-control" name="subcategory_name" value="{{ $subcategory->subcategory_name }}">
              </div>
              
              <div class="form-group">
                <label for="exampleInputEmail1">Category Name</label>
                <select class="form-control select2" name="category_id" data-placeholder="Choose Category">
                  <option label="Category Category"></option>
                  @foreach ($categories as $id => $category_name))
                    <option value="{{ $id }}" {{ $subcategory->category_id === $id ? 'selected' : '' }}>
                      {{ $category_name }}
                    </option>
                  @endforeach
                </select>
              </div>
            </div><!-- modal-body -->
            <div class="modal-footer">
              <button type="submit" class="btn btn-info pd-x-20">Update</button>
            </div>
            
        </form>

          </div><!-- table-wrapper -->
        </div><!-- card -->
      </div><!-- sl-pagebody -->
    </div><!-- sl-mainpanel -->
    <!-- ########## END: MAIN PANEL ########## -->
      
@endsection