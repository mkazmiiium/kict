@php
    $student = $student ?? null;
@endphp

<div class="row">
  <div class="col-md-6 mb-6">
    <label for="name" class="form-label">Name</label>
    <input
      type="text"
      id="name"
      name="name"
      class="form-control @error('name') is-invalid @enderror"
      value="{{ old('name', $student->name ?? '') }}"
      required
      autofocus />
    @error('name')
      <div class="invalid-feedback d-block">{{ $message }}</div>
    @enderror
  </div>

  <div class="col-md-3 mb-6">
    <label for="email" class="form-label">Email</label>
    <input
      type="email"
      id="email"
      name="email"
      class="form-control @error('email') is-invalid @enderror"
      value="{{ old('email', $student->email ?? '') }}" />
    <div class="form-text">Used for disciplinary notice emails.</div>
    @error('email')
      <div class="invalid-feedback d-block">{{ $message }}</div>
    @enderror
  </div>

  <div class="col-md-3 mb-6">
    <label for="phone_no" class="form-label">Phone No.</label>
    <input
      type="text"
      id="phone_no"
      name="phone_no"
      class="form-control @error('phone_no') is-invalid @enderror"
      value="{{ old('phone_no', $student->phone_no ?? '') }}" />
    @error('phone_no')
      <div class="invalid-feedback d-block">{{ $message }}</div>
    @enderror
  </div>

  <div class="col-md-3 mb-6">
    <label for="matric_no" class="form-label">Matric No.</label>
    <input
      type="text"
      id="matric_no"
      name="matric_no"
      class="form-control @error('matric_no') is-invalid @enderror"
      value="{{ old('matric_no', $student->matric_no ?? '') }}"
      required />
    @error('matric_no')
      <div class="invalid-feedback d-block">{{ $message }}</div>
    @enderror
  </div>

  <div class="col-md-3 mb-6">
    <label for="gender" class="form-label">Gender</label>
    <select id="gender" name="gender" class="form-select @error('gender') is-invalid @enderror">
      <option value="">Not specified</option>
      <option value="male" {{ old('gender', $student->gender ?? '') === 'male' ? 'selected' : '' }}>Male</option>
      <option value="female" {{ old('gender', $student->gender ?? '') === 'female' ? 'selected' : '' }}>Female</option>
    </select>
    @error('gender')
      <div class="invalid-feedback d-block">{{ $message }}</div>
    @enderror
  </div>

  <div class="col-md-3 mb-6">
    <label for="passport_no" class="form-label">Passport No.</label>
    <input
      type="text"
      id="passport_no"
      name="passport_no"
      class="form-control @error('passport_no') is-invalid @enderror"
      value="{{ old('passport_no', $student->passport_no ?? '') }}" />
    @error('passport_no')
      <div class="invalid-feedback d-block">{{ $message }}</div>
    @enderror
  </div>

  <div class="col-md-3 mb-6">
    <label for="nric_no" class="form-label">NRIC No.</label>
    <input
      type="text"
      id="nric_no"
      name="nric_no"
      class="form-control @error('nric_no') is-invalid @enderror"
      value="{{ old('nric_no', $student->nric_no ?? '') }}" />
    @error('nric_no')
      <div class="invalid-feedback d-block">{{ $message }}</div>
    @enderror
  </div>

  <div class="col-md-3 mb-6">
    <label for="department_id" class="form-label">Department</label>
    <select id="department_id" name="department_id" class="form-select @error('department_id') is-invalid @enderror" required>
      <option value="">Select department…</option>
      @foreach ($departments as $department)
        <option
          value="{{ $department->id }}"
          {{ (int) old('department_id', $student->department_id ?? '') === $department->id ? 'selected' : '' }}>
          {{ $department->name_en }}
        </option>
      @endforeach
    </select>
    @error('department_id')
      <div class="invalid-feedback d-block">{{ $message }}</div>
    @enderror
  </div>

  <div class="col-md-3 mb-6">
    <label for="program_id" class="form-label">Program</label>
    <select id="program_id" name="program_id" class="form-select @error('program_id') is-invalid @enderror" required>
      <option value="">Select program…</option>
      @foreach ($programs as $program)
        <option
          value="{{ $program->id }}"
          {{ (int) old('program_id', $student->program_id ?? '') === $program->id ? 'selected' : '' }}>
          {{ $program->name_en }}
        </option>
      @endforeach
    </select>
    @error('program_id')
      <div class="invalid-feedback d-block">{{ $message }}</div>
    @enderror
  </div>

  <div class="col-md-3 mb-6">
    <label for="year_of_study" class="form-label">Year of Study</label>
    <input
      type="number"
      id="year_of_study"
      name="year_of_study"
      min="1"
      max="8"
      class="form-control @error('year_of_study') is-invalid @enderror"
      value="{{ old('year_of_study', $student->year_of_study ?? '') }}" />
    @error('year_of_study')
      <div class="invalid-feedback d-block">{{ $message }}</div>
    @enderror
  </div>

  <div class="col-md-3 mb-6">
    <label for="status" class="form-label">Status</label>
    <select id="status" name="status" class="form-select @error('status') is-invalid @enderror" required>
      @foreach (['active' => 'Active', 'inactive' => 'Inactive', 'graduated' => 'Graduated'] as $value => $label)
        <option value="{{ $value }}" {{ old('status', $student->status ?? 'active') === $value ? 'selected' : '' }}>
          {{ $label }}
        </option>
      @endforeach
    </select>
    @error('status')
      <div class="invalid-feedback d-block">{{ $message }}</div>
    @enderror
  </div>
</div>

<button type="submit" class="btn btn-primary">Save</button>
<a href="{{ route('administration.students.index') }}" class="btn btn-outline-secondary">Cancel</a>
