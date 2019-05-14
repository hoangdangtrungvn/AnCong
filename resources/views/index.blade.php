@extends('layouts.user')
@section('content')
<!-- Site Main / Start -->
<main id="main" class="site-main container" role="main" style="display:block">

    <div id="primary" class="content-area column">

        <!-- Featured Content / Start -->
        <div id="featured-content" class="category-box clearfix">
            <div id="news-ticker" class="clearfix">
                <span class="text">@lang('user.featured'):</span>
                <ul class="news-list">
                    @foreach($featured_posts as $item)
                    <li class="news-item">
                        <a href="{{ route('post.show', $item->slug) }}" rel="bookmark">{{ $item->title }}</a> - <span class="entry-date">{{ $item->created_at->diffForHumans() }}</span>
                    </li>
                    
                    @endforeach
                </ul>
                <span class="headline-nav">
                    <a class="headline-prev" href="#"><i class="fa fa-angle-left"></i></a>
                    <a class="headline-next" href="#"><i class="fa fa-angle-right"></i></a>
                </span><!-- headline-nav -->
            </div><!-- .news-ticker -->
            <div id="camera-slideshow">
                @foreach ($slides as $item)
                <div data-src="{{ $item->image }}" data-link="{{ $item->url }}" data-target="_blank"></div>
                @endforeach
            </div>
        </div>
        <!-- Featured Content / End -->

        <!-- Content Block #1 / Start -->
        <section id="carousel-courses" class="category-box clearfix wow fadeInLeft">
            <h3 class="section-title">@lang('user.courses')</h3>
            <div class="jcarousel">
                <ul>
                    @foreach($course_types as $item)
                    <li>
                        <article class="hentry post">
                            <a href="{{ route('course_type.show', $item->slug) }}">
                                <img class="entry-thumbnail" src="{{ $item->image }}" alt="{{ $item->name }}" />
                            </a>
                            <h2 class="entry-title">
                                <a href="{{ route('course_type.show', $item->slug) }}">{{ $item->name }}</a>
                            </h2>
                        </article>
                    </li>
                    @endforeach
                </ul>
            </div><!-- .jcarousel -->
            <a href="#" class="jcarousel-control-prev"><i class="fa fa-angle-left"></i></a>
            <a href="#" class="jcarousel-control-next"><i class="fa fa-angle-right"></i></a>
        </section>
        <!-- Content Block #1 / End -->

        @foreach ($categories as $item)
        @if ($item->posts->count())
        <!-- Content Block #2 / Start -->
        <section class="content-block-2 category-box clearfix wow fadeInUp">
            <h3 class="section-title">
                <a href="{{ route('category.show', $item->slug) }}">{{ $item->name }}</a> <span class="see-all"><a href="{{ route('category.show', $item->slug) }}">@lang_l('user.read_more')</a></span>
            </h3>
            @php $posts = \App\Post::where('category_id', $item->id)->orderBy('created_at', 'desc')->take(5)->get()
            @endphp
            <ul>
                @foreach ($posts as $key => $val)
                @if ($key == 0)
                <li class="article-first">
                    <a href="{{ route('post.show', $val->slug) }}">
                        <img class="entry-thumbnail" src="{{ $val->image }}" alt="{{ $val->title }}" />
                    </a>
                    <h2 class="entry-title"><a href="{{ route('post.show', $val->slug) }}">{{ $val->title }}</a></h2>
                    <div class="entry-meta">
                        <span class="entry-date">{{ $val->created_at->format('d/m/Y - H:i:s') }}</span>
                    </div><!-- .entry-meta -->
                    <div class="entry-summary">
                        {{ str_limit($val->summary, $limit = 100, $end = '...') }}
                    </div><!-- .entry-summary -->
                    <div class="more-link">
                        <a href="{{ route('post.show', $val->slug) }}">@lang('user.more_link')</a>
                    </div><!-- .more-link -->
                </li><!-- .article-first -->
                @else
                <li class="article-list">
                    <a href="{{ route('post.show', $val->slug) }}">
                        <img class="entry-thumbnail" src="{{ $val->image }}" alt="{{ $val->title }}" style="width: 52px; height: 52px;" />
                    </a>
                    <h2 class="entry-title"><a href="{{ route('post.show', $val->slug) }}">{{ $val->title }}</a></h2>
                    <div class="entry-meta">
                        <span class="entry-date">{{ $val->created_at->format('d/m/Y - H:i:s') }}</span>
                    </div><!-- .entry-meta -->
                </li><!-- .article-list -->
                @endif
                @endforeach
            </ul>

        </section>
        <!-- Content Block #2 / End -->
        @endif
        @endforeach

        @include('user.shared.branches')

    </div>
    <!-- Primary / End -->

    <!-- Sidebar #2 / Start -->
    <div id="secondary" class="widget-area widget-primary sidebar2 column" role="complementary">

        @include('user.shared.widget_social')
        @include('user.shared.widget_register')
        @include('user.shared.widget_tabs')

    </div>
    <!-- Secondary / End -->

    <div class="clearfix"></div>
    <!-- Sidebar #2 / End -->

</main>
<!-- Site Main / End -->

@endsection

@section('script')
<script>
    $("#camera-slideshow").camera({
        height: '41%',
        time: 3000
    });

    new WOW().init();
</script>
@endsection