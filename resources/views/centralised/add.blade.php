

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
                        <li class="breadcrumb-item"><a href="home">Home</a></li>
                        <li class="breadcrumb-item active">Centralised Examination Booking</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    <form action="addbooking_centralise_exam" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="col-md-12">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Add New Centralised Examination Booking</h3>
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

                        {{-- <div class="form-group">
                            <label for="assessmentType">Assessment Type</label>
                            <select name="assessmentType" class="form-control select2" style="width: 50%" required>
                                <option value="">-- Select Assessment Type -- </option>
                                <option value="Final Assessment - Decentralized Exam">Final Assessment - Decentralized Exam
                                </option>
                                <option value="Final Assessment - Test">Final Assessment - Test</option>
                                <option value="Final Assessment - Take Home">Final Assessment - Take Home</option>
                            </select>
                        </div> --}}

                        {{-- <div class="form-group">
                            <label for="booking_date">Booking Date</label>
                            <input type="date" class="form-control" style="width: 30%" name="booking_date" min="2022-12-05" max="2023-01-26" required>
                        </div> --}}

                        {{-- <div class="form-group">
                            <label for="bookingslot">Booking Slot</label>
                            <select name="bookingslot" class="form-control select2" style="width: 30%" required>
                                <option value="">-- Select Time Slot -- </option>
                                <option value="9:00am - 1:00pm">9:00am - 1:00pm </option>
                                <option value="2:30pm - 5:30pm">2:00pm - 5:00pm</option>
                                <option value="5:00pm - 8:00pm">5:00pm - 8:00pm</option>
                            </select>
                        </div> --}}

                        <div class="form-group">
                            <label for="capacity">Number of Students</label>
                            <input type="text" class="form-control" style="width: 15%" name="capacity" required>
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

        // $('select[multiple]').multiselect();
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
        // azmi
        // $('#state-dropdown').on('change', function () {
        //     var idState = this.value;
        //     $("#city-dropdown").html('');
        //     $.ajax({
        //         url: "{{ url('api/fetch-cities') }}",
        //         type: "POST",
        //         data: {
        //             state_id: idState,
        //             _token: '{{ csrf_token() }}'
        //         },
        //         dataType: 'json',
        //         success: function (res) {
        //             $('#city-dropdown').html('<option value="">-- Select City --</option>');
        //             $.each(res.cities, function (key, value) {
        //                 $("#city-dropdown").append('<option value="' + value
        //                     .id + '">' + value.name + '</option>');
        //             });
        //         }
        //     });
        // });
    });
</script>
