@extends('layouts.main')
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0"></h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="/">Home</a></li>
                        <li class="breadcrumb-item active">Add Final Assessment Booking</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    <form action="addbooking" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="col-md-12">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Add New Final Assessment Booking</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form>
                    <div class="card-body">

                        <div class="form-group">
                            <label for="programId">Programme</label>
                            <select name="programId" id="program-dropdown" class="form-control select2" style="width: 100%"
                                required>
                                <option value="">-- Select Programme --</option>
                                @foreach ($programs as $program)
                                    <option value="{{ $program->program_id }}">
                                        {{ $program->program_name }} ({{ $program->program_id }})
                                    </option>
                                @endforeach
                            </select>

                        </div>

                        <div class="form-group">
                            <label for="courseId">Course Code</label>
                            <select name="courseId" id="courses-dropdown" class="form-control select2" style="width: 100%"
                                required>
                                <option value="">-- Select Course -- </option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="staffId">Staff Name</label>
                            <select name="staffId" class="form-control select2" style="width: 100%" required>
                                <option value="">-- Select Your Name --</option>
                                @foreach ($staffs as $staff)
                                    <option value="{{ $staff->staff_id }}"> {{ $staff->staff_name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="sections">Sections (Allow Multiple Sections)</label>
                            <select class="form-control select2" multiple id="sections" name ="sections[]" style="width: 50%" required>
                                {{-- <option value="All Sections">All Sections</option> --}}
                                <option value="Section 1">Section 1</option>
                                <option value="Section 2">Section 2</option>
                                <option value="Section 3">Section 3</option>
                                <option value="Section 4">Section 4</option>
                                <option value="Section 5">Section 5</option>
                                <option value="Section 6">Section 6</option>
                                <option value="Section 7">Section 7</option>
                                <option value="Section 8">Section 8</option>
                                <option value="Section 9">Section 9</option>
                                <option value="Section 10">Section 10</option>
                                <option value="Section 11">Section 11</option>
                                <option value="Section 12">Section 12</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="inClass">Assessment Time</label>
                            <select onchange="check()" name="inClass" id="inClass-dropdown" class="form-control select2" style="width: 50%"
                                required>
                                <option value="">-- Select Time --</option>
                                <option value="in-class">In Class Time</option>
                                <option value="outside-class">Outside Class Time</option>
                            </select>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Date</label>
                                <div class="input-group date" id="reservationdate" data-target-input="nearest">
                                    <input type="text" class="form-control datetimepicker-input" name="booking_date" runat="server" data-target="#reservationdate"/>
                                    <div class="input-group-append" data-target="#reservationdate" data-toggle="datetimepicker">
                                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="bookingslot">Booking Slot</label>
                            <select name="bookingslot" id="bookingslot1" class="form-control select2" style="width: 30%" disabled required>
                                <option value="">-- Select Time Slot -- </option>
                                <option value="9:00am - 1:00pm">9:00am - 1:00pm </option>
                                <option value="2:00pm - 5:00pm">2:00pm - 5:00pm</option>
                                <option value="5:00pm - 8:00pm">5:00pm - 8:00pm</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="assessmentType">Assessment Type</label>
                            <select name="assessmentType" class="form-control select2" style="width: 30%" required>
                                <option value="">-- Select Assessment Type -- </option>
                                <option value="Final Assessment - Decentralized Exam">Final Assessment - Decentralized Exam
                                </option>
                                <option value="Final Assessment - Test">Final Assessment - Test</option>
                                <option value="Final Assessment - Take Home">Final Assessment - Take Home</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="capacity">Number of Students</label>
                            <input type="number" max="400" class="form-control" style="width: 15%" name="capacity" required>
                        </div>

                    </div>
                    <!-- /.card-body -->

                    <div class="card-footer">
                        <a href="javascript:history.back()" class="btn btn-warning">
                            < Back</a>
                                <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </form>
@endsection


<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

<!-- JS & CSS library of MultiSelect plugin -->
<script src="{{asset('multiselect/jquery.multiselect.js')}}"></script>
<link rel="stylesheet" href="{{asset('multiselect/jquery.multiselect.css')}}">

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js" ></script>

<script>
    $(function () {
        $('#reservationdate').datetimepicker({
            format: 'L',
            dateFormat: 'yyyy-mm-dd',
            todayHighlight: true,
            minDate: new Date('2022-12-5'),
            maxDate: new Date('2023-1-26'),
            multidate: false,
            daysOfWeekHighlighted: "0, 5, 6",
            language: 'en',
            daysOfWeekDisabled: [0, 5, 6]
        });
    })

    function check(){
    if(document.getElementById('inClass-dropdown').value=='in-class')
        // document.getElementById('bookingslot1').value = "Class-Time";
        document.getElementById('bookingslot1').disabled=true;
    else
        document.getElementById('bookingslot1').disabled=false;
    }

    $(document).ready(function() {

        /*------------------------------------------
        --------------------------------------------
        Country Dropdown Change Event
        --------------------------------------------
        --------------------------------------------*/
        $('#program-dropdown').on('change', function() {
            var idProgram = this.value;
            $("#courses-dropdown").html('');
            $.ajax({
                url: "{{ url('api/fetch-course') }}",
                type: "POST",
                data: {
                    program_id: idProgram,
                    _token: '{{ csrf_token() }}'
                },
                dataType: 'json',
                success: function(result) {
                    $('#courses-dropdown').html(
                        '<option value="">-- Select Course --</option>');
                    $.each(result.courses, function(key, value) {
                        $("#courses-dropdown").append('<option value="' + value
                            .course_id + '">' + value.course_id + ' - ' + value
                            .course_name + '</option>');
                    });
                    $('#city-dropdown').html('<option value="">-- Select City --</option>');
                }
            });
        });

        $('#sections').multiselect({
            columns: 1,
            placeholder: 'Select Languages',
            search: true
        });

        /*------------------------------------------
        --------------------------------------------
        State Dropdown Change Event
        --------------------------------------------
        --------------------------------------------*/

    });
</script>
