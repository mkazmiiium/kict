@extends('layouts.app')

@section('title', 'Reinstatement Records')

@php
  $columns = [
      'student_name' => 'Name',
      'matric_no' => 'Matric No.',
      'academic_session_id' => 'Semester',
      'cgpa' => 'CGPA',
      'date' => 'Date',
      'year_of_study' => 'Year of Study',
  ];
@endphp

@section('content')
  <h4 class="mb-6">DDSDCE Office / Reinstatement</h4>

  @if (session('status'))
    <div class="alert alert-success alert-dismissible" role="alert">
      {{ session('status') }}
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
  @endif

  <div class="card">
    <div class="card-header d-flex align-items-center justify-content-between flex-wrap gap-3">
      <h5 class="mb-0">Reinstatement Records</h5>

      <div class="d-flex align-items-center gap-3">
        <form action="{{ route('ddsdce.reinstate.index') }}" method="GET" class="d-flex">
          <input type="hidden" name="sort" value="{{ $sort }}" />
          <input type="hidden" name="direction" value="{{ $direction }}" />
          <input
            type="text"
            name="search"
            class="form-control"
            placeholder="Search name, matric no..."
            value="{{ $search }}" />
          <button type="submit" class="btn btn-outline-secondary ms-2">
            <i class="icon-base bx bx-search"></i>
          </button>
          @include('partials.per-page-select')
        </form>

        <a href="{{ route('ddsdce.reinstate.export-pdf', request()->query()) }}" class="btn btn-outline-secondary" title="Export current list to PDF">
          <i class="icon-base bx bxs-file-pdf"></i>
        </a>

        <a href="{{ route('ddsdce.reinstate.create') }}" class="btn btn-primary text-nowrap">
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
                  href="{{ route('ddsdce.reinstate.index', ['sort' => $column, 'direction' => $newDirection, 'search' => $search]) }}"
                  class="text-body text-decoration-none">
                  {{ $label }}
                  @if ($sort === $column)
                    <i class="icon-base bx {{ $direction === 'asc' ? 'bx-chevron-up' : 'bx-chevron-down' }}"></i>
                  @endif
                </a>
              </th>
            @endforeach
            <th>Action</th>
          </tr>
        </thead>
        <tbody class="table-border-bottom-0">
          @forelse ($reinstateRecords as $record)
            <tr>
              <td>{{ $record->student->name }}</td>
              <td>{{ $record->student->matric_no }}</td>
              <td>{{ $record->academicSession->label() }}</td>
              <td>{{ number_format((float) $record->cgpa, 2) }}</td>
              <td>{{ $record->date->format('d M Y') }}</td>
              <td>{{ $record->student->year_of_study ?? '—' }}</td>
              <td>
                <div class="d-flex gap-2">
                  <a href="{{ route('ddsdce.reinstate.edit', $record) }}" class="btn btn-icon btn-sm btn-text-primary" title="Edit">
                    <i class="icon-base bx bx-edit"></i>
                  </a>
                  <form action="{{ route('ddsdce.reinstate.destroy', $record) }}" method="POST"
                    onsubmit="return confirm('Delete reinstatement record for {{ $record->student->name }}?');">
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
              <td colspan="7" class="text-center text-body-secondary py-6">No reinstatement records yet.</td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    @if ($reinstateRecords->hasPages())
      <div class="card-footer">
        {{ $reinstateRecords->links('pagination::sneat') }}
      </div>
    @endif
  </div>
@endsection
