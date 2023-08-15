@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Tour Details</h1>
    <div class="card">
        <div class="card-body">
            <h2>{{ $tour->name }}</h2>
            <p>Start Date: {{ $tour->start_date }}</p>
            <p>End Date: {{ $tour->end_date }}</p>
            <img src="{{ asset($tour->logo) }}" alt="Logo" width="100" height="100">
        </div>
    </div>
    <div class="mt-3">
        <a href="{{ route('tours.edit', ['tour' => $tour->id]) }}" class="btn btn-primary">Edit</a>
        <a href="{{ route('tours.index') }}" class="btn btn-secondary">Back to List</a>
    </div>
</div>
@endsection
