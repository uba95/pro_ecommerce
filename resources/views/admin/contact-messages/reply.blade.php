@extends('layouts.admin.index')

@section('admin_content')
<!-- ########## START: MAIN PANEL ########## -->
<div class="sl-mainpanel">
  <div class="sl-pagebody">
    <div class="sl-page-title">
      <h5>Reply Message</h5>
    </div><!-- sl-page-title -->
    <div class="card pd-20 pd-sm-40">
      <h6 class="card-body-title">Reply {{ $message->name }}'s Message</h6>
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

        <form action='{{ route('admin.contact.messages.update', $message->id) }}' method="POST">
          @csrf
          @method('PUT')
          <div class="modal-body pd-20">
            <div class="form-group">
              <label for="exampleInputEmail1">Subject</label>
              <input id="subject" type="text" name="subject"
                value="{{ old('subject') ?? '[Request updated] ' . $message->subject}}" class="form-control" 
                required="required">
            </div>
            <div class="form-group">
              <label for="exampleInputEmail1">Message</label>
              <textarea name="reply" class="form-control" id="summernote">{{ old('reply') }}</textarea>
            </div>
          </div><!-- modal-body -->
          <div class="modal-footer">
            <button type="submit" class="btn btn-info pd-x-20">Send Reply</button>
          </div>
        </form>

      </div><!-- table-wrapper -->
    </div><!-- card -->
  </div><!-- sl-pagebody -->
</div><!-- sl-mainpanel -->
<!-- ########## END: MAIN PANEL ########## -->

@endsection