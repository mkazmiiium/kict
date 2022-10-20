<!-- Google Font: Source Sans Pro -->
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
<!-- Font Awesome -->
<link rel="stylesheet" href="{{asset('plugins/fontawesome-free/css/all.min.css')}}">
<!-- DataTables -->
<link rel="stylesheet" href="{{asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('plugins/datatables-buttons/css/buttons.bootstrap4.min.css')}}">
<!-- Theme style -->
<link rel="stylesheet" href="{{asset('dist/css/adminlte.min.css')}}">

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

<div class="card">
    <div class="card-header">
      <h3 class="card-title"><strong>CENTRALISED EXAMINATION BOOKING</strong></h3>
    </div>
    <!-- /.card-header -->
    <div class="card-body">

        <div class="col-md2">
                {{-- <button type="button" class="btn btn-block btn-primary btn-lg">Primary</button> --}}
                <a href="/add_booking_centralise_exam" class="btn btn-block btn-primary btn-lg">Add New Booking</a>
        </div>

        <p></p>

        <table id="example2" class="table table-bordered table-hover" style="width: 100%">
            <thead>
            <tr>
            <th>ID</th>
            <th>PROGRAMME</th>
            <th>COURSE CODE</th>
            <th>COURSE NAME</th>
            {{-- <th>STAFF NUMBER </th> --}}
            <th>STAFF NAME</th>
            {{-- <th>DATE</th> --}}
            {{-- <th>SLOT</th> --}}
            <th>SECTIONS</th>
            <th>STUDENT NUMBERS</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($centraliseds as $centralised)
            <tr>
                <td>{{ $centralised->id }}</td>
                <td>{{ $centralised->program_id }}</td>
                <td>{{ $centralised->course_id }}</td>
                <td>{{ $centralised->course_name }}</td>
                {{-- <td>{{ $centralised->staff_id }}</td> --}}
                <td>{{ $centralised->staff_name }}</td>
                {{-- <td>{{ $centralised->booking_date }}</td> --}}
                {{-- <td>{{ $centralised->booking_slot }}</td> --}}
                <td>{{ $centralised->sections }}</td>
                <td>{{ $centralised->student_capacity }}</td>
            </tr>
            @endforeach
        </table>
        <p>
        {{-- {{$decentraliseds->links()}} --}}
    </div>
    <!-- /.card-body -->
</div>
@endsection

<!-- jQuery -->
<script src="{{asset('plugins/jquery/jquery.min.js')}}"></script>
<!-- Bootstrap 4 -->
<script src="{{asset('plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<!-- DataTables  & Plugins -->
<script src="{{asset('plugins/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{asset('plugins/datatables-responsive/js/dataTables.responsive.min.js')}}"></script>
<script src="{{asset('plugins/datatables-responsive/js/responsive.bootstrap4.min.js')}}"></script>
<script src="{{asset('plugins/datatables-buttons/js/dataTables.buttons.min.js')}}"></script>
<script src="{{asset('plugins/datatables-buttons/js/buttons.bootstrap4.min.js')}}"></script>
<script src="{{asset('plugins/jszip/jszip.min.js')}}"></script>
<script src="{{asset('plugins/pdfmake/pdfmake.min.js')}}"></script>
<script src="{{asset('plugins/pdfmake/vfs_fonts.js')}}"></script>
<script src="{{asset('plugins/datatables-buttons/js/buttons.html5.min.js')}}"></script>
<script src="{{asset('plugins/datatables-buttons/js/buttons.print.min.js')}}"></script>
<script src="{{asset('plugins/datatables-buttons/js/buttons.colVis.min.js')}}"></script>
<!-- AdminLTE App -->
<script src="{{asset('dist/js/adminlte.min.js')}}"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{asset('dist/js/demo.js')}}"></script>
<!-- Page specific script -->
<script>
  $(function () {
    $("#example1").DataTable({
      "responsive": true,
      "lengthChange": false,
      "autoWidth": false,
      "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": true,
      "searching": true,
      "ordering": false,
      "info": true,
      "autoWidth": true,
      "responsive": true,
      "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    });
  });
</script>
