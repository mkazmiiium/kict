@extends('layouts.app')

@section('title', 'Edit Expected Graduation Letter')

@section('content')
  <h4 class="mb-6">DDSDCE Office / Expected Graduation Letter / Edit — {{ $expectedGraduationLetter->reference_no }}</h4>

  <div class="card">
    <div class="card-body">
      <form action="{{ route('ddsdce.expected-graduation.update', $expectedGraduationLetter) }}" method="POST">
        @csrf
        @method('PUT')
        @include('ddsdce.expected-graduation.form')
      </form>
    </div>
  </div>
@endsection
