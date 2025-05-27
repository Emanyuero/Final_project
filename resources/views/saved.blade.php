@extends('layout.app')

@section('content')
<h1>Saved Jokes</h1>
@foreach($jokes as $j)
    <div class="card mt-2">
        <div class="card-body">
            @if($j->type == 'single')
                <p>{{ $j->joke }}</p>
            @else
                <p><strong>{{ $j->setup }}</strong></p>
                <p>{{ $j->delivery }}</p>
            @endif
        </div>
    </div>
@endforeach
@endsection
