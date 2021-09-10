@extends('layouts.admin.index')
@section('admin_content')

  <div class="sl-mainpanel">
      <div class="sl-pagebody">
          <div class="card pd-20 pd-sm-40">
                <h6 class="card-body-title">Contact Messages </h6>
                <div class="row">
                        <div class="col-md-8">
                            <div class="card">
                                <h6 class="card-header">Message Details</h6>
                                <div class="card-body">
                                  <table class="table"> 
                                    
                                    <tr>
                                      <th> Sender: </th>
                                      <th>{{ $message->name }} </th>
                                    </tr>
                            
                                    <tr>
                                      <th> Email: </th>
                                      <th>{{ $message->email }} </th>
                                    </tr>
                            
                                    <tr>
                                      <th> Phone Number: </th>
                                      <th>{{ $message->phone }}</th>
                                    </tr>
                            
                                    <tr>
                                      <th> Date: </th>
                                      <th> 
                                          {{ $message->created_at->isoFormat('Y-MM-DD HH:mm') }} 
                                          <div class="ml-2 text-muted small text-left">{{ $message->created_at->diffForHumans() }} </div>
                                      </th>
                                    </tr>
                
                                  </table>
                                </div>
                            </div>                
                        </div>
                </div>

                <div class="row">
                    <div class="card">
                        <h6 class="card-header">{{ $message->subject }}</h6>
                        <div class="card-body">
                            <table class="table"> 
                                {{ $message->message }}
                            </table>
                                <a href='{{ route('admin.contact.messages.reply', $message->id) }}' class="btn btn-success">Reply</a>
                        </div>
                    </div>                
                </div>
          </div>
      </div>
  </div>
@endsection
