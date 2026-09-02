@php
    $record = $dsuStudent ?? null;
    $studentsForJs = $students->map(fn ($student) => [
        'id' => $student->id,
        'name' => $student->name,
        'matric_no' => $student->matric_no,
        'program' => $student->program->name_en ?? '—',
        'department' => $student->department->name_en ?? '—',
        'kulliyyah' => $student->department->kulliyyah->name_en ?? '—',
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
    <label class="form-label">Kulliyyah (auto-filled)</label>
    <input type="text" id="kulliyyah_preview" class="form-control" readonly
      value="{{ $record->student->department->kulliyyah->name_en ?? '' }}" />
  </div>

  <div class="col-md-4 mb-6">
    <label for="disability_category_id" class="form-label">Type of Disability</label>
    <select id="disability_category_id" name="disability_category_id" class="form-select @error('disability_category_id') is-invalid @enderror">
      <option value="">=== Please Select ===</option>
      @foreach ($disabilityCategories as $category)
        <option value="{{ $category->id }}" {{ (int) old('disability_category_id', $record->disability_category_id ?? '') === $category->id ? 'selected' : '' }}>
          {{ $category->code }} - {{ $category->name }}
        </option>
      @endforeach
    </select>
    @error('disability_category_id')
      <div class="invalid-feedback d-block">{{ $message }}</div>
    @enderror
  </div>

  <div class="col-md-4 mb-6">
    <label for="disability_detail" class="form-label">Detail</label>
    <input
      type="text"
      id="disability_detail"
      name="disability_detail"
      class="form-control @error('disability_detail') is-invalid @enderror"
      placeholder="e.g. Autism, ADHD, Physical (lower limb)"
      value="{{ old('disability_detail', $record->disability_detail ?? '') }}" />
    @error('disability_detail')
      <div class="invalid-feedback d-block">{{ $message }}</div>
    @enderror
  </div>

  <div class="col-md-4 mb-6">
    <label for="disabled_since" class="form-label">Disabled Since</label>
    <input
      type="text"
      id="disabled_since"
      name="disabled_since"
      class="form-control @error('disabled_since') is-invalid @enderror"
      placeholder="e.g. Birth, 2018, 6 years old"
      value="{{ old('disabled_since', $record->disabled_since ?? '') }}" />
    @error('disabled_since')
      <div class="invalid-feedback d-block">{{ $message }}</div>
    @enderror
  </div>

  <div class="col-md-4 mb-6">
    <label for="equipment_used" class="form-label">Usage of Equipment</label>
    <input
      type="text"
      id="equipment_used"
      name="equipment_used"
      class="form-control @error('equipment_used') is-invalid @enderror"
      placeholder="e.g. Wheelchair, Walking stick, None"
      value="{{ old('equipment_used', $record->equipment_used ?? '') }}" />
    @error('equipment_used')
      <div class="invalid-feedback d-block">{{ $message }}</div>
    @enderror
  </div>

  <div class="col-md-4 mb-6">
    <label for="joined_academic_session_id" class="form-label">Joined Semester</label>
    <select id="joined_academic_session_id" name="joined_academic_session_id" class="form-select @error('joined_academic_session_id') is-invalid @enderror" required>
      <option value="">Select semester…</option>
      @foreach ($academicSessions as $session)
        <option value="{{ $session->id }}" {{ (int) old('joined_academic_session_id', $record->joined_academic_session_id ?? '') === $session->id ? 'selected' : '' }}>
          {{ $session->label() }}
        </option>
      @endforeach
    </select>
    <div class="form-text">Short semesters (Semester 3) are excluded — a student always joins in Semester 1 or 2.</div>
    @error('joined_academic_session_id')
      <div class="invalid-feedback d-block">{{ $message }}</div>
    @enderror
  </div>

  @if ($record)
    <div class="col-md-4 mb-6">
      <label class="form-label">Semesters Completed (auto-calculated)</label>
      <input type="text" class="form-control" readonly value="{{ $record->semestersSinceJoining() ?? '—' }}" />
      <div class="form-text">Not stored — recalculated each time based on the current semester setting.</div>
    </div>
  @endif

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
<a href="{{ route('ddsdce.dsu.index') }}" class="btn btn-outline-secondary">Cancel</a>

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
      const kulliyyahPreview = document.getElementById('kulliyyah_preview');

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
        kulliyyahPreview.value = student ? student.kulliyyah : '';
      }
    });
  </script>
@endpush
