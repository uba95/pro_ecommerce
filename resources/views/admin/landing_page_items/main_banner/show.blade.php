<div class="card pd-20 pd-sm-40">
  <div class="row">
          <div class="col-md-8">
              <div class="card">
                  <h6 class="card-header">Main Banner Details</h6>
                  <div class="card-body">
                    <table class="table"> 
                      
                      <tr>
                        <th> Product: </th>
                        <th> {{ $item->product->product_name }} </th>
                      </tr>
              
                      <tr>
                        <th> Text: </th>
                        <th>{{ $item->main_banner_text }} </th>
                      </tr>
              
                      <tr>
                        <th> Date: </th>
                        <th> 
                            {{ $item->created_at->isoFormat('Y-MM-DD HH:mm') }} 
                            <div class="ml-2 text-muted small text-left">{{ $item->created_at->diffForHumans() }} </div>
                        </th>
                      </tr>
  
                    </table>
                  </div>
              </div>                
          </div>

          <div class="col-md-4">
              <img src="{{ $item->main_banner_img }}" alt="" style="max-width: 100%">
          </div>
  </div>
</div>
