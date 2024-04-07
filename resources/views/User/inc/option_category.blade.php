@foreach ($item->ParentCate as $row)
    <option value="{{ $row->id }}"> {{ $text }} {{ $row->name }}</option>
    @if ($row->ParentCate->count() > 0)
        @include('User.inc.option_category', ['item' => $row, 'text' => $text .' '.'- -'])
    @endif
@endforeach
