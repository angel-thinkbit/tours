@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Booking Details</h1>
    <div class="card">
        <div class="card-body">
            <h2>{{ $booking->tour->name }}</h2>
            <p>Start Date: {{ $booking->start_date }}</p>
            <p>End Date: {{ $booking->end_date }}</p>
        </div>
    </div>
    <div class="mt-3">
        <a href="{{ route('bookings.edit', ['booking' => $booking->id]) }}" class="btn btn-primary">Edit</a>
        <a href="{{ route('bookings.index') }}" class="btn btn-secondary">Back to List</a>
    </div>
</div>
@endsection
