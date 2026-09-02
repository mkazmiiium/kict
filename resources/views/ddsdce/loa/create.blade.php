@extends('layouts.app')

@section('title', 'Add LOA Letter')

@section('content')
  <h4 class="mb-6">DDSDCE Office / LOA / Add New</h4>

  <div class="card">
    <div class="card-body">
      <form action="{{ route('ddsdce.loa.store') }}" method="POST">
        @csrf
        @include('ddsdce.loa.form')
      </form>
    </div>
  </div>
@endsection
