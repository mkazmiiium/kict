<!doctype html>
<html>
<head>
  <meta charset="utf-8" />
  <style>
    @page {
      size: A4;
      margin: 2cm;
    }
    body {
      font-family: Arial, sans-serif;
      font-size: 12px;
      color: #000;
      line-height: 1.4;
    }
    .header-logo {
      width: 100%;
      margin-bottom: 14px;
    }
    .org-title {
      text-align: center;
      font-weight: bold;
      font-size: 13px;
      margin-bottom: 10px;
    }
    .proposal-title {
      text-align: center;
      margin-bottom: 4px;
    }
    .proposal-title .label {
      font-weight: bold;
    }
    .proposal-title .name {
      font-weight: bold;
      text-transform: uppercase;
      display: block;
      width: 100%;
      margin-top: 12px;
      padding-bottom: 8px;
      border-bottom: 1px dotted #000;
    }
    h2.section {
      font-size: 12.5px;
      margin: 16px 0 6px;
    }
    h3.subsection {
      font-size: 12px;
      margin: 10px 0 4px;
    }
    p {
      text-align: justify;
      margin: 0 0 8px;
    }
    ol.objectives {
      margin: 0 0 8px 18px;
      padding: 0;
    }
    table.data-table {
      width: 100%;
      border-collapse: collapse;
      margin: 6px 0 14px;
    }
    table.data-table th,
    table.data-table td {
      border: 1px solid #333;
      padding: 5px 7px;
      vertical-align: top;
      text-align: left;
    }
    table.data-table th {
      background-color: #f0f0f0;
      font-weight: bold;
    }
    table.plain-kv td {
      border: none;
      padding: 2px 6px 2px 0;
      vertical-align: top;
    }
    table.plain-kv .kv-label {
      width: 130px;
      font-weight: bold;
    }
    table.plain-kv .kv-colon {
      width: 12px;
    }
    table.approval {
      width: 100%;
      border-collapse: collapse;
      margin-top: 12px;
    }
    table.approval td {
      border: 1px solid #333;
      padding: 10px;
      width: 50%;
      vertical-align: top;
      height: 130px;
    }
    table.approval .approval-role {
      text-align: center;
      font-weight: bold;
      margin-bottom: 60px;
    }
    table.approval .approval-name {
      text-align: center;
      font-weight: bold;
      text-transform: uppercase;
    }
    table.approval .approval-meta {
      text-align: center;
    }
    table.approval .approval-full {
      width: 100%;
    }
    .text-center {
      text-align: center;
    }
    .amount-col {
      text-align: right;
    }
    .page-break {
      page-break-before: always;
    }
  </style>
</head>
<body>
  <img
    class="header-logo"
    src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('assets/img/iium-logo-image.png'))) }}" />

  <div class="org-title">INFORMATION COMMUNICATION STUDENTS' SOCIETY (ICTSS), KICT</div>
  <div class="proposal-title">
    <span class="label">PROPOSAL ON</span>
    <span class="name">{{ $proposal->name }}</span>
  </div>

  @if ($proposal->introduction)
    <h2 class="section">1. INTRODUCTION</h2>
    <p>{{ $proposal->introduction }}</p>
  @endif

  @if ($proposal->background)
    <h2 class="section">2. BACKGROUND</h2>
    <p>{{ $proposal->background }}</p>
  @endif

  @if ($proposal->objectives)
    <h2 class="section">3. OBJECTIVES</h2>
    <p>The objectives of the programme are as follows:</p>
    <ol class="objectives">
      @foreach (preg_split('/\r\n|\r|\n/', trim($proposal->objectives)) as $objective)
        @continue(trim($objective) === '')
        <li>{{ trim($objective) }}</li>
      @endforeach
    </ol>
  @endif

  @php
    $impactRows = [
        'Sustainability' => $proposal->impact_sustainability,
        'Care and Compassion' => $proposal->impact_care_compassion,
        'Respect' => $proposal->impact_respect,
        'Innovation' => $proposal->impact_innovation,
        'Prosperity' => $proposal->impact_prosperity,
        'Trust' => $proposal->impact_trust,
    ];
    $impactRows = array_filter($impactRows, fn ($v) => filled($v));
  @endphp
  @if (count($impactRows))
    <h2 class="section">4. PROGRAMME IMPACT <span style="font-weight: normal;">(Aligned with IIUM Mission, Vision and relevant MADANI S.C.R.I.P.T Elements)</span></h2>
    @foreach ($impactRows as $label => $value)
      <h3 class="subsection">{{ $label }}:</h3>
      <p>{{ $value }}</p>
    @endforeach
  @endif

  <h2 class="section">5. DETAILS OF THE PROGRAMME</h2>
  <table class="plain-kv">
    <tr><td class="kv-label">Name of the programme</td><td class="kv-colon">:</td><td>{{ $proposal->name }}</td></tr>
    <tr><td class="kv-label">Date</td><td class="kv-colon">:</td><td>{{ $proposal->programme_date?->format('d M Y') ?? '-' }}</td></tr>
    <tr><td class="kv-label">Venue</td><td class="kv-colon">:</td><td>{{ $proposal->venue ?: '-' }}</td></tr>
    <tr><td class="kv-label">Organizer</td><td class="kv-colon">:</td><td>{{ $proposal->organizer ?: '-' }}</td></tr>
    <tr><td class="kv-label">Participants</td><td class="kv-colon">:</td><td>{{ $proposal->participants ?: '-' }}</td></tr>
  </table>

  @if ($proposal->scheduleItems->isNotEmpty())
    <h2 class="section">6. PROGRAMME SCHEDULE</h2>
    <table class="data-table">
      <thead>
        <tr><th style="width: 25%;">TIME</th><th>ACTIVITY/PROGRAMME</th></tr>
      </thead>
      <tbody>
        @foreach ($proposal->scheduleItems as $item)
          <tr><td>{{ $item->time ?: '-' }}</td><td>{{ $item->activity }}</td></tr>
        @endforeach
      </tbody>
    </table>
  @endif

  @if ($proposal->committees->isNotEmpty())
    <h2 class="section">7. LIST OF COMMITTEES</h2>
    <table class="data-table">
      <thead>
        <tr><th>POSITION</th><th>NAME</th><th>MATRIC NO.</th><th>PHONE NO.</th></tr>
      </thead>
      <tbody>
        @foreach ($proposal->committees as $member)
          <tr>
            <td>{{ $member->position }}</td>
            <td>{{ $member->name ?: '-' }}</td>
            <td>{{ $member->matric_no ?: '-' }}</td>
            <td>{{ $member->phone_no ?: '-' }}</td>
          </tr>
        @endforeach
      </tbody>
    </table>
    <p style="font-size: 10.5px;">*Other members are to be determined and will be included in the final report.</p>
  @endif

  <h2 class="section">8. BUDGET IMPLICATION</h2>
  @if ($proposal->no_budget_required)
    <p>This programme does not require any financial allocation. All activities will be carried out using existing resources and voluntary contributions.</p>
  @else
    @php
      $budgetCategoryLabels = [
          'stadd_trust_fund' => 'a) Expected Expenditure from STADD Trust Fund',
          'student_activities_programme' => 'b) Expected Expenditure Student Activities Programme',
          'sponsorships_participants_fee' => 'c) Expected Expenditure Sponsorships/Participants Fee',
      ];
    @endphp
    @foreach ($budgetCategoryLabels as $category => $label)
      @php $items = $proposal->budgetItems->where('category', $category); @endphp
      @if ($items->isNotEmpty())
        <h3 class="subsection">{{ $label }}</h3>
        <table class="data-table">
          <thead>
            <tr><th>NO.</th><th>PARTICULAR</th><th>PRICE PER UNIT (RM)</th><th>QUANTITY</th><th>AMOUNT (RM)</th></tr>
          </thead>
          <tbody>
            @php $categoryTotal = 0; @endphp
            @foreach ($items as $index => $item)
              @php $categoryTotal += (float) ($item->amount ?? 0); @endphp
              <tr>
                <td>{{ $index + 1 }}.</td>
                <td>{{ $item->particular }}</td>
                <td class="amount-col">{{ $item->price_per_unit !== null ? number_format((float) $item->price_per_unit, 2) : '-' }}</td>
                <td class="text-center">{{ $item->quantity ?? '-' }}</td>
                <td class="amount-col">{{ $item->amount !== null ? number_format((float) $item->amount, 2) : '-' }}</td>
              </tr>
            @endforeach
            <tr>
              <td colspan="4" style="text-align: right; font-weight: bold;">TOTAL</td>
              <td class="amount-col" style="font-weight: bold;">{{ number_format($categoryTotal, 2) }}</td>
            </tr>
          </tbody>
        </table>
      @endif
    @endforeach

    <h3 class="subsection">Source of Funds</h3>
    <table class="data-table">
      <thead>
        <tr><th>NO.</th><th>PARTICULAR</th><th>AMOUNT (RM)</th></tr>
      </thead>
      <tbody>
        @foreach ($proposal->sourceOfFundsRows() as $index => $row)
          <tr>
            <td>{{ $index + 1 }}.</td>
            <td>{{ $row['particular'] }}</td>
            <td class="amount-col">{{ number_format($row['amount'], 2) }}</td>
          </tr>
        @endforeach
        <tr>
          <td colspan="2" style="text-align: right; font-weight: bold;">TOTAL</td>
          <td class="amount-col" style="font-weight: bold;">{{ number_format($proposal->sourceOfFundsTotal(), 2) }}</td>
        </tr>
      </tbody>
    </table>
  @endif

  <h2 class="section">9. APPROVAL</h2>
  <p>
    The authority's approval is kindly requested for the execution of this <strong>{{ $proposal->name }}</strong>.
    The financial implication of the programme is
    <strong>RM {{ $proposal->no_budget_required ? '0.00' : number_format((float) ($proposal->financial_implication_amount ?? 0), 2) }}</strong>
    @if ($proposal->funding_source)
      and to be utilized from <strong>{{ $proposal->funding_source }}</strong>.
    @else
      .
    @endif
  </p>

  <table class="approval">
    <tr>
      <td>
        <div class="approval-role">Prepared by:</div>
        <div class="approval-name">{{ $proposal->prepared_by_name ?: '(Br./Sr. Name)' }}</div>
        <div class="approval-meta">{{ $proposal->prepared_by_position ?: 'Secretary / Programme Manager' }}</div>
        <div class="approval-meta">ICT Students' Society {{ $proposal->societyTerm->term ?? '' }}</div>
        <div class="approval-meta">KICT, IIUM</div>
        <div class="approval-meta">Date: {{ optional($proposal->prepared_by_date)->format('d M Y') }}</div>
      </td>
      <td>
        <div class="approval-role">Checked by:</div>
        <div class="approval-name">{{ $proposal->checkedBySignatory->name ?? '-' }}</div>
        <div class="approval-meta">{{ $proposal->checkedBySignatory->designation_en ?? '' }}</div>
        <div class="approval-meta">ICT Students' Society {{ $proposal->societyTerm->term ?? '' }}</div>
        <div class="approval-meta">KICT, IIUM</div>
        <div class="approval-meta">Date: {{ optional($proposal->checked_by_date)->format('d M Y') }}</div>
      </td>
    </tr>
    <tr>
      <td>
        <div class="approval-role">Reviewed by:</div>
        <div class="approval-name">{{ $proposal->reviewedBySignatory->name ?? '-' }}</div>
        <div class="approval-meta">{{ $proposal->reviewedBySignatory->designation_en ?? '' }}</div>
        <div class="approval-meta">KICT, IIUM</div>
        <div class="approval-meta">Date: {{ optional($proposal->reviewed_by_date)->format('d M Y') }}</div>
      </td>
      <td>
        <div class="approval-role">Recommended by:</div>
        <div class="approval-name">{{ $proposal->recommendedBySignatory->name ?? '-' }}</div>
        <div class="approval-meta">{{ $proposal->recommendedBySignatory->designation_en ?? '' }}</div>
        <div class="approval-meta">KICT, IIUM</div>
        <div class="approval-meta">Date: {{ optional($proposal->recommended_by_date)->format('d M Y') }}</div>
      </td>
    </tr>
    <tr>
      <td colspan="2" class="approval-full">
        <div class="approval-role">Approved by:</div>
        <div class="approval-name">{{ $proposal->approvedBySignatory->name ?? '-' }}</div>
        <div class="approval-meta">{{ $proposal->approvedBySignatory->designation_en ?? '' }}</div>
        <div class="approval-meta">KICT, IIUM</div>
        <div class="approval-meta">Date: {{ optional($proposal->approved_by_date)->format('d M Y') }}</div>
      </td>
    </tr>
  </table>
</body>
</html>
