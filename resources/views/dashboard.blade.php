@extends('layouts.app')

@section('title', 'Dashboard')

@php
    $canSeeDdai = auth()->user()->hasAnyRole(['Superadmin', 'DDAI Office']);
    $canSeeDdsdce = auth()->user()->hasAnyRole(['Superadmin', 'DDSDCE Office']);
@endphp

@section('content')
  <div class="row">
    <div class="col-12">
      <div class="card mb-6">
        <div class="card-body">
          <h4 class="mb-1">Welcome, {{ auth()->user()->name }} 👋</h4>
          <p class="mb-0">
            Use the menu on the left to access the
            {{ $canSeeDdai && $canSeeDdsdce ? 'DDAI and DDSDCE offices' : ($canSeeDdsdce ? 'DDSDCE office' : 'DDAI office') }}.
          </p>
        </div>
      </div>
    </div>
  </div>

  <div class="row">
    @if ($canSeeDdai)
      <div class="col-md-6 mb-6">
        <div class="card h-100">
          <div class="card-body">
            <div class="avatar mb-3">
              <span class="avatar-initial rounded bg-label-secondary">
                <i class="icon-base bx bx-buildings icon-lg"></i>
              </span>
            </div>
            <h5 class="card-title">DDAI Office</h5>
            <p class="card-text">Coming in Phase 2.</p>
            <a href="{{ route('ddai.index') }}" class="btn btn-outline-secondary">Open</a>
          </div>
        </div>
      </div>
    @endif
    @if ($canSeeDdsdce)
      <div class="col-md-6 mb-6">
        <div class="card h-100">
          <div class="card-body">
            <div class="avatar mb-3">
              <span class="avatar-initial rounded bg-label-primary">
                <i class="icon-base bx bx-briefcase-alt-2 icon-lg"></i>
              </span>
            </div>
            <h5 class="card-title">DDSDCE Office</h5>
            <p class="card-text">Manage Attendance and Expected Graduation letters.</p>
            <a href="{{ route('ddsdce.dashboard') }}" class="btn btn-primary">Open</a>
          </div>
        </div>
      </div>
    @endif
  </div>
@endsection
