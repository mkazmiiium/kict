@extends('layouts.app')

@section('title', 'Add Expected Graduation Letter')

@section('content')
  <h4 class="mb-6">DDSDCE Office / Expected Graduation Letter / Add New</h4>

  <div class="card">
    <div class="card-body">
      <form action="{{ route('ddsdce.expected-graduation.store') }}" method="POST">
        @csrf
        @include('ddsdce.expected-graduation.form')
      </form>
    </div>
  </div>
@endsection
