@extends('layouts.home')

@section('section')
            <div class="col-lg-8 card p-0">
                <div class="card-header">Edit User</div>
                <div class="card-body">
                    <form method="POST" action="{{ route('home.update') }}" enctype="multipart/form-data">
                        @csrf @method('PUT')
                        <input type="hidden" name="id" value="true">
                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>
                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" value="{{  old('name') ?? current_user()->name }}"
                                name="name" required autocomplete="name" autofocus>

                                @error('name')
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="phone" class="col-md-4 col-form-label text-md-right">{{ __('Phone Number') }}</label>
                            <div class="col-md-6">
                                <input id="phone" type="text" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone') ?? current_user()->phone }}"
                                name="phone" required autocomplete="phone" autofocus>

                                @error('phone')
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>
                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" value="{{  old('email') ?? current_user()->email }}"
                                name="email" required autocomplete="email">

                                @error('email')
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="form-group row">
                            <label for="avatar" class="col-form-label col-md-4 text-md-right">Avatar</label>
                            <div class="col-md-4 " style="margin-left: 15px">
                                <input id="avatar" type="file" class="@error('avatar') 'is-invalid' @enderror custom-file-input" name="avatar" onchange="readURL(this)">

                                <label for="avatar" class="custom-file-label">
                                    Choose file...
                                </label>
                            </div>

                            <div class="input-group-append ml-2">
                                <img src="{{ current_user()->avatar }}" width= "40" height= "40">
                            </div>

                            @error('avatar')
                                <span class="invalid-feedback d-block" role="alert" style="margin: 10px auto">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
          
                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4 mg-l-auto">
                                <div class="form-layout-footer">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Update Account') }}
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
@endsection

@push('scripts')
<script type="text/javascript">
    function readURL(input){
    if (input.files) {
        $(input).parent().parent().find('img').remove();
        Array.from(input.files).forEach(function (file) {
        var reader = new FileReader();
        reader.onload = function (e) {
        $(input).parent().siblings('.input-group-append').append(`<img src="${e.target.result}" width= "40" height= "40">`)
        };
        reader.readAsDataURL(file);
        });
    }
    }
</script>
@endpush
