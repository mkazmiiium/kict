@extends('layouts.app')

@section('title', 'Edit Completion Letter')

@section('content')
  <h4 class="mb-6">DDSDCE Office / Completion Letter / Edit — {{ $completionLetter->reference_no }}</h4>

  <div class="card">
    <div class="card-body">
      <form action="{{ route('ddsdce.completion.update', $completionLetter) }}" method="POST">
        @csrf
        @method('PUT')
        @include('ddsdce.completion.form')
      </form>
    </div>
  </div>
@endsection
