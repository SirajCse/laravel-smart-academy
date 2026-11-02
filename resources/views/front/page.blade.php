@extends('layouts.front')

@section('title', $page->title ?? __('Page'))

@section('content')
<div class="row">
    <div class="col-md-8">
        <article class="page-content">
            @if($page?->image)
                <img src="{{ fileUrl($page->image) }}" alt="{{ $page->title }}" class="img-responsive">
            @endif
            <h1>{{ $page?->title }}</h1>
            <div class="content">{!! $page?->description !!}</div>
        </article>
    </div>
    <div class="col-md-4">
        <div class="sidebar">
            <h3>{{ __('Quick Links') }}</h3>
            <ul>
                @foreach($menus ?? [] as $menu)
                    <li><a href="{{ $menu->page_id ? route('page.read', $menu->slug) : $menu->url }}">{{ $menu->title }}</a></li>
                @endforeach
            </ul>
        </div>
    </div>
</div>
@endsection
