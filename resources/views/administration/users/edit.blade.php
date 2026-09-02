@extends('layouts.app')

@section('title', 'Edit User')

@section('content')
  <h4 class="mb-6">Administration / Users / Edit — {{ $user->name }}</h4>

  <div class="card">
    <div class="card-body">
      <form action="{{ route('administration.users.update', $user) }}" method="POST">
        @csrf
        @method('PUT')
        @include('administration.users.form')
      </form>
    </div>
  </div>
@endsection
