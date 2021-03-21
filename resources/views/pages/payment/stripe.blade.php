@push('styles')
<script src="https://js.stripe.com/v3/"></script>
<style>
    /**
   * The CSS shown here will not be introduced in the Quickstart guide, but shows
   * how you can use CSS to style your Element's container.
   */
   .header{z-index: unset !important;}
   .modal{top: 10%; !important;}
   .modal-content {padding: 20px;}
  .StripeElement {
    box-sizing: border-box;
  
    height: 40px;
    width: 100%;
  
    padding: 10px 12px;
  
    border: 1px solid transparent;
    border-radius: 4px;
    background-color: white;
  
    box-shadow: 0 1px 3px 0 #e6ebf1;
    -webkit-transition: box-shadow 150ms ease;
    transition: box-shadow 150ms ease;
  }
  
  .StripeElement--focus {
    box-shadow: 0 1px 3px 0 #cfd7df;
  }
  
  .StripeElement--invalid {
    border-color: #fa755a;
  }
  
  .StripeElement--webkit-autofill {
    background-color: #fefde5 !important;
  }
  
  </style>
@endpush

<button type="button" class="btn text-white" data-toggle="modal" data-target=".bd-example-modal-lg" style="background-color: var(--purple)">
  <i class="fas fa-chevron-circle-right"></i>
  Pay With Stripe
</button>

<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <form id="payment-form" action="{{ route('payment.store') }}" method="post">
        @csrf
        <input type="hidden" name="payment_method"  value="stripe">
        <input type="hidden" name="rate_object_id"  value="{{ $shipment->rates[0]->object_id }}">
        <input type="hidden" name="billing_address"  value="{{ $addresses[0]->id}}">
        <input type="hidden" name="shipping_address"  value="{{ $addresses[0]->id}}">
        <div class="form-row">
          <label for="card-element">
            Credit or debit card
          </label>
          <div id="card-element">
            <!-- A Stripe Element will be inserted here. -->
          </div>
    
          <!-- Used to display form errors. -->
          <div id="card-errors" role="alert"></div>
        </div><br>
        <button class="btn text-white" style="background-color: var(--purple)">Pay Now</button>
      </form>
    </div>
  </div>
</div>

@push('scripts')
    <script>
    //   $(function name(params) {

    //     // $('#payment-form').append(``);
    //   })
    // </script>
    <script type="text/javascript">
   
    // Create a Stripe client.
    var stripe = Stripe("{!! env('STRIPE_KEY') !!}");
    
    // Create an instance of Elements.
    var elements = stripe.elements();
    
    // Custom styling can be passed to options when creating an Element.
    // (Note that this demo uses a wider set of styles than the guide below.)
    var style = {
      base: {
        color: '#32325d',
        fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
        fontSmoothing: 'antialiased',
        fontSize: '16px',
        '::placeholder': {
          color: '#aab7c4'
        }
      },
      invalid: {
        color: '#fa755a',
        iconColor: '#fa755a'
      }
    };
    
    // Create an instance of the card Element.
    var card = elements.create('card', {style: style});
    
    // Add an instance of the card Element into the `card-element` <div>.
    card.mount('#card-element');
    
    // Handle real-time validation errors from the card Element.
    card.addEventListener('change', function(event) {
      var displayError = document.getElementById('card-errors');
      if (event.error) {
        displayError.textContent = event.error.message;
      } else {
        displayError.textContent = '';
      }
    });
    
    // Handle form submission.
    var form = document.getElementById('payment-form');
    form.addEventListener('submit', function(event) {
      event.preventDefault();
    
      stripe.createToken(card).then(function(result) {
        if (result.error) {
          // Inform the user if there was an error.
          var errorElement = document.getElementById('card-errors');
          errorElement.textContent = result.error.message;
        } else {
          // Send the token to your server.
          stripeTokenHandler(result.token);
        }
      });
    });
    
    // Submit the form with the token ID.
    function stripeTokenHandler(token) {
      // Insert the token ID into the form so it gets submitted to the server
      var form = document.getElementById('payment-form');
      var hiddenInput = document.createElement('input');
      hiddenInput.setAttribute('type', 'hidden');
      hiddenInput.setAttribute('name', 'stripeToken');
      hiddenInput.setAttribute('value', token.id);
      form.appendChild(hiddenInput);
    
      // Submit the form
      form.submit();
    }
    
    
    </script>
@endpush