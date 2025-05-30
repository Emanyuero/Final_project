@extends('layout.app')

@section('content')
<div class="text-center">
    <h1 class="display-5 mb-4">🔍 Search Saved Jokes</h1>

    <!-- Back Button -->
    <a href="{{ route('home') }}" class="btn btn-secondary mb-4">Back to Home</a>

    <form method="GET" action="{{ route('jokes.search') }}" class="mb-4 d-flex justify-content-center">
        <div class="input-group" style="max-width: 600px; width: 100%;">
            <input
                type="text"
                name="query"
                class="form-control"
                placeholder="Search for a joke..."
                value="{{ $query ?? '' }}"
                aria-label="Search for a joke"
            >
            <button class="btn btn-primary" type="submit">Search</button>
        </div>
    </form>

    @if(isset($jokes) && $jokes->count())
        @foreach($jokes as $joke)
            <div class="card mb-3 p-3 text-start mx-auto" style="max-width: 600px;">
                @if($joke->type === 'single')
                    <p>{{ $joke->joke }}</p>
                @else
                    <p><strong>{{ $joke->setup }}</strong></p>
                    <p>{{ $joke->delivery }}</p>
                @endif
            </div>
        @endforeach

        <div class="mt-4">
            {{ $jokes->withQueryString()->links() }}
        </div>
    @else
        <p>No jokes found.</p>
    @endif
</div>
@endsection
