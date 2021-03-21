<div class="col-md-8 order-md-1">
    <h4 class="mb-3"><i class="fas fa-paper-plane"></i> Billing Address</h4>
    <form class="needs-validation" novalidate>
      @foreach ($addresses as $address)
        <div class="custom-control custom-radio">
          <input id="{{'billing_address'.  $address->id }}" data-id = "{{ $address->id }}"  name="billing" type="radio" class="custom-control-input" required {{ $loop->first ? 'checked' : '' }} >
          <label class="custom-control-label text-muted font-weight-bold" style="word-spacing: 10px" for="{{'billing_address'.  $address->id }}">
            {{  ucwords($address->alias)}},
            {{  ucwords($address->address_1) }},
            {{  ucwords($address->address_2) }},
            {{  ucwords($address->city) }},
            {{  Str::title($address->country->name) }}
          </label>
        </div>
        @endforeach
    </form> 
    <div id="shipping_address" class="mt-3"  style="display: none">
      <hr class="my-3">

      <h4 class="mb-3"><i class="fas fa-plane"></i> Shipping Address</h4>
      <form class="needs-validation" novalidate>
        @foreach ($addresses as $address)
          <div class="custom-control custom-radio">
            <input id="{{'shipping_address_'.  $address->id }}" data-id = "{{ $address->id }}"  name="shipping" type="radio" class="custom-control-input" required {{ $loop->first ? 'checked' : '' }}>
            <label class="custom-control-label text-muted font-weight-bold" style="word-spacing: 10px" for="{{'shipping_address_'.  $address->id }}">
              {{  $address->alias }},
              {{  $address->address_1 }},
              {{  $address->address_2 }},
              {{  $address->city }},
              {{  $address->country->name }}
            </label>
          </div>
        @endforeach 
      </form>   
    </div>
