@extends('layouts.app')

@section('title', 'Add Attendance Letter')

@section('content')
  <h4 class="mb-6">DDSDCE Office / Attendance Letter / Add New</h4>

  <div class="card">
    <div class="card-body">
      <form action="{{ route('ddsdce.attendance.store') }}" method="POST">
        @csrf
        @include('ddsdce.attendance.form')
      </form>
    </div>
  </div>
@endsection
