@extends('layouts.app')

@section('title', 'Add Readmission Condition')

@section('content')
  <h4 class="mb-6">Administration / Readmission Conditions / Add New</h4>

  <div class="card">
    <div class="card-body">
      <form action="{{ route('administration.readmission-conditions.store') }}" method="POST">
        @csrf
        @include('administration.readmission-conditions.form')
      </form>
    </div>
  </div>
@endsection
