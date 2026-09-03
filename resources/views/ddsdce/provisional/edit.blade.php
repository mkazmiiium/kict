@extends('layouts.app')

@section('title', 'Edit Provisional Record')

@section('content')
  <h4 class="mb-6">DDSDCE Office / Provisional / Edit — {{ $provisionalRecord->student->name }}</h4>

  <div class="card">
    <div class="card-body">
      <form action="{{ route('ddsdce.provisional.update', $provisionalRecord) }}" method="POST">
        @csrf
        @method('PUT')
        @include('ddsdce.provisional.form')
      </form>
    </div>
  </div>
@endsection
