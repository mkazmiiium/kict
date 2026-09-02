@extends('layouts.app')

@section('title', 'View Attendance Letter')

@section('content')
  <h4 class="mb-6">DDSDCE Office / Attendance Letter / View — {{ $attendanceLetter->reference_no }}</h4>

  <div class="card">
    <div class="card-body">
      <dl class="row mb-0">
        <dt class="col-sm-3">Reference No.</dt>
        <dd class="col-sm-9">{{ $attendanceLetter->reference_no }}</dd>

        <dt class="col-sm-3">Date</dt>
        <dd class="col-sm-9">{{ $attendanceLetter->date->format('d M Y') }}</dd>

        <dt class="col-sm-3">Student</dt>
        <dd class="col-sm-9">{{ $attendanceLetter->student->name }} ({{ $attendanceLetter->student->matric_no }})</dd>

        <dt class="col-sm-3">Program</dt>
        <dd class="col-sm-9">{{ $attendanceLetter->student->program->name_en ?? '—' }}</dd>

        <dt class="col-sm-3">Department</dt>
        <dd class="col-sm-9">{{ $attendanceLetter->student->department->name_en ?? '—' }}</dd>

        <dt class="col-sm-3">Semester(s)</dt>
        <dd class="col-sm-9">
          {{ $attendanceLetter->academicSessions->map->label()->join(', ') }}
        </dd>

        <dt class="col-sm-3">Attendance % Met</dt>
        <dd class="col-sm-9">{{ $attendanceLetter->attendance_percentage }}%</dd>

        <dt class="col-sm-3">Signatory</dt>
        <dd class="col-sm-9">{{ $attendanceLetter->signatory->name }} — {{ $attendanceLetter->signatory->designation_en }}</dd>

        <dt class="col-sm-3">Language</dt>
        <dd class="col-sm-9">{{ strtoupper($attendanceLetter->language) }}</dd>

        <dt class="col-sm-3">Letter Content</dt>
        <dd class="col-sm-9" style="white-space: pre-line;">{{ $attendanceLetter->body_text }}</dd>
      </dl>
    </div>
    <div class="card-footer d-flex gap-2">
      <a href="{{ route('ddsdce.attendance.edit', $attendanceLetter) }}" class="btn btn-primary">Edit</a>
      <a href="{{ route('ddsdce.attendance.print', $attendanceLetter) }}" class="btn btn-outline-primary">Print</a>
      <a href="{{ route('ddsdce.attendance.index') }}" class="btn btn-outline-secondary">Back to list</a>
    </div>
  </div>
@endsection
