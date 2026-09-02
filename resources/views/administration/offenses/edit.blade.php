@extends('layouts.app')

@section('title', 'Edit Offense')

@section('content')
  <h4 class="mb-6">Administration / Offenses / Edit — {{ $offense->name }}</h4>

  <div class="card">
    <div class="card-body">
      <form action="{{ route('administration.offenses.update', $offense) }}" method="POST">
        @csrf
        @method('PUT')
        @include('administration.offenses.form')
      </form>
    </div>
  </div>
@endsection
