@extends('layouts.admin.index')


@section('admin_content')
<div class="container"><br><br><br><br><br><br>
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Add New Advert</div>
                <div class="card-body">
                    @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li class="mg-t-10"><strong>{{ $error }}</strong></li>
                            @endforeach
                        </ul>
                    </div>
                  @endif
            
                    <form method="POST" action="{{ route('admin.landing_page_items.store') }}" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="is_advert" value="1">

                        <div class="form-group row">
                            <label for="advert_headline" class="col-md-2 col-form-label text-md-right">{{ __('Headline') }}</label>
                            <div class="col-md-10">
                                <input name="advert_headline" type="text" class="form-control" value="{{ old('advert_headline') }}">
                                @error('advert_headline')
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <!-- col-4 -->
                        <div class="form-group row">
                            <label for="advert_text" class="col-md-2 col-form-label text-md-right">{{ __('Text') }}</label>

                            <div class="col-md-10">
                                <textarea name="advert_text" class="form-control">{{ old('advert_text') }}</textarea>
                                @error('advert_text')
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div><!-- col-4 -->
          
                        <div class="form-group row">
                            <label for="advert_img" class="col-form-label col-md-2 text-md-right">Image</label>
                            <div class="col-md-6" style="align-items: center; justify-content: space-between; display: flex;">
                                <label id="advert_img" class="custom-file">
                                    <input type="file" class="custom-file-input" name="advert_img" onchange="readURL(this)">
                                    <span class="custom-file-control"></span>
                                </label>
                            </div>
                            @error('advert_img')
                                <span class="invalid-feedback d-block px-3" role="alert" style="margin-left: 16.6667%">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group row">
                            <div class="col-lg-4" style="margin-left: 16.6667%">
                                <label class="ckbox">
                                    <input name="status" type="checkbox" value="active" checked>
                                    <span>Active</span>
                                </label>
                            </div><!-- col-4 -->
                        </div>
            
          
                        <div class="form-group row mb-0">
                            <div class="col-md-8" style="margin-left: 16.6667%">
                                <div class="form-layout-footer">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Add Advert') }}
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
    @push('scripts')
        <script type="text/javascript">
            function readURL(input){
            if (input.files) {
                $(input).parent().siblings('img').remove();
                Array.from(input.files).forEach(function (file) {
                var reader = new FileReader();
                reader.onload = function (e) {
                $(input).parent().parent().append(`<img src="${e.target.result}" width= "40" height= "40">`)
                };
                reader.readAsDataURL(file);
                });
            }
            }
        </script>
    @endpush

@endsection
