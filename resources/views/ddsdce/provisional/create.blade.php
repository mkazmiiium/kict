@extends('layouts.app')

@section('title', 'Add Provisional Record')

@section('content')
  <h4 class="mb-6">DDSDCE Office / Provisional / Add New</h4>

  <div class="card">
    <div class="card-body">
      <form action="{{ route('ddsdce.provisional.store') }}" method="POST">
        @csrf
        @include('ddsdce.provisional.form')
      </form>
    </div>
  </div>
@endsection
