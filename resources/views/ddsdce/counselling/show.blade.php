@extends('layouts.app')

@section('title', 'View Counselling Record')

@section('content')
  <h4 class="mb-6">DDSDCE Office / Counselling / View — {{ $counsellingRecord->student->name }}</h4>

  @if (session('status'))
    <div class="alert alert-success alert-dismissible" role="alert">
      {{ session('status') }}
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
  @endif

  <div class="card">
    <div class="card-body">
      <dl class="row mb-0">
        <dt class="col-sm-3">Matric No.</dt>
        <dd class="col-sm-9">{{ $counsellingRecord->student->matric_no }}</dd>

        <dt class="col-sm-3">Name</dt>
        <dd class="col-sm-9">{{ $counsellingRecord->student->name }}</dd>

        <dt class="col-sm-3">Programme</dt>
        <dd class="col-sm-9">{{ $counsellingRecord->student->program->name_en ?? '—' }}</dd>

        <dt class="col-sm-3">Department</dt>
        <dd class="col-sm-9">{{ $counsellingRecord->student->department->name_en ?? '—' }}</dd>

        <dt class="col-sm-3">Date</dt>
        <dd class="col-sm-9">{{ $counsellingRecord->date->format('d M Y') }}</dd>

        <dt class="col-sm-3">Referred By</dt>
        <dd class="col-sm-9">{{ $counsellingRecord->referred_by ?: '—' }}</dd>

        <dt class="col-sm-3">Date Emailed to CCSC</dt>
        <dd class="col-sm-9">{{ $counsellingRecord->emailed_to_ccsc_date?->format('d M Y') ?? '—' }}</dd>

        <dt class="col-sm-3">Remarks</dt>
        <dd class="col-sm-9" style="white-space: pre-line;">{{ $counsellingRecord->remarks ?: '—' }}</dd>

        <dt class="col-sm-3">Recorded By</dt>
        <dd class="col-sm-9">{{ $counsellingRecord->creator->name ?? '—' }} on {{ $counsellingRecord->created_at->format('d M Y') }}</dd>
      </dl>
    </div>
    <div class="card-footer d-flex gap-2">
      <a href="{{ route('ddsdce.counselling.edit', $counsellingRecord) }}" class="btn btn-primary">Edit</a>
      <a href="{{ route('ddsdce.counselling.index') }}" class="btn btn-outline-secondary">Back to list</a>
    </div>
  </div>
@endsection
