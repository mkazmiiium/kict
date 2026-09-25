@extends('layouts.app')

@section('title', 'Add Proposal')

@section('content')
  <h4 class="mb-6">Student Activity / Proposal / Add New</h4>

  <div class="card">
    <div class="card-body">
      <form action="{{ route('student-activity.proposal.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @include('student-activity.proposal.form')
      </form>
    </div>
  </div>
@endsection
