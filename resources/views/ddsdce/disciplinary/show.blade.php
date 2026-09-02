@extends('layouts.app')

@section('title', 'View Disciplinary Record')

@php
  $statusBadges = [
      'pending' => 'bg-label-warning',
      'cancelled' => 'bg-label-success',
      'escalated' => 'bg-label-danger',
  ];
@endphp

@section('content')
  <h4 class="mb-6">DDSDCE Office / Disciplinary / View — {{ $disciplinaryRecord->student->name }}</h4>

  @if (session('status'))
    <div class="alert alert-success alert-dismissible" role="alert">
      {{ session('status') }}
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
  @endif

  @if (session('error'))
    <div class="alert alert-danger alert-dismissible" role="alert">
      {{ session('error') }}
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
  @endif

  <div class="card">
    <div class="card-body">
      <dl class="row mb-0">
        <dt class="col-sm-3">Date</dt>
        <dd class="col-sm-9">{{ $disciplinaryRecord->date->format('d M Y') }}</dd>

        <dt class="col-sm-3">Matric No.</dt>
        <dd class="col-sm-9">{{ $disciplinaryRecord->student->matric_no }}</dd>

        <dt class="col-sm-3">Name</dt>
        <dd class="col-sm-9">{{ $disciplinaryRecord->student->name }}</dd>

        <dt class="col-sm-3">Kulliyyah</dt>
        <dd class="col-sm-9">{{ $disciplinaryRecord->student->department->kulliyyah->name_en ?? '—' }}</dd>

        <dt class="col-sm-3">Department</dt>
        <dd class="col-sm-9">{{ $disciplinaryRecord->student->department->name_en ?? '—' }}</dd>

        <dt class="col-sm-3">Program</dt>
        <dd class="col-sm-9">{{ $disciplinaryRecord->student->program->name_en ?? '—' }}</dd>

        <dt class="col-sm-3">Offense</dt>
        <dd class="col-sm-9">{{ $disciplinaryRecord->offense->name ?? '—' }}</dd>

        <dt class="col-sm-3">Location</dt>
        <dd class="col-sm-9">{{ $disciplinaryRecord->location }}</dd>

        <dt class="col-sm-3">Remarks</dt>
        <dd class="col-sm-9" style="white-space: pre-line;">{{ $disciplinaryRecord->remarks ?: '—' }}</dd>

        <dt class="col-sm-3">Photos</dt>
        <dd class="col-sm-9">
          @if ($disciplinaryRecord->photos->isEmpty())
            —
          @else
            <div class="d-flex flex-wrap gap-3">
              @foreach ($disciplinaryRecord->photos as $photo)
                <a href="{{ $photo->url() }}" target="_blank" rel="noopener">
                  <img src="{{ $photo->url() }}" alt="Photo evidence" style="width: 110px; height: 110px; object-fit: cover; border-radius: 0.375rem; border: 1px solid var(--bs-border-color);" />
                </a>
              @endforeach
            </div>
          @endif
        </dd>

        <dt class="col-sm-3">Status</dt>
        <dd class="col-sm-9">
          <span class="badge {{ $statusBadges[$disciplinaryRecord->status] }}">{{ ucfirst($disciplinaryRecord->status) }}</span>
          @if ($disciplinaryRecord->isOverdue())
            <span class="badge bg-label-danger">Overdue</span>
          @endif
        </dd>

        <dt class="col-sm-3">Due Date</dt>
        <dd class="col-sm-9">{{ $disciplinaryRecord->due_date->format('d M Y') }}</dd>

        <dt class="col-sm-3">Notice Sent</dt>
        <dd class="col-sm-9">
          {{ $disciplinaryRecord->notified_at?->format('d M Y, g:i A') ?? 'Not sent — no email on file for this student' }}
        </dd>

        @if ($disciplinaryRecord->status === 'cancelled')
          <dt class="col-sm-3">Resolved</dt>
          <dd class="col-sm-9">{{ $disciplinaryRecord->resolved_at?->format('d M Y, g:i A') }}</dd>
        @endif

        @if ($disciplinaryRecord->status === 'escalated')
          <dt class="col-sm-3">Escalated</dt>
          <dd class="col-sm-9">{{ $disciplinaryRecord->escalated_at?->format('d M Y, g:i A') }}</dd>
        @endif

        <dt class="col-sm-3">Recorded By</dt>
        <dd class="col-sm-9">{{ $disciplinaryRecord->creator->name ?? '—' }} on {{ $disciplinaryRecord->created_at->format('d M Y') }}</dd>
      </dl>
    </div>
    <div class="card-footer d-flex gap-2">
      @if ($disciplinaryRecord->status === 'pending')
        <a href="{{ route('ddsdce.disciplinary.edit', $disciplinaryRecord) }}" class="btn btn-primary">Edit</a>

        <form action="{{ route('ddsdce.disciplinary.cancel', $disciplinaryRecord) }}" method="POST"
          onsubmit="return confirm('Mark this record as cancelled (student improved)? A closure email will be sent.');">
          @csrf
          <button type="submit" class="btn btn-success">Cancel (Improved)</button>
        </form>

        <form action="{{ route('ddsdce.disciplinary.escalate', $disciplinaryRecord) }}" method="POST"
          onsubmit="return confirm('Escalate this record to OSEM? This cannot be undone.');">
          @csrf
          <button type="submit" class="btn btn-danger">Escalate to OSEM</button>
        </form>
      @endif
      <a href="{{ route('ddsdce.disciplinary.index') }}" class="btn btn-outline-secondary">Back to list</a>
    </div>
  </div>
@endsection
