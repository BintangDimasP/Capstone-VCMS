@extends('layouts.public')

@section('title', $news['title'])

@section('content')
<div class="max-w-4xl mx-auto px-6 py-12">

    <img src="{{ $news['image'] }}" class="rounded-xl mb-8 w-full">

    <div class="text-sm text-gray-400 mb-2">
        {{ $news['date'] }}
    </div>

    <h1 class="text-4xl font-bold mb-6">
        {{ $news['title'] }}
    </h1>

    <article class="prose max-w-none">
        {!! $news['desc'] !!}
    </article>

</div>
@endsection
