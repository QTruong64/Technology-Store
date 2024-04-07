@extends('LayoutUser')
@section('content')
    @include('User.inc.area', ['active' => 'Bài Viết', 'sub' => $post->name ?? ''])
    <!-- blog-main-area-start -->
    <div class="blog-main-area mb-70">
        <div class="container">
            <div class="row">
                @include('User.inc.left_post')
                <div class="col-lg-9 col-md-12 col-12 order-lg-2 order-1">
                    <div class="blog-main-wrapper">
                        <div class="author-destils mb-30">
                            <div class="author-left">
                                <div class="author-img">
                                    <a href="#"><img
                                            src="https://lzd-img-global.slatic.net/g/p/c60f0628bbf9ff1b2a30cc0e3aa0bdab.jpg_720x720q80.jpg"
                                            alt="man" /></a>
                                </div>
                                <div class="author-description">
                                    <p>Đăng bởi:
                                        <a href="#"><span>{{ $post->PostToUser->name }}</span></a>
                                    </p>
                                    <span>{{ $post->created_at->format('M d Y') }}</span>
                                </div>
                            </div>
                            <div class="author-right">
                                <span>Chia sẻ:</span>
                                <ul>
                                    <li><a href="#"><i class="fa fa-facebook"></i></a></li>
                                    <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                                    <li><a href="#"><i class="fa fa-dribbble"></i></a></li>
                                    <li><a href="#"><i class="fa fa-google-plus"></i></a></li>
                                    <li><a href="#"><i class="fa fa-instagram"></i></a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="blog-img mb-30">
                            <img src="{{ asset('uploads/baiviet/' . $post->image) }}" alt="blog" />
                        </div>
                        <div class="single-blog-content">
                            <div class="single-blog-title">
                                <h3>{{ $post->name }}</h3>
                            </div>
                            <div class="blog-single-content">
                                {!! $post->desc !!}
                            </div>
                        </div>
                        <style>
                            .tag-text {
                                color: #333;
                                margin-bottom: 10px;
                                text-decoration: none;
                                font-size: 15px;
                                transition: .3s;
                                font-family: 'Rufina', serif;
                                font-weight: 400;
                            }

                            .tag_text:hover {
                                color: #00abe0;
                            }
                        </style>
                        <div class="comment-tag">
                            <p>
                                02 Bình luận
                                @if (isset($post->PostToPostTags))
                                    @php
                                        $last = $post->PostToPostTags->last();
                                    @endphp
                                    /Tags:
                                    @foreach ($post->PostToPostTags as $key => $row)
                                        <a class="tag-text"
                                            href="{{ route('shared.show', $row->PostTagToTag) }}">{{ $row->PostTagToTag->name }}</a>{{ $row->id == $last->id ? '.' : ', ' }}
                                    @endforeach
                                @endif
                            </p>
                        </div>
                        <div class="sharing-post mt-20">
                            <div class="share-text">
                                <span>Chia sẻ bài đăng này</span>
                            </div>
                            <div class="share-icon">
                                <ul>
                                    <li><a href="#"><i class="fa fa-facebook"></i></a></li>
                                    <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                                    <li><a href="#"><i class="fa fa-dribbble"></i></a></li>
                                    <li><a href="#"><i class="fa fa-google-plus"></i></a></li>
                                    <li><a href="#"><i class="fa fa-instagram"></i></a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="comment-title-wrap mt-30">
                            <h3>02 BÌNH LUẬN</h3>
                        </div>
                        <div class="comment-reply-wrap mt-50">
                            <ul>
                                <li>
                                    <div class="public-comment">
                                        <div class="comment-img">
                                            <a href="#"><img
                                                    src="https://i.pinimg.com/236x/65/f6/9e/65f69e531f37a58d6a169cfdc1460357.jpg"
                                                    alt="man" /></a>
                                        </div>
                                        <div class="public-text">
                                            <div class="single-comm-top">
                                                <a href="#">Pipj Moriarty</a>
                                                <p>{{ now()->locale('vi')->format('M \\, Y \\a\\t h:i A') }}<a href="#">Trả lời</a>
                                                </p>
                                            </div>
                                            <p>Tôi đã không suy nghĩ nhiều về cách tạo các mục
                                                blog của riêng mình để khuyến khích phản hồi. Tuy nhiên, mục tiêu là thu hút
                                                người theo dõi và phát triển tương tác nên điều này hoàn toàn hợp lý. Tôi
                                                chắc chắn sẽ kết hợp một số gợi ý này vào các bài viết trong tương lai của
                                                mình.
                                            </p>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="public-comment public-comment-2">
                                        <div class="comment-img">
                                            <a href="#"><img
                                                    src="https://i.pinimg.com/236x/65/f6/9e/65f69e531f37a58d6a169cfdc1460357.jpg"
                                                    alt="man" /></a>
                                        </div>
                                        <div class="public-text">
                                            <div class="single-comm-top">
                                                <a href="#">Pipj Moriarty</a>
                                                <p>{{ now()->locale('vi')->format('M \\, Y \\a\\t h:i A') }}<a href="#">Trả lời</a></p>
                                            </div>
                                            <p>Ồ</p>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                        <div class="comment-title-wrap mt-30">
                            <h3>ĐỂ LẠI BÌNH LUẬN </h3>
                        </div>
                        <div class="comment-input mt-40">
                            <p>Chúng tôi sẽ không công bố địa chỉ email của bạn. Các trường bắt buộc được đánh dấu*</p>
                            <div class="comment-input-textarea mb-30">
                                <form action="#">
                                    <label>Bình luận</label>
                                    <textarea name="massage" cols="30" rows="10" placeholder="Viết bình luận của bạn ở đây"></textarea>
                                </form>
                            </div>
                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                    <div class="single-comment-input mb-30">
                                        <form action="#">
                                            <label>Tên*</label>
                                            <input type="text" placeholder="Name" />
                                        </form>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                    <div class="single-comment-input mb-30">
                                        <form action="#">
                                            <label>Email*</label>
                                            <input type="text" placeholder="Email" />
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="single-post-button">
                            <a href="#">đăng bình luận</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- blog-main-area-end -->
@endsection
