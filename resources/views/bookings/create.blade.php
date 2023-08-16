@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Create Booking</h1>

    @if (session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if (session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('bookings.store') }}" method="POST">
        @csrf
        <div class="form-group mb-3">
            <label for="tour_id">Tour:</label>
            <select name="tour_id" class="form-control" required>
                @foreach ($tours as $tour)
                <option value="{{ $tour->id }}">{{ $tour->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group mb-3">
            <label for="start_date">Start Date:</label>
            <input type="date" name="start_date" class="form-control" required>
        </div>
        <div class="form-group mb-3">
            <label for="end_date">End Date:</label>
            <input type="date" name="end_date" class="form-control" required>
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-primary">Create</button>
            <a href="{{ route('bookings.index') }}" class="btn btn-secondary">Back to List</a>
        </div>
    </form>
</div>
@endsection
