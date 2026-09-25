@extends('layouts.app')

@section('title', $label)

@section('content')
  <h4 class="mb-6">DDSDCE Office / {{ $label }}</h4>

  @if (session('status'))
    <div class="alert alert-success alert-dismissible" role="alert">
      {{ session('status') }}
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
  @endif

  <div class="card">
    <div class="card-header d-flex align-items-center justify-content-between flex-wrap gap-3">
      <h5 class="mb-0">{{ $label }}s</h5>

      <div class="d-flex align-items-center gap-3">
        <form action="{{ route("ddsdce.proposal-letters.{$type}.index") }}" method="GET" class="d-flex align-items-center">
          <input
            type="text"
            name="search"
            class="form-control"
            placeholder="Search reference no., proposal name..."
            value="{{ $search }}" />
          <button type="submit" class="btn btn-outline-secondary ms-2">
            <i class="icon-base bx bx-search"></i>
          </button>
          @include('partials.per-page-select')
        </form>
      </div>
    </div>

    <div class="table-responsive">
      <table class="table">
        <thead class="table-light">
          <tr>
            <th>Reference No.</th>
            <th>Proposal</th>
            <th>Date</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody class="table-border-bottom-0">
          @forelse ($letters as $letter)
            <tr>
              <td>{{ $letter->reference_no }}</td>
              <td>{{ $letter->proposal->name }}</td>
              <td>{{ $letter->date->format('d M Y') }}</td>
              <td>
                <div class="d-flex gap-2">
                  <a href="{{ route("ddsdce.proposal-letters.{$type}.view-pdf", $letter) }}" target="_blank" rel="noopener" class="btn btn-icon btn-sm btn-text-secondary" title="View">
                    <i class="icon-base bx bx-show"></i>
                  </a>
                  <a href="{{ route("ddsdce.proposal-letters.{$type}.print", $letter) }}" target="_blank" rel="noopener" class="btn btn-icon btn-sm btn-text-info" title="Print">
                    <i class="icon-base bx bx-printer"></i>
                  </a>
                </div>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="4" class="text-center text-body-secondary py-6">No records yet.</td>
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
