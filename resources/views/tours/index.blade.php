@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-6">
            <h1>Tours</h1>
            <a href="{{ route('tours.create') }}" class="btn btn-success mb-3">Add</a>
            
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
    @if ($tours->isEmpty())
        <p>No tours available.</p>
    @else
    <form action="{{ route('tours.multi-delete') }}" method="POST" onsubmit="return confirm('Are you sure you want to delete the selected tours?')">
        @csrf
        <table class="table">
            <thead>
                <tr>
                    <th>
                        <input type="checkbox" id="select-all-checkbox">
                    </th>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Logo</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($tours as $tour)
                    <tr>
                        <td>
                            <input type="checkbox" name="selected_tours[]" value="{{ $tour->id }}">
                        </td>
                        <td>{{ $tour->id }}</td>
                        <td>{{ $tour->name }}</td>
                        <td><img src="{{ $tour->logo }}" alt="Logo" width="100" height="100"></td>
                        <td>{{ $tour->start_date }}</td>
                        <td>{{ $tour->end_date }}</td>
                        <td>
                            <a href="{{ route('tours.show', ['tour' => $tour->id]) }}" class="btn btn-secondary">View</a>
                            <a href="{{ route('tours.edit', ['tour' => $tour->id]) }}" class="btn btn-primary">Edit</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div>
            {!! $tours->links() !!}
        </div>
        <button type="submit" id="delete-selected-btn" class="btn btn-danger" disabled>Delete Selected</button>
    </form>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Get the "Select All" checkbox, individual checkboxes, and the "Delete Selected" button
            const selectAllCheckbox = document.getElementById("select-all-checkbox");
            const individualCheckboxes = document.querySelectorAll("[name='selected_tours[]']");
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