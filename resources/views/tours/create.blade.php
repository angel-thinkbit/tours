@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Create Tour</h1>

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

    <form action="{{ route('tours.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group mb-3">
            <label for="name">Name:</label>
            <input type="text" name="name" class="form-control" required value="{{ old('name') }}">
        </div>
        <div class="form-group mb-3">
            <label for="logo">Logo:</label>
            <input type="file" name="logo" class="form-control-file" required>
        </div>
        <div class="form-group mb-3">
            <label for="start_date">Start Date:</label>
            <input type="date" name="start_date" class="form-control" required value="{{ old('start_date') }}">
        </div>
        <div class="form-group mb-3">
            <label for="end_date">End Date:</label>
            <input type="date" name="end_date" class="form-control" required value="{{ old('end_date') }}">
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-primary">Create</button>
            <a href="{{ route('tours.index') }}" class="btn btn-secondary">Back to List</a>
        </div>
    </form>
</div>
@endsection
