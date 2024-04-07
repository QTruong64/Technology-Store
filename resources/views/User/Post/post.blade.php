@extends('LayoutUser')
@section('content')
    @include('User.inc.area', ['active' => 'Bài Viết'])
    <!-- blog-main-area-start -->
    <div class="blog-main-area mb-70">
        <div class="container">
            <div class="row">
                @include('User.inc.left_post')
                <div class="col-lg-9 col-md-12 col-12 order-lg-2 order-1">
                    <div class="blog-main-wrapper">
                        @if ($posts->count() == 0)
                            @include('User.inc.not_found')
                        @endif
                        @foreach ($posts as $item)
                            <div class="single-blog-post">
                                <div class="author-destils mb-30">
                                    <div class="author-left">
                                        <div class="author-img">
                                            <a href="#"><img
                                                    src="https://lzd-img-global.slatic.net/g/p/c60f0628bbf9ff1b2a30cc0e3aa0bdab.jpg_720x720q80.jpg"
                                                    alt="man" /></a>
                                        </div>
                                        <div class="author-description">
                                            <p>Đăng bởi:
                                                <a href="#"><span>{{ $item->PostToUser->name }}</span></a>
                                            </p>
                                            <span>{{ $item->created_at->format('M d Y') }}</span>
                                        </div>
                                    </div>
                                    <div class="author-right">
                                        <span>Chia sẻ:</span>
                                        <ul>
                                            <li><a target="_bank" href="https://www.facebook.com/sharer/sharer.php?u={{ route('post.show', $item) }}"><i class="fa fa-facebook"></i></a></li>
                                            <li><a target="_bank" href="#"><i class="fa fa-twitter"></i></a></li>
                                            <li><a target="_bank" href="#"><i class="fa fa-whatsapp"></i></a></li>
                                            <li><a target="_bank" href="#"><i class="fa fa-linkedin"></i></a></li>
                                            <li><a target="_bank" href="#"><i class="fa fa-instagram"></i></a></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="blog-img mb-30">
                                    <a href="{{ route('post.show', $item) }}"><img
                                            src="{{ asset('uploads/baiviet/' . $item->image) }}" alt="blog" /></a>
                                </div>
                                <div class="single-blog-content">
                                    <div class="single-blog-title">
                                        <h3><a href="{{ route('post.show', $item) }}">{{ $item->name }}</a></h3>
                                    </div>
                                    <div class="blog-single-content">
                                        <p style="text-align: justify;"> {!! substr($item->short_desc, 0, 200) !!}
                                            {{ strlen($item->short_desc) > 200 ? '...' : '' }}</p>
                                    </div>
                                </div>
                                <div class="blog-comment-readmore">
                                    <div class="blog-readmore">
                                        <a href="{{ route('post.show', $item) }}">Đọc thêm<i
                                                class="fa fa-long-arrow-right"></i></a>
                                    </div>
                                    <div class="blog-com">
                                        <a href="#">2 bình luận</a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        {{--  <div class="blog-pagination text-center">
                            <ul>
                                <li><a href="#"><i class="fa fa-angle-left"></i></a></li>
                                <li class="active"><a href="#">1</a></li>
                                <li><a href="#">2</a></li>
                                <li><a href="#">3</a></li>
                                <li><a href="#">4</a></li>
                                <li><a href="#"><i class="fa fa-angle-right"></i></a></li>
                            </ul>
                        </div>  --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- blog-main-area-end -->
@endsection
