<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;
use App\Models\Decentralised;
use App\Models\Programs;
use App\Models\Staff;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DecentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $decentraliseds = Decentralised::orderBy('course_id')->simplePaginate(25);

        $decentraliseds = DB::table('decentraliseds')
        ->join('courses', 'courses.course_id', '=', 'decentraliseds.course_id')
        ->join('staff', 'staff.staff_id', '=', 'decentraliseds.staff_id')
        ->select('decentraliseds.id', 'decentraliseds.program_id', 'decentraliseds.course_id', 'courses.course_name', 'decentraliseds.staff_id', 'staff.staff_name', 'decentraliseds.booking_date', 'decentraliseds.booking_slot', 'decentraliseds.student_capacity', 'decentraliseds.sections', 'decentraliseds.assessment_type', 'decentraliseds.assessment_time')
        ->get();

        return view('decentralised.view', ['decentraliseds'=>$decentraliseds]);
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

        $decentralised= new Decentralised();
        $decentralised->course_id=$request->courseId;
        $decentralised->staff_id=$request->staffId;
        // $decentralised->booking_date=$request->booking_date;
        $decentralised->booking_date=$date2;
        $decentralised->booking_slot=$request->bookingslot;
        $decentralised->student_capacity=$request->capacity;
        $decentralised->created_at=today();
        $decentralised->updated_at=today();
        $decentralised->program_id=$request->programId;
        $decentralised->sections=$sections2;
        $decentralised->assessment_type=$request->assessmentType;
        $decentralised->assessment_time=$request->inClass;

        $decentraliseds_count = DB::table('decentraliseds')
        ->where('booking_date', $date2)
        ->where('booking_slot', $request->bookingslot)
        ->count();

        if ($request->bookingslot == '') {
            $decentralised->booking_slot='Class-Time';
            $decentralised->save();
            return redirect('Decentralised-booking')->with('success', 'Data Sucessfully Saved!! Thank You.');
        } elseif ($decentraliseds_count > 0) {
            return redirect('add_booking')->with('not success', 'Booking Date and Time Clash with other Section !! Please RE-TRY');
        } else {
            $decentralised->save();
            return redirect('Decentralised-booking')->with('success', 'Data Sucessfully Saved!! Thank You.');
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

    public function viewsearch(Request $request)
    {
        $decentraliseds = DB::table('decentraliseds')
        ->join('courses', 'courses.course_id', '=', 'decentraliseds.course_id')
        ->join('staff', 'staff.staff_id', '=', 'decentraliseds.staff_id')
        ->select('decentraliseds.id', 'decentraliseds.course_id', 'courses.course_name', 'decentraliseds.staff_id', 'staff.staff_name', 'decentraliseds.booking_date', 'decentraliseds.booking_slot', 'decentraliseds.student_capacity', 'decentraliseds.program_id', 'decentraliseds.sections', 'decentraliseds.assessment_type')
        ->where('decentraliseds.course_id', 'like', '%' .$request->search. '%')
        ->orwhere('courses.course_name', 'like', '%' .$request->search. '%')
        ->orwhere('staff.staff_id', 'like', '%' .$request->search. '%')
        ->orwhere('staff.staff_name', 'like', '%' .$request->search. '%')
        ->orwhere('decentraliseds.booking_slot', 'like', '%' .$request->search. '%')
        ->orderBy('decentraliseds.course_id')
        ->get();
        return view('decentralised.view', ['decentraliseds'=>$decentraliseds]);
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
        return view('decentralised.add', $programs, $staffs);
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
