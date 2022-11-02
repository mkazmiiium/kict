<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\PGDecentralised;
use App\Models\PGProgram;
use Illuminate\Http\Request;
// use App\Models\PGDecentralised;
use Illuminate\Support\Facades\DB;
use App\Models\Programs;
use App\Models\Staff;
use Carbon\Carbon;

class PGDecentralisedController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pgdecentraliseds = DB::table('p_g_decentraliseds')
        ->join('courses', 'courses.course_id', '=', 'p_g_decentraliseds.course_id')
        ->join('staff', 'staff.staff_id', '=', 'p_g_decentraliseds.staff_id')
        ->select('p_g_decentraliseds.id', 'p_g_decentraliseds.program_id', 'p_g_decentraliseds.course_id', 'courses.course_name', 'p_g_decentraliseds.staff_id', 'staff.staff_name', 'p_g_decentraliseds.booking_date', 'p_g_decentraliseds.booking_slot', 'p_g_decentraliseds.student_capacity', 'p_g_decentraliseds.sections', 'p_g_decentraliseds.assessment_type', 'p_g_decentraliseds.assessment_time', 'p_g_decentraliseds.deleted')
        ->orderBy('p_g_decentraliseds.id', 'desc')
        ->where('p_g_decentraliseds.deleted', 'no')
        ->get();

        return view('pgdecentralised.view', ['pgdecentraliseds'=>$pgdecentraliseds]);
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
            'assessmentType' => 'required',
            'booking_date' => 'required',
            // 'bookingslot' => 'required',
            'capacity' => 'required',
            'inClass' => 'required',
        ]);

        $sections1 = $request->sections;
        $sections2 = implode(' , ' , $sections1);

        $date1 = $request->booking_date;
        $date2 = Carbon::parse($request->booking_date);

        // $inClass = $request->inClass;

        $PGDecentralised= new PGDecentralised();
        $PGDecentralised->course_id=$request->courseId;
        $PGDecentralised->staff_id=$request->staffId;
        // $PGDecentralised->booking_date=$request->booking_date;
        $PGDecentralised->booking_date=$date2;
        $PGDecentralised->booking_slot=$request->bookingslot;
        $PGDecentralised->student_capacity=$request->capacity;
        $PGDecentralised->created_at=today();
        $PGDecentralised->updated_at=today();
        $PGDecentralised->program_id=$request->programId;
        $PGDecentralised->sections=$sections2;
        $PGDecentralised->assessment_type=$request->assessmentType;
        $PGDecentralised->assessment_time=$request->inClass;
        $PGDecentralised->deleted='no';

        $PGDecentraliseds_count = DB::table('p_g_decentraliseds')
        ->where('booking_date', $date2)
        ->where('booking_slot', $request->bookingslot)
        ->where('deleted', 'no')
        ->count();

        if ($request->bookingslot == '') {
            $PGDecentralised->booking_slot='Class-Time';
            $PGDecentralised->save();
            return redirect('PGDecentralised-booking')->with('success', 'Data Sucessfully Saved!! Thank You.');
        } elseif ($PGDecentraliseds_count > 0) {
            return redirect('pg_addbooking')->with('not success', 'Booking Date and Time Clash with other Section !! Please RE-TRY');
        } else {
            $PGDecentralised->save();
            return redirect('PGDecentralised-booking')->with('success', 'Data Sucessfully Saved!! Thank You.');
        }
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
        return view('pgdecentralised.add', $pgprograms, $staffs);
    }

    public function fetchCourse(Request $request)
    {
        $courses['courses'] = Course::orderBy('course_id')
                                ->where('program_id', $request->program_id)
                                ->get(['course_id', 'course_name']);
        return response()->json($courses);
    }
}
