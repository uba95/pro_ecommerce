@extends('layouts.app.index')

@section('content')
    @push('styles')
        <link rel="stylesheet" type="text/css" href="{{ asset('frontend/styles/contact_styles.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('frontend/styles/contact_responsive.css') }}">
    @endpush
    <!-- Contact Info -->

	<div class="contact_info">
		<div class="container">
			<div class="row">
				<div class="col-lg-10 offset-lg-1">
					<div class="contact_info_container d-flex flex-lg-row flex-column justify-content-between align-items-between">

						<!-- Contact Item -->
						<div class="contact_info_item d-flex flex-row align-items-center justify-content-start">
							<div class="contact_info_image"><img src="{{ asset('frontend/images/contact_1.png') }}" alt=""></div>
							<div class="contact_info_content">
								<div class="contact_info_title">Phone</div>
								<div class="contact_info_text">{{  $site_settings->phone  }}</div>
							</div>
						</div>

						<!-- Contact Item -->
						<div class="contact_info_item d-flex flex-row align-items-center justify-content-start">
							<div class="contact_info_image"><img src="{{ asset('frontend/images/contact_2.png') }}" alt=""></div>
							<div class="contact_info_content">
								<div class="contact_info_title">Email</div>
								<div class="contact_info_text">{{  $site_settings->email  }}</div>
							</div>
						</div>

						<!-- Contact Item -->
						<div class="contact_info_item d-flex flex-row align-items-center justify-content-start">
							<div class="contact_info_image"><img src="{{ asset('frontend/images/contact_3.png') }}" alt=""></div>
							<div class="contact_info_content">
								<div class="contact_info_title">Address</div>
								<div class="contact_info_text">{{  $site_settings->address  }}</div>
							</div>
						</div>

					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- Contact Form -->

	<div class="contact_form">
		<div class="container">
			<div class="row">
				<div class="col-lg-10 offset-lg-1">
					<div class="contact_form_container">
						<div class="contact_form_title">Get in Touch</div>

                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li class="mg-t-10">{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

						<form action ='{{ route('contact.store') }}' method="POST" id="contact_form"> @csrf
							<div class="contact_form_inputs d-flex flex-md-row flex-column justify-content-between align-items-between">
								<input type="text" name="name" value="{{ old('name') }}" id="contact_form_name" class="contact_form_name input_field  @error('name') border border-danger @enderror" placeholder="Your name" required="required" data-error="Name is required.">
								<input type="text" name="email" value="{{ old('email') }}" id="contact_form_email" class="contact_form_email input_field @error('email') border border-danger @enderror" placeholder="Your email" required="required" data-error="Email is required.">
								<input type="text" name="phone" value="{{ old('phone') }}" id="contact_form_phone" class="contact_form_phone input_field @error('phone ') border border-danger @enderror" placeholder="Your phone number">
							</div>
							<div class="mb-4">
								<input type="text" name="subject" value="{{ old('subject') }}" class="input_field w-100 @error('subject') border border-danger @enderror" placeholder="Subject"  required="required">
							</div> 
							<div class="contact_form_text mb-2">
								<textarea id="contact_form_message" class="text_field contact_form_message @error('message') border border-danger @enderror" name="message" rows="4" placeholder="Message" required="required" data-error="Please, write us a message.">{{ old('message') }}</textarea>
							</div>
							<div class="d-inline-block @error('g-recaptcha-response') border border-danger @enderror">
								{!! NoCaptcha::display() !!}
							</div> 
							<div class="contact_form_button">
								<button type="submit" class="button contact_submit_button">Send Message</button>
							</div>
						</form>

					</div>
				</div>
			</div>
		</div>
		<div class="panel"></div>
	</div>

	<!-- Map -->

	<div class="contact_map">
		<div id="google_map" class="google_map">
			<div class="map_container">
				<div id="map"></div>
			</div>
		</div>
	</div>

	{!! NoCaptcha::renderJs() !!}
    @push('scripts')
        <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&key=AIzaSyCIwF204lFZg1y4kPSIhKaHEXMLYxxuMhA"></script>
        <script src="{{ asset('frontend/js/contact_custom.js')}}"></script>
    @endpush
@endsection
