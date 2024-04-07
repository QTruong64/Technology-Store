<!-- breadcrumbs-area-start -->
<div class="breadcrumbs-area mb-70">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcrumbs-menu">
                    <ul>
                        <li><a href="{{ route('home.index') }}">Trang Chủ</a></li>
                        @if (isset($cate))
                            @if ($cate->parent_id != null)
                                @include('User.inc.li', ['cate' => $cate->ParentCateBe])
                                <li><a href="{{ route('home.show', $cate->slug) }}" class="active">{{ $cate->name }}</a>
                                </li>
                            @endif
                        @endif
                        <li><a href="#" class="{{ isset($sub) ? '' : 'active' }}">{{ $active }}</a></li>
                        @if (isset($sub))
                            <li><a href="#" class="active">{{ $sub }}</a></li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- breadcrumbs-area-end -->
