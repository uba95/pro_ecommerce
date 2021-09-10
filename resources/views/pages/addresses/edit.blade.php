@extends('layouts.app.index')
@section('content')

        <div class="container py-5">
          <h3>Edit Address</h3>

          <div class="row mt-5">
            <div class="col-md-8 order-md-1">
              <form action="{{ route('addresses.update', $address->id) }}" method="POST" class="needs-validation" novalidate>
                @csrf @method('PUT')
                <div class="mb-3">
                  <label for="address">Alias</label>
                  <input type="text" name="alias" value="{{ $address->alias }}" class="form-control" id="address" placeholder="Home, Office, ect..." required>
                  <div class="invalid-feedback">
                    Please enter your alias.
                  </div>
                </div>

                <div class="mb-3">
                  <label for="address">Address</label>
                  <input type="text" name="address_1" value="{{ $address->address_1 }}" class="form-control" id="address" placeholder="1234 Main St" required>
                  <div class="invalid-feedback">
                    Please enter your address.
                  </div>
                </div>
    
                <div class="mb-3">
                  <label for="address2">Address 2 <span class="text-muted">(Optional)</span></label>
                  <input type="text" name="address_2" value="{{ $address->address_2 }}" class="form-control" id="address2" placeholder="Apartment or suite">
                </div>
    
                <div class="row">
                  <div class="col-md-5 mb-3">
                    <label for="country">Country</label>
                    <select name="country_id"  class="custom-select d-block w-100 ml-0" id="country" required>
                      <option value="">Choose...</option>
                      @foreach ($countries as $country)
                        <option value="{{ $country->id }}" {{ $country->id === $address->country->id ? 'selected' : ''}}>
                          {{ $country->name }}
                        </option>
                      @endforeach
                    </select>
                    <div class="invalid-feedback">
                      Please select a valid country.
                    </div>
                  </div>
                  <div class="col-md-3 mb-3">
                    <label for="city">City</label>
                    <input name="city" value="{{ $address->city }}" type="text" class="form-control" id="city" placeholder="" required>
                    <div class="invalid-feedback">
                        City required.
                    </div>
                  </div>
                  <div class="col-md-3 mb-3">
                    <label for="zip">Zip</label>
                    <input name="zip" value="{{ $address->zip }}" type="text" class="form-control" id="zip" placeholder="">
                  </div>
                  <div class="col-md-3 mb-3">
                    <label for="phone">Phone</label>
                    <input name="phone" value="{{ $address->phone }}" type="text" class="form-control" id="phone" placeholder="">
                  </div>  
                </div>
    

                <hr class="mb-4">
                <button class="btn btn-primary btn-lg btn-block" type="submit">Edit</button>
              </form>
            </div>
          </div>
        </div>

    @push('scripts') 

    <script>
        // Example starter JavaScript for disabling form submissions if there are invalid fields
        (function() {
          'use strict';
  
          window.addEventListener('load', function() {
            // Fetch all the forms we want to apply custom Bootstrap validation styles to
            var forms = document.getElementsByClassName('needs-validation');
  
            // Loop over them and prevent submission
            var validation = Array.prototype.filter.call(forms, function(form) {
              form.addEventListener('submit', function(event) {
                if (form.checkValidity() === false) {
                  event.preventDefault();
                  event.stopPropagation();
                }
                form.classList.add('was-validated');
              }, false);
            });
          }, false);
        })();
    </script>
  
    @endpush

@endsection