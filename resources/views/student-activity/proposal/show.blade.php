@extends('layouts.app')

@section('title', 'View Proposal')

@php
  $statusBadges = \App\Models\Proposal::STATUS_BADGES;
  $statusLabels = \App\Models\Proposal::STATUS_LABELS;
@endphp

@section('content')
  <h4 class="mb-6">Student Activity / Proposal / View — {{ $proposal->name }}</h4>

  <div class="card mb-6">
    <div class="card-body">
      @if ($proposal->status === 'make_correction' && $proposal->ddsdce_remark)
        <div class="alert alert-warning">
          <strong>DDSDCE remark — please make the following correction:</strong>
          <div class="mt-1" style="white-space: pre-line;">{{ $proposal->ddsdce_remark }}</div>
        </div>
      @endif
      <dl class="row mb-0">
        <dt class="col-sm-3">Status</dt>
        <dd class="col-sm-9"><span class="badge {{ $statusBadges[$proposal->status] ?? 'bg-label-secondary' }}">{{ $statusLabels[$proposal->status] ?? ucfirst($proposal->status) }}</span></dd>

        <dt class="col-sm-3">Society Term</dt>
        <dd class="col-sm-9">{{ $proposal->societyTerm->term ?? '—' }}</dd>

        <dt class="col-sm-3">Date</dt>
        <dd class="col-sm-9">{{ $proposal->programme_date?->format('d M Y') ?? '—' }}</dd>

        <dt class="col-sm-3">Venue</dt>
        <dd class="col-sm-9">{{ $proposal->venue ?: '—' }}</dd>

        <dt class="col-sm-3">Organizer</dt>
        <dd class="col-sm-9">{{ $proposal->organizer ?: '—' }}</dd>

        <dt class="col-sm-3">Participants</dt>
        <dd class="col-sm-9">{{ $proposal->participants ?: '—' }}</dd>

        <dt class="col-sm-3">Budget</dt>
        <dd class="col-sm-9">
          @if ($proposal->no_budget_required)
            No financial allocation required.
          @else
            RM {{ number_format((float) ($proposal->financial_implication_amount ?? 0), 2) }}
            @if ($proposal->funding_source)
              — {{ $proposal->funding_source }}
            @endif
          @endif
        </dd>
      </dl>
    </div>
    <div class="card-footer d-flex gap-2">
      @if ($proposal->isEditableByIctss())
        <a href="{{ route('student-activity.proposal.edit', $proposal) }}" class="btn btn-primary">Edit</a>
      @endif
      <a href="{{ route('student-activity.proposal.print', $proposal) }}" class="btn btn-outline-primary">Print</a>
      <a href="{{ route('student-activity.proposal.index') }}" class="btn btn-outline-secondary">Back to list</a>
    </div>
  </div>

  <div class="card mb-6">
    <div class="card-header"><h5 class="mb-0">Programme Schedule</h5></div>
    <div class="table-responsive">
      <table class="table mb-0">
        <thead class="table-light">
          <tr><th>Time</th><th>Activity</th></tr>
        </thead>
        <tbody>
          @forelse ($proposal->scheduleItems as $item)
            <tr><td>{{ $item->time ?: '—' }}</td><td>{{ $item->activity }}</td></tr>
          @empty
            <tr><td colspan="2" class="text-center text-body-secondary py-4">No schedule items.</td></tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>

  <div class="card mb-6">
    <div class="card-header"><h5 class="mb-0">List of Committees</h5></div>
    <div class="table-responsive">
      <table class="table mb-0">
        <thead class="table-light">
          <tr><th>Position</th><th>Name</th><th>Matric No.</th><th>Phone No.</th></tr>
        </thead>
        <tbody>
          @forelse ($proposal->committees as $member)
            <tr>
              <td>{{ $member->position }}</td>
              <td>{{ $member->name ?: '—' }}</td>
              <td>{{ $member->matric_no ?: '—' }}</td>
              <td>{{ $member->phone_no ?: '—' }}</td>
            </tr>
          @empty
            <tr><td colspan="4" class="text-center text-body-secondary py-4">No committee members.</td></tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>

  @unless ($proposal->no_budget_required)
    @php
      $budgetCategoryLabels = [
          'stadd_trust_fund' => 'a) Expected Expenditure from STADD Trust Fund',
          'student_activities_programme' => 'b) Expected Expenditure Student Activities Programme',
          'sponsorships_participants_fee' => 'c) Expected Expenditure Sponsorships/Participants Fee',
      ];
    @endphp
    <div class="card mb-6">
      <div class="card-header"><h5 class="mb-0">Budget</h5></div>
      <div class="card-body">
        @foreach ($budgetCategoryLabels as $category => $label)
          @php $items = $proposal->budgetItems->where('category', $category); @endphp
          <h6>{{ $label }}</h6>
          <div class="table-responsive mb-4">
            <table class="table mb-0">
              <thead class="table-light">
                <tr><th>Particular</th><th>Price/Unit (RM)</th><th>Qty</th><th>Amount (RM)</th></tr>
              </thead>
              <tbody>
                @forelse ($items as $item)
                  <tr>
                    <td>{{ $item->particular }}</td>
                    <td>{{ $item->price_per_unit !== null ? number_format((float) $item->price_per_unit, 2) : '—' }}</td>
                    <td>{{ $item->quantity ?? '—' }}</td>
                    <td>{{ $item->amount !== null ? number_format((float) $item->amount, 2) : '—' }}</td>
                  </tr>
                @empty
                  <tr><td colspan="4" class="text-center text-body-secondary py-4">No items.</td></tr>
                @endforelse
              </tbody>
            </table>
          </div>
        @endforeach

        <h6>Source of Funds</h6>
        <div class="table-responsive">
          <table class="table mb-0">
            <thead class="table-light">
              <tr><th>Particular</th><th>Amount (RM)</th></tr>
            </thead>
            <tbody>
              @foreach ($proposal->sourceOfFundsRows() as $row)
                <tr>
                  <td>{{ $row['particular'] }}</td>
                  <td>{{ number_format($row['amount'], 2) }}</td>
                </tr>
              @endforeach
              <tr class="fw-bold">
                <td>TOTAL</td>
                <td>{{ number_format($proposal->sourceOfFundsTotal(), 2) }}</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  @endunless

  <div class="card mb-6">
    <div class="card-header"><h5 class="mb-0">Approval</h5></div>
    <div class="card-body">
      <dl class="row mb-0">
        <dt class="col-sm-3">Prepared by</dt>
        <dd class="col-sm-9">{{ $proposal->prepared_by_name ?: '—' }} @if($proposal->prepared_by_position) ({{ $proposal->prepared_by_position }}) @endif</dd>

        <dt class="col-sm-3">Checked by</dt>
        <dd class="col-sm-9">{{ $proposal->checkedBySignatory->name ?? '—' }}</dd>

        <dt class="col-sm-3">Reviewed by</dt>
        <dd class="col-sm-9">{{ $proposal->reviewedBySignatory->name ?? '—' }}</dd>

        <dt class="col-sm-3">Recommended by</dt>
        <dd class="col-sm-9">{{ $proposal->recommendedBySignatory->name ?? '—' }}</dd>

        <dt class="col-sm-3">Approved by</dt>
        <dd class="col-sm-9">{{ $proposal->approvedBySignatory->name ?? '—' }}</dd>
      </dl>
    </div>
  </div>

  <div class="card">
    <div class="card-header"><h5 class="mb-0">Appendices</h5></div>
    <div class="card-body">
      @forelse ($proposal->attachments as $attachment)
        <a href="{{ route('student-activity.proposal.attachment', [$proposal, $attachment]) }}" target="_blank" rel="noopener" class="d-block mb-2">
          <i class="icon-base bx bx-paperclip me-1"></i> {{ $attachment->label ?: $attachment->original_filename }}
        </a>
      @empty
        <p class="text-body-secondary mb-0">No attachments.</p>
      @endforelse
    </div>
  </div>
@endsection
