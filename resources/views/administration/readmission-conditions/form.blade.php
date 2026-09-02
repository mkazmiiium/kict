@php
    $condition = $condition ?? null;
@endphp

<div class="row">
  <div class="col-md-6 mb-6">
    <label for="name" class="form-label">Name</label>
    <input
      type="text"
      id="name"
      name="name"
      class="form-control @error('name') is-invalid @enderror"
      value="{{ old('name', $condition->name ?? '') }}"
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
        {{ old('is_active', $condition->is_active ?? true) ? 'checked' : '' }} />
      <label for="is_active" class="form-check-label">Active</label>
    </div>
  </div>

  <div class="col-md-12 mb-6">
    <label for="footnote_text" class="form-label">Footnote Text</label>
    <textarea
      id="footnote_text"
      name="footnote_text"
      rows="4"
      class="form-control @error('footnote_text') is-invalid @enderror"
      required>{{ old('footnote_text', $condition->footnote_text ?? '') }}</textarea>
    <div class="form-text">Shown in bold-italic at the bottom of the readmission letter, prefixed with an asterisk.</div>
    @error('footnote_text')
      <div class="invalid-feedback d-block">{{ $message }}</div>
    @enderror
  </div>
</div>

<button type="submit" class="btn btn-primary">Save</button>
<a href="{{ route('administration.readmission-conditions.index') }}" class="btn btn-outline-secondary">Cancel</a>
