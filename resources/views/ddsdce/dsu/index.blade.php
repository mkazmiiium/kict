@extends('layouts.app')

@section('title', 'DSU Students')

@php
  $columns = [
      'student_name' => 'Name',
      'matric_no' => 'Matric No.',
      'disability_category' => 'Disability',
      'joined_academic_session_id' => 'Joined Semester',
  ];
@endphp

@section('content')
  <h4 class="mb-6">DDSDCE Office / DSU Students</h4>

  @if (session('status'))
    <div class="alert alert-success alert-dismissible" role="alert">
      {{ session('status') }}
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
  @endif

  <div class="card">
    <div class="card-header d-flex align-items-center justify-content-between flex-wrap gap-3">
      <h5 class="mb-0">DSU Students</h5>

      <div class="d-flex align-items-center gap-3">
        <form action="{{ route('ddsdce.dsu.index') }}" method="GET" class="d-flex">
          <input type="hidden" name="sort" value="{{ $sort }}" />
          <input type="hidden" name="direction" value="{{ $direction }}" />
          <input
            type="text"
            name="search"
            class="form-control"
            placeholder="Search name, matric no., disability..."
            value="{{ $search }}" />
          <button type="submit" class="btn btn-outline-secondary ms-2">
            <i class="icon-base bx bx-search"></i>
          </button>
          @include('partials.per-page-select')
        </form>

        <a href="{{ route('ddsdce.dsu.export-pdf', request()->query()) }}" class="btn btn-outline-secondary" title="Export current list to PDF">
          <i class="icon-base bx bxs-file-pdf"></i>
        </a>

        <a href="{{ route('ddsdce.dsu.create') }}" class="btn btn-primary text-nowrap">
          <i class="icon-base bx bx-plus me-1"></i> Add New
        </a>
      </div>
    </div>

    <div class="table-responsive text-nowrap">
      <table class="table">
        <thead class="table-light">
          <tr>
            @foreach ($columns as $column => $label)
              @php
                $newDirection = ($sort === $column && $direction === 'asc') ? 'desc' : 'asc';
              @endphp
              <th>
                <a
                  href="{{ route('ddsdce.dsu.index', ['sort' => $column, 'direction' => $newDirection, 'search' => $search]) }}"
                  class="text-body text-decoration-none">
                  {{ $label }}
                  @if ($sort === $column)
                    <i class="icon-base bx {{ $direction === 'asc' ? 'bx-chevron-up' : 'bx-chevron-down' }}"></i>
                  @endif
                </a>
              </th>
            @endforeach
            <th>Semesters</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody class="table-border-bottom-0">
          @forelse ($dsuStudents as $dsu)
            <tr>
              <td>{{ $dsu->student->name }}</td>
              <td>{{ $dsu->student->matric_no }}</td>
              <td>
                {{ $dsu->disabilityCategory->code ?? '—' }}
                @if ($dsu->disability_detail)
                  - {{ $dsu->disability_detail }}
                @endif
              </td>
              <td>{{ $dsu->joinedAcademicSession->label() }}</td>
              <td>{{ $dsu->semestersSinceJoining() ?? '—' }}</td>
              <td>
                <div class="d-flex gap-2">
                  <a href="{{ route('ddsdce.dsu.show', $dsu) }}" class="btn btn-icon btn-sm btn-text-secondary" title="View">
                    <i class="icon-base bx bx-show"></i>
                  </a>
                  <a href="{{ route('ddsdce.dsu.edit', $dsu) }}" class="btn btn-icon btn-sm btn-text-primary" title="Edit">
                    <i class="icon-base bx bx-edit"></i>
                  </a>
                  <form action="{{ route('ddsdce.dsu.destroy', $dsu) }}" method="POST"
                    onsubmit="return confirm('Delete DSU record for {{ $dsu->student->name }}?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-icon btn-sm btn-text-danger" title="Delete">
                      <i class="icon-base bx bx-trash"></i>
                    </button>
                  </form>
                </div>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="6" class="text-center text-body-secondary py-6">No DSU students yet.</td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    @if ($dsuStudents->hasPages())
      <div class="card-footer">
        {{ $dsuStudents->links('pagination::sneat') }}
      </div>
    @endif
  </div>
@endsection
