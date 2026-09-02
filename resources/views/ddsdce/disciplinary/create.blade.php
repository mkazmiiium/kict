@extends('layouts.app')

@section('title', 'Add Disciplinary Record')

@section('content')
  <h4 class="mb-6">DDSDCE Office / Disciplinary / Add New</h4>

  <div class="card">
    <div class="card-body">
      <form action="{{ route('ddsdce.disciplinary.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @include('ddsdce.disciplinary.form')
      </form>
    </div>
  </div>
@endsection
