@if ($cate->parent_id != null)
    @include('User.inc.li', ['cate' => $cate->ParentCateBe])
@endif
<li><a href="{{ route('home.show',$cate->slug) }}" class="active">{{ $cate->name }}</a></li>
