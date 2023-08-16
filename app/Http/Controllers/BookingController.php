<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBookingRequest;
use App\Http\Requests\UpdateBookingRequest;
use App\Models\Booking;
use App\Models\Tour;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $bookings = Booking::all();
        return view('bookings.index', compact('bookings'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $tours = Tour::all(); // Fetch all tours to populate the dropdown
        return view('bookings.create', compact('tours'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreBookingRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreBookingRequest $request)
    {
        try {
            // Create the booking with the validated data
            $booking = new Booking([
                'tour_id' => $request->input('tour_id'),
                'start_date' => $request->input('start_date'),
                'end_date' => $request->input('end_date'),
            ]);
            $booking->save();
    
            return redirect()->route('bookings.index')->with('success', 'Booking created successfully.');
        } catch (ValidationException $e) {
            return redirect()->route('bookings.create')->withErrors($e->validator->errors());
        } catch (\Exception $e) {
            return redirect()->route('bookings.create')->with('error', 'An error occurred. Please try again.');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Booking  $booking
     * @return \Illuminate\Http\Response
     */
    public function show(Booking $booking)
    {
        $booking = $booking->load('tour');

        return view('bookings.show', compact('booking'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Booking  $booking
     * @return \Illuminate\Http\Response
     */
    public function edit(Booking $booking)
    {
        $tours = Tour::all(); // Fetch all tours to populate the dropdown
        return view('bookings.edit', compact('booking', 'tours'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateBookingRequest  $request
     * @param  \App\Models\Booking  $booking
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateBookingRequest $request, Booking $booking)
    {
        try {
            // Update the booking with the validated data
            $booking->tour_id = $request->input('tour_id');
            $booking->start_date = $request->input('start_date');
            $booking->end_date = $request->input('end_date');
            $booking->save();
    
            return redirect()->route('bookings.index')->with('success', 'Booking updated successfully.');
        } catch (ValidationException $e) {
            return redirect()->route('bookings.edit', $booking->id)->withErrors($e->validator->errors());
        } catch (\Exception $e) {
            return redirect()->route('bookings.edit', $booking->id)->with('error', 'An error occurred. Please try again.');
        }
    }

    public function multiDelete(Request $request)
    {
        try {
            $bookingIds = $request->input('selected_bookings', []);
    
            Booking::whereIn('id', $bookingIds)->delete();
    
            return redirect()->route('bookings.index')->with('success', 'Selected bookings deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->route('bookings.index')->with('error', 'An error occurred. Please try again.');
        }
    }
}
