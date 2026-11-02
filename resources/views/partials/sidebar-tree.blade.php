<li class="treeview {{ isActiveMenu('admin.'.$item->short_code.'.*') }}">
    <a href="#"><i class="fa {{ $item->icon ?? 'fa-folder' }}"></i> <span>{{ __($item->name) }}</span><span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span></a>
    <ul class="treeview-menu">
        @foreach($children as $child)
            @can($child->short_code . '.view')
                <li class="{{ isActiveMenu('admin.'.$child->short_code.'.*') }}">
                    <a href="{{ route('admin.'.$child->short_code.'.index') }}"><i class="fa fa-circle-o"></i> {{ __($child->name) }}</a>
                </li>
            @endcan
        @endforeach
    </ul>
</li>
