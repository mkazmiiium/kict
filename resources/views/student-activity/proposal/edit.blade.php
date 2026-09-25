@extends('layouts.app')

@section('title', 'Edit Proposal')

@section('content')
  <h4 class="mb-6">Student Activity / Proposal / Edit — {{ $proposal->name }}</h4>

  <div class="card">
    <div class="card-body">
      <form action="{{ route('student-activity.proposal.update', $proposal) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        @include('student-activity.proposal.form')
      </form>
    </div>
  </div>
@endsection
