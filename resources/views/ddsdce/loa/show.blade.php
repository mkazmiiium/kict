@extends('layouts.app')

@section('title', 'View LOA Letter')

@section('content')
  <h4 class="mb-6">DDSDCE Office / LOA / View — {{ $loaLetter->reference_no }}</h4>

  <div class="card">
    <div class="card-body">
      <dl class="row mb-0">
        <dt class="col-sm-3">Reference No.</dt>
        <dd class="col-sm-9">{{ $loaLetter->reference_no }}</dd>

        <dt class="col-sm-3">Date</dt>
        <dd class="col-sm-9">{{ $loaLetter->date->format('d M Y') }}</dd>

        <dt class="col-sm-3">Student</dt>
        <dd class="col-sm-9">{{ $loaLetter->student->name }} ({{ $loaLetter->student->matric_no }})</dd>

        <dt class="col-sm-3">Programme</dt>
        <dd class="col-sm-9">{{ $loaLetter->student->program->name_en ?? '—' }}</dd>

        <dt class="col-sm-3">Leave Semester</dt>
        <dd class="col-sm-9">{{ $loaLetter->leaveAcademicSession->label() }}</dd>

        <dt class="col-sm-3">Meeting</dt>
        <dd class="col-sm-9">
          {{ $loaLetter->meeting_number ?: '—' }}
          @if ($loaLetter->meeting_date)
            (dated {{ $loaLetter->meeting_date->format('d M Y') }})
          @endif
        </dd>

        <dt class="col-sm-3">Status</dt>
        <dd class="col-sm-9">
          <span class="badge {{ $loaLetter->status === 'approved' ? 'bg-label-success' : 'bg-label-danger' }}">
            {{ ucfirst($loaLetter->status) }}
          </span>
        </dd>

        <dt class="col-sm-3">Reason for Study Leave</dt>
        <dd class="col-sm-9">
          {{ ucfirst($loaLetter->reason_type) }}
          @if ($loaLetter->reason_type === 'other' && $loaLetter->other_reason_note)
            — {{ $loaLetter->other_reason_note }}
          @endif
        </dd>

        <dt class="col-sm-3">Remarks</dt>
        <dd class="col-sm-9" style="white-space: pre-line;">{{ $loaLetter->remarks ?: '—' }}</dd>

        <dt class="col-sm-3">Signatory</dt>
        <dd class="col-sm-9">{{ $loaLetter->signatory->name }} — {{ $loaLetter->signatory->designation_en }}</dd>

        <dt class="col-sm-3">Language</dt>
        <dd class="col-sm-9">{{ strtoupper($loaLetter->language) }}</dd>
      </dl>
    </div>
    <div class="card-footer d-flex gap-2">
      <a href="{{ route('ddsdce.loa.edit', $loaLetter) }}" class="btn btn-primary">Edit</a>
      <a href="{{ route('ddsdce.loa.print', $loaLetter) }}" class="btn btn-outline-primary">Print</a>
      <a href="{{ route('ddsdce.loa.index') }}" class="btn btn-outline-secondary">Back to list</a>
    </div>
  </div>
@endsection
