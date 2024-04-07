<nav class="menu">
    <ul>
        @foreach ($categoriesParent as $item)
            <li class="cr-dropdown">
                <a href="{{ route('home.show',$item->slug) }}">{{ $item->name }}
                    @if ($item->ParentCate->count() > 0)
                        <i class="none-lg fa fa-angle-down"></i>
                        <i class="none-sm fa fa-angle-right"></i>
                    @endif
                </a>
                @if ($item->ParentCate->count() > 0)
                    <div class="left-menu">
                        @include('User.inc.child_menu_inc', ['item' => $item, 'class' => 0])
                    </div>
                @endif
            </li>
        @endforeach
        @foreach ($categoriesNext as $item)
            <li class="rx-child">
                <a href="{{ route('home.show',$item->slug) }}">{{ $item->name }}
                    @if ($item->ParentCate->count() > 0)
                        <i class="none-lg fa fa-angle-down"></i>
                        <i class="none-sm fa fa-angle-right"></i>
                    @endif
                </a>
                @if ($item->ParentCate->count() > 0)
                    <div class="left-menu">
                        @include('User.inc.child_menu_inc', ['item' => $item, 'class' => 0])
                    </div>
                @endif
            </li>
        @endforeach
        <li class="rx-parent">
            <a class="rx-default">
                <span class="cat-thumb fa fa-plus"></span> xem thêm
            </a>
            <a class="rx-show">
                <span class="cat-thumb fa fa-minus"></span> đóng
            </a>
        </li>
    </ul>
</nav>
