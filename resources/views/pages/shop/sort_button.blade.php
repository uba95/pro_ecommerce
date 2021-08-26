<li class="shop_sorting_button">
    <a href ='{{ route('shop.index',request()->except('page', 'sort', 'order') + ['sort' => $sort]) }}'>
        {{ ucwords($sort) }}
    </a>
</li>
