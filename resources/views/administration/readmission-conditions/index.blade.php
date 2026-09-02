@extends('layouts.app')

@section('title', 'Readmission Conditions')

@section('content')
  <h4 class="mb-6">Administration / Readmission Conditions</h4>

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
      <h5 class="mb-0">Readmission Conditions</h5>

      <div class="d-flex align-items-center gap-3">
        <form action="{{ route('administration.readmission-conditions.index') }}" method="GET">
          @include('partials.per-page-select')
        </form>

        <a href="{{ route('administration.readmission-conditions.export-pdf') }}" class="btn btn-outline-secondary" title="Export current list to PDF">
          <i class="icon-base bx bxs-file-pdf"></i>
        </a>

        <a href="{{ route('administration.readmission-conditions.create') }}" class="btn btn-primary text-nowrap">
          <i class="icon-base bx bx-plus me-1"></i> Add New
        </a>
      </div>
    </div>

    <div class="table-responsive text-nowrap">
      <table class="table">
        <thead class="table-light">
          <tr>
            <th>Name</th>
            <th>Footnote Text</th>
            <th>Status</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody class="table-border-bottom-0">
          @forelse ($conditions as $condition)
            <tr>
              <td>{{ $condition->name }}</td>
              <td class="text-wrap" style="max-width: 420px; white-space: normal !important;">{{ \Illuminate\Support\Str::limit($condition->footnote_text, 120) }}</td>
              <td>
                <span class="badge {{ $condition->is_active ? 'bg-label-success' : 'bg-label-secondary' }}">
                  {{ $condition->is_active ? 'Active' : 'Inactive' }}
                </span>
              </td>
              <td>
                <div class="d-flex gap-2">
                  <a href="{{ route('administration.readmission-conditions.edit', $condition) }}" class="btn btn-icon btn-sm btn-text-primary" title="Edit">
                    <i class="icon-base bx bx-edit"></i>
                  </a>
                  <form action="{{ route('administration.readmission-conditions.destroy', $condition) }}" method="POST"
                    onsubmit="return confirm('Delete condition {{ $condition->name }}?');">
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
              <td colspan="4" class="text-center text-body-secondary py-6">No readmission conditions yet.</td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    @if ($conditions->hasPages())
      <div class="card-footer">
        {{ $conditions->links('pagination::sneat') }}
      </div>
    @endif
  </div>
@endsection
