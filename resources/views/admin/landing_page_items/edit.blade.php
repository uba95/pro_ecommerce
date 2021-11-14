@extends('layouts.admin.index')


@section('admin_content')
<div class="container"><br><br><br><br><br><br>
    <div class="row justify-content-center">
        <div class="col-md-8">

            @if ($item->is_main_banner)
                @include('admin.landing_page_items.main_banner.edit')
            @endif
            @if ($item->is_banner_slider)
                @include('admin.landing_page_items.banner_slider.edit')
            @endif
            @if ($item->is_advert)
                @include('admin.landing_page_items.advert.edit')
            @endif

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
