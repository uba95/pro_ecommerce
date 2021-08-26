@extends('admin.admin_layouts')

@section('admin_content')
    <!-- ########## START: MAIN PANEL ########## -->
    <div class="sl-mainpanel">
      <div class="sl-pagebody">
        <div class="sl-page-title">
          <h5>Contact Messages Table</h5>
        </div><!-- sl-page-title -->

        <div class="card pd-20 pd-sm-40">
          <h6 class="card-body-title">
            Contact Messages List
        </h6>

          <div class="table-wrapper">
            <table id="datatable1" class="table display responsive nowrap">
              <thead>
                <tr>
                  <th class="wd-15p">Message ID</th>
                  <th class="wd-15p">Sender</th>
                  <th class="wd-15p">Subject</th>
                  <th class="wd-15p">Date</th>
                  @canany(['view contact messages', 'reply contact messages', 'delete contact messages'])
                    <th class="wd-20p">Action</th>
                  @endcanany
                </tr>
              </thead>
              <tbody>
                @foreach ($messages as $key => $message)
                    <tr @if (!$message->replied) style="background-color:#c4f9f9 !important" @endif>
                        <td>{{ $message->id }}</td>
                        <td>{{ ucwords($message->name) }}</td>
                        <td>{{ Str::limit($message->subject, 30)  }}</td>
                        <td>{{ $message->created_at->diffForHumans() }}</td>
                        @canany(['view contact messages', 'reply contact messages', 'delete contact messages'])
                        <td class="d-flex">
                              @can('view contact messages')
                                <a href ='{{ route('admin.contact.messages.show', $message->id) }}'>
                                    <i class=" btn btn-sm btn-info fa fa-eye fa-fw" title="view"></i>
                                </a>
                              @endcan
                              @can('reply contact messages')
                                <a href ='{{ route('admin.contact.messages.reply', $message->id) }}'>
                                    <i class=" btn btn-sm btn-success ml-1 fa fa-reply fa-fw" title="reply"></i>
                                </a>
                              @endcan
                              @can('delete contact messages')
                                <form method="POST" action='{{ route('admin.contact.messages.destroy', $message->id) }}' class="delete">
                                    @csrf @method('DELETE')
                                    <i class=" btn btn-sm btn-danger ml-1 fa fa-trash fa-fw" title="delete"></i>
                                </form>
                              @endcan
                          </td>
                        @endcanany
                    </tr>
                @endforeach
              </tbody>
            </table>
          </div><!-- table-wrapper -->
        </div><!-- card -->
      </div><!-- sl-pagebody -->
    </div><!-- sl-mainpanel -->
    <!-- ########## END: MAIN PANEL ########## -->      
@endsection