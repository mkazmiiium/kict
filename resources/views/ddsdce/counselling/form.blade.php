@php
    $record = $counsellingRecord ?? null;
    $studentsForJs = $students->map(fn ($student) => [
        'id' => $student->id,
        'name' => $student->name,
        'matric_no' => $student->matric_no,
        'program' => $student->program->name_en ?? '—',
        'department' => $student->department->name_en ?? '—',
    ]);
@endphp

<div class="row">
  <div class="col-md-6 mb-6 position-relative">
    <label for="student_search" class="form-label">Student</label>
    <input
      type="text"
      id="student_search"
      class="form-control @error('student_id') is-invalid @enderror"
      placeholder="Type matric no. or name to search…"
      value="{{ $record ? $record->student->name.' ('.$record->student->matric_no.')' : '' }}"
      autocomplete="off"
      required />
    <input type="hidden" id="student_id" name="student_id" value="{{ old('student_id', $record->student_id ?? '') }}" />
    <div
      id="student_results"
      class="list-group position-absolute w-100 shadow"
      style="top: 100%; left: 0; z-index: 1050; max-height: 260px; overflow-y: auto; display: none; background-color: var(--bs-body-bg); border: 1px solid var(--bs-border-color); border-radius: 0.375rem;"></div>
    @error('student_id')
      <div class="invalid-feedback d-block">{{ $message }}</div>
    @enderror
  </div>

  <div class="col-md-3 mb-6">
    <label class="form-label">Programme (auto-filled)</label>
    <input type="text" id="program_preview" class="form-control" readonly
      value="{{ $record->student->program->name_en ?? '' }}" />
  </div>

  <div class="col-md-3 mb-6">
    <label class="form-label">Department (auto-filled)</label>
    <input type="text" id="department_preview" class="form-control" readonly
      value="{{ $record->student->department->name_en ?? '' }}" />
  </div>

  <div class="col-md-4 mb-6">
    <label for="date" class="form-label">Date</label>
    <input
      type="date"
      id="date"
      name="date"
      class="form-control @error('date') is-invalid @enderror"
      value="{{ old('date', optional($record?->date)->format('Y-m-d') ?? now()->format('Y-m-d')) }}"
      required />
    @error('date')
      <div class="invalid-feedback d-block">{{ $message }}</div>
    @enderror
  </div>

  <div class="col-md-4 mb-6">
    <label for="referred_by" class="form-label">Referred By</label>
    <input
      type="text"
      id="referred_by"
      name="referred_by"
      class="form-control @error('referred_by') is-invalid @enderror"
      placeholder="Lecturer's name"
      value="{{ old('referred_by', $record->referred_by ?? '') }}" />
    @error('referred_by')
      <div class="invalid-feedback d-block">{{ $message }}</div>
    @enderror
  </div>

  <div class="col-md-4 mb-6">
    <label for="emailed_to_ccsc_date" class="form-label">Date Emailed to CCSC</label>
    <input
      type="date"
      id="emailed_to_ccsc_date"
      name="emailed_to_ccsc_date"
      class="form-control @error('emailed_to_ccsc_date') is-invalid @enderror"
      value="{{ old('emailed_to_ccsc_date', optional($record?->emailed_to_ccsc_date)->format('Y-m-d') ?? '') }}" />
    @error('emailed_to_ccsc_date')
      <div class="invalid-feedback d-block">{{ $message }}</div>
    @enderror
  </div>

  <div class="col-md-12 mb-6">
    <label for="remarks" class="form-label">Remarks</label>
    <textarea
      id="remarks"
      name="remarks"
      rows="3"
      class="form-control @error('remarks') is-invalid @enderror">{{ old('remarks', $record->remarks ?? '') }}</textarea>
    @error('remarks')
      <div class="invalid-feedback d-block">{{ $message }}</div>
    @enderror
  </div>
</div>

<button type="submit" class="btn btn-primary">Save</button>
<a href="{{ route('ddsdce.counselling.index') }}" class="btn btn-outline-secondary">Cancel</a>

@push('page-css')
  <style>
    #student_results .list-group-item {
      background-color: var(--bs-body-bg);
      color: var(--bs-body-color);
      text-align: left;
      border-color: var(--bs-border-color);
    }
    #student_results .list-group-item:hover,
    #student_results .list-group-item:focus {
      background-color: var(--bs-tertiary-bg);
    }
  </style>
@endpush

@push('page-js')
  <script>
    document.addEventListener('DOMContentLoaded', function () {
      const studentsData = @json($studentsForJs);

      const studentSearch = document.getElementById('student_search');
      const studentIdInput = document.getElementById('student_id');
      const studentResults = document.getElementById('student_results');
      const programPreview = document.getElementById('program_preview');
      const departmentPreview = document.getElementById('department_preview');

      function findStudent(id) {
        return studentsData.find((s) => s.id === Number(id));
      }

      function renderStudentResults(query) {
        const q = query.trim().toLowerCase();

        if (q === '') {
          studentResults.style.display = 'none';
          studentResults.innerHTML = '';
          return;
        }

        const matches = studentsData
          .filter((s) => s.name.toLowerCase().includes(q) || s.matric_no.toLowerCase().includes(q))
          .slice(0, 20);

        studentResults.innerHTML = '';

        if (matches.length === 0) {
          const empty = document.createElement('div');
          empty.className = 'list-group-item text-body-secondary';
          empty.textContent = 'No matching students';
          studentResults.appendChild(empty);
          studentResults.style.display = 'block';
          return;
        }

        matches.forEach((student) => {
          const item = document.createElement('button');
          item.type = 'button';
          item.className = 'list-group-item list-group-item-action';
          item.textContent = `${student.name} (${student.matric_no})`;
          item.addEventListener('click', function () {
            selectStudent(student);
          });
          studentResults.appendChild(item);
        });

        studentResults.style.display = 'block';
      }

      function selectStudent(student) {
        studentIdInput.value = student.id;
        studentSearch.value = `${student.name} (${student.matric_no})`;
        studentResults.style.display = 'none';
        updatePreview();
      }

      studentSearch.addEventListener('input', function () {
        studentIdInput.value = '';
        renderStudentResults(studentSearch.value);
      });

      studentSearch.addEventListener('focus', function () {
        if (studentSearch.value.trim() !== '') renderStudentResults(studentSearch.value);
      });

      document.addEventListener('click', function (event) {
        if (event.target !== studentSearch && !studentResults.contains(event.target)) {
          studentResults.style.display = 'none';
        }
      });

      function updatePreview() {
        const student = findStudent(studentIdInput.value);
        programPreview.value = student ? student.program : '';
        departmentPreview.value = student ? student.department : '';
      }
    });
  </script>
@endpush
