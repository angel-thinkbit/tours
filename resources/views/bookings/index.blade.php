@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-6">
            <h1>Bookings</h1>
            <a href="{{ route('bookings.create') }}" class="btn btn-success mb-3">Add</a>
            
            @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
            @endif
        
            @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
            @endif
        </div>
        <div class="col-md-6 text-right">
        </div>
    </div>
    @if ($bookings->isEmpty())
        <p>No bookings available.</p>
    @else
    <form action="{{ route('bookings.multi-delete') }}" method="POST" onsubmit="return confirm('Are you sure you want to delete the selected bookings?')">
        @csrf
        <table class="table">
            <thead>
                <tr>
                    <th>
                        <input type="checkbox" id="select-all-checkbox">
                    </th>
                    <th>ID</th>
                    <th>Tour Name</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($bookings as $booking)
                    <tr>
                        <td>
                            <input type="checkbox" name="selected_bookings[]" value="{{ $booking->id }}">
                        </td>
                        <td>{{ $booking->id }}</td>
                        <td>{{ $booking->tour->name }}</td>
                        <td>{{ $booking->start_date }}</td>
                        <td>{{ $booking->end_date }}</td>
                        <td>
                            <a href="{{ route('bookings.show', ['booking' => $booking->id]) }}" class="btn btn-secondary">View</a>
                            <a href="{{ route('bookings.edit', ['booking' => $booking->id]) }}" class="btn btn-primary">Edit</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <button type="submit" id="delete-selected-btn" class="btn btn-danger" disabled>Delete Selected</button>
    </form>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Get the "Select All" checkbox, individual checkboxes, and the "Delete Selected" button
            const selectAllCheckbox = document.getElementById("select-all-checkbox");
            const individualCheckboxes = document.querySelectorAll("[name='selected_bookings[]']");
            const deleteSelectedButton = document.getElementById("delete-selected-btn");
            
            // Add a click event listener to the "Select All" checkbox
            selectAllCheckbox.addEventListener("click", function() {
                const isChecked = selectAllCheckbox.checked;
    
                // Set all individual checkboxes to the same checked status as the "Select All" checkbox
                individualCheckboxes.forEach(function(checkbox) {
                    checkbox.checked = isChecked;
                });
    
                // Enable or disable the "Delete Selected" button based on the checkbox selection
                if (isChecked) {
                    deleteSelectedButton.removeAttribute("disabled");
                } else {
                    deleteSelectedButton.setAttribute("disabled", "disabled");
                }
            });
    
            // Add click event listeners to individual checkboxes
            individualCheckboxes.forEach(function(checkbox) {
                checkbox.addEventListener("click", function() {
                    // Check if at least one checkbox is checked
                    const atLeastOneChecked = Array.from(individualCheckboxes).some(function(checkbox) {
                        return checkbox.checked;
                    });
    
                    // Enable or disable the "Delete Selected" button based on checkbox selections
                    if (atLeastOneChecked) {
                        deleteSelectedButton.removeAttribute("disabled");
                    } else {
                        deleteSelectedButton.setAttribute("disabled", "disabled");
                    }
                });
            });
        });
    </script>
    @endif
</div>
@endsection