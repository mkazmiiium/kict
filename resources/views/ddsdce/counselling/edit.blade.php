@extends('layouts.app')

@section('title', 'Edit Counselling Record')

@section('content')
  <h4 class="mb-6">DDSDCE Office / Counselling / Edit — {{ $counsellingRecord->student->name }}</h4>

  <div class="card">
    <div class="card-body">
      <form action="{{ route('ddsdce.counselling.update', $counsellingRecord) }}" method="POST">
        @csrf
        @method('PUT')
        @include('ddsdce.counselling.form')
      </form>
    </div>
  </div>
@endsection
