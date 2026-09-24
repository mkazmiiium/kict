@php
    $letter = $completionLetter ?? null;
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

    $iaSessionOptions = $academicSessions->take(6);
    if ($letter && $letter->ia_academic_session_id && ! $iaSessionOptions->contains('id', $letter->ia_academic_session_id)) {
        $extra = $academicSessions->firstWhere('id', $letter->ia_academic_session_id);
        if ($extra) {
            $iaSessionOptions = $iaSessionOptions->push($extra);
        }
    }

    $graduationStatus = old('graduation_status', $letter->graduation_status ?? 'subject_to_endorsement');
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
    <label for="ia_academic_session_id" class="form-label">IAP Semester</label>
    <select id="ia_academic_session_id" name="ia_academic_session_id" class="form-select @error('ia_academic_session_id') is-invalid @enderror" required>
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

  <div class="col-md-4 mb-6">
    <div class="d-flex align-items-center justify-content-between">
      <label for="ia_completion_date" class="form-label mb-0">IAP Completion Date</label>
      <div class="form-check form-check-inline mb-0 ms-2">
        <input
          class="form-check-input"
          type="checkbox"
          id="include_ia_completion_date"
          {{ old('ia_completion_date', $letter->ia_completion_date ?? null) ? 'checked' : '' }} />
        <label class="form-check-label" for="include_ia_completion_date">Include</label>
      </div>
    </div>
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

  <div class="col-md-12 mb-3">
    <label class="form-label d-block">Graduation Status</label>
    <div class="form-check form-check-inline">
      <input
        class="form-check-input"
        type="radio"
        id="graduation_status_endorsement"
        name="graduation_status"
        value="subject_to_endorsement"
        {{ $graduationStatus === 'subject_to_endorsement' ? 'checked' : '' }} />
      <label class="form-check-label" for="graduation_status_endorsement">Subject to Graduation Endorsement Meeting</label>
    </div>
    <div class="form-check form-check-inline">
      <input
        class="form-check-input"
        type="radio"
        id="graduation_status_fulfilled"
        name="graduation_status"
        value="fulfilled"
        {{ $graduationStatus === 'fulfilled' ? 'checked' : '' }} />
      <label class="form-check-label" for="graduation_status_fulfilled">Fulfilled All Graduation Requirements</label>
    </div>
    @error('graduation_status')
      <div class="invalid-feedback d-block">{{ $message }}</div>
    @enderror
  </div>

  <div class="col-md-6 mb-6" id="graduation_semester_wrap">
    <label for="graduation_semester_text" class="form-label">Expected Graduation Semester</label>
    <input
      type="text"
      id="graduation_semester_text"
      name="graduation_semester_text"
      class="form-control @error('graduation_semester_text') is-invalid @enderror"
      placeholder="e.g. Semester 3, 2025/2026"
      value="{{ old('graduation_semester_text', $letter->graduation_semester_text ?? '') }}" />
    <div class="form-text">Free text — future semesters aren't in the reference list yet.</div>
    @error('graduation_semester_text')
      <div class="invalid-feedback d-block">{{ $message }}</div>
    @enderror
  </div>

  <div class="col-md-6 mb-6" id="expected_graduation_date_wrap">
    <label for="expected_graduation_date" class="form-label">Expected Graduation Date</label>
    <input
      type="date"
      id="expected_graduation_date"
      name="expected_graduation_date"
      class="form-control @error('expected_graduation_date') is-invalid @enderror"
      value="{{ old('expected_graduation_date', optional($letter?->expected_graduation_date)->format('Y-m-d') ?? '') }}" />
    @error('expected_graduation_date')
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
    <label for="signatory_id" class="form-label">Signatory</label>
    <select id="signatory_id" name="signatory_id" class="form-select @error('signatory_id') is-invalid @enderror" required>
      <option value="">Select signatory…</option>
      @foreach ($signatories as $signatory)
        <option value="{{ $signatory->id }}" {{ (int) old('signatory_id', $displaySignatory->id ?? '') === $signatory->id ? 'selected' : '' }}>
          {{ $signatory->name }} — {{ $signatory->designation_en }}
        </option>
      @endforeach
    </select>
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
  <a href="{{ route('ddsdce.completion.index') }}" class="btn btn-outline-secondary">Cancel</a>
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
      const joinedSessionSelect = document.getElementById('joined_academic_session_id');
      const iaSessionSelect = document.getElementById('ia_academic_session_id');
      const includeIaCompletionDateCheckbox = document.getElementById('include_ia_completion_date');
      const iaCompletionDateInput = document.getElementById('ia_completion_date');
      const graduationStatusEndorsement = document.getElementById('graduation_status_endorsement');
      const graduationStatusFulfilled = document.getElementById('graduation_status_fulfilled');
      const graduationSemesterInput = document.getElementById('graduation_semester_text');
      const graduationSemesterWrap = document.getElementById('graduation_semester_wrap');
      const expectedGraduationDateInput = document.getElementById('expected_graduation_date');
      const expectedGraduationDateWrap = document.getElementById('expected_graduation_date_wrap');
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

      function toggleGraduationStatusFields() {
        const fulfilled = graduationStatusFulfilled.checked;
        graduationSemesterWrap.style.display = fulfilled ? 'none' : '';
        expectedGraduationDateWrap.style.display = fulfilled ? '' : 'none';
      }

      function toggleIaCompletionDateField() {
        const show = includeIaCompletionDateCheckbox.checked;
        iaCompletionDateInput.style.display = show ? '' : 'none';
        if (!show) iaCompletionDateInput.value = '';
      }

      function formatDateLong(value) {
        if (!value) return '';
        const [year, month, day] = value.split('-').map(Number);
        const date = new Date(year, month - 1, day);
        return date.toLocaleDateString('en-GB', { day: 'numeric', month: 'long', year: 'numeric' });
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
        const yearOfStudy = student.year_of_study ? ordinal(student.year_of_study) : '';
        const studentName = toTitleCase(student.name || '');

        const paragraphs = [];

        paragraphs.push(
          `This is to certify that ${salutation} ${studentName} is a ${yearOfStudy} year student in the ${student.department}, ${student.kulliyyah}, International Islamic University Malaysia (IIUM).`
        );

        const iaOption = iaSessionSelect.options[iaSessionSelect.selectedIndex];
        if (iaOption && iaOption.value) {
          const iaSemesterLabel = `Semester ${iaOption.dataset.semester}, ${iaOption.dataset.academicYear}`;
          const completionText = includeIaCompletionDateCheckbox.checked ? formatDateLong(iaCompletionDateInput.value) : '';
          paragraphs.push(
            `The student has successfully completed the Industrial Attachment Programme in ${iaSemesterLabel}${completionText ? ` which ended on ${completionText}` : ''}.`
          );
        }

        const joinedOption = joinedSessionSelect.options[joinedSessionSelect.selectedIndex];
        if (joinedOption && joinedOption.value) {
          const joinedSentence = `The student has joined the ${student.kulliyyah} in Semester ${joinedOption.dataset.semester}, ${joinedOption.dataset.academicYear} academic session`;

          if (graduationStatusFulfilled.checked) {
            const expectedDateText = formatDateLong(expectedGraduationDateInput.value);
            paragraphs.push(
              `${joinedSentence}. The student has fulfilled and completed all the requirements for graduation${expectedDateText ? ` and is expected to graduate by ${expectedDateText}` : ''}.`
            );
          } else {
            const graduationText = graduationSemesterInput.value.trim();
            if (graduationText) {
              paragraphs.push(
                `${joinedSentence} and is expected to graduate in ${graduationText} subject to Graduation Endorsement Meeting.`
              );
            }
          }
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

      toggleGraduationStatusFields();
      toggleIaCompletionDateField();

      graduationStatusEndorsement.addEventListener('change', function () {
        toggleGraduationStatusFields();
        buildBodyText();
      });
      graduationStatusFulfilled.addEventListener('change', function () {
        toggleGraduationStatusFields();
        buildBodyText();
      });
      includeIaCompletionDateCheckbox.addEventListener('change', function () {
        toggleIaCompletionDateField();
        buildBodyText();
      });
      joinedSessionSelect.addEventListener('change', buildBodyText);
      iaSessionSelect.addEventListener('change', buildBodyText);
      iaCompletionDateInput.addEventListener('change', buildBodyText);
      graduationSemesterInput.addEventListener('change', buildBodyText);
      expectedGraduationDateInput.addEventListener('change', buildBodyText);
      contactEmailInput.addEventListener('change', buildBodyText);
    });
  </script>
@endpush
