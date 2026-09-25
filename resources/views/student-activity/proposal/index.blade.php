@extends('layouts.app')

@section('title', 'Proposal')

@php
  $columns = [
      'name' => 'Proposal Name',
      'status' => 'Status',
      'created_at' => 'Submitted',
  ];

  $statusBadges = \App\Models\Proposal::STATUS_BADGES;
  $statusLabels = \App\Models\Proposal::STATUS_LABELS;
@endphp

@section('content')
  <h4 class="mb-6">Student Activity / Proposal</h4>

  @if (session('status'))
    <div class="alert alert-success alert-dismissible" role="alert">
      {{ session('status') }}
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
  @endif

  <div class="card">
    <div class="card-header d-flex align-items-center justify-content-between flex-wrap gap-3">
      <h5 class="mb-0">Proposals</h5>

      <div class="d-flex align-items-center gap-3">
        <form action="{{ route('student-activity.proposal.index') }}" method="GET" class="d-flex align-items-center">
          <input type="hidden" name="sort" value="{{ $sort }}" />
          <input type="hidden" name="direction" value="{{ $direction }}" />
          <input
            type="text"
            name="search"
            class="form-control"
            placeholder="Search name, venue, organizer..."
            value="{{ $search }}" />
          <select name="status" class="form-select ms-2" onchange="this.form.submit()">
            <option value="">All statuses</option>
            @foreach ($statusLabels as $value => $label)
              <option value="{{ $value }}" @selected($status === $value)>{{ $label }}</option>
            @endforeach
          </select>
          <button type="submit" class="btn btn-outline-secondary ms-2">
            <i class="icon-base bx bx-search"></i>
          </button>
          @include('partials.per-page-select')
        </form>

        <a href="{{ route('student-activity.proposal.create') }}" class="btn btn-primary text-nowrap">
          <i class="icon-base bx bx-plus me-1"></i> Add New
        </a>
      </div>
    </div>

    <div class="table-responsive">
      <table class="table">
        <thead class="table-light">
          <tr>
            @foreach ($columns as $column => $label)
              @php
                $newDirection = ($sort === $column && $direction === 'asc') ? 'desc' : 'asc';
              @endphp
              <th>
                <a
                  href="{{ route('student-activity.proposal.index', ['sort' => $column, 'direction' => $newDirection, 'search' => $search, 'status' => $status]) }}"
                  class="text-body text-decoration-none">
                  {{ $label }}
                  @if ($sort === $column)
                    <i class="icon-base bx {{ $direction === 'asc' ? 'bx-chevron-up' : 'bx-chevron-down' }}"></i>
                  @endif
                </a>
              </th>
            @endforeach
            <th>Venue</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody class="table-border-bottom-0">
          @forelse ($proposals as $proposal)
            <tr>
              <td>{{ $proposal->name }}</td>
              <td><span class="badge {{ $statusBadges[$proposal->status] ?? 'bg-label-secondary' }}">{{ $statusLabels[$proposal->status] ?? ucfirst($proposal->status) }}</span></td>
              <td>{{ $proposal->created_at->format('d M Y') }}</td>
              <td>{{ $proposal->venue ?: '—' }}</td>
              <td>
                <div class="d-flex gap-2">
                  <a href="{{ route('student-activity.proposal.view-pdf', $proposal) }}" target="_blank" rel="noopener" class="btn btn-icon btn-sm btn-text-secondary" title="View">
                    <i class="icon-base bx bx-show"></i>
                  </a>
                  @if ($proposal->isEditableByIctss())
                    <a href="{{ route('student-activity.proposal.edit', $proposal) }}" class="btn btn-icon btn-sm btn-text-primary" title="Edit">
                      <i class="icon-base bx bx-edit"></i>
                    </a>
                  @else
                    <span class="btn btn-icon btn-sm btn-text-secondary disabled" title="Approved — no longer editable">
                      <i class="icon-base bx bx-lock-alt"></i>
                    </span>
                  @endif
                  <a href="{{ route('student-activity.proposal.print', $proposal) }}" target="_blank" rel="noopener" class="btn btn-icon btn-sm btn-text-info" title="Print">
                    <i class="icon-base bx bx-printer"></i>
                  </a>
                  <form action="{{ route('student-activity.proposal.destroy', $proposal) }}" method="POST"
                    onsubmit="return confirm('Delete proposal {{ $proposal->name }}?');">
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
              <td colspan="5" class="text-center text-body-secondary py-6">No proposals yet.</td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    @if ($proposals->hasPages())
      <div class="card-footer">
        {{ $proposals->links('pagination::sneat') }}
      </div>
    @endif
  </div>
@endsection
