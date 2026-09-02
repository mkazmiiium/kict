@extends('layouts.app')

@section('title', 'Edit Readmission Condition')

@section('content')
  <h4 class="mb-6">Administration / Readmission Conditions / Edit — {{ $condition->name }}</h4>

  <div class="card">
    <div class="card-body">
      <form action="{{ route('administration.readmission-conditions.update', $condition) }}" method="POST">
        @csrf
        @method('PUT')
        @include('administration.readmission-conditions.form')
      </form>
    </div>
  </div>
@endsection
