@extends('layouts.app')

@section('title', 'Edit Attendance Letter')

@section('content')
  <h4 class="mb-6">DDSDCE Office / Attendance Letter / Edit — {{ $attendanceLetter->reference_no }}</h4>

  <div class="card">
    <div class="card-body">
      <form action="{{ route('ddsdce.attendance.update', $attendanceLetter) }}" method="POST">
        @csrf
        @method('PUT')
        @include('ddsdce.attendance.form')
      </form>
    </div>
  </div>
@endsection
