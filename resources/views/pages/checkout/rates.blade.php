@foreach($shipment->rates as $rate)
<li class="col-md-6 mb-3">
    <label class="radio">
        <input type="radio" name="rate"
         data-amount="{{ $rate->amount }}" 
         data-provider="{{ $rate->servicelevel->name . ' ' . $rate->provider }}" 
         data-days="{{ $rate->estimated_days }}" 
         value="{{ $rate->object_id }}" 
         class="font-weight-bold" 
         {{ $loop->first ? 'checked' : '' }}>

    </label>
    <img src="{{ $rate->provider_image_75 }}" alt="courier" class="img-thumbnail" />
    <strong> {{ $rate->currency }} {{ $rate->amount }} <br></strong>
    <span>{{ $rate->servicelevel->name . ' ' . $rate->provider}}</span> <br>
    <strong> {{ $rate->estimated_days  }} days</strong>
</li>
@endforeach
