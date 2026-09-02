@extends('layouts.app')

@section('title', 'Add Readmission Letter')

@section('content')
  <h4 class="mb-6">DDSDCE Office / Readmission / Add New</h4>

  <div class="card">
    <div class="card-body">
      <form action="{{ route('ddsdce.readmission.store') }}" method="POST">
        @csrf
        @include('ddsdce.readmission.form')
      </form>
    </div>
  </div>
@endsection
