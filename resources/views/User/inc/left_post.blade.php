<div class="col-lg-3 col-md-12 col-12 order-lg-1 order-2 mt-sm-50">
    <div class="single-blog mb-50">
        <div class="blog-left-title">
            <h3>TÌM KIẾM</h3>
        </div>
        <div class="side-form">
            <form action="#">
                <input type="text" placeholder="Search...." />
                <a href="#"><i class="fa fa-search"></i></a>
            </form>
        </div>
    </div>
    <div class="single-blog mb-50">
        <div class="blog-left-title">
            <h3>THỂ LOẠI</h3>
        </div>
        <div class="blog-side-menu">
            <ul>
                @foreach ($types as $item)
                    <li><a href="{{ route('post.show', ['id' => $item->id, 'slug' => Str::slug($item->name)]) }}">{{ $item->name }}
                            ({{ $item->TypeToPost->count() }})</a></li>
                @endforeach
            </ul>
        </div>
    </div>
    <div class="single-blog mb-50">
        <div class="blog-left-title">
            <h3>BÀI VIẾT GẦN ĐÂY</h3>
        </div>
        <div class="blog-side-menu">
            <ul>
                @foreach ($post_view as $item)
                    <li><a href="{{ route('post.show', $item) }}">{{ $item->name }}</a></li>
                @endforeach
            </ul>
        </div>
    </div>
    <div class="single-blog mb-50">
        <div class="blog-left-title">
            <h3>LƯU TRỮ</h3>
        </div>
        <div class="blog-side-menu">
            <ul>
                @foreach ($post_archive as $item)
                    <li><a href="{{ route('post.edit', $item->created_at->format('m')) }}"><i
                                class="fa fa-calendar-o"></i>{{ ucfirst($item->created_at->translatedFormat('F Y')) }}
                            ({{ $item->count }})
                        </a></li>
                @endforeach
            </ul>
        </div>
    </div>

    <div class="single-blog">
        <div class="blog-left-title">
            <h3>Tags</h3>
        </div>
        <div class="blog-tag">
            <ul>
                @foreach ($left_tags as $item)
                    <li><a href="{{ route('shared.show', $item) }}">{{ ucwords($item->name) }}</a></li>
                @endforeach
            </ul>
        </div>
    </div>
</div>
