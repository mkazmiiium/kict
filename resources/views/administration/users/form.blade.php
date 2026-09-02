@php
    $user = $user ?? null;
    $selectedRoles = old('roles', $user?->roles->pluck('name')->all() ?? []);
@endphp

<div class="row">
  <div class="col-md-6 mb-6">
    <label for="name" class="form-label">Name</label>
    <input
      type="text"
      id="name"
      name="name"
      class="form-control @error('name') is-invalid @enderror"
      value="{{ old('name', $user->name ?? '') }}"
      required
      autofocus />
    @error('name')
      <div class="invalid-feedback d-block">{{ $message }}</div>
    @enderror
  </div>

  <div class="col-md-6 mb-6">
    <label for="email" class="form-label">Email</label>
    <input
      type="email"
      id="email"
      name="email"
      class="form-control @error('email') is-invalid @enderror"
      value="{{ old('email', $user->email ?? '') }}"
      required />
    @error('email')
      <div class="invalid-feedback d-block">{{ $message }}</div>
    @enderror
  </div>

  <div class="col-md-6 mb-6">
    <label for="password" class="form-label">
      Password
      @if ($user)
        <span class="text-body-secondary">(leave blank to keep current)</span>
      @endif
    </label>
    <input
      type="password"
      id="password"
      name="password"
      class="form-control @error('password') is-invalid @enderror"
      {{ $user ? '' : 'required' }} />
    @error('password')
      <div class="invalid-feedback d-block">{{ $message }}</div>
    @enderror
  </div>

  <div class="col-md-6 mb-6">
    <label for="password_confirmation" class="form-label">Confirm Password</label>
    <input
      type="password"
      id="password_confirmation"
      name="password_confirmation"
      class="form-control" />
  </div>

  <div class="col-12 mb-6">
    <label class="form-label d-block">Roles</label>
    <div class="d-flex flex-wrap gap-4">
      @foreach ($roles as $role)
        <div class="form-check">
          <input
            type="checkbox"
            id="role_{{ $role->id }}"
            name="roles[]"
            value="{{ $role->name }}"
            class="form-check-input"
            {{ in_array($role->name, $selectedRoles) ? 'checked' : '' }} />
          <label for="role_{{ $role->id }}" class="form-check-label">{{ $role->name }}</label>
        </div>
      @endforeach
    </div>
    @error('roles')
      <div class="invalid-feedback d-block">{{ $message }}</div>
    @enderror
  </div>
</div>

<button type="submit" class="btn btn-primary">Save</button>
<a href="{{ route('administration.users.index') }}" class="btn btn-outline-secondary">Cancel</a>
