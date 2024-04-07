@foreach ($item->ParentCate as $row)
    {!! $class == 0 ? '<span class="mb-30">' : '' !!}
    <a href="{{ route('home.show',$row->slug) }}" class="{{ $class == 0 ? 'title' : '' }}">{{ $row->name }}</a>
    @if ($row->ParentCate->count() > 0)
        @include('User.inc.child_menu_inc', ['item' => $row, 'class' => 1])
    @endif
    {!! $class == 0 ? '</span>' : '' !!}
@endforeach
