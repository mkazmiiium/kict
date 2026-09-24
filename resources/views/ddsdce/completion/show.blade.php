@extends('layouts.app')

@section('title', 'View Completion Letter')

@section('content')
  <h4 class="mb-6">DDSDCE Office / Completion Letter / View — {{ $completionLetter->reference_no }}</h4>

  <div class="card">
    <div class="card-body">
      <dl class="row mb-0">
        <dt class="col-sm-3">Reference No.</dt>
        <dd class="col-sm-9">{{ $completionLetter->reference_no }}</dd>

        <dt class="col-sm-3">Date</dt>
        <dd class="col-sm-9">{{ $completionLetter->date->format('d M Y') }}</dd>

        <dt class="col-sm-3">Student</dt>
        <dd class="col-sm-9">{{ $completionLetter->student->name }} ({{ $completionLetter->student->matric_no }})</dd>

        <dt class="col-sm-3">Program</dt>
        <dd class="col-sm-9">{{ $completionLetter->student->program->name_en ?? '—' }}</dd>

        <dt class="col-sm-3">Department</dt>
        <dd class="col-sm-9">{{ $completionLetter->student->department->name_en ?? '—' }}</dd>

        <dt class="col-sm-3">Joined Semester</dt>
        <dd class="col-sm-9">{{ $completionLetter->joinedAcademicSession->label() }}</dd>

        <dt class="col-sm-3">IAP Semester</dt>
        <dd class="col-sm-9">
          {{ $completionLetter->iaAcademicSession->label() }}
          @if ($completionLetter->ia_completion_date)
            (completed {{ $completionLetter->ia_completion_date->format('d M Y') }})
          @endif
        </dd>

        <dt class="col-sm-3">Graduation Status</dt>
        <dd class="col-sm-9">
          @if ($completionLetter->graduation_status === 'fulfilled')
            Fulfilled all requirements
            @if ($completionLetter->expected_graduation_date)
              — expected to graduate by {{ $completionLetter->expected_graduation_date->format('d M Y') }}
            @endif
          @else
            Subject to Graduation Endorsement Meeting — {{ $completionLetter->graduation_semester_text }}
          @endif
        </dd>

        <dt class="col-sm-3">Signatory</dt>
        <dd class="col-sm-9">{{ $completionLetter->signatory->name }} — {{ $completionLetter->signatory->designation_en }}</dd>

        <dt class="col-sm-3">Language</dt>
        <dd class="col-sm-9">{{ strtoupper($completionLetter->language) }}</dd>

        <dt class="col-sm-3">Letter Content</dt>
        <dd class="col-sm-9" style="white-space: pre-line;">{{ $completionLetter->body_text }}</dd>
      </dl>
    </div>
    <div class="card-footer d-flex gap-2">
      <a href="{{ route('ddsdce.completion.edit', $completionLetter) }}" class="btn btn-primary">Edit</a>
      <a href="{{ route('ddsdce.completion.print', $completionLetter) }}" class="btn btn-outline-primary">Print</a>
      <a href="{{ route('ddsdce.completion.index') }}" class="btn btn-outline-secondary">Back to list</a>
    </div>
  </div>
@endsection
