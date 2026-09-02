@php
    $offense = $offense ?? null;
@endphp

<div class="row">
  <div class="col-md-6 mb-6">
    <label for="name" class="form-label">Name</label>
    <input
      type="text"
      id="name"
      name="name"
      class="form-control @error('name') is-invalid @enderror"
      value="{{ old('name', $offense->name ?? '') }}"
      required
      autofocus />
    @error('name')
      <div class="invalid-feedback d-block">{{ $message }}</div>
    @enderror
  </div>

  <div class="col-md-6 mb-6 d-flex align-items-end">
    <div class="form-check">
      <input
        type="checkbox"
        id="is_active"
        name="is_active"
        value="1"
        class="form-check-input"
        {{ old('is_active', $offense->is_active ?? true) ? 'checked' : '' }} />
      <label for="is_active" class="form-check-label">Active</label>
    </div>
  </div>
</div>

<button type="submit" class="btn btn-primary">Save</button>
<a href="{{ route('administration.offenses.index') }}" class="btn btn-outline-secondary">Cancel</a>
