@extends('layouts.public')

@section('title', $agenda['title'])

@section('content')
<div class="max-w-4xl mx-auto px-6 py-12">

    <img 
        src="{{ $agenda['image'] }}" 
        alt="{{ $agenda['title'] }}"
        class="rounded-xl mb-8 w-full object-cover"
    >

    <div class="text-sm text-gray-400 mb-2">
        {{ $agenda['date'] }}
    </div>

    <h1 class="text-4xl font-bold mb-6">
        {{ $agenda['title'] }}
    </h1>

    <p class="text-gray-600 leading-relaxed">
        {{ $agenda['desc'] }}
    </p>

</div>
@endsection
