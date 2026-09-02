@extends('layouts.app')

@section('title', 'Edit DSU Student')

@section('content')
  <h4 class="mb-6">DDSDCE Office / DSU Students / Edit — {{ $dsuStudent->student->name }}</h4>

  <div class="card">
    <div class="card-body">
      <form action="{{ route('ddsdce.dsu.update', $dsuStudent) }}" method="POST">
        @csrf
        @method('PUT')
        @include('ddsdce.dsu.form')
      </form>
    </div>
  </div>
@endsection
