@extends('layouts.app')

@section('title', 'Disciplinary')

@php
  $columns = [
      'student_name' => 'Student',
      'matric_no' => 'Matric No.',
      'date' => 'Date',
      'offense' => 'Offense',
      'location' => 'Location',
      'status' => 'Status',
      'due_date' => 'Due Date',
  ];

  $statusBadges = [
      'pending' => 'bg-label-warning',
      'cancelled' => 'bg-label-success',
      'escalated' => 'bg-label-danger',
  ];

  $monthOptions = [
      1 => 'January', 2 => 'February', 3 => 'March', 4 => 'April',
      5 => 'May', 6 => 'June', 7 => 'July', 8 => 'August',
      9 => 'September', 10 => 'October', 11 => 'November', 12 => 'December',
  ];
  $yearOptions = range(now()->year + 1, 2019);
@endphp

@section('content')
  <h4 class="mb-6">DDSDCE Office / Disciplinary</h4>

  @if (session('status'))
    <div class="alert alert-success alert-dismissible" role="alert">
      {{ session('status') }}
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
  @endif

  @if (session('error'))
    <div class="alert alert-danger alert-dismissible" role="alert">
      {{ session('error') }}
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
  @endif

  <div class="card">
    <div class="card-header d-flex align-items-center justify-content-between flex-wrap gap-3">
      <h5 class="mb-0">Disciplinary Records</h5>

      <div class="d-flex align-items-center gap-3">
        <form action="{{ route('ddsdce.disciplinary.index') }}" method="GET" class="d-flex align-items-center gap-2">
          <input type="hidden" name="sort" value="{{ $sort }}" />
          <input type="hidden" name="direction" value="{{ $direction }}" />
          <select name="status" class="form-select" onchange="this.form.submit()">
            <option value="">All statuses</option>
            <option value="pending" {{ $status === 'pending' ? 'selected' : '' }}>Pending</option>
            <option value="cancelled" {{ $status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
            <option value="escalated" {{ $status === 'escalated' ? 'selected' : '' }}>Escalated</option>
          </select>
          <input
            type="text"
            name="search"
            class="form-control"
            placeholder="Search name, matric no., offense..."
            value="{{ $search }}" />
          <button type="submit" class="btn btn-outline-secondary">
            <i class="icon-base bx bx-search"></i>
          </button>
          @php
            $clearMonthYearUrl = route('ddsdce.disciplinary.index', ['sort' => $sort, 'direction' => $direction, 'search' => $search, 'status' => $status]);
          @endphp
          @include('partials.month-year-filter')
          @include('partials.per-page-select')
        </form>

        <a href="{{ route('ddsdce.disciplinary.export-pdf', request()->query()) }}" class="btn btn-outline-secondary" title="Export current list to PDF">
          <i class="icon-base bx bxs-file-pdf"></i>
        </a>

        <a href="{{ route('ddsdce.disciplinary.create') }}" class="btn btn-primary text-nowrap">
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
                  href="{{ route('ddsdce.disciplinary.index', ['sort' => $column, 'direction' => $newDirection, 'search' => $search, 'status' => $status, 'month' => $filterMonth, 'year' => $filterYear]) }}"
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
          @forelse ($records as $record)
            <tr>
              <td>{{ $record->student->name }}</td>
              <td>{{ $record->student->matric_no }}</td>
              <td>{{ $record->date->format('d M Y') }}</td>
              <td>{{ $record->offense->name ?? '—' }}</td>
              <td>{{ $record->location }}</td>
              <td>
                <span class="badge {{ $statusBadges[$record->status] }}">{{ ucfirst($record->status) }}</span>
                @if ($record->isOverdue())
                  <span class="badge bg-label-danger">Overdue</span>
                @endif
              </td>
              <td>{{ $record->due_date->format('d M Y') }}</td>
              <td>
                <div class="d-flex gap-2">
                  <a href="{{ route('ddsdce.disciplinary.show', $record) }}" class="btn btn-icon btn-sm btn-text-secondary" title="View">
                    <i class="icon-base bx bx-show"></i>
                  </a>
                  @if ($record->status === 'pending')
                    <a href="{{ route('ddsdce.disciplinary.edit', $record) }}" class="btn btn-icon btn-sm btn-text-primary" title="Edit">
                      <i class="icon-base bx bx-edit"></i>
                    </a>
                  @endif
                  <form action="{{ route('ddsdce.disciplinary.destroy', $record) }}" method="POST"
                    onsubmit="return confirm('Delete this disciplinary record for {{ $record->student->name }}?');">
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
              <td colspan="8" class="text-center text-body-secondary py-6">No disciplinary records yet.</td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    @if ($records->hasPages())
      <div class="card-footer">
        {{ $records->links('pagination::sneat') }}
      </div>
    @endif
  </div>
@endsection
