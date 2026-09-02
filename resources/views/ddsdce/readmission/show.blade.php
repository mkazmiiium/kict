@extends('layouts.app')

@section('title', 'View Readmission Letter')

@section('content')
  <h4 class="mb-6">DDSDCE Office / Readmission / View — {{ $readmissionLetter->reference_no }}</h4>

  <div class="card">
    <div class="card-body">
      <dl class="row mb-0">
        <dt class="col-sm-3">Reference No.</dt>
        <dd class="col-sm-9">{{ $readmissionLetter->reference_no }}</dd>

        <dt class="col-sm-3">Date</dt>
        <dd class="col-sm-9">{{ $readmissionLetter->date->format('d M Y') }}</dd>

        <dt class="col-sm-3">Student</dt>
        <dd class="col-sm-9">{{ $readmissionLetter->student->name }} ({{ $readmissionLetter->student->matric_no }})</dd>

        <dt class="col-sm-3">Programme</dt>
        <dd class="col-sm-9">{{ $readmissionLetter->student->program->name_en ?? '—' }}</dd>

        <dt class="col-sm-3">Readmission Semester</dt>
        <dd class="col-sm-9">{{ $readmissionLetter->readmissionAcademicSession->label() }}</dd>

        <dt class="col-sm-3">Condition</dt>
        <dd class="col-sm-9">{{ $readmissionLetter->readmissionCondition->name }}</dd>

        <dt class="col-sm-3">Meeting</dt>
        <dd class="col-sm-9">
          {{ $readmissionLetter->meeting_number ?: '—' }}
          @if ($readmissionLetter->meeting_date)
            (dated {{ $readmissionLetter->meeting_date->format('d M Y') }})
          @endif
        </dd>

        <dt class="col-sm-3">Signatory</dt>
        <dd class="col-sm-9">{{ $readmissionLetter->signatory->name }} — {{ $readmissionLetter->signatory->designation_en }}</dd>

        <dt class="col-sm-3">Language</dt>
        <dd class="col-sm-9">{{ strtoupper($readmissionLetter->language) }}</dd>
      </dl>
    </div>
    <div class="card-footer d-flex gap-2">
      <a href="{{ route('ddsdce.readmission.edit', $readmissionLetter) }}" class="btn btn-primary">Edit</a>
      <a href="{{ route('ddsdce.readmission.print', $readmissionLetter) }}" class="btn btn-outline-primary">Print</a>
      <a href="{{ route('ddsdce.readmission.index') }}" class="btn btn-outline-secondary">Back to list</a>
    </div>
  </div>
@endsection
