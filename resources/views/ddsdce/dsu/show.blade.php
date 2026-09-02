@extends('layouts.app')

@section('title', 'View DSU Student')

@section('content')
  <h4 class="mb-6">DDSDCE Office / DSU Students / View — {{ $dsuStudent->student->name }}</h4>

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
        <dd class="col-sm-9">{{ $dsuStudent->student->matric_no }}</dd>

        <dt class="col-sm-3">Name</dt>
        <dd class="col-sm-9">{{ $dsuStudent->student->name }}</dd>

        <dt class="col-sm-3">Kulliyyah</dt>
        <dd class="col-sm-9">{{ $dsuStudent->student->department->kulliyyah->name_en ?? '—' }}</dd>

        <dt class="col-sm-3">Programme</dt>
        <dd class="col-sm-9">{{ $dsuStudent->student->program->name_en ?? '—' }}</dd>

        <dt class="col-sm-3">Phone No.</dt>
        <dd class="col-sm-9">{{ $dsuStudent->student->phone_no ?: '—' }}</dd>

        <dt class="col-sm-3">Email</dt>
        <dd class="col-sm-9">{{ $dsuStudent->student->email ?: '—' }}</dd>

        <dt class="col-sm-3">Type of Disability</dt>
        <dd class="col-sm-9">
          {{ $dsuStudent->disabilityCategory ? $dsuStudent->disabilityCategory->code.' - '.$dsuStudent->disabilityCategory->name : '—' }}
          @if ($dsuStudent->disability_detail)
            ({{ $dsuStudent->disability_detail }})
          @endif
        </dd>

        <dt class="col-sm-3">Disabled Since</dt>
        <dd class="col-sm-9">{{ $dsuStudent->disabled_since ?: '—' }}</dd>

        <dt class="col-sm-3">Usage of Equipment</dt>
        <dd class="col-sm-9">{{ $dsuStudent->equipment_used ?: '—' }}</dd>

        <dt class="col-sm-3">Joined Semester</dt>
        <dd class="col-sm-9">{{ $dsuStudent->joinedAcademicSession->label() }}</dd>

        <dt class="col-sm-3">Semesters Completed</dt>
        <dd class="col-sm-9">{{ $dsuStudent->semestersSinceJoining() ?? '—' }}</dd>

        <dt class="col-sm-3">Remarks</dt>
        <dd class="col-sm-9" style="white-space: pre-line;">{{ $dsuStudent->remarks ?: '—' }}</dd>

        <dt class="col-sm-3">Recorded By</dt>
        <dd class="col-sm-9">{{ $dsuStudent->creator->name ?? '—' }} on {{ $dsuStudent->created_at->format('d M Y') }}</dd>
      </dl>
    </div>
    <div class="card-footer d-flex gap-2">
      <a href="{{ route('ddsdce.dsu.edit', $dsuStudent) }}" class="btn btn-primary">Edit</a>
      <a href="{{ route('ddsdce.dsu.index') }}" class="btn btn-outline-secondary">Back to list</a>
    </div>
  </div>
@endsection
