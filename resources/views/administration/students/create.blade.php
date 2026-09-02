@extends('layouts.app')

@section('title', 'Add Student')

@section('content')
  <h4 class="mb-6">Administration / Students / Add New</h4>

  <div class="card">
    <div class="card-body">
      <form action="{{ route('administration.students.store') }}" method="POST">
        @csrf
        @include('administration.students.form')
      </form>
    </div>
  </div>
@endsection
