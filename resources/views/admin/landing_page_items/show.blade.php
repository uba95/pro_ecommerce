@extends('layouts.admin.index')
@section('admin_content')

  <div class="sl-mainpanel">
      <div class="sl-pagebody">
        @if ($item->is_main_banner)
            @include('admin.landing_page_items.main_banner.show')
        @endif
        @if ($item->is_banner_slider)
            @include('admin.landing_page_items.banner_slider.show')
        @endif
        @if ($item->is_advert)
            @include('admin.landing_page_items.advert.show')
        @endif
      </div>
  </div>
@endsection
