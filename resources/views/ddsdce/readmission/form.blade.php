@php
    $letter = $readmissionLetter ?? null;
    $displaySignatory = $letter->signatory ?? $defaultSignatory ?? null;
    $studentsForJs = $students->map(fn ($student) => [
        'id' => $student->id,
        'name' => $student->name,
        'matric_no' => $student->matric_no,
        'program' => $student->program->name_en ?? '—',
        'department' => $student->department->name_en ?? '—',
        'kulliyyah' => $student->department->kulliyyah->name_en ?? '—',
    ]);

    // Readmission Semester is only ever recent — limit the list to the most
    // recent sessions, but keep whatever an existing letter already has
    // selected even if it has since fallen out of that recent window.
    $sessionOptions = $academicSessions->take(6);
    if ($letter && $letter->readmission_academic_session_id && ! $sessionOptions->contains('id', $letter->readmission_academic_session_id)) {
        $extra = $academicSessions->firstWhere('id', $letter->readmission_academic_session_id);
        if ($extra) {
            $sessionOptions = $sessionOptions->push($extra);
        }
    }
@endphp

<div class="row">
  <div class="col-md-6 mb-6 position-relative">
    <label for="student_search" class="form-label">Student</label>
    <input
      type="text"
      id="student_search"
      class="form-control @error('student_id') is-invalid @enderror"
      placeholder="Type matric no. or name to search…"
      value="{{ $letter ? $letter->student->name.' ('.$letter->student->matric_no.')' : '' }}"
      autocomplete="off"
      required />
    <input type="hidden" id="student_id" name="student_id" value="{{ old('student_id', $letter->student_id ?? '') }}" />
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
      value="{{ $letter->student->program->name_en ?? '' }}" />
  </div>

  <div class="col-md-3 mb-6">
    <label class="form-label">Kulliyyah (auto-filled)</label>
    <input type="text" id="kulliyyah_preview" class="form-control" readonly
      value="{{ $letter->student->department->kulliyyah->name_en ?? '' }}" />
  </div>

  <div class="col-md-4 mb-6">
    <label for="readmission_academic_session_id" class="form-label">Readmission Semester</label>
    <select id="readmission_academic_session_id" name="readmission_academic_session_id" class="form-select @error('readmission_academic_session_id') is-invalid @enderror" required>
      <option value="">Select semester…</option>
      @foreach ($sessionOptions as $session)
        <option value="{{ $session->id }}" {{ (int) old('readmission_academic_session_id', $letter->readmission_academic_session_id ?? '') === $session->id ? 'selected' : '' }}>
          {{ $session->label() }}
        </option>
      @endforeach
    </select>
    @error('readmission_academic_session_id')
      <div class="invalid-feedback d-block">{{ $message }}</div>
    @enderror
  </div>

  <div class="col-md-4 mb-6">
    <label for="readmission_condition_id" class="form-label">Readmission Condition</label>
    <select id="readmission_condition_id" name="readmission_condition_id" class="form-select @error('readmission_condition_id') is-invalid @enderror" required>
      <option value="">Select condition…</option>
      @foreach ($readmissionConditions as $condition)
        <option value="{{ $condition->id }}" {{ (int) old('readmission_condition_id', $letter->readmission_condition_id ?? '') === $condition->id ? 'selected' : '' }}>
          {{ $condition->name }}
        </option>
      @endforeach
    </select>
    @error('readmission_condition_id')
      <div class="invalid-feedback d-block">{{ $message }}</div>
    @enderror
  </div>

  <div class="col-md-4 mb-6">
    <label for="date" class="form-label">Date</label>
    <input
      type="date"
      id="date"
      name="date"
      class="form-control @error('date') is-invalid @enderror"
      value="{{ old('date', optional($letter?->date)->format('Y-m-d') ?? now()->format('Y-m-d')) }}"
      required />
    @error('date')
      <div class="invalid-feedback d-block">{{ $message }}</div>
    @enderror
  </div>

  <div class="col-md-4 mb-6">
    <label for="meeting_number" class="form-label">Meeting No.</label>
    <input
      type="text"
      id="meeting_number"
      name="meeting_number"
      class="form-control @error('meeting_number') is-invalid @enderror"
      placeholder="e.g. 6/2026"
      value="{{ old('meeting_number', $letter->meeting_number ?? '') }}" />
    @error('meeting_number')
      <div class="invalid-feedback d-block">{{ $message }}</div>
    @enderror
  </div>

  <div class="col-md-4 mb-6">
    <label for="meeting_date" class="form-label">Meeting Date</label>
    <input
      type="date"
      id="meeting_date"
      name="meeting_date"
      class="form-control @error('meeting_date') is-invalid @enderror"
      value="{{ old('meeting_date', optional($letter?->meeting_date)->format('Y-m-d') ?? '') }}" />
    @error('meeting_date')
      <div class="invalid-feedback d-block">{{ $message }}</div>
    @enderror
  </div>

  <div class="col-md-6 mb-6">
    <label class="form-label">Signatory (auto-filled)</label>
    <input
      type="text"
      class="form-control"
      readonly
      value="{{ $displaySignatory ? $displaySignatory->name.' — '.$displaySignatory->designation_en : 'No active signatory configured' }}" />
    <input type="hidden" name="signatory_id" value="{{ $displaySignatory->id ?? '' }}" />
    @error('signatory_id')
      <div class="invalid-feedback d-block">{{ $message }}</div>
    @enderror
  </div>

  <div class="col-md-6 mb-6">
    <label for="language" class="form-label">Language</label>
    <select id="language" name="language" class="form-select" required>
      <option value="en" selected>English</option>
    </select>
    <div class="form-text">Bahasa Melayu template will be added once a sample is available.</div>
  </div>
</div>

<div class="mt-4">
  <button type="submit" class="btn btn-primary">Save</button>
  <a href="{{ route('ddsdce.readmission.index') }}" class="btn btn-outline-secondary">Cancel</a>
</div>

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
