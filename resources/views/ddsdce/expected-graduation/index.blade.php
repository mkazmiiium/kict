@extends('layouts.app')

@section('title', 'Expected Graduation Letter')

@php
  $columns = [
      'reference_no' => 'Reference No.',
      'student_name' => 'Student Name',
      'matric_no' => 'Matric No.',
      'date' => 'Date Issued',
      'graduation_semester_text' => 'Expected Graduation',
      'include_cgpa' => 'CGPA Included?',
  ];

  $monthOptions = [
      1 => 'January', 2 => 'February', 3 => 'March', 4 => 'April',
      5 => 'May', 6 => 'June', 7 => 'July', 8 => 'August',
      9 => 'September', 10 => 'October', 11 => 'November', 12 => 'December',
  ];
  $yearOptions = range(now()->year + 1, 2019);
@endphp

@section('content')
  <h4 class="mb-6">DDSDCE Office / Expected Graduation Letter</h4>

  @if (session('status'))
    <div class="alert alert-success alert-dismissible" role="alert">
      {{ session('status') }}
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
  @endif

  <div class="card">
    <div class="card-header d-flex align-items-center justify-content-between flex-wrap gap-3">
      <h5 class="mb-0">Expected Graduation Letters</h5>

      <div class="d-flex align-items-center gap-3">
        <form action="{{ route('ddsdce.expected-graduation.index') }}" method="GET" class="d-flex align-items-center">
          <input type="hidden" name="sort" value="{{ $sort }}" />
          <input type="hidden" name="direction" value="{{ $direction }}" />
          <input
            type="text"
            name="search"
            class="form-control"
            placeholder="Search reference no., name, matric no., session..."
            value="{{ $search }}" />
          <button type="submit" class="btn btn-outline-secondary ms-2">
            <i class="icon-base bx bx-search"></i>
          </button>
          @php
            $clearMonthYearUrl = route('ddsdce.expected-graduation.index', ['sort' => $sort, 'direction' => $direction, 'search' => $search]);
          @endphp
          <span class="ms-2">
            @include('partials.month-year-filter')
          </span>
          @include('partials.per-page-select')
        </form>

        <a href="{{ route('ddsdce.expected-graduation.export-pdf', request()->query()) }}" class="btn btn-outline-secondary" title="Export current list to PDF">
          <i class="icon-base bx bxs-file-pdf"></i>
        </a>

        <a href="{{ route('ddsdce.expected-graduation.create') }}" class="btn btn-primary text-nowrap">
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
                  href="{{ route('ddsdce.expected-graduation.index', ['sort' => $column, 'direction' => $newDirection, 'search' => $search, 'month' => $filterMonth, 'year' => $filterYear]) }}"
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
          @forelse ($letters as $letter)
            <tr>
              <td>{{ $letter->reference_no }}</td>
              <td>{{ $letter->student->name }}</td>
              <td>{{ $letter->student->matric_no }}</td>
              <td>{{ $letter->date->format('d M Y') }}</td>
              <td>{{ $letter->graduation_semester_text }}</td>
              <td>{{ $letter->include_cgpa ? 'Yes' : 'No' }}</td>
              <td>
                <div class="d-flex gap-2">
                  <a href="{{ route('ddsdce.expected-graduation.view-pdf', $letter) }}" target="_blank" rel="noopener" class="btn btn-icon btn-sm btn-text-secondary" title="View">
                    <i class="icon-base bx bx-show"></i>
                  </a>
                  <a href="{{ route('ddsdce.expected-graduation.edit', $letter) }}" class="btn btn-icon btn-sm btn-text-primary" title="Edit">
                    <i class="icon-base bx bx-edit"></i>
                  </a>
                  <a href="{{ route('ddsdce.expected-graduation.print', $letter) }}" target="_blank" rel="noopener" class="btn btn-icon btn-sm btn-text-info" title="Print">
                    <i class="icon-base bx bx-printer"></i>
                  </a>
                  <form action="{{ route('ddsdce.expected-graduation.destroy', $letter) }}" method="POST"
                    onsubmit="return confirm('Delete expected graduation letter {{ $letter->reference_no }}?');">
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
              <td colspan="7" class="text-center text-body-secondary py-6">No records yet.</td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    @if ($letters->hasPages())
      <div class="card-footer">
        {{ $letters->links('pagination::sneat') }}
      </div>
    @endif
  </div>
@endsection
