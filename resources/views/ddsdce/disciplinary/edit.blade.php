@extends('layouts.app')

@section('title', 'Edit Disciplinary Record')

@section('content')
  <h4 class="mb-6">DDSDCE Office / Disciplinary / Edit — {{ $disciplinaryRecord->student->name }}</h4>

  <div class="card">
    <div class="card-body">
      <form action="{{ route('ddsdce.disciplinary.update', $disciplinaryRecord) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        @include('ddsdce.disciplinary.form')
      </form>
    </div>
  </div>
@endsection
