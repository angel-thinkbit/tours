<?php

namespace App\Http\Controllers;

use App\Models\Tour;
use App\Http\Requests\StoreTourRequest;
use App\Http\Requests\UpdateTourRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class TourController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tours = Tour::paginate(10);
        return view('tours.index', compact('tours'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('tours.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreTourRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTourRequest $request)
    {
        try {
            // Process and store the logo image
            $logoPath = $request->file('logo')->store('public/logos');
            $logoPath = str_replace('public', 'storage', $logoPath);

            // Create the tour with the validated data
            $tour = new Tour([
                'name' => $request->input('name'),
                'logo' => $logoPath,
                'start_date' => $request->input('start_date'),
                'end_date' => $request->input('end_date'),
            ]);
            $tour->save();

            return redirect()->route('tours.index')->with('success', 'Tour created successfully.');
        } catch (ValidationException $e) {
            return redirect()->route('tours.create')->withErrors($e->validator->errors());
        } catch (\Exception $e) {
            return redirect()->route('tours.create')->with('error', 'An error occurred. Please try again.');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Tour  $tour
     * @return \Illuminate\Http\Response
     */
    public function show(Tour $tour)
    {
        return view('tours.show', compact('tour'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Tour  $tour
     * @return \Illuminate\Http\Response
     */
    public function edit(Tour $tour)
    {
        return view('tours.edit', compact('tour'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateTourRequest  $request
     * @param  \App\Models\Tour  $tour
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTourRequest $request, Tour $tour)
    {
        try {
            // Update the tour's data
            $tour->name = $request->input('name');
            $tour->start_date = $request->input('start_date');
            $tour->end_date = $request->input('end_date');
    
            // Process and update the logo image if provided
            if ($request->hasFile('logo')) {
                $logoPath = $request->file('logo')->store('public/logos');
                $logoPath = str_replace('public', 'storage', $logoPath);
                $tour->logo = $logoPath;
            }
    
            // Save the updated tour
            $tour->save();
    
            return redirect()->route('tours.show', ['tour' => $tour->id])->with('success', 'Tour updated successfully.');
        } catch (ValidationException $e) {
            return redirect()->route('tours.edit', ['tour' => $tour->id])->withErrors($e->validator->errors());
        } catch (\Exception $e) {
            return redirect()->route('tours.edit', ['tour' => $tour->id])->with('error', 'An error occurred. Please try again.');
        }
    }

    public function multiDelete(Request $request)
    {
        $selectedTourIds = $request->input('selected_tours', []);

        try {
            $toursToDelete = Tour::whereIn('id', $selectedTourIds)->get();

            $toursWithBookings = collect();

            foreach ($toursToDelete as $tour) {
                // Check if there are associated bookings
                if ($tour->bookings()->exists()) {
                    $toursWithBookings->push($tour);
                } else {
                    // Delete the logo image from storage
                    if ($tour->logo) {
                        Storage::delete(str_replace('storage', 'public', $tour->logo));
                    }

                    $tour->delete();
                }
            }

            if ($toursWithBookings->count() > 0) {
                $tourNames = $toursWithBookings->pluck('name')->implode(', ');
                return redirect()->route('tours.index')->with('error', 'Cannot delete tours (' . $tourNames . ') because they have associated bookings.');
            } else {
                return redirect()->route('tours.index')->with('success', 'Selected tours deleted successfully.');
            }
        } catch (\Exception $e) {
            return redirect()->route('tours.index')->with('error', 'An error occurred while deleting the selected tours.');
        }
    }
}
