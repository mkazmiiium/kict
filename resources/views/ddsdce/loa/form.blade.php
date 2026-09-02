@php
    $letter = $loaLetter ?? null;
    $displaySignatory = $letter->signatory ?? $defaultSignatory ?? null;
    $studentsForJs = $students->map(fn ($student) => [
        'id' => $student->id,
        'name' => $student->name,
        'matric_no' => $student->matric_no,
        'program' => $student->program->name_en ?? '—',
        'department' => $student->department->name_en ?? '—',
        'kulliyyah' => $student->department->kulliyyah->name_en ?? '—',
    ]);

    // Leave Semester is only ever recent — limit the list to the most recent
    // sessions, but keep whatever an existing letter already has selected
    // even if it has since fallen out of that recent window.
    $leaveSessionOptions = $academicSessions->take(6);
    if ($letter && $letter->leave_academic_session_id && ! $leaveSessionOptions->contains('id', $letter->leave_academic_session_id)) {
        $extra = $academicSessions->firstWhere('id', $letter->leave_academic_session_id);
        if ($extra) {
            $leaveSessionOptions = $leaveSessionOptions->push($extra);
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
    <label for="leave_academic_session_id" class="form-label">Leave Semester</label>
    <select id="leave_academic_session_id" name="leave_academic_session_id" class="form-select @error('leave_academic_session_id') is-invalid @enderror" required>
      <option value="">Select semester…</option>
      @foreach ($leaveSessionOptions as $session)
        <option
          value="{{ $session->id }}"
          data-semester="{{ $session->semester }}"
          data-academic-year="{{ $session->academic_year }}"
          {{ (int) old('leave_academic_session_id', $letter->leave_academic_session_id ?? '') === $session->id ? 'selected' : '' }}>
          {{ $session->label() }}
        </option>
      @endforeach
    </select>
    @error('leave_academic_session_id')
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

  <div class="col-md-4 mb-6">
    <label for="status" class="form-label">Status</label>
    <select id="status" name="status" class="form-select @error('status') is-invalid @enderror" required>
      <option value="approved" {{ old('status', $letter->status ?? 'approved') === 'approved' ? 'selected' : '' }}>Approved</option>
      <option value="rejected" {{ old('status', $letter->status ?? '') === 'rejected' ? 'selected' : '' }}>Rejected</option>
    </select>
    @error('status')
      <div class="invalid-feedback d-block">{{ $message }}</div>
    @enderror
  </div>

  <div class="col-md-4 mb-6">
    <label for="reason_type" class="form-label">Reason for Study Leave</label>
    <select id="reason_type" name="reason_type" class="form-select @error('reason_type') is-invalid @enderror" required>
      <option value="medical" {{ old('reason_type', $letter->reason_type ?? '') === 'medical' ? 'selected' : '' }}>Medical</option>
      <option value="maternity" {{ old('reason_type', $letter->reason_type ?? '') === 'maternity' ? 'selected' : '' }}>Maternity</option>
      <option value="other" {{ old('reason_type', $letter->reason_type ?? '') === 'other' ? 'selected' : '' }}>Other reason</option>
    </select>
    @error('reason_type')
      <div class="invalid-feedback d-block">{{ $message }}</div>
    @enderror
  </div>

  <div class="col-md-4 mb-6" id="other_reason_note_wrap">
    <label for="other_reason_note" class="form-label">Other Reason Note</label>
    <input
      type="text"
      id="other_reason_note"
      name="other_reason_note"
      class="form-control @error('other_reason_note') is-invalid @enderror"
      placeholder="e.g. Financial issue"
      value="{{ old('other_reason_note', $letter->other_reason_note ?? '') }}" />
    @error('other_reason_note')
      <div class="invalid-feedback d-block">{{ $message }}</div>
    @enderror
  </div>

  <div class="col-md-12 mb-6">
    <label for="remarks" class="form-label">Remarks</label>
    <textarea
      id="remarks"
      name="remarks"
      rows="4"
      class="form-control @error('remarks') is-invalid @enderror"
      placeholder="e.g. You are required to resume your studies in Semester 1, 2026/2027, which will begin on 28th September 2026. Failing to register during the registration period will result in the termination of your studies.">{{ old('remarks', $letter->remarks ?? '') }}</textarea>
    @error('remarks')
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

  <div class="col-md-4 mb-6">
    <label for="language" class="form-label">Language</label>
    <select id="language" name="language" class="form-select" required>
      <option value="en" selected>English</option>
    </select>
    <div class="form-text">Bahasa Melayu template will be added once a sample is available.</div>
  </div>
</div>

<div class="mt-4">
  <button type="submit" class="btn btn-primary">Save</button>
  <a href="{{ route('ddsdce.loa.index') }}" class="btn btn-outline-secondary">Cancel</a>
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
      const reasonTypeSelect = document.getElementById('reason_type');
      const otherReasonNoteWrap = document.getElementById('other_reason_note_wrap');
      const leaveSessionSelect = document.getElementById('leave_academic_session_id');
      const dateInput = document.getElementById('date');
      const remarksTextarea = document.getElementById('remarks');
      const isEditMode = {{ $letter ? 'true' : 'false' }};

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

      function toggleOtherReasonNote() {
        otherReasonNoteWrap.style.display = reasonTypeSelect.value === 'other' ? '' : 'none';
      }

      toggleOtherReasonNote();
      reasonTypeSelect.addEventListener('change', toggleOtherReasonNote);

      function ordinal(n) {
        n = Number(n);
        const suffixes = ['th', 'st', 'nd', 'rd'];
        const v = n % 100;
        return n + (suffixes[(v - 20) % 10] || suffixes[v] || suffixes[0]);
      }

      function nextSemesterLabel(semester, academicYear) {
        const [startYear, endYear] = academicYear.split('/').map(Number);

        if (semester === 1) {
          return `Semester 2, ${startYear}/${endYear}`;
        }

        return `Semester 1, ${startYear + 1}/${endYear + 1}`;
      }

      function formatDatePlusTwoMonths(dateValue) {
        if (!dateValue) return '';
        const [year, month, day] = dateValue.split('-').map(Number);
        const date = new Date(year, month - 1 + 2, day);
        const months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
        return `${ordinal(date.getDate())} ${months[date.getMonth()]} ${date.getFullYear()}`;
      }

      let lastAutoRemarks = remarksTextarea.value;

      function updateDefaultRemarks() {
        if (isEditMode) return;
        // Only overwrite if the field is still exactly what we last auto-filled
        // (or still empty) — i.e. the user hasn't typed their own edits over it.
        if (remarksTextarea.value !== lastAutoRemarks && remarksTextarea.value.trim() !== '') return;

        const option = leaveSessionSelect.options[leaveSessionSelect.selectedIndex];
        if (!option || !option.value || !dateInput.value) return;

        const nextSemester = nextSemesterLabel(Number(option.dataset.semester), option.dataset.academicYear);
        const resumeDate = formatDatePlusTwoMonths(dateInput.value);

        lastAutoRemarks = `You are required to resume your studies in ${nextSemester}, which will begin on ${resumeDate}. Failing to register during the registration period will result in the termination of your studies.`;
        remarksTextarea.value = lastAutoRemarks;
      }

      leaveSessionSelect.addEventListener('change', updateDefaultRemarks);
      dateInput.addEventListener('change', updateDefaultRemarks);
    });
  </script>
@endpush
