@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit Tour</h1>

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

    <form action="{{ route('tours.update', ['tour' => $tour->id]) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="form-group mb-3">
            <label for="name">Name:</label>
            <input type="text" name="name" class="form-control" value="{{ old('name', $tour->name) }}" required>
        </div>
        <div class="form-group mb-3">
            <label for="logo">Logo:</label>
            <input type="file" name="logo" class="form-control-file">
            <img src="{{ asset($tour->logo) }}" alt="Logo" width="100" height="100">
        </div>
        <div class="form-group mb-3">
            <label for="start_date">Start Date:</label>
            <input type="date" name="start_date" class="form-control" value="{{ old('start_date', $tour->start_date) }}" required>
        </div>
        <div class="form-group mb-3">
            <label for="end_date">End Date:</label>
            <input type="date" name="end_date" class="form-control" value="{{ old('end_date', $tour->end_date) }}" required>
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-primary">Update</button>
            <a href="{{ route('tours.index') }}" class="btn btn-secondary">Back to List</a>
        </div>
    </form>
</div>
@endsection
