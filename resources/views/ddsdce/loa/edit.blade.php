@extends('layouts.app')

@section('title', 'Edit LOA Letter')

@section('content')
  <h4 class="mb-6">DDSDCE Office / LOA / Edit — {{ $loaLetter->reference_no }}</h4>

  <div class="card">
    <div class="card-body">
      <form action="{{ route('ddsdce.loa.update', $loaLetter) }}" method="POST">
        @csrf
        @method('PUT')
        @include('ddsdce.loa.form')
      </form>
    </div>
  </div>
@endsection
