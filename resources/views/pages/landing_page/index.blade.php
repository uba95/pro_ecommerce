@extends('layouts.app.index')
@section('content')
    
    @include('pages.landing_page.main_banner')

    <!-- Characteristics -->
    @include('pages.landing_page.characteristics')

    <!-- Deals of the week -->
    @include('pages.landing_page.deals_featured')

    <!-- Popular Categories -->
    @include('pages.landing_page.popular_categories')

    <!-- Banner -->
    @include('pages.landing_page.banner_slider')

    <!-- Hot New Arrivals -->
    @include('pages.landing_page.new_arrivals')

    <!-- Best Sellers -->
    @include('pages.landing_page.discounts')

    <!-- Adverts -->
    @include('pages.landing_page.adverts')

    <!-- Trends -->
    @include('pages.landing_page.trends')

    <!-- Reviews -->
    @include('pages.landing_page.reviews')

    <!-- Recently Viewed -->
    @include('layouts.recently_viewed')

    <!-- Brands -->
    @include('pages.landing_page.brands')

    <!-- Newsletter -->
    @include('pages.landing_page.newsletter')

@endsection