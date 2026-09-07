@extends('layouts.app')

@section('title', 'Add Counselling Record')

@section('content')
  <h4 class="mb-6">DDSDCE Office / Counselling / Add New</h4>

  <div class="card">
    <div class="card-body">
      <form action="{{ route('ddsdce.counselling.store') }}" method="POST">
        @csrf
        @include('ddsdce.counselling.form')
      </form>
    </div>
  </div>
@endsection
