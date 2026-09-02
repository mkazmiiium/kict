@extends('layouts.app')

@section('title', 'Add User')

@section('content')
  <h4 class="mb-6">Administration / Users / Add New</h4>

  <div class="card">
    <div class="card-body">
      <form action="{{ route('administration.users.store') }}" method="POST">
        @csrf
        @include('administration.users.form')
      </form>
    </div>
  </div>
@endsection
