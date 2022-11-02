<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\PGCentralised;
use App\Models\PGProgram;
use Illuminate\Http\Request;
// use App\Models\PGCentralised;
use App\Models\Programs;
use App\Models\Staff;
use Illuminate\Support\Facades\DB;

class PGCentralisedController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pgcentraliseds = DB::table('p_g_centraliseds')
        ->join('courses', 'courses.course_id', '=', 'p_g_centraliseds.course_id')
        ->join('staff', 'staff.staff_id', '=', 'p_g_centraliseds.staff_id')
        ->select('p_g_centraliseds.id', 'p_g_centraliseds.program_id', 'p_g_centraliseds.course_id', 'courses.course_name', 'p_g_centraliseds.staff_id', 'staff.staff_name', 'p_g_centraliseds.student_capacity', 'p_g_centraliseds.sections', 'p_g_centraliseds.deleted')
        ->orderBy('p_g_centraliseds.id', 'desc')
        ->where('p_g_centraliseds.deleted', 'no')
        ->get();

        return view('pgcentralised.view', ['pgcentraliseds'=>$pgcentraliseds]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate ([
            'programId' => 'required',
            'courseId' => 'required',
            'staffId' => 'required',
            'sections' => 'required',
            // 'assessmentType' => 'required',
            // 'booking_date' => 'required',
            // 'bookingslot' => 'required',
            'capacity' => 'required',
        ]);

        $sections1 = $request->sections;
        $sections2 = implode(' , ' , $sections1);

        $PGCentralised= new PGCentralised();
        $PGCentralised->course_id=$request->courseId;
        $PGCentralised->staff_id=$request->staffId;
        // $PGCentralised->booking_date=$request->booking_date;
        // $PGCentralised->booking_slot=$request->bookingslot;
        $PGCentralised->student_capacity=$request->capacity;
        $PGCentralised->created_at=today();
        $PGCentralised->updated_at=today();
        $PGCentralised->program_id=$request->programId;
        $PGCentralised->sections=$sections2;
        $PGCentralised->deleted='no';
        // $PGCentralised->assessment_type=$request->assessmentType;

        $PGCentralised->save();
        return redirect('PGCentralised-booking')->with('success', 'Data Sucessfully Saved!! Thank You.');

        // $PGCentralised = DB::table('centraliseds')
        // ->where('booking_date', $request->booking_date)
        // ->where('booking_slot', $request->bookingslot)
        // ->count();

        // if ($PGCentralised > 0) {
        //     return redirect('add_booking')->with('not success', 'Booking Date and Time Clash!! Please RE-TRY');
        // } else {
        //     $PGCentralised->save();
        //     return redirect('Decentralised-booking')->with('success', 'Data Sucessfully Saved!! Thank You.');
        // }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function dropmenuprogram()
    {
        $pgprograms['pgprograms'] = PGProgram::orderBy('program_id')->get(['program_id', 'program_name']);
        $staffs['staffs'] = Staff::orderBy('staff_name')->get(['staff_id', 'staff_name']);
        return view('pgcentralised.add', $pgprograms, $staffs);
    }

    public function fetchCourse(Request $request)
    {
        $courses['courses'] = Course::orderBy('course_id')
                                ->where('program_id', $request->program_id)
                                ->get(['course_id', 'course_name']);
        return response()->json($courses);
    }
}
