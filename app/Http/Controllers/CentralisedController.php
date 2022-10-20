<?php

namespace App\Http\Controllers;
use App\Models\Centralised;
use App\Models\Programs;
use App\Models\Staff;
use App\Models\Course;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CentralisedController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $centraliseds = DB::table('centraliseds')
        ->join('courses', 'courses.course_id', '=', 'centraliseds.course_id')
        ->join('staff', 'staff.staff_id', '=', 'centraliseds.staff_id')
        ->select('centraliseds.id', 'centraliseds.program_id', 'centraliseds.course_id', 'courses.course_name', 'centraliseds.staff_id', 'staff.staff_name', 'centraliseds.student_capacity', 'centraliseds.sections')
        ->orderBy('centraliseds.id', 'desc')
        ->get();

        return view('centralised.view', ['centraliseds'=>$centraliseds]);
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

        $centralised= new Centralised();
        $centralised->course_id=$request->courseId;
        $centralised->staff_id=$request->staffId;
        // $centralised->booking_date=$request->booking_date;
        // $centralised->booking_slot=$request->bookingslot;
        $centralised->student_capacity=$request->capacity;
        $centralised->created_at=today();
        $centralised->updated_at=today();
        $centralised->program_id=$request->programId;
        $centralised->sections=$sections2;
        // $centralised->assessment_type=$request->assessmentType;

        $centralised->save();
        return redirect('Centralised-booking')->with('success', 'Data Sucessfully Saved!! Thank You.');

        // $centraliseds_count = DB::table('centraliseds')
        // ->where('booking_date', $request->booking_date)
        // ->where('booking_slot', $request->bookingslot)
        // ->count();

        // if ($centraliseds_count > 0) {
        //     return redirect('add_booking')->with('not success', 'Booking Date and Time Clash!! Please RE-TRY');
        // } else {
        //     $decentralised->save();
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
        // $courses = Course::orderBy('course_id')->get();
        // $staffs = Staff::orderBy('staff_id')->get();
        // return view ('decentralised.add')->with(compact('courses', 'staffs'));

        // $programs = DB::table('programs')->pluck('program_id','program_name');
        // return view('decentralised.add',compact('programs'));

        $programs['programs'] = Programs::orderBy('program_id')->get(['program_id', 'program_name']);
        $staffs['staffs'] = Staff::orderBy('staff_name')->get(['staff_id', 'staff_name']);
        // $staffs = Staff::orderBy('staff_id')->get();
        // return view ('decentralised.add')->with(compact('programs', 'staffs'));
        return view('centralised.add', $programs, $staffs);
    }

    // public function dropmenucourse($id)
    // {
    //     // $courses = Course::orderBy('course_id')->get();
    //     // $staffs = Staff::orderBy('staff_id')->get();
    //     // return view ('decentralised.add')->with(compact('courses', 'staffs'));

    //     $courses = DB::table("courses")
    //     ->where("course_id",$id)
    //     ->pluck('course_id','course_name');
    //     return json_encode($courses);
    // }

    public function fetchCourse(Request $request)
    {
        $courses['courses'] = Course::orderBy('course_id')
                                ->where('program_id', $request->program_id)
                                ->get(['course_id', 'course_name']);
        return response()->json($courses);
    }
}
