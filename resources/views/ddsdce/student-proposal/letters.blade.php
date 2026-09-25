@extends('layouts.app')

@section('title', 'Proposal Letters')

@section('content')
  <div class="d-flex align-items-center justify-content-between flex-wrap gap-3 mb-6">
    <h4 class="mb-0">DDSDCE Office / Student Proposal / Letters</h4>
    <a href="{{ route('ddsdce.student-proposal.index') }}" class="btn btn-outline-secondary">
      <i class="icon-base bx bx-arrow-back me-1"></i> Back to Inbox
    </a>
  </div>

  <div class="card">
    <div class="card-header">
      <h5 class="mb-0">{{ $proposal->name }}</h5>
      <p class="mb-0 text-body-secondary small">
        {{ $proposal->venue ?: '—' }} &middot; {{ $proposal->programme_date?->format('d M Y') ?? '—' }}
      </p>
    </div>

    <div class="table-responsive">
      <table class="table">
        <thead class="table-light">
          <tr>
            <th>Letter Type</th>
            <th>Reference No.</th>
            <th>Date</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody class="table-border-bottom-0">
          @forelse ($proposal->letters as $letter)
            <tr>
              <td>{{ \App\Models\ProposalLetter::TYPES[$letter->type]['label'] ?? ucfirst($letter->type) }}</td>
              <td>{{ $letter->reference_no }}</td>
              <td>{{ $letter->date->format('d M Y') }}</td>
              <td>
                <div class="d-flex gap-2">
                  <a href="{{ route("ddsdce.proposal-letters.{$letter->type}.view-pdf", $letter) }}" target="_blank" rel="noopener" class="btn btn-icon btn-sm btn-text-secondary" title="View">
                    <i class="icon-base bx bx-show"></i>
                  </a>
                  <a href="{{ route("ddsdce.proposal-letters.{$letter->type}.print", $letter) }}" target="_blank" rel="noopener" class="btn btn-icon btn-sm btn-text-info" title="Print">
                    <i class="icon-base bx bx-printer"></i>
                  </a>
                </div>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="4" class="text-center text-body-secondary py-6">
                No letters generated yet for this proposal. Letters are generated automatically when the proposal is accepted with the corresponding letter types ticked.
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
@endsection
