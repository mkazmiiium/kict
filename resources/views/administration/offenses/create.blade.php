@extends('layouts.app')

@section('title', 'Add Offense')

@section('content')
  <h4 class="mb-6">Administration / Offenses / Add New</h4>

  <div class="card">
    <div class="card-body">
      <form action="{{ route('administration.offenses.store') }}" method="POST">
        @csrf
        @include('administration.offenses.form')
      </form>
    </div>
  </div>
@endsection
