@php
    $proposal = $proposal ?? null;

    $scheduleRows = $proposal
        ? $proposal->scheduleItems->map(fn ($row) => ['time' => $row->time, 'activity' => $row->activity])->all()
        : [['time' => '', 'activity' => '']];

    $committeeRows = $proposal
        ? $proposal->committees->map(fn ($row) => ['position' => $row->position, 'name' => $row->name, 'matric_no' => $row->matric_no, 'phone_no' => $row->phone_no])->all()
        : collect(['Program Manager', 'Secretary', 'Treasurer', 'Program Coordinator', 'Preparation and Technical', 'Special Task', 'Food and Beverage'])
            ->map(fn ($position) => ['position' => $position, 'name' => '', 'matric_no' => '', 'phone_no' => ''])
            ->all();

    $expenditureCategories = [
        'stadd' => ['field' => 'budget_expenditure_stadd', 'category' => 'stadd_trust_fund', 'label' => 'a) Expected Expenditure from STADD Trust Fund'],
        'sap' => ['field' => 'budget_expenditure_sap', 'category' => 'student_activities_programme', 'label' => 'b) Expected Expenditure Student Activities Programme'],
        'sponsorship' => ['field' => 'budget_expenditure_sponsorship', 'category' => 'sponsorships_participants_fee', 'label' => 'c) Expected Expenditure Sponsorships/Participants Fee'],
    ];
    $starterParticulars = ['Materials & Supplies', 'Printing & Documentation', 'Equipment Rental', 'Marketing/Promotion', 'Miscellaneous/Contingency'];

    $expenditureRowsByCategory = [];
    foreach ($expenditureCategories as $key => $cfg) {
        $expenditureRowsByCategory[$key] = $proposal
            ? $proposal->budgetItems->where('category', $cfg['category'])->map(fn ($row) => ['particular' => $row->particular, 'price_per_unit' => $row->price_per_unit, 'quantity' => $row->quantity, 'amount' => $row->amount])->values()->all()
            : collect($starterParticulars)->map(fn ($p) => ['particular' => $p, 'price_per_unit' => '', 'quantity' => '', 'amount' => ''])->all();
    }

    $sourceRows = $proposal ? $proposal->sourceOfFundsRows() : collect(\App\Models\Proposal::BUDGET_CATEGORIES)
        ->map(fn ($label, $category) => ['category' => $category, 'particular' => $label, 'amount' => 0])
        ->values()
        ->all();
    $sourceTotal = array_sum(array_column($sourceRows, 'amount'));

    $currentTerm = $proposal?->societyTerm ?? $currentSocietyTerm ?? null;

    $studentsForJs = $students->map(fn ($student) => ['matric_no' => $student->matric_no, 'name' => $student->name]);

    $checkedBy = $proposal?->checkedBySignatory ?? $defaultCheckedBy ?? null;
    $recommendedBy = $proposal?->recommendedBySignatory ?? $defaultRecommendedBy ?? null;
    $approvedBy = $proposal?->approvedBySignatory ?? $defaultApprovedBy ?? null;

    $reviewMode = $reviewMode ?? false;
    $routePrefix = $routePrefix ?? 'student-activity.proposal';
@endphp

@if (! $reviewMode && $proposal?->status === 'make_correction' && $proposal->ddsdce_remark)
  <div class="alert alert-warning">
    <strong>DDSDCE remark — please make the following correction:</strong>
    <div class="mt-1" style="white-space: pre-line;">{{ $proposal->ddsdce_remark }}</div>
  </div>
@endif

<div class="row">
  <div class="col-md-8 mb-6">
    <label for="name" class="form-label">Name of the Proposal</label>
    <input
      type="text"
      id="name"
      name="name"
      class="form-control @error('name') is-invalid @enderror"
      value="{{ old('name', $proposal->name ?? '') }}"
      required />
    @error('name')
      <div class="invalid-feedback d-block">{{ $message }}</div>
    @enderror
  </div>

  <div class="col-md-4 mb-6">
    <label class="form-label">Society Term</label>
    <input type="text" class="form-control" readonly value="{{ $currentTerm->term ?? '—' }}" />
    <input type="hidden" name="society_term_id" value="{{ old('society_term_id', $currentTerm->id ?? '') }}" />
  </div>
</div>

<h6 class="mt-4">1. Introduction</h6>
<div class="mb-6">
  <textarea id="introduction" name="introduction" rows="3" class="form-control @error('introduction') is-invalid @enderror">{{ old('introduction', $proposal->introduction ?? '') }}</textarea>
  @error('introduction')
    <div class="invalid-feedback d-block">{{ $message }}</div>
  @enderror
</div>

<h6>2. Background</h6>
<div class="mb-6">
  <textarea id="background" name="background" rows="3" class="form-control @error('background') is-invalid @enderror">{{ old('background', $proposal->background ?? '') }}</textarea>
  @error('background')
    <div class="invalid-feedback d-block">{{ $message }}</div>
  @enderror
</div>

<h6>3. Objectives</h6>
<div class="mb-6">
  <textarea id="objectives" name="objectives" rows="4" class="form-control @error('objectives') is-invalid @enderror" placeholder="One objective per line">{{ old('objectives', $proposal->objectives ?? '') }}</textarea>
  <div class="form-text">One objective per line — printed as a numbered list.</div>
  @error('objectives')
    <div class="invalid-feedback d-block">{{ $message }}</div>
  @enderror
</div>

<h6>4. Programme Impact <span class="text-body-secondary fw-normal">(MADANI S.C.R.I.P.T Elements)</span></h6>
<div class="row">
  @foreach ([
      'impact_sustainability' => 'Sustainability',
      'impact_care_compassion' => 'Care and Compassion',
      'impact_respect' => 'Respect',
      'impact_innovation' => 'Innovation',
      'impact_prosperity' => 'Prosperity',
      'impact_trust' => 'Trust',
  ] as $field => $label)
    <div class="col-md-6 mb-6">
      <label for="{{ $field }}" class="form-label">{{ $label }}</label>
      <textarea id="{{ $field }}" name="{{ $field }}" rows="2" class="form-control @error($field) is-invalid @enderror">{{ old($field, $proposal->{$field} ?? '') }}</textarea>
      @error($field)
        <div class="invalid-feedback d-block">{{ $message }}</div>
      @enderror
    </div>
  @endforeach
</div>

<h6>5. Details of the Programme</h6>
<div class="row">
  <div class="col-md-3 mb-6">
    <label for="programme_date" class="form-label">Date</label>
    <input type="date" id="programme_date" name="programme_date" class="form-control @error('programme_date') is-invalid @enderror" value="{{ old('programme_date', optional($proposal?->programme_date)->format('Y-m-d')) }}" />
    @error('programme_date')
      <div class="invalid-feedback d-block">{{ $message }}</div>
    @enderror
  </div>
  <div class="col-md-3 mb-6">
    <label for="venue" class="form-label">Venue</label>
    <input type="text" id="venue" name="venue" class="form-control" value="{{ old('venue', $proposal->venue ?? '') }}" />
  </div>
  <div class="col-md-3 mb-6">
    <label for="organizer" class="form-label">Organizer</label>
    <input type="text" id="organizer" name="organizer" class="form-control" value="{{ old('organizer', $proposal->organizer ?? "Information Communication Students' Society (ICTSS), KICT") }}" />
  </div>
  <div class="col-md-3 mb-6">
    <label for="participants" class="form-label">Participants</label>
    <input type="text" id="participants" name="participants" class="form-control" value="{{ old('participants', $proposal->participants ?? '') }}" />
  </div>
</div>

<h6>6. Programme Schedule</h6>
<div class="table-responsive mb-3">
  <table class="table table-bordered align-middle" id="schedule-table">
    <thead class="table-light">
      <tr>
        <th style="width: 25%;">Time</th>
        <th>Activity / Programme</th>
        <th style="width: 40px;"></th>
      </tr>
    </thead>
    <tbody>
      @foreach ($scheduleRows as $index => $row)
        <tr>
          <td><input type="text" name="schedule[{{ $index }}][time]" class="form-control" value="{{ $row['time'] }}" /></td>
          <td><input type="text" name="schedule[{{ $index }}][activity]" class="form-control" value="{{ $row['activity'] }}" /></td>
          <td class="text-center"><button type="button" class="btn btn-icon btn-sm btn-text-danger remove-row" title="Remove"><i class="icon-base bx bx-trash"></i></button></td>
        </tr>
      @endforeach
    </tbody>
  </table>
</div>
<button type="button" class="btn btn-sm btn-outline-secondary mb-6" data-add-row="schedule-table">
  <i class="icon-base bx bx-plus me-1"></i> Add Schedule Row
</button>

<h6>7. List of Committees</h6>
<div class="table-responsive mb-3">
  <table class="table table-bordered align-middle" id="committee-table">
    <thead class="table-light">
      <tr>
        <th style="width: 20%;">Position</th>
        <th style="width: 15%;">Matric No.</th>
        <th>Name</th>
        <th style="width: 15%;">Phone No.</th>
        <th style="width: 40px;"></th>
      </tr>
    </thead>
    <tbody>
      @foreach ($committeeRows as $index => $row)
        <tr>
          <td><input type="text" name="committee[{{ $index }}][position]" class="form-control" value="{{ $row['position'] }}" /></td>
          <td><input type="text" name="committee[{{ $index }}][matric_no]" class="form-control committee-matric" value="{{ $row['matric_no'] }}" /></td>
          <td><input type="text" name="committee[{{ $index }}][name]" class="form-control committee-name" value="{{ $row['name'] }}" readonly /></td>
          <td><input type="text" name="committee[{{ $index }}][phone_no]" class="form-control" value="{{ $row['phone_no'] }}" /></td>
          <td class="text-center"><button type="button" class="btn btn-icon btn-sm btn-text-danger remove-row" title="Remove"><i class="icon-base bx bx-trash"></i></button></td>
        </tr>
      @endforeach
    </tbody>
  </table>
</div>
<button type="button" class="btn btn-sm btn-outline-secondary mb-6" data-add-row="committee-table">
  <i class="icon-base bx bx-plus me-1"></i> Add Committee Member
</button>
<div class="form-text mb-6 mt-n4">*Other members are to be determined and will be included in the final report. Type a matric no. to auto-fill the student's name.</div>

<h6>8. Budget Implication</h6>
<div class="col-md-12 mb-3">
  <div class="form-check">
    <input class="form-check-input" type="checkbox" id="no_budget_required" name="no_budget_required" value="1" {{ old('no_budget_required', $proposal->no_budget_required ?? false) ? 'checked' : '' }} />
    <label class="form-check-label" for="no_budget_required">This programme does not require any financial allocation. All activities will be carried out using existing resources and voluntary contributions.</label>
  </div>
</div>

<div id="budget-fields">
  @foreach ($expenditureCategories as $key => $cfg)
    <label class="form-label d-block mt-2">{{ $cfg['label'] }}</label>
    <div class="table-responsive mb-3">
      <table class="table table-bordered align-middle expenditure-table" id="expenditure-table-{{ $key }}">
        <thead class="table-light">
          <tr>
            <th>Particular</th>
            <th style="width: 15%;">Price/Unit (RM)</th>
            <th style="width: 12%;">Quantity</th>
            <th style="width: 15%;">Amount (RM)</th>
            <th style="width: 40px;"></th>
          </tr>
        </thead>
        <tbody>
          @foreach ($expenditureRowsByCategory[$key] as $index => $row)
            <tr>
              <td><input type="text" name="{{ $cfg['field'] }}[{{ $index }}][particular]" class="form-control" value="{{ $row['particular'] }}" /></td>
              <td><input type="number" step="0.01" min="0" name="{{ $cfg['field'] }}[{{ $index }}][price_per_unit]" class="form-control budget-price" value="{{ $row['price_per_unit'] }}" /></td>
              <td><input type="number" min="0" name="{{ $cfg['field'] }}[{{ $index }}][quantity]" class="form-control budget-qty" value="{{ $row['quantity'] }}" /></td>
              <td><input type="number" step="0.01" name="{{ $cfg['field'] }}[{{ $index }}][amount]" class="form-control budget-amount" value="{{ $row['amount'] }}" readonly /></td>
              <td class="text-center"><button type="button" class="btn btn-icon btn-sm btn-text-danger remove-row" title="Remove"><i class="icon-base bx bx-trash"></i></button></td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
    <button type="button" class="btn btn-sm btn-outline-secondary mb-6" data-add-row="expenditure-table-{{ $key }}">
      <i class="icon-base bx bx-plus me-1"></i> Add Row
    </button>
  @endforeach

  <label class="form-label d-block">Source of Funds <span class="text-body-secondary fw-normal">(read-only — totals from the expenditure tables above)</span></label>
  <div class="table-responsive mb-3">
    <table class="table table-bordered align-middle">
      <thead class="table-light">
        <tr>
          <th>Particular</th>
          <th style="width: 20%;">Amount (RM)</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($sourceRows as $row)
          <tr>
            <td>{{ $row['particular'] }}</td>
            <td class="text-end source-amount">{{ number_format($row['amount'], 2) }}</td>
          </tr>
        @endforeach
        <tr class="fw-bold">
          <td>TOTAL</td>
          <td class="text-end" id="source-total">{{ number_format($sourceTotal, 2) }}</td>
        </tr>
      </tbody>
    </table>
  </div>
</div>

<div class="row">
  <div class="col-md-6 mb-6">
    <label for="financial_implication_amount" class="form-label">Financial Implication (RM)</label>
    <input type="text" id="financial_implication_amount" class="form-control" value="{{ number_format($sourceTotal, 2) }}" readonly />
    <div class="form-text">Auto-calculated from the Source of Funds total.</div>
  </div>
  <div class="col-md-6 mb-6">
    <label for="funding_source" class="form-label">Funding Source</label>
    <input type="text" id="funding_source" name="funding_source" class="form-control" placeholder="e.g. STADD Trust Fund, S-173-0001" value="{{ old('funding_source', $proposal->funding_source ?? '') }}" />
    <div class="form-text">Auto-suggested from the Source of Funds entries with an amount — feel free to edit.</div>
  </div>
</div>

<h6>9. Approval</h6>
<div class="row">
  <div class="col-md-4 mb-6">
    <label class="form-label">Prepared by — Name</label>
    <input type="text" class="form-control" readonly value="{{ $proposal?->prepared_by_name ?? auth()->user()->name }}" />
  </div>
  <div class="col-md-4 mb-6">
    <label for="prepared_by_position" class="form-label">Position</label>
    <input type="text" id="prepared_by_position" name="prepared_by_position" class="form-control" placeholder="Secretary / Programme Manager" value="{{ old('prepared_by_position', $proposal->prepared_by_position ?? '') }}" />
  </div>
  <div class="col-md-4 mb-6">
    <label for="prepared_by_date" class="form-label">Date</label>
    <input type="date" id="prepared_by_date" name="prepared_by_date" class="form-control" value="{{ old('prepared_by_date', optional($proposal?->prepared_by_date)->format('Y-m-d')) }}" />
  </div>

  <div class="col-md-8 mb-6">
    <label class="form-label">Checked by</label>
    <input type="text" class="form-control" readonly value="{{ $checkedBy ? $checkedBy->name.' — '.$checkedBy->designation_en : 'No President configured' }}" />
    <input type="hidden" name="checked_by_signatory_proposal_id" value="{{ $checkedBy->id ?? '' }}" />
  </div>
  <div class="col-md-4 mb-6">
    <label for="checked_by_date" class="form-label">Date</label>
    <input type="date" id="checked_by_date" name="checked_by_date" class="form-control" value="{{ old('checked_by_date', optional($proposal?->checked_by_date)->format('Y-m-d')) }}" />
  </div>

  <div class="col-md-8 mb-6">
    <label for="reviewed_by_signatory_id" class="form-label">Reviewed by</label>
    <select id="reviewed_by_signatory_id" name="reviewed_by_signatory_id" class="form-select @error('reviewed_by_signatory_id') is-invalid @enderror">
      <option value="">Select signatory…</option>
      @foreach ($signatories as $signatory)
        <option value="{{ $signatory->id }}" {{ (int) old('reviewed_by_signatory_id', $proposal->reviewed_by_signatory_id ?? '') === $signatory->id ? 'selected' : '' }}>
          {{ $signatory->name }} — {{ $signatory->designation_en }}
        </option>
      @endforeach
    </select>
    @error('reviewed_by_signatory_id')
      <div class="invalid-feedback d-block">{{ $message }}</div>
    @enderror
  </div>
  <div class="col-md-4 mb-6">
    <label for="reviewed_by_date" class="form-label">Date</label>
    <input type="date" id="reviewed_by_date" name="reviewed_by_date" class="form-control" value="{{ old('reviewed_by_date', optional($proposal?->reviewed_by_date)->format('Y-m-d')) }}" />
  </div>

  <div class="col-md-8 mb-6">
    <label class="form-label">Recommended by</label>
    <input type="text" class="form-control" readonly value="{{ $recommendedBy ? $recommendedBy->name.' — '.$recommendedBy->designation_en : 'No Deputy Director configured' }}" />
    <input type="hidden" name="recommended_by_signatory_proposal_id" value="{{ $recommendedBy->id ?? '' }}" />
  </div>
  <div class="col-md-4 mb-6">
    <label for="recommended_by_date" class="form-label">Date</label>
    <input type="date" id="recommended_by_date" name="recommended_by_date" class="form-control" value="{{ old('recommended_by_date', optional($proposal?->recommended_by_date)->format('Y-m-d')) }}" />
  </div>

  <div class="col-md-8 mb-6">
    <label class="form-label">Approved by</label>
    <input type="text" class="form-control" readonly value="{{ $approvedBy ? $approvedBy->name.' — '.$approvedBy->designation_en : 'No Dean configured' }}" />
    <input type="hidden" name="approved_by_signatory_proposal_id" value="{{ $approvedBy->id ?? '' }}" />
  </div>
  <div class="col-md-4 mb-6">
    <label for="approved_by_date" class="form-label">Date</label>
    <input type="date" id="approved_by_date" name="approved_by_date" class="form-control" value="{{ old('approved_by_date', optional($proposal?->approved_by_date)->format('Y-m-d')) }}" />
  </div>
</div>

<h6>Appendices</h6>
@if ($proposal && $proposal->attachments->isNotEmpty())
  <div class="mb-3">
    <ul class="list-group">
      @foreach ($proposal->attachments as $attachment)
        <li class="list-group-item d-flex align-items-center justify-content-between">
          <div>
            <a href="{{ route("{$routePrefix}.attachment", [$proposal, $attachment]) }}" target="_blank" rel="noopener">
              {{ $attachment->label ?: $attachment->original_filename }}
            </a>
            <span class="text-body-secondary small">({{ $attachment->original_filename }})</span>
          </div>
          <div class="form-check mb-0">
            <input class="form-check-input" type="checkbox" name="remove_attachments[]" value="{{ $attachment->id }}" id="remove_attachment_{{ $attachment->id }}" />
            <label class="form-check-label text-danger" for="remove_attachment_{{ $attachment->id }}">Remove</label>
          </div>
        </li>
      @endforeach
    </ul>
  </div>
@endif
<div class="table-responsive mb-3">
  <table class="table table-bordered align-middle" id="attachment-table">
    <thead class="table-light">
      <tr>
        <th style="width: 30%;">Label</th>
        <th>File</th>
        <th style="width: 40px;"></th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td><input type="text" name="attachment_labels[]" class="form-control" placeholder="e.g. Poster Event" /></td>
        <td><input type="file" name="attachments[]" class="form-control" /></td>
        <td class="text-center"><button type="button" class="btn btn-icon btn-sm btn-text-danger remove-row" title="Remove"><i class="icon-base bx bx-trash"></i></button></td>
      </tr>
    </tbody>
  </table>
</div>
<button type="button" class="btn btn-sm btn-outline-secondary mb-6" data-add-row="attachment-table">
  <i class="icon-base bx bx-plus me-1"></i> Add File
</button>

@if ($proposal && $proposal->status !== 'draft')
  <div class="alert alert-info">
    Current status: <strong>{{ \App\Models\Proposal::STATUS_LABELS[$proposal->status] ?? ucfirst($proposal->status) }}</strong>
  </div>
@endif

@if ($reviewMode)
  <h6>Letters to Generate <span class="text-body-secondary fw-normal">(generated automatically once Accepted)</span></h6>
  <div class="mb-6 d-flex flex-wrap gap-4">
    <div class="form-check">
      <input class="form-check-input" type="checkbox" id="needs_sponsorship_letter" name="needs_sponsorship_letter" value="1" {{ old('needs_sponsorship_letter', $proposal->needs_sponsorship_letter ?? false) ? 'checked' : '' }} />
      <label class="form-check-label" for="needs_sponsorship_letter">Sponsorship Letter</label>
    </div>
    <div class="form-check">
      <input class="form-check-input" type="checkbox" id="needs_invitation_letter" name="needs_invitation_letter" value="1" {{ old('needs_invitation_letter', $proposal->needs_invitation_letter ?? false) ? 'checked' : '' }} />
      <label class="form-check-label" for="needs_invitation_letter">Invitation Letter</label>
    </div>
    <div class="form-check">
      <input class="form-check-input" type="checkbox" id="needs_appointment_letter" name="needs_appointment_letter" value="1" {{ old('needs_appointment_letter', $proposal->needs_appointment_letter ?? false) ? 'checked' : '' }} />
      <label class="form-check-label" for="needs_appointment_letter">Appointment Letter</label>
    </div>
    <div class="form-check">
      <input class="form-check-input" type="checkbox" id="needs_approval_letter" checked disabled />
      <input type="hidden" name="needs_approval_letter" value="1" />
      <label class="form-check-label" for="needs_approval_letter">Approval Letter <span class="text-body-secondary">(required)</span></label>
    </div>
  </div>

  <div class="mb-6">
    <label for="ddsdce_remark" class="form-label">Remark for ICTSS <span class="text-body-secondary fw-normal">(required if rejecting — explain what needs to change)</span></label>
    <textarea id="ddsdce_remark" name="ddsdce_remark" rows="3" class="form-control @error('ddsdce_remark') is-invalid @enderror">{{ old('ddsdce_remark', $proposal->ddsdce_remark ?? '') }}</textarea>
    @error('ddsdce_remark')
      <div class="invalid-feedback d-block">{{ $message }}</div>
    @enderror
  </div>

  <div class="mt-4">
    <button type="submit" name="action" value="save" class="btn btn-outline-primary">Save</button>
    <button type="submit" name="action" value="accept" class="btn btn-success">Accept</button>
    <button type="submit" name="action" value="reject" class="btn btn-danger">Reject</button>
    <a href="{{ route("{$routePrefix}.index") }}" class="btn btn-outline-secondary">Cancel</a>
  </div>
@else
  <div class="mt-4">
    <button type="submit" name="action" value="draft" class="btn btn-outline-primary">Save as Draft</button>
    <button type="submit" name="action" value="submit" class="btn btn-primary">Submit</button>
    <a href="{{ route("{$routePrefix}.index") }}" class="btn btn-outline-secondary">Cancel</a>
  </div>
@endif

@push('page-js')
  <script>
    document.addEventListener('DOMContentLoaded', function () {
      var studentsByMatric = {};
      @json($studentsForJs).forEach(function (student) {
        studentsByMatric[student.matric_no.trim().toLowerCase()] = student.name;
      });

      function lookupCommitteeName(input) {
        var row = input.closest('tr');
        if (!row) return;
        var nameInput = row.querySelector('.committee-name');
        if (!nameInput) return;
        var match = studentsByMatric[input.value.trim().toLowerCase()];
        nameInput.value = match || '';
      }

      document.body.addEventListener('input', function (e) {
        if (e.target.classList && e.target.classList.contains('committee-matric')) {
          lookupCommitteeName(e.target);
        }
      });

      document.querySelectorAll('[data-add-row]').forEach(function (button) {
        var table = document.getElementById(button.dataset.addRow);
        // Rows use an explicit numeric bracket index (e.g. "schedule[3][time]")
        // rather than "schedule[][time]" — PHP treats every bare "[]" as its
        // own auto-incrementing counter, so two sibling inputs like
        // "foo[][a]" and "foo[][b]" land in DIFFERENT array rows instead of
        // being grouped together. Track the next free index per table so
        // cloned rows get a fresh one instead of colliding with the row they
        // were cloned from (which would silently overwrite it on submit).
        table.dataset.nextIndex = table.querySelectorAll('tbody tr').length;

        button.addEventListener('click', function () {
          var tbody = table.querySelector('tbody');
          var lastRow = tbody.querySelector('tr:last-child');
          var newRow = lastRow.cloneNode(true);
          var newIndex = table.dataset.nextIndex;
          table.dataset.nextIndex = parseInt(newIndex, 10) + 1;
          newRow.querySelectorAll('input').forEach(function (input) {
            if (input.name) {
              input.name = input.name.replace(/\[\d+\]/, '[' + newIndex + ']');
            }
            if (input.type === 'file') {
              input.value = '';
            } else if (input.type === 'checkbox' || input.type === 'radio') {
              input.checked = false;
            } else {
              input.value = '';
            }
          });
          tbody.appendChild(newRow);
          if (table.classList.contains('expenditure-table')) {
            calculateBudgetAndFunding();
          }
        });
      });

      document.querySelectorAll('table').forEach(function (table) {
        table.addEventListener('click', function (e) {
          var btn = e.target.closest('.remove-row');
          if (!btn) return;
          var tbody = table.querySelector('tbody');
          if (tbody.querySelectorAll('tr').length > 1) {
            btn.closest('tr').remove();
          } else {
            btn.closest('tr').querySelectorAll('input').forEach(function (input) {
              if (input.type === 'file') {
                input.value = '';
              } else if (input.type === 'checkbox' || input.type === 'radio') {
                input.checked = false;
              } else {
                input.value = '';
              }
            });
          }
          if (table.classList.contains('expenditure-table')) {
            calculateBudgetAndFunding();
          }
        });
      });

      var noBudgetCheckbox = document.getElementById('no_budget_required');
      var budgetFields = document.getElementById('budget-fields');
      function toggleBudgetFields() {
        budgetFields.style.display = noBudgetCheckbox.checked ? 'none' : '';
      }
      toggleBudgetFields();
      noBudgetCheckbox.addEventListener('change', function () {
        toggleBudgetFields();
        calculateBudgetAndFunding();
      });

      var fundingLabels = ['STADD Trust Fund, S-173-0001', 'Student Activities Programme, B52201', 'Sponsorships/Participants Fee'];

      // Recomputes the read-only Source of Funds totals + Financial Implication
      // field. Safe to call on page load — doesn't touch Funding Source, so it
      // never clobbers a value the user already saved or typed.
      function updateSourceTotals() {
        var categoryTotals = [];

        document.querySelectorAll('.expenditure-table').forEach(function (table) {
          var sum = 0;
          table.querySelectorAll('tbody tr').forEach(function (row) {
            sum += parseFloat(row.querySelector('.budget-amount').value) || 0;
          });
          categoryTotals.push(sum);
        });

        var grandTotal = 0;
        document.querySelectorAll('.source-amount').forEach(function (cell, index) {
          var amount = categoryTotals[index] || 0;
          cell.textContent = amount.toFixed(2);
          grandTotal += amount;
        });

        var total = document.getElementById('no_budget_required').checked ? 0 : grandTotal;
        document.getElementById('source-total').textContent = total.toFixed(2);
        document.getElementById('financial_implication_amount').value = total.toFixed(2);

        return categoryTotals;
      }

      // Recomputes totals AND overwrites the Funding Source suggestion — only
      // called from genuine user edits to the expenditure tables, never on load.
      function calculateBudgetAndFunding() {
        var categoryTotals = updateSourceTotals();
        var activeSources = document.getElementById('no_budget_required').checked
          ? []
          : fundingLabels.filter(function (label, index) { return (categoryTotals[index] || 0) > 0; });
        document.getElementById('funding_source').value = activeSources.join(' / ');
      }

      document.querySelectorAll('.expenditure-table').forEach(function (table) {
        table.addEventListener('input', function (e) {
          var row = e.target.closest('tr');
          if (!row) return;
          if (e.target.classList.contains('budget-price') || e.target.classList.contains('budget-qty')) {
            var price = parseFloat(row.querySelector('.budget-price').value) || 0;
            var qty = parseFloat(row.querySelector('.budget-qty').value) || 0;
            row.querySelector('.budget-amount').value = (price * qty).toFixed(2);
            calculateBudgetAndFunding();
          }
        });
      });

      updateSourceTotals();
    });
  </script>
@endpush
