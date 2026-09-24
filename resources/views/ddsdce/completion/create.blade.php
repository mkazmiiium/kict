@extends('layouts.app')

@section('title', 'Add Completion Letter')

@section('content')
  <h4 class="mb-6">DDSDCE Office / Completion Letter / Add New</h4>

  <div class="card">
    <div class="card-body">
      <form action="{{ route('ddsdce.completion.store') }}" method="POST">
        @csrf
        @include('ddsdce.completion.form')
      </form>
    </div>
  </div>
@endsection
