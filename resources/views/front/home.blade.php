@extends('layouts.front')

@section('title', __('Home'))

@section('content')
<section class="hero">
    <div id="hero-carousel" class="carousel slide" data-ride="carousel">
        <div class="carousel-inner">
            @foreach($slides ?? [] as $i => $slide)
                <div class="item {{ $loop->first ? 'active' : '' }}">
                    <img src="{{ fileUrl($slide->image) }}" alt="{{ $slide->title }}">
                    <div class="carousel-caption">
                        <h2>{{ $slide->title }}</h2>
                        <p>{{ $slide->subtitle }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

<section class="about-us">
    <div class="row">
        <div class="col-md-6">
            <h2>{{ __('Welcome to') }} {{ $schoolName }}</h2>
            <p class="lead">{{ $welcomeText ?? __('A leading institution committed to excellence in education.') }}</p>
            <p>{{ __('Our school provides a nurturing environment where students learn, grow, and excel. With experienced faculty, modern facilities, and a holistic approach to education, we prepare students for a bright future.') }}</p>
            <a href="{{ route('page.admission') }}" class="btn btn-primary">{{ __('Apply for Admission') }}</a>
        </div>
        <div class="col-md-6">
            <img src="{{ asset('themes/'.$theme.'/img/about.jpg') }}" alt="About" class="img-responsive">
        </div>
    </div>
</section>

<section class="features">
    <div class="row">
        <div class="col-md-4">
            <div class="feature-box">
                <i class="fa fa-graduation-cap"></i>
                <h3>{{ __('Quality Education') }}</h3>
                <p>{{ __('Modern curriculum with experienced faculty.') }}</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="feature-box">
                <i class="fa fa-users"></i>
                <h3>{{ __('Co-curricular') }}</h3>
                <p>{{ __('Sports, arts, and cultural activities for all-round development.') }}</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="feature-box">
                <i class="fa fa-building"></i>
                <h3>{{ __('Modern Facilities') }}</h3>
                <p>{{ __('Well-equipped labs, library, and sports facilities.') }}</p>
            </div>
        </div>
    </div>
</section>

<section class="news-events">
    <h2 class="text-center">{{ __('Latest News & Events') }}</h2>
    <div class="row">
        @foreach($news ?? [] as $article)
            <div class="col-md-4">
                <div class="news-card">
                    <img src="{{ fileUrl($article->image) }}" alt="{{ $article->title }}">
                    <h3>{{ $article->title }}</h3>
                    <p>{{ \Str::limit($article->description, 100) }}</p>
                    <a href="{{ route('news.show', $article) }}" class="btn btn-info btn-sm">{{ __('Read More') }}</a>
                </div>
            </div>
        @endforeach
    </div>
</section>
@endsection
