@php
    $letter = $expectedGraduationLetter ?? null;
    $displaySignatory = $letter->signatory ?? $defaultSignatory ?? null;
    $studentsForJs = $students->map(fn ($student) => [
        'id' => $student->id,
        'name' => $student->name,
        'matric_no' => $student->matric_no,
        'gender' => $student->gender,
        'year_of_study' => $student->year_of_study,
        'program' => $student->program->name_en ?? '—',
        'department' => $student->department->name_en ?? '—',
        'kulliyyah' => $student->department->kulliyyah->name_en ?? '',
    ]);

    // Currently Registered / CGPA semesters are only ever recent — limit the list to
    // the most recent sessions, but keep whatever an existing letter already has
    // selected even if it has since fallen out of that recent window.
    $currentSessionOptions = $academicSessions->take(6);
    if ($letter && $letter->current_academic_session_id && ! $currentSessionOptions->contains('id', $letter->current_academic_session_id)) {
        $extra = $academicSessions->firstWhere('id', $letter->current_academic_session_id);
        if ($extra) {
            $currentSessionOptions = $currentSessionOptions->push($extra);
        }
    }

    $cgpaSessionOptions = $academicSessions->take(3);
    if ($letter && $letter->cgpa_academic_session_id && ! $cgpaSessionOptions->contains('id', $letter->cgpa_academic_session_id)) {
        $extra = $academicSessions->firstWhere('id', $letter->cgpa_academic_session_id);
        if ($extra) {
            $cgpaSessionOptions = $cgpaSessionOptions->push($extra);
        }
    }

    $iaSessionOptions = $academicSessions->take(6);
    if ($letter && $letter->ia_academic_session_id && ! $iaSessionOptions->contains('id', $letter->ia_academic_session_id)) {
        $extra = $academicSessions->firstWhere('id', $letter->ia_academic_session_id);
        if ($extra) {
            $iaSessionOptions = $iaSessionOptions->push($extra);
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
    <label class="form-label">Program (auto-filled)</label>
    <input type="text" id="program_preview" class="form-control" readonly
      value="{{ $letter->student->program->name_en ?? '' }}" />
  </div>

  <div class="col-md-3 mb-6">
    <label class="form-label">Department (auto-filled)</label>
    <input type="text" id="department_preview" class="form-control" readonly
      value="{{ $letter->student->department->name_en ?? '' }}" />
  </div>

  <div class="col-md-4 mb-6">
    <label for="current_academic_session_id" class="form-label">Currently Registered Semester</label>
    <select id="current_academic_session_id" name="current_academic_session_id" class="form-select @error('current_academic_session_id') is-invalid @enderror">
      <option value="">Not applicable</option>
      @foreach ($currentSessionOptions as $session)
        <option
          value="{{ $session->id }}"
          data-semester="{{ $session->semester }}"
          data-academic-year="{{ $session->academic_year }}"
          {{ (int) old('current_academic_session_id', $letter->current_academic_session_id ?? '') === $session->id ? 'selected' : '' }}>
          {{ $session->label() }}
        </option>
      @endforeach
    </select>
    @error('current_academic_session_id')
      <div class="invalid-feedback d-block">{{ $message }}</div>
    @enderror
  </div>

  <div class="col-md-4 mb-6">
    <label for="joined_academic_session_id" class="form-label">Joined Semester</label>
    <select id="joined_academic_session_id" name="joined_academic_session_id" class="form-select @error('joined_academic_session_id') is-invalid @enderror" required>
      <option value="">Select semester…</option>
      @foreach ($academicSessions as $session)
        <option
          value="{{ $session->id }}"
          data-semester="{{ $session->semester }}"
          data-academic-year="{{ $session->academic_year }}"
          {{ (int) old('joined_academic_session_id', $letter->joined_academic_session_id ?? '') === $session->id ? 'selected' : '' }}>
          {{ $session->label() }}
        </option>
      @endforeach
    </select>
    @error('joined_academic_session_id')
      <div class="invalid-feedback d-block">{{ $message }}</div>
    @enderror
  </div>

  <div class="col-md-4 mb-6">
    <label for="graduation_semester_text" class="form-label">Expected Graduation Semester</label>
    <input
      type="text"
      id="graduation_semester_text"
      name="graduation_semester_text"
      class="form-control @error('graduation_semester_text') is-invalid @enderror"
      placeholder="e.g. Semester 3, 2025/2026"
      value="{{ old('graduation_semester_text', $letter->graduation_semester_text ?? '') }}"
      required />
    <div class="form-text">Free text — future semesters aren't in the reference list yet.</div>
    @error('graduation_semester_text')
      <div class="invalid-feedback d-block">{{ $message }}</div>
    @enderror
  </div>

  <div class="col-md-12 mb-3">
    <div class="form-check">
      <input
        class="form-check-input"
        type="checkbox"
        id="include_cgpa"
        name="include_cgpa"
        value="1"
        {{ old('include_cgpa', $letter->include_cgpa ?? false) ? 'checked' : '' }} />
      <label class="form-check-label" for="include_cgpa">Include CGPA statement</label>
    </div>
  </div>

  <div class="col-md-3 mb-6" id="cgpa_session_wrap">
    <label for="cgpa_academic_session_id" class="form-label">CGPA Semester</label>
    <select id="cgpa_academic_session_id" name="cgpa_academic_session_id" class="form-select @error('cgpa_academic_session_id') is-invalid @enderror">
      <option value="">Select semester…</option>
      @foreach ($cgpaSessionOptions as $session)
        <option
          value="{{ $session->id }}"
          data-semester="{{ $session->semester }}"
          data-academic-year="{{ $session->academic_year }}"
          {{ (int) old('cgpa_academic_session_id', $letter->cgpa_academic_session_id ?? '') === $session->id ? 'selected' : '' }}>
          {{ $session->label() }}
        </option>
      @endforeach
    </select>
    @error('cgpa_academic_session_id')
      <div class="invalid-feedback d-block">{{ $message }}</div>
    @enderror
  </div>

  <div class="col-md-3 mb-6" id="cgpa_value_wrap">
    <label for="cgpa" class="form-label">CGPA Value</label>
    <input
      type="number"
      step="0.01"
      min="0"
      max="4"
      id="cgpa"
      name="cgpa"
      class="form-control @error('cgpa') is-invalid @enderror"
      value="{{ old('cgpa', $letter->cgpa ?? '') }}" />
    @error('cgpa')
      <div class="invalid-feedback d-block">{{ $message }}</div>
    @enderror
  </div>

  <div class="col-md-12 mb-3">
    <div class="form-check">
      <input
        class="form-check-input"
        type="checkbox"
        id="include_ia_statement"
        name="include_ia_statement"
        value="1"
        {{ old('include_ia_statement', $letter->include_ia_statement ?? false) ? 'checked' : '' }} />
      <label class="form-check-label" for="include_ia_statement">Include IA statement</label>
    </div>
  </div>

  <div class="col-md-4 mb-6" id="ia_session_wrap">
    <label for="ia_academic_session_id" class="form-label">IAP Semester</label>
    <select id="ia_academic_session_id" name="ia_academic_session_id" class="form-select @error('ia_academic_session_id') is-invalid @enderror">
      <option value="">Select semester…</option>
      @foreach ($iaSessionOptions as $session)
        <option
          value="{{ $session->id }}"
          data-semester="{{ $session->semester }}"
          data-academic-year="{{ $session->academic_year }}"
          {{ (int) old('ia_academic_session_id', $letter->ia_academic_session_id ?? '') === $session->id ? 'selected' : '' }}>
          {{ $session->label() }}
        </option>
      @endforeach
    </select>
    @error('ia_academic_session_id')
      <div class="invalid-feedback d-block">{{ $message }}</div>
    @enderror
  </div>

  <div class="col-md-4 mb-6" id="ia_completion_date_wrap">
    <label for="ia_completion_date" class="form-label">IAP Completion Date (Optional)</label>
    <input
      type="date"
      id="ia_completion_date"
      name="ia_completion_date"
      class="form-control @error('ia_completion_date') is-invalid @enderror"
      value="{{ old('ia_completion_date', optional($letter?->ia_completion_date)->format('Y-m-d') ?? '') }}" />
    @error('ia_completion_date')
      <div class="invalid-feedback d-block">{{ $message }}</div>
    @enderror
  </div>

  <div class="col-md-6 mb-6">
    <label for="endorsing_body_text" class="form-label">Endorsing Body (auto-filled)</label>
    <input
      type="text"
      id="endorsing_body_text"
      name="endorsing_body_text"
      class="form-control @error('endorsing_body_text') is-invalid @enderror"
      value="{{ old('endorsing_body_text', $letter->endorsing_body_text ?? 'the Senate Graduation Committee') }}"
      readonly />
    @error('endorsing_body_text')
      <div class="invalid-feedback d-block">{{ $message }}</div>
    @enderror
  </div>

  <div class="col-md-6 mb-6">
    <label for="contact_email" class="form-label">Contact Email (optional)</label>
    <input
      type="email"
      id="contact_email"
      name="contact_email"
      class="form-control @error('contact_email') is-invalid @enderror"
      value="{{ old('contact_email', $letter->contact_email ?? 'kict_ddsdce@iium.edu.my') }}" />
    @error('contact_email')
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
      rows="10"
      class="form-control @error('body_text') is-invalid @enderror"
      required>{{ old('body_text', $letter->body_text ?? '') }}</textarea>
    <div class="form-text">Auto-fills as you fill in the fields above. Edit freely afterwards.</div>
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
      <option value="en" selected>English</option>
    </select>
    <div class="form-text">Bahasa Melayu template will be added once a sample is available.</div>
  </div>
</div>

<div class="mt-4">
  <button type="submit" class="btn btn-primary">Save</button>
  <a href="{{ route('ddsdce.expected-graduation.index') }}" class="btn btn-outline-secondary">Cancel</a>
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
      const departmentPreview = document.getElementById('department_preview');
      const currentSessionSelect = document.getElementById('current_academic_session_id');
      const joinedSessionSelect = document.getElementById('joined_academic_session_id');
      const graduationSemesterInput = document.getElementById('graduation_semester_text');
      const includeCgpaCheckbox = document.getElementById('include_cgpa');
      const cgpaSessionSelect = document.getElementById('cgpa_academic_session_id');
      const cgpaSessionWrap = document.getElementById('cgpa_session_wrap');
      const cgpaValueInput = document.getElementById('cgpa');
      const cgpaValueWrap = document.getElementById('cgpa_value_wrap');
      const includeIaCheckbox = document.getElementById('include_ia_statement');
      const iaSessionSelect = document.getElementById('ia_academic_session_id');
      const iaSessionWrap = document.getElementById('ia_session_wrap');
      const iaCompletionDateInput = document.getElementById('ia_completion_date');
      const iaCompletionDateWrap = document.getElementById('ia_completion_date_wrap');
      const endorsingBodyInput = document.getElementById('endorsing_body_text');
      const contactEmailInput = document.getElementById('contact_email');
      const bodyText = document.getElementById('body_text');

      function findStudent(id) {
        return studentsData.find((s) => s.id === Number(id));
      }

      function ordinal(n) {
        n = Number(n);
        const suffixes = ['th', 'st', 'nd', 'rd'];
        const v = n % 100;
        return n + (suffixes[(v - 20) % 10] || suffixes[v] || suffixes[0]);
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

      function toggleCgpaFields() {
        const show = includeCgpaCheckbox.checked;
        cgpaSessionWrap.style.display = show ? '' : 'none';
        cgpaValueWrap.style.display = show ? '' : 'none';
      }

      function toggleIaFields() {
        const show = includeIaCheckbox.checked;
        iaSessionWrap.style.display = show ? '' : 'none';
        iaCompletionDateWrap.style.display = show ? '' : 'none';
      }

      function formatDateLong(value) {
        if (!value) return '';
        const [year, month, day] = value.split('-').map(Number);
        const date = new Date(year, month - 1, day);
        return date.toLocaleDateString('en-GB', { day: 'numeric', month: 'long', year: 'numeric' });
      }

      function clampCgpaValue() {
        if (cgpaValueInput.value === '') return;
        const value = parseFloat(cgpaValueInput.value);
        if (isNaN(value)) return;
        if (value > 4) cgpaValueInput.value = '4.00';
        if (value < 0) cgpaValueInput.value = '0.00';
      }

      function toTitleCase(str) {
        return str.toLowerCase().replace(/(^|[\s'-])([a-z])/g, (match, separator, letter) => separator + letter.toUpperCase());
      }

      function buildBodyText() {
        const student = findStudent(studentIdInput.value);
        if (!student) return;

        const gender = student.gender;
        const salutation = gender === 'male' ? 'Br.' : (gender === 'female' ? 'Sr.' : 'Br./Sr.');
        const pronounSubject = gender === 'male' ? 'He' : (gender === 'female' ? 'She' : 'He/She');
        const pronounPossessive = gender === 'male' ? 'His' : (gender === 'female' ? 'Her' : 'His/Her');
        const yearOfStudy = student.year_of_study ? ordinal(student.year_of_study) : '';
        const studentName = toTitleCase(student.name || '');

        const paragraphs = [];

        paragraphs.push(
          `This is to certify that ${salutation} ${studentName} is a ${yearOfStudy} year student in the ${student.department}, ${student.kulliyyah}, International Islamic University Malaysia (IIUM).`
        );

        const currentOption = currentSessionSelect.options[currentSessionSelect.selectedIndex];
        const currentSentence = (currentOption && currentOption.value)
          ? `The student is currently registered in Semester ${currentOption.dataset.semester}, ${currentOption.dataset.academicYear}.`
          : '';

        let cgpaSentence = '';
        if (includeCgpaCheckbox.checked) {
          const cgpaOption = cgpaSessionSelect.options[cgpaSessionSelect.selectedIndex];
          if (cgpaOption && cgpaOption.value && cgpaValueInput.value) {
            cgpaSentence = `${pronounPossessive} CGPA in Semester ${cgpaOption.dataset.semester}, ${cgpaOption.dataset.academicYear} was ${cgpaValueInput.value}.`;
          }
        }

        const paragraph2 = [currentSentence, cgpaSentence].filter(Boolean).join(' ');
        if (paragraph2) paragraphs.push(paragraph2);

        if (includeIaCheckbox.checked) {
          const iaOption = iaSessionSelect.options[iaSessionSelect.selectedIndex];
          if (iaOption && iaOption.value) {
            const iaSemesterLabel = `Semester ${iaOption.dataset.semester}, ${iaOption.dataset.academicYear}`;
            const completionText = formatDateLong(iaCompletionDateInput.value);
            paragraphs.push(
              `${pronounSubject} is currently undergoing Industrial Attachment Programme in ${iaSemesterLabel}${completionText ? ` which will be completed by ${completionText}` : ''}.`
            );
          }
        }

        const joinedOption = joinedSessionSelect.options[joinedSessionSelect.selectedIndex];
        const graduationText = graduationSemesterInput.value.trim();
        if (joinedOption && joinedOption.value && graduationText) {
          const endorsingText = endorsingBodyInput.value.trim();
          paragraphs.push(
            `${pronounSubject} joined the ${student.kulliyyah} in Semester ${joinedOption.dataset.semester}, ${joinedOption.dataset.academicYear} academic session and is expected to graduate in ${graduationText} academic session${endorsingText ? `, subject to endorsement by ${endorsingText}` : ''}.`
          );
        }

        const contactEmail = contactEmailInput.value.trim();
        paragraphs.push(
          contactEmail
            ? `Any assistance rendered to the student is most appreciated. For any inquiry, please contact us at ${contactEmail}.`
            : 'Any assistance rendered to the student is most appreciated.'
        );

        paragraphs.push('Thank you, Wassalam.');

        bodyText.value = paragraphs.join('\n\n');
      }

      toggleCgpaFields();
      toggleIaFields();

      includeCgpaCheckbox.addEventListener('change', function () {
        toggleCgpaFields();
        buildBodyText();
      });
      includeIaCheckbox.addEventListener('change', function () {
        toggleIaFields();
        buildBodyText();
      });
      currentSessionSelect.addEventListener('change', buildBodyText);
      joinedSessionSelect.addEventListener('change', buildBodyText);
      graduationSemesterInput.addEventListener('change', buildBodyText);
      cgpaSessionSelect.addEventListener('change', buildBodyText);
      cgpaValueInput.addEventListener('change', function () {
        clampCgpaValue();
        buildBodyText();
      });
      iaSessionSelect.addEventListener('change', buildBodyText);
      iaCompletionDateInput.addEventListener('change', buildBodyText);
      endorsingBodyInput.addEventListener('change', buildBodyText);
      contactEmailInput.addEventListener('change', buildBodyText);
    });
  </script>
@endpush
