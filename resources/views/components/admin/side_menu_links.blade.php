<a href="#" class="sl-menu-link">
  <div class="sl-menu-item">
    {{ $icon }}
    <span class="menu-item-label">{{ $title }}</span>
    <i class="menu-item-arrow fa fa-angle-down"></i>
  </div><!-- menu-item -->
</a><!-- sl-menu-link -->
<ul class="sl-menu-sub nav flex-column">
  {{ $slot }}
</ul>