@extends('layouts.app')

@section('title', 'My Profile')

@section('content')
  <h4 class="mb-6">My Profile</h4>

  @if (session('status'))
    <div class="alert alert-success alert-dismissible" role="alert">
      {{ session('status') }}
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
  @endif

  <div class="row">
    <div class="col-md-6 mb-6">
      <div class="card h-100">
        <h5 class="card-header">Profile Information</h5>
        <div class="card-body">
          <form action="{{ route('profile.update') }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-6">
              <label for="name" class="form-label">Name</label>
              <input
                type="text"
                id="name"
                name="name"
                class="form-control @error('name') is-invalid @enderror"
                value="{{ old('name', $user->name) }}"
                required
                autofocus />
              @error('name')
                <div class="invalid-feedback d-block">{{ $message }}</div>
              @enderror
            </div>

            <div class="mb-6">
              <label for="email" class="form-label">Email</label>
              <input
                type="email"
                id="email"
                class="form-control"
                value="{{ $user->email }}"
                disabled
                readonly />
              <div class="form-text">Email is used as your login ID and cannot be changed.</div>
            </div>

            <button type="submit" class="btn btn-primary">Save Changes</button>
          </form>
        </div>
      </div>
    </div>

    <div class="col-md-6 mb-6">
      <div class="card h-100">
        <h5 class="card-header">Update Password</h5>
        <div class="card-body">
          <form action="{{ route('profile.password.update') }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-6">
              <label for="current_password" class="form-label">Current Password</label>
              <input
                type="password"
                id="current_password"
                name="current_password"
                class="form-control @error('current_password') is-invalid @enderror"
                autocomplete="current-password"
                required />
              @error('current_password')
                <div class="invalid-feedback d-block">{{ $message }}</div>
              @enderror
            </div>

            <div class="mb-6">
              <label for="password" class="form-label">New Password</label>
              <input
                type="password"
                id="password"
                name="password"
                class="form-control @error('password') is-invalid @enderror"
                autocomplete="new-password"
                required />
              @error('password')
                <div class="invalid-feedback d-block">{{ $message }}</div>
              @enderror
            </div>

            <div class="mb-6">
              <label for="password_confirmation" class="form-label">Confirm New Password</label>
              <input
                type="password"
                id="password_confirmation"
                name="password_confirmation"
                class="form-control"
                autocomplete="new-password"
                required />
            </div>

            <button type="submit" class="btn btn-primary">Update Password</button>
          </form>
        </div>
      </div>
    </div>
  </div>
@endsection
