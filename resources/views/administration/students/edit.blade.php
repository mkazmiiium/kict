@extends('layouts.app')

@section('title', 'Edit Student')

@section('content')
  <h4 class="mb-6">Administration / Students / Edit — {{ $student->name }}</h4>

  <div class="card">
    <div class="card-body">
      <form action="{{ route('administration.students.update', $student) }}" method="POST">
        @csrf
        @method('PUT')
        @include('administration.students.form')
      </form>
    </div>
  </div>
@endsection
