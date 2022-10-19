@extends('layouts.main')

@section('content')

<div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0"></h1>
          <a href="javascript:history.back()" class="btn btn-primary">< Back</a>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="home">Home</a></li>
            <li class="breadcrumb-item active">Edit Student</li>
          </ol>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->
<form action="{{ route ('addstudent.update', $student->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PATCH')

    <div class="col-md-12" >
        <div class="card card-primary">
            <div class="card-header">
            <h3 class="card-title">Edit Student</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form>
            <div class="card-body">
                <div class="form-group">
                <label for="studentId">Student ID</label>
                <input type="text" class="form-control" name="studentId" value="{{$student->student_id}}" disabled>
                </div>
                <div class="form-group">
                <label for="firstName">First Name</label>
                <input type="text" class="form-control" name="firstName" value="{{$student->first_name}}" required>
                </div>
                <div class="form-group">
                    <label for="lastName">Last Name</label>
                    <input type="text" class="form-control" name="lastName" value="{{$student->last_name}}" required>
                </div>
                <div class="form-group">
                    <label for="thesisTitle">Thesis Title</label>
                    <input type="text" class="form-control" name="thesisTitle" value="{{$student->thesis_title}}" required>
                </div>
                <div class="form-group">
                    <label for="thesis_submission_date_to_ajk">Thesis Submission to Admin</label>
                    <input type="date" class="form-control" style="width: 15%" name="thesis_submission_date_to_ajk" value="{{$student->thesis_submission_date_to_ajk}}" required>
                </div>
                <div class="form-group">
                    <label for="registrationDate">Registration Date</label>
                    <input type="date" class="form-control" style="width: 15%" name="registrationDate" value="{{$student->registration_date}}" required>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="text" class="form-control" name="email" value="{{$student->email}}" required>
                </div>
                <div class="form-group">
                    <label for="mobileNumber">Mobile No</label>
                    <input type="text" class="form-control" name="mobileNumber" value="{{$student->mobile_no}}" required>
                </div>
                <div class="form-group">
                    <label for="sv1">Supervisor 1</label>
                    <select name="sv1" class="form-control select2" style="width: 100%;">
                        @foreach ($students_supervisors as $student_supervisor)
                            @if($student_supervisor->sv_rank =='sv1')
                                <option value="{{$student_supervisor->staff_id}}" selected="selected">{{$student_supervisor->first_name}} {{$student_supervisor->last_name}}</option>
                            @endif
                        @endforeach

                        @foreach($supervisors as $supervisor)
                            <option value="{{$supervisor->staff_id}}">{{$supervisor->first_name}} {{$supervisor->last_name}}</option>
                        @endforeach
                      </select>
                </div>
                <div class="form-group">
                    <label for="sv2">Supervisor 2</label>
                    <select name="sv2" class="form-control select2" style="width: 100%;">
                        @foreach ($students_supervisors as $student_supervisor)
                            @if($student_supervisor->sv_rank =='sv2')
                                <option value="{{$student_supervisor->staff_id}}" selected="selected">{{$student_supervisor->first_name}} {{$student_supervisor->last_name}}</option>
                            @endif
                        @endforeach

                        @foreach($supervisors as $supervisor)
                            <option value="{{$supervisor->staff_id}}">{{$supervisor->first_name}} {{$supervisor->last_name}}</option>
                        @endforeach
                      </select>
                </div>
                <div class="form-group">
                    <label for="sv3">Supervisor 3</label>
                    <select name="sv3" class="form-control select2" style="width: 100%;">
                        @foreach ($students_supervisors as $student_supervisor)
                            @if($student_supervisor->sv_rank =='sv3')
                                <option value="{{$student_supervisor->staff_id}}" selected="selected">{{$student_supervisor->first_name}} {{$student_supervisor->last_name}}</option>
                            @endif
                        @endforeach

                        <option value=""></option> --}}
                        @foreach($supervisors as $supervisor)
                            <option value="{{$supervisor->staff_id}}">{{$supervisor->first_name}} {{$supervisor->last_name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="sv4">Supervisor 4</label>
                    <select name="sv4" class="form-control select2" style="width: 100%;">
                        @foreach ($students_supervisors as $student_supervisor)
                            @if($student_supervisor->sv_rank =='sv4')
                                <option value="{{$student_supervisor->staff_id}}" selected="selected">{{$student_supervisor->first_name}} {{$student_supervisor->last_name}}</option>
                            @endif
                        @endforeach

                        <option value=""></option>
                        @foreach($supervisors as $supervisor)
                            <option value="{{$supervisor->staff_id}}">{{$supervisor->first_name}} {{$supervisor->last_name}}</option>
                        @endforeach
                      </select>
                </div>
                <div class="form-group">
                    <label for="examiner1">Examiner 1</label>
                    <select name="examiner1" class="form-control select2" style="width: 100%;">
                        @foreach ($students_examiners as $student_examiner)
                            @if($student_examiner->examiner_rank =='examiner1')
                                <option value="{{$student_examiner->staff_id}}" selected="selected">{{$student_examiner->first_name}} {{$student_examiner->last_name}}</option>
                            @endif
                        @endforeach
                        @foreach($examiners as $examiner)
                            <option value="{{$examiner->staff_id}}">{{$examiner->first_name}} {{$examiner->last_name}}</option>
                        @endforeach
                      </select>
                </div>
                <div class="form-group">
                    <label for="examiner2">Examiner 2</label>
                    <select name="examiner2" class="form-control select2" style="width: 100%;">
                        @foreach ($students_examiners as $student_examiner)
                            @if($student_examiner->examiner_rank =='examiner2')
                                <option value="{{$student_examiner->staff_id}}" selected="selected">{{$student_examiner->first_name}} {{$student_examiner->last_name}}</option>
                            @endif
                        @endforeach
                        @foreach($examiners as $examiner)
                            <option value="{{$examiner->staff_id}}">{{$examiner->first_name}} {{$examiner->last_name}}</option>
                        @endforeach
                      </select>
                </div>
                <div class="form-group">
                    <label for="turnitin">Turnitin (Numbers Only)</label>
                    <input type="text" class="form-control" name="turnitin" value="{{$student->turnitin_report}}" required>
                </div>
                <div class="form-group">
                    <label for="publication">Publication</label>
                    <select name="publication" class="form-control select2" style="width: 100%;">
                        <option value="{{$student->publication}}" selected="selected">{{$student->publication}}</option>
                        <option>---------------------------------</option>
                        <option value="Yes">Yes</option>
                        <option value="No">No</option>
                        <option value="Others">Others</option>
                      </select>
                </div>
                <div class="form-group">
                    <label for="engLanguage">English Language</label>
                    <select name="engLanguage" class="form-control select2" style="width: 100%;">
                        <option value="{{$student->english}}" selected="selected">{{$student->english}}</option>
                        <option>---------------------------------</option>
                        <option value="Yes">Yes</option>
                        <option value="No">No</option>
                        <option value="Others">Others</option>
                      </select>
                </div>
                <div class="form-group">
                    <label for="malayLanguage">Malay Language</label>
                    <select name="malayLanguage" class="form-control select2" style="width: 100%;">
                        <option value="{{$student->malay}}" selected="selected">{{$student->malay}}</option>
                        <option>---------------------------------</option>
                        <option value="Yes">Yes</option>
                        <option value="No">No</option>
                        <option value="Others">Others</option>
                      </select>
                </div>

                <div class="form-group">
                    <label>File Upload (pdf file only)</label>
                </div>
                <div class="input-group">
                    <button type="button" class="btn btn-outline-success btn-sm"><a href="/uploadFiles/{{ $student->abstract_file }}" target="_blank">View Abstract</a></button>
                    &nbsp &nbsp &nbsp
                    <input type="file" class="form-group" name="uploadFile">
                </div>
            </div>
            <!-- /.card-body -->

            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Update Data</button>
            </div>
            </form>
        </div>
    </div>
</form>
@endsection
