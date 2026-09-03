@extends('layouts.app')

@section('title', 'Add Reinstatement Record')

@section('content')
  <h4 class="mb-6">DDSDCE Office / Reinstatement / Add New</h4>

  <div class="card">
    <div class="card-body">
      <form action="{{ route('ddsdce.reinstate.store') }}" method="POST">
        @csrf
        @include('ddsdce.reinstate.form')
      </form>
    </div>
  </div>
@endsection
