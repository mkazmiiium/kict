@php
    $record = $disciplinaryRecord ?? null;
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

  <div class="col-md-2 mb-6">
    <label class="form-label">Program (auto-filled)</label>
    <input type="text" id="program_preview" class="form-control" readonly
      value="{{ $record->student->program->name_en ?? '' }}" />
  </div>

  <div class="col-md-2 mb-6">
    <label class="form-label">Department (auto-filled)</label>
    <input type="text" id="department_preview" class="form-control" readonly
      value="{{ $record->student->department->name_en ?? '' }}" />
  </div>

  <div class="col-md-2 mb-6">
    <label class="form-label">Kulliyyah (auto-filled)</label>
    <input type="text" id="kulliyyah_preview" class="form-control" readonly
      value="{{ $record->student->department->kulliyyah->name_en ?? '' }}" />
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
    <label for="offense_id" class="form-label">Offense</label>
    <select id="offense_id" name="offense_id" class="form-select @error('offense_id') is-invalid @enderror">
      <option value="">=== Please Select ===</option>
      @foreach ($offenses as $offense)
        <option value="{{ $offense->id }}" {{ (int) old('offense_id', $record->offense_id ?? '') === $offense->id ? 'selected' : '' }}>
          {{ $offense->name }}
        </option>
      @endforeach
    </select>
    @error('offense_id')
      <div class="invalid-feedback d-block">{{ $message }}</div>
    @enderror
  </div>

  <div class="col-md-4 mb-6">
    <label for="location" class="form-label">Location</label>
    <select id="location" name="location" class="form-select @error('location') is-invalid @enderror" required>
      @foreach (['KICT'] as $option)
        <option value="{{ $option }}" {{ old('location', $record->location ?? 'KICT') === $option ? 'selected' : '' }}>
          {{ $option }}
        </option>
      @endforeach
    </select>
    @error('location')
      <div class="invalid-feedback d-block">{{ $message }}</div>
    @enderror
  </div>

  <div class="col-md-12 mb-6">
    <label for="remarks" class="form-label">Remarks</label>
    <textarea
      id="remarks"
      name="remarks"
      rows="4"
      class="form-control @error('remarks') is-invalid @enderror">{{ old('remarks', $record->remarks ?? '') }}</textarea>
    @error('remarks')
      <div class="invalid-feedback d-block">{{ $message }}</div>
    @enderror
  </div>

  @if ($record && $record->photos->isNotEmpty())
    <div class="col-md-12 mb-6">
      <label class="form-label d-block">Existing Photos</label>
      <div class="d-flex flex-wrap gap-3">
        @foreach ($record->photos as $photo)
          <div class="position-relative">
            <a href="{{ $photo->url() }}" target="_blank" rel="noopener">
              <img src="{{ $photo->url() }}" alt="Photo evidence" style="width: 110px; height: 110px; object-fit: cover; border-radius: 0.375rem; border: 1px solid var(--bs-border-color);" />
            </a>
            <form
              action="{{ route('ddsdce.disciplinary.photos.destroy', [$record, $photo]) }}"
              method="POST"
              class="position-absolute top-0 end-0 m-1"
              onsubmit="return confirm('Remove this photo?');">
              @csrf
              @method('DELETE')
              <button type="submit" class="btn btn-icon btn-sm btn-danger" title="Remove photo">
                <i class="icon-base bx bx-x"></i>
              </button>
            </form>
          </div>
        @endforeach
      </div>
    </div>
  @endif

  <div class="col-md-12 mb-6">
    @php
      $existingPhotoCount = $record?->photos->count() ?? 0;
      $remainingSlots = 3 - $existingPhotoCount;
    @endphp
    <label for="photos" class="form-label">
      {{ $record ? 'Add More Photos' : 'Photos' }}
      <span class="text-body-secondary">(up to {{ $remainingSlots }} more, max 8MB each)</span>
    </label>
    @if ($remainingSlots > 0)
      <input
        type="file"
        id="photos"
        name="photos[]"
        class="form-control @error('photos') is-invalid @enderror @error('photos.*') is-invalid @enderror"
        accept="image/*"
        capture="environment"
        multiple />
      <div class="form-text">You can take a photo directly or choose from your gallery.</div>
    @else
      <div class="text-body-secondary">Maximum of 3 photos reached — remove one above to add another.</div>
    @endif
    @error('photos')
      <div class="invalid-feedback d-block">{{ $message }}</div>
    @enderror
    @error('photos.*')
      <div class="invalid-feedback d-block">{{ $message }}</div>
    @enderror
  </div>
</div>

@unless ($record)
  <div class="alert alert-info">
    Saving will automatically email the student a notice giving them 14 days to visit the DDSDCE
    Office, if an email address is on file for them.
  </div>
@endunless

<button type="submit" class="btn btn-primary">Save</button>
<a href="{{ route('ddsdce.disciplinary.index') }}" class="btn btn-outline-secondary">Cancel</a>

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
        departmentPreview.value = student ? student.department : '';
        kulliyyahPreview.value = student ? student.kulliyyah : '';
      }

      const photosInput = document.getElementById('photos');
      if (photosInput) {
        const remainingSlots = {{ $remainingSlots }};
        photosInput.addEventListener('change', function () {
          if (photosInput.files.length > remainingSlots) {
            alert(`You can only add up to ${remainingSlots} more photo(s).`);
            photosInput.value = '';
          }
        });
      }
    });
  </script>
@endpush
