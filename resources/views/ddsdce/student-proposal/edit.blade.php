@extends('layouts.app')

@section('title', 'Review Proposal')

@section('content')
  <h4 class="mb-6">DDSDCE Office / Student Proposal / Review — {{ $proposal->name }}</h4>

  <div class="card">
    <div class="card-body">
      <form action="{{ route('ddsdce.student-proposal.update', $proposal) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        @include('student-activity.proposal.form', ['reviewMode' => true, 'routePrefix' => 'ddsdce.student-proposal'])
      </form>
    </div>
  </div>
@endsection
