@extends('layouts.app')

@section('title', 'Edit Readmission Letter')

@section('content')
  <h4 class="mb-6">DDSDCE Office / Readmission / Edit — {{ $readmissionLetter->reference_no }}</h4>

  <div class="card">
    <div class="card-body">
      <form action="{{ route('ddsdce.readmission.update', $readmissionLetter) }}" method="POST">
        @csrf
        @method('PUT')
        @include('ddsdce.readmission.form')
      </form>
    </div>
  </div>
@endsection
