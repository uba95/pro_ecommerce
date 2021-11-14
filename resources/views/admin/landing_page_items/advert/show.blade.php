<div class="card pd-20 pd-sm-40">
  <div class="row">
          <div class="col-md-8">
              <div class="card">
                  <h6 class="card-header">Advert Details</h6>
                  <div class="card-body">
                    <table class="table"> 
                      
                      <tr>
                        <th> Headline: </th>
                        <th> {{ $item->advert_headline }} </th>
                      </tr>
              
                      <tr>
                        <th> Text: </th>
                        <th>{{ $item->advert_text }} </th>
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
              <img src="{{ $item->advert_img }}" alt="" style="max-width: 100%">
          </div>
  </div>
</div>
