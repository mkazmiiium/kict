@php
    $letter = $attendanceLetter ?? null;
    $selectedSessionIds = $letter ? $letter->academicSessions->pluck('id')->all() : old('academic_session_ids', []);
    $displaySignatory = $letter->signatory ?? $defaultSignatory ?? null;
    $studentsForJs = $students->map(fn ($student) => [
        'id' => $student->id,
        'name' => $student->name,
        'matric_no' => $student->matric_no,
        'gender' => $student->gender,
        'program' => $student->program->name_en ?? '—',
        'department' => $student->department->name_en ?? '—',
        'department_bm' => $student->department->name_bm ?? $student->department->name_en ?? '',
        'kulliyyah_bm' => $student->department->kulliyyah->name_bm ?? '',
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
    <label class="form-label">Program (auto-filled)</label>
    <input type="text" id="program_preview" class="form-control" readonly
      value="{{ $letter->student->program->name_en ?? '' }}" />
  </div>

  <div class="col-md-3 mb-6">
    <label class="form-label">Department (auto-filled)</label>
    <input type="text" id="department_preview" class="form-control" readonly
      value="{{ $letter->student->department->name_en ?? '' }}" />
  </div>

  <div class="col-md-6 mb-6 position-relative">
    <label for="academic_session_search" class="form-label">Attendance Semester(s)</label>
    <input
      type="text"
      id="academic_session_search"
      class="form-control @error('academic_session_ids') is-invalid @enderror"
      placeholder="Click or type to filter semesters…"
      autocomplete="off" />
    <div
      id="academic_session_results"
      class="list-group position-absolute w-100 shadow"
      style="top: 100%; left: 0; z-index: 1050; max-height: 260px; overflow-y: auto; display: none; background-color: var(--bs-body-bg); border: 1px solid var(--bs-border-color); border-radius: 0.375rem;"></div>
    <select id="academic_session_ids" name="academic_session_ids[]" multiple class="d-none">
      @foreach ($academicSessions as $session)
        <option
          value="{{ $session->id }}"
          data-semester="{{ $session->semester }}"
          data-academic-year="{{ $session->academic_year }}"
          {{ in_array($session->id, $selectedSessionIds) ? 'selected' : '' }}>
          {{ $session->label() }}
        </option>
      @endforeach
    </select>
    <div class="form-text">Click to browse, or type to filter. Select as many semesters as needed.</div>
    @error('academic_session_ids')
      <div class="invalid-feedback d-block">{{ $message }}</div>
    @enderror
  </div>

  <div class="col-md-3 mb-6">
    <label for="attendance_percentage" class="form-label">Attendance % Met</label>
    <input
      type="number"
      step="0.01"
      min="0"
      max="100"
      id="attendance_percentage"
      name="attendance_percentage"
      class="form-control @error('attendance_percentage') is-invalid @enderror"
      value="{{ old('attendance_percentage', $letter->attendance_percentage ?? '80.00') }}"
      required />
    @error('attendance_percentage')
      <div class="invalid-feedback d-block">{{ $message }}</div>
    @enderror
  </div>

  <div class="col-md-3 mb-6">
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

  <div class="col-md-12 mb-6">
    <label for="body_text" class="form-label">Letter Content (auto-filled — you can edit before saving)</label>
    <textarea
      id="body_text"
      name="body_text"
      rows="8"
      class="form-control @error('body_text') is-invalid @enderror"
      required>{{ old('body_text', $letter->body_text ?? '') }}</textarea>
    <div class="form-text">Auto-fills when you pick the student, semester(s), or attendance %. Edit freely afterwards — e.g. to adjust wording if attendance is below 80%.</div>
    @error('body_text')
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
      <option value="bm" selected>Bahasa Melayu</option>
    </select>
    <div class="form-text">English template will be added once a sample is available.</div>
  </div>
</div>

<div class="mt-4">
  <button type="submit" class="btn btn-primary">Save</button>
  <a href="{{ route('ddsdce.attendance.index') }}" class="btn btn-outline-secondary">Cancel</a>
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
    #academic_session_results .list-group-item {
      background-color: var(--bs-body-bg);
      color: var(--bs-body-color);
      text-align: left;
      border-color: var(--bs-border-color);
      cursor: pointer;
    }
    #academic_session_results .list-group-item:hover,
    #academic_session_results .list-group-item:focus {
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
      const sessionSelect = document.getElementById('academic_session_ids');
      const sessionSearch = document.getElementById('academic_session_search');
      const sessionResults = document.getElementById('academic_session_results');
      const percentageInput = document.getElementById('attendance_percentage');
      const bodyText = document.getElementById('body_text');

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
        buildBodyText();
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

      function updateSessionSearchLabel() {
        const selected = Array.from(sessionSelect.selectedOptions).map((opt) => opt.textContent.trim());
        sessionSearch.value = selected.length ? selected.join(', ') : '';
      }

      function renderSessionResults(query) {
        const q = query.trim().toLowerCase();
        const options = Array.from(sessionSelect.options);
        const matches = q === ''
          ? options
          : options.filter((opt) => opt.textContent.toLowerCase().includes(q));

        sessionResults.innerHTML = '';

        if (matches.length === 0) {
          const empty = document.createElement('div');
          empty.className = 'list-group-item text-body-secondary';
          empty.textContent = 'No matching semesters';
          sessionResults.appendChild(empty);
          sessionResults.style.display = 'block';
          return;
        }

        matches.forEach((option) => {
          const item = document.createElement('label');
          item.className = 'list-group-item d-flex align-items-center gap-2';

          const checkbox = document.createElement('input');
          checkbox.type = 'checkbox';
          checkbox.className = 'form-check-input mt-0';
          checkbox.checked = option.selected;
          checkbox.addEventListener('change', function () {
            option.selected = checkbox.checked;
            updateSessionSearchLabel();
            buildBodyText();
          });

          const text = document.createElement('span');
          text.textContent = option.textContent.trim();

          item.appendChild(checkbox);
          item.appendChild(text);
          sessionResults.appendChild(item);
        });

        sessionResults.style.display = 'block';
      }

      sessionSearch.addEventListener('focus', function () {
        renderSessionResults(sessionSearch.value.includes(',') ? '' : sessionSearch.value);
      });

      sessionSearch.addEventListener('input', function () {
        renderSessionResults(sessionSearch.value);
      });

      document.addEventListener('click', function (event) {
        if (event.target !== sessionSearch && !sessionResults.contains(event.target)) {
          sessionResults.style.display = 'none';
          updateSessionSearchLabel();
        }
      });

      updateSessionSearchLabel();

      function buildSemesterText() {
        const selected = Array.from(sessionSelect.selectedOptions)
          .map((opt) => `semester ${opt.dataset.semester}, ${opt.dataset.academicYear}`);

        if (selected.length === 0) return '';
        if (selected.length === 1) return selected[0];

        const last = selected.pop();

        return selected.join(', ') + ' dan ' + last;
      }

      function buildBodyText() {
        const student = findStudent(studentIdInput.value);
        if (!student) return;

        const name = student.name || '';
        const gender = student.gender || '';
        const departmentBm = student.department_bm || '';
        const kulliyyahBm = student.kulliyyah_bm || '';

        const salutation = gender === 'male' ? 'Saudara' : (gender === 'female' ? 'Saudari' : 'Saudara/Saudari');

        const percentageValue = parseFloat(percentageInput.value);
        const percentage = isNaN(percentageValue) ? '' : percentageValue.toString();

        const semesterText = buildSemesterText();

        const paragraphs = [
          `Adalah dengan ini mengesahkan ${salutation} ${name} adalah pelajar dalam ${departmentBm} di ${kulliyyahBm}, Universiti Islam Antarabangsa Malaysia (UIAM).`,
          `Pelajar ini telah memenuhi keperluan ${percentage}% kehadiran dalam kelas bagi ${semesterText}.`,
          'Segala bantuan yang diberikan kepada pelajar ini adalah sangat dihargai.',
          'Sekian, terima kasih.',
        ];

        bodyText.value = paragraphs.join('\n\n');
      }

      percentageInput.addEventListener('change', buildBodyText);
    });
  </script>
@endpush
