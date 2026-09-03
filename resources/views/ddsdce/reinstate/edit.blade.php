@extends('layouts.app')

@section('title', 'Edit Reinstatement Record')

@section('content')
  <h4 class="mb-6">DDSDCE Office / Reinstatement / Edit — {{ $reinstateRecord->student->name }}</h4>

  <div class="card">
    <div class="card-body">
      <form action="{{ route('ddsdce.reinstate.update', $reinstateRecord) }}" method="POST">
        @csrf
        @method('PUT')
        @include('ddsdce.reinstate.form')
      </form>
    </div>
  </div>
@endsection
