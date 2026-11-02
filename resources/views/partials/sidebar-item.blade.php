<li class="{{ isActiveMenu('admin.'.$item->short_code.'.*') }}">
    <a href="{{ route('admin.'.$item->short_code.'.index') }}">
        <i class="fa {{ $item->icon ?? 'fa-circle-o' }}"></i>
        <span>{{ __($item->name) }}</span>
    </a>
</li>
