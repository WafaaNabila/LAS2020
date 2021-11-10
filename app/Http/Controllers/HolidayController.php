<?php

namespace App\Http\Controllers;

use App\Http\Requests\HolidayPostRequest;
use App\Models\Holiday;

class HolidayController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $holidays       = Holiday::paginate(10);
        $holidays_count = $holidays->count();

        return view('holiday.holiday_list', compact('holidays', 'holidays_count'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('holiday.holiday_add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(HolidayPostRequest $request)
    {
        $holiday                = new Holiday();
        $holiday->holiday_name  = $request->get('holiday_name');
        $holiday->holiday_date  = $request->get('holiday_date');

        $holiday->save();

        return redirect()->route('holiday.create')->with('success' , 'Holiday added.');
    }

    /**
     * Display the specified resource.
     *
     * @param  App\Models\Holiday $holiday
     * @return \Illuminate\Http\Response
     */
    public function show($holiday)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  App\Models\Holiday $holiday
     * @return \Illuminate\Http\Response
     */
    public function edit($holiday)
    {
        return view('holiday.holiday_edit' , compact('holiday'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  App\Models\Holiday $holiday
     * @return \Illuminate\Http\Response
     */
    public function update(HolidayPostRequest $request, $holiday)
    {
        $holiday->holiday_name  = $request->get('holiday_name');
        $holiday->holiday_date  = $request->get('holiday_date');

        $holiday->save();

        return redirect()->route('holiday.index')->with('success', 'Holiday Updated.');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  App\Models\Holiday $holiday
     * @return \Illuminate\Http\Response
     */
    public function destroy($holiday)
    {
        $holiday->delete();

        return redirect()->route('holiday.index')->with('error', 'Holiday Deleted.');
    }
}
