@extends('layouts.app')

@section('title', 'DDSDCE Dashboard')

@push('page-css')
  <link rel="stylesheet" href="{{ asset('assets') }}/vendor/libs/apex-charts/apex-charts.css" />
  <style>
    @media print {
      #layout-menu, .layout-navbar, .content-footer, .no-print {
        display: none !important;
      }
      .layout-page, .content-wrapper {
        margin: 0 !important;
        padding: 0 !important;
      }
      .card {
        break-inside: avoid;
        box-shadow: none !important;
        border: 1px solid #dee2e6 !important;
      }
    }
  </style>
@endpush

@section('content')
  <div class="d-flex align-items-center justify-content-between flex-wrap gap-3 mb-6">
    <h4 class="mb-0">DDSDCE Office / Dashboard</h4>
    <button type="button" class="btn btn-outline-secondary no-print" onclick="window.print()">
      <i class="icon-base bx bx-printer me-1"></i> Print / Export
    </button>
  </div>

  {{-- Headline KPIs --}}
  <div class="row">
    <div class="col-md-3 col-sm-6 mb-6">
      <div class="card h-100">
        <div class="card-body">
          <div class="card-title d-flex align-items-start justify-content-between mb-4">
            <div class="avatar flex-shrink-0">
              <span class="avatar-initial rounded bg-label-primary">
                <i class="icon-base bx bx-briefcase-alt-2 icon-lg"></i>
              </span>
            </div>
          </div>
          <p class="mb-1">Total Case Load (All Modules)</p>
          <h4 class="card-title mb-0">{{ number_format($grandTotal) }}</h4>
        </div>
      </div>
    </div>
    <div class="col-md-3 col-sm-6 mb-6">
      <div class="card h-100">
        <div class="card-body">
          <div class="card-title d-flex align-items-start justify-content-between mb-4">
            <div class="avatar flex-shrink-0">
              <span class="avatar-initial rounded bg-label-info">
                <i class="icon-base bx bx-calendar icon-lg"></i>
              </span>
            </div>
          </div>
          <p class="mb-1">New Records This Month</p>
          <h4 class="card-title mb-0">
            {{ number_format($lettersMonthly->last() + $disciplinaryMonthly->last() + $dsuMonthly->last() + $academicStandingMonthly->last() + $counsellingMonthly->last()) }}
          </h4>
        </div>
      </div>
    </div>
    <div class="col-md-3 col-sm-6 mb-6">
      <div class="card h-100 {{ $disciplinaryOverdueCount > 0 ? 'border-danger' : '' }}">
        <div class="card-body">
          <div class="card-title d-flex align-items-start justify-content-between mb-4">
            <a href="{{ route('ddsdce.disciplinary.index') }}" class="avatar flex-shrink-0" title="View Disciplinary Records">
              <span class="avatar-initial rounded bg-label-danger">
                <i class="icon-base bx bx-error icon-lg"></i>
              </span>
            </a>
          </div>
          <p class="mb-1">Overdue Disciplinary Cases</p>
          <h4 class="card-title mb-0">{{ number_format($disciplinaryOverdueCount) }}</h4>
        </div>
      </div>
    </div>
    <div class="col-md-3 col-sm-6 mb-6">
      <div class="card h-100 {{ $counsellingPendingEmailCount > 0 ? 'border-warning' : '' }}">
        <div class="card-body">
          <div class="card-title d-flex align-items-start justify-content-between mb-4">
            <a href="{{ route('ddsdce.counselling.index') }}" class="avatar flex-shrink-0" title="View Counselling Records">
              <span class="avatar-initial rounded bg-label-warning">
                <i class="icon-base bx bx-envelope icon-lg"></i>
              </span>
            </a>
          </div>
          <p class="mb-1">Counselling Pending CCSC Email</p>
          <h4 class="card-title mb-0">{{ number_format($counsellingPendingEmailCount) }}</h4>
        </div>
      </div>
    </div>
  </div>

  {{-- Per-module counters --}}
  <div class="row">
    <div class="col-md-4 col-sm-6 mb-6">
      <div class="card h-100">
        <div class="card-body">
          <div class="card-title d-flex align-items-start justify-content-between mb-4">
            <a href="{{ route('ddsdce.attendance.index') }}" class="avatar flex-shrink-0" title="View Attendance Letters">
              <span class="avatar-initial rounded bg-label-success">
                <i class="icon-base bx bx-calendar-check icon-lg"></i>
              </span>
            </a>
          </div>
          <p class="mb-1">Attendance Letters</p>
          <h4 class="card-title mb-0">{{ number_format($attendanceCount) }}</h4>
        </div>
      </div>
    </div>
    <div class="col-md-4 col-sm-6 mb-6">
      <div class="card h-100">
        <div class="card-body">
          <div class="card-title d-flex align-items-start justify-content-between mb-4">
            <a href="{{ route('ddsdce.expected-graduation.index') }}" class="avatar flex-shrink-0" title="View Expected Graduation Letters">
              <span class="avatar-initial rounded bg-label-info">
                <i class="icon-base bx bx-certification icon-lg"></i>
              </span>
            </a>
          </div>
          <p class="mb-1">Expected Graduation</p>
          <h4 class="card-title mb-0">{{ number_format($expectedGraduationCount) }}</h4>
        </div>
      </div>
    </div>
    <div class="col-md-4 col-sm-6 mb-6">
      <div class="card h-100">
        <div class="card-body">
          <div class="card-title d-flex align-items-start justify-content-between mb-4">
            <a href="{{ route('ddsdce.loa.index') }}" class="avatar flex-shrink-0" title="View LOA Letters">
              <span class="avatar-initial rounded bg-label-danger">
                <i class="icon-base bx bx-calendar-x icon-lg"></i>
              </span>
            </a>
          </div>
          <p class="mb-1">LOA Letters</p>
          <h4 class="card-title mb-0">{{ number_format($loaCount) }}</h4>
        </div>
      </div>
    </div>
    <div class="col-md-4 col-sm-6 mb-6">
      <div class="card h-100">
        <div class="card-body">
          <div class="card-title d-flex align-items-start justify-content-between mb-4">
            <a href="{{ route('ddsdce.readmission.index') }}" class="avatar flex-shrink-0" title="View Readmission Letters">
              <span class="avatar-initial rounded bg-label-primary">
                <i class="icon-base bx bx-user-check icon-lg"></i>
              </span>
            </a>
          </div>
          <p class="mb-1">Readmission Letters</p>
          <h4 class="card-title mb-0">{{ number_format($readmissionCount) }}</h4>
        </div>
      </div>
    </div>
    <div class="col-md-4 col-sm-6 mb-6">
      <div class="card h-100">
        <div class="card-body">
          <div class="card-title d-flex align-items-start justify-content-between mb-4">
            <a href="{{ route('ddsdce.disciplinary.index') }}" class="avatar flex-shrink-0" title="View Disciplinary Records">
              <span class="avatar-initial rounded bg-label-warning">
                <i class="icon-base bx bx-error-circle icon-lg"></i>
              </span>
            </a>
          </div>
          <p class="mb-1">Disciplinary Records</p>
          <h4 class="card-title mb-0">{{ number_format($disciplinaryCount) }}</h4>
        </div>
      </div>
    </div>
    <div class="col-md-4 col-sm-6 mb-6">
      <div class="card h-100">
        <div class="card-body">
          <div class="card-title d-flex align-items-start justify-content-between mb-4">
            <a href="{{ route('ddsdce.dsu.index') }}" class="avatar flex-shrink-0" title="View DSU Students">
              <span class="avatar-initial rounded bg-label-secondary">
                <i class="icon-base bx bx-accessibility icon-lg"></i>
              </span>
            </a>
          </div>
          <p class="mb-1">DSU Students</p>
          <h4 class="card-title mb-0">{{ number_format($dsuCount) }}</h4>
        </div>
      </div>
    </div>
    <div class="col-md-4 col-sm-6 mb-6">
      <div class="card h-100">
        <div class="card-body">
          <div class="card-title d-flex align-items-start justify-content-between mb-4">
            <a href="{{ route('ddsdce.provisional.index') }}" class="avatar flex-shrink-0" title="View Provisional Records">
              <span class="avatar-initial rounded bg-label-info">
                <i class="icon-base bx bx-timer icon-lg"></i>
              </span>
            </a>
          </div>
          <p class="mb-1">Provisional Records</p>
          <h4 class="card-title mb-0">{{ number_format($provisionalCount) }}</h4>
        </div>
      </div>
    </div>
    <div class="col-md-4 col-sm-6 mb-6">
      <div class="card h-100">
        <div class="card-body">
          <div class="card-title d-flex align-items-start justify-content-between mb-4">
            <a href="{{ route('ddsdce.reinstate.index') }}" class="avatar flex-shrink-0" title="View Reinstatement Records">
              <span class="avatar-initial rounded bg-label-success">
                <i class="icon-base bx bx-reset icon-lg"></i>
              </span>
            </a>
          </div>
          <p class="mb-1">Reinstatement Records</p>
          <h4 class="card-title mb-0">{{ number_format($reinstateCount) }}</h4>
        </div>
      </div>
    </div>
    <div class="col-md-4 col-sm-6 mb-6">
      <div class="card h-100">
        <div class="card-body">
          <div class="card-title d-flex align-items-start justify-content-between mb-4">
            <a href="{{ route('ddsdce.counselling.index') }}" class="avatar flex-shrink-0" title="View Counselling Records">
              <span class="avatar-initial rounded bg-label-dark">
                <i class="icon-base bx bx-conversation icon-lg"></i>
              </span>
            </a>
          </div>
          <p class="mb-1">Counselling Records</p>
          <h4 class="card-title mb-0">{{ number_format($counsellingCount) }}</h4>
        </div>
      </div>
    </div>
  </div>

  {{-- Trend + composition --}}
  <div class="row">
    <div class="col-xxl-8 mb-6">
      <div class="card h-100">
        <div class="card-header d-flex align-items-center justify-content-between">
          <h5 class="mb-0">Case Volume Trend (Last 6 Months)</h5>
        </div>
        <div class="card-body">
          <div id="caseTrendChart"></div>
        </div>
      </div>
    </div>
    <div class="col-xxl-4 mb-6">
      <div class="card h-100">
        <div class="card-header">
          <h5 class="mb-0">Case Mix (All Time)</h5>
        </div>
        <div class="card-body">
          @if ($grandTotal > 0)
            <div class="d-flex justify-content-center">
              <div id="caseMixChart"></div>
            </div>
          @else
            <p class="text-body-secondary text-center mb-0">No records yet.</p>
          @endif
          <ul class="p-0 m-0 mt-4">
            <li class="d-flex align-items-center mb-4">
              <i class="icon-base bx bxs-circle text-primary me-2"></i>
              <div class="d-flex w-100 flex-wrap align-items-center justify-content-between">
                <span>Letters</span>
                <span class="fw-medium">{{ number_format($lettersCount) }}</span>
              </div>
            </li>
            <li class="d-flex align-items-center mb-4">
              <i class="icon-base bx bxs-circle text-info me-2"></i>
              <div class="d-flex w-100 flex-wrap align-items-center justify-content-between">
                <span>Disciplinary</span>
                <span class="fw-medium">{{ number_format($disciplinaryCount) }}</span>
              </div>
            </li>
            <li class="d-flex align-items-center mb-4">
              <i class="icon-base bx bxs-circle text-success me-2"></i>
              <div class="d-flex w-100 flex-wrap align-items-center justify-content-between">
                <span>DSU Students</span>
                <span class="fw-medium">{{ number_format($dsuCount) }}</span>
              </div>
            </li>
            <li class="d-flex align-items-center mb-4">
              <i class="icon-base bx bxs-circle text-secondary me-2"></i>
              <div class="d-flex w-100 flex-wrap align-items-center justify-content-between">
                <span>Academic Standing</span>
                <span class="fw-medium">{{ number_format($academicStandingCount) }}</span>
              </div>
            </li>
            <li class="d-flex align-items-center">
              <i class="icon-base bx bxs-circle text-dark me-2"></i>
              <div class="d-flex w-100 flex-wrap align-items-center justify-content-between">
                <span>Counselling</span>
                <span class="fw-medium">{{ number_format($counsellingCount) }}</span>
              </div>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </div>

  {{-- Supporting breakdowns --}}
  <div class="row">
    <div class="col-xxl-4 mb-6">
      <div class="card h-100">
        <div class="card-header">
          <h5 class="mb-0">Needs Attention</h5>
        </div>
        <div class="card-body">
          <ul class="p-0 m-0">
            <li class="d-flex align-items-center justify-content-between mb-4">
              <a href="{{ route('ddsdce.disciplinary.index') }}" class="text-body text-decoration-none d-flex align-items-center">
                <i class="icon-base bx bx-error-circle text-danger me-2"></i>
                Overdue Disciplinary Cases
              </a>
              <span class="badge {{ $disciplinaryOverdueCount > 0 ? 'bg-danger' : 'bg-label-secondary' }}">{{ number_format($disciplinaryOverdueCount) }}</span>
            </li>
            <li class="d-flex align-items-center justify-content-between">
              <a href="{{ route('ddsdce.counselling.index') }}" class="text-body text-decoration-none d-flex align-items-center">
                <i class="icon-base bx bx-envelope text-warning me-2"></i>
                Counselling Pending CCSC Email
              </a>
              <span class="badge {{ $counsellingPendingEmailCount > 0 ? 'bg-warning' : 'bg-label-secondary' }}">{{ number_format($counsellingPendingEmailCount) }}</span>
            </li>
          </ul>
        </div>
      </div>
    </div>
    <div class="col-xxl-4 mb-6">
      <div class="card h-100">
        <div class="card-header d-flex align-items-center justify-content-between">
          <h5 class="mb-0">DSU Students by Disability Category</h5>
          <a href="{{ route('ddsdce.dsu.index') }}" class="btn btn-icon btn-sm btn-text-secondary" title="View DSU Students">
            <i class="icon-base bx bx-right-arrow-alt"></i>
          </a>
        </div>
        <div class="card-body">
          @if ($dsuByCategory->isEmpty())
            <p class="text-body-secondary mb-0">No DSU students recorded yet.</p>
          @else
            <ul class="p-0 m-0">
              @foreach ($dsuByCategory as $row)
                <li class="d-flex align-items-center {{ ! $loop->last ? 'mb-4' : '' }}">
                  <i class="icon-base bx bxs-circle text-secondary me-2"></i>
                  <div class="d-flex w-100 flex-wrap align-items-center justify-content-between">
                    <span>{{ $row->code ? $row->code.' - '.$row->name : 'Unspecified' }}</span>
                    <span class="fw-medium">{{ number_format($row->total) }}</span>
                  </div>
                </li>
              @endforeach
            </ul>
          @endif
        </div>
      </div>
    </div>
    <div class="col-xxl-4 mb-6">
      <div class="card h-100">
        <div class="card-header d-flex align-items-center justify-content-between">
          <h5 class="mb-0">Top Disciplinary Offenses</h5>
          <a href="{{ route('ddsdce.disciplinary.index') }}" class="btn btn-icon btn-sm btn-text-secondary" title="View Disciplinary Records">
            <i class="icon-base bx bx-right-arrow-alt"></i>
          </a>
        </div>
        <div class="card-body">
          @if ($disciplinaryByOffense->isEmpty())
            <p class="text-body-secondary mb-0">No disciplinary records yet.</p>
          @else
            <ul class="p-0 m-0">
              @foreach ($disciplinaryByOffense as $row)
                <li class="d-flex align-items-center {{ ! $loop->last ? 'mb-4' : '' }}">
                  <i class="icon-base bx bxs-circle text-warning me-2"></i>
                  <div class="d-flex w-100 flex-wrap align-items-center justify-content-between">
                    <span>{{ $row->name ?? 'Unspecified' }}</span>
                    <span class="fw-medium">{{ number_format($row->total) }}</span>
                  </div>
                </li>
              @endforeach
            </ul>
          @endif
        </div>
      </div>
    </div>
  </div>

  {{-- Recent activity --}}
  <div class="row">
    <div class="col-12 mb-6">
      <div class="card">
        <div class="card-header d-flex align-items-center justify-content-between">
          <h5 class="mb-0">Recent Activity</h5>
        </div>
        <div class="table-responsive text-nowrap">
          <table class="table">
            <thead class="table-light">
              <tr>
                <th>Reference No. / Offense</th>
                <th>Type</th>
                <th>Student</th>
                <th>Date</th>
              </tr>
            </thead>
            <tbody class="table-border-bottom-0">
              @forelse ($recentActivity as $item)
                <tr>
                  <td><a href="{{ $item['url'] }}">{{ $item['reference_no'] }}</a></td>
                  <td>{{ $item['type'] }}</td>
                  <td>{{ $item['student'] }}</td>
                  <td>{{ $item['date']->format('d M Y') }}</td>
                </tr>
              @empty
                <tr>
                  <td colspan="4" class="text-center text-body-secondary py-6">No activity yet.</td>
                </tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
@endsection

@push('page-js')
  <script src="{{ asset('assets') }}/vendor/libs/apex-charts/apexcharts.js"></script>
  <script>
    (function () {
      const trendEl = document.querySelector('#caseTrendChart');
      const mixEl = document.querySelector('#caseMixChart');

      const cardColor = config.colors.cardColor;
      const labelColor = config.colors.textMuted;
      const legendColor = config.colors.bodyColor;
      const borderColor = config.colors.borderColor;
      const fontFamily = config.fontFamily;

      // Fixed category order + colors, reused identically across the trend
      // and mix charts so the same category always reads the same color.
      const categoryColors = [
        config.colors.primary,
        config.colors.info,
        config.colors.success,
        config.colors.secondary,
        config.colors.dark
      ];

      @php
        $trendPayload = [
            'categories' => $monthlyLabels->values(),
            'letters' => $lettersMonthly->values(),
            'disciplinary' => $disciplinaryMonthly->values(),
            'dsu' => $dsuMonthly->values(),
            'academicStanding' => $academicStandingMonthly->values(),
            'counselling' => $counsellingMonthly->values(),
        ];
      @endphp
      const trendData = @json($trendPayload);

      if (trendEl) {
        const trendChart = new ApexCharts(trendEl, {
          series: [
            { name: 'Letters', data: trendData.letters },
            { name: 'Disciplinary', data: trendData.disciplinary },
            { name: 'DSU Students', data: trendData.dsu },
            { name: 'Academic Standing', data: trendData.academicStanding },
            { name: 'Counselling', data: trendData.counselling }
          ],
          chart: {
            height: 360,
            type: 'bar',
            stacked: true,
            toolbar: { show: false }
          },
          plotOptions: {
            bar: {
              horizontal: false,
              columnWidth: '45%',
              borderRadius: 6,
              borderRadiusApplication: 'around'
            }
          },
          colors: categoryColors,
          dataLabels: { enabled: false },
          stroke: {
            show: true,
            width: 2,
            colors: [cardColor]
          },
          legend: {
            show: true,
            horizontalAlign: 'left',
            position: 'top',
            markers: { size: 4, radius: 12, shape: 'circle', strokeWidth: 0 },
            fontSize: '13px',
            fontFamily: fontFamily,
            labels: { colors: legendColor },
            itemMargin: { horizontal: 10 }
          },
          grid: {
            strokeDashArray: 7,
            borderColor: borderColor,
            padding: { top: 0, bottom: -8, left: 10, right: 10 }
          },
          xaxis: {
            categories: trendData.categories,
            labels: { style: { fontSize: '13px', fontFamily: fontFamily, colors: labelColor } },
            axisTicks: { show: false },
            axisBorder: { show: false }
          },
          yaxis: {
            labels: {
              style: { fontSize: '13px', fontFamily: fontFamily, colors: labelColor },
              formatter: function (val) { return Math.round(val); }
            }
          }
        });
        trendChart.render();
      }

      if (mixEl) {
        const mixChart = new ApexCharts(mixEl, {
          chart: { height: 165, width: 220, type: 'donut' },
          labels: ['Letters', 'Disciplinary', 'DSU Students', 'Academic Standing', 'Counselling'],
          series: [{{ $lettersCount }}, {{ $disciplinaryCount }}, {{ $dsuCount }}, {{ $academicStandingCount }}, {{ $counsellingCount }}],
          colors: categoryColors,
          stroke: { width: 5, colors: [cardColor] },
          dataLabels: {
            enabled: true,
            formatter: function (val) {
              return parseInt(val) + '%';
            }
          },
          legend: { show: false },
          states: {
            hover: { filter: { type: 'none' } },
            active: { filter: { type: 'none' } }
          },
          plotOptions: {
            pie: {
              donut: {
                size: '70%',
                labels: {
                  show: true,
                  value: {
                    fontSize: '1.125rem',
                    fontFamily: fontFamily,
                    fontWeight: 500,
                    offsetY: -17
                  },
                  name: { offsetY: 17, fontFamily: fontFamily },
                  total: {
                    show: true,
                    fontSize: '13px',
                    color: legendColor,
                    label: 'Total',
                    formatter: function () {
                      return '{{ $grandTotal }}';
                    }
                  }
                }
              }
            }
          }
        });
        mixChart.render();
      }
    })();
  </script>
@endpush
