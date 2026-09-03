@extends('layouts.app')

@section('title', 'DDSDCE Dashboard')

@push('page-css')
  <link rel="stylesheet" href="{{ asset('assets') }}/vendor/libs/apex-charts/apex-charts.css" />
@endpush

@section('content')
  <h4 class="mb-6">DDSDCE Office / Dashboard</h4>

  <div class="row">
    <div class="col-md-4 col-sm-6 mb-6">
      <div class="card h-100">
        <div class="card-body">
          <div class="card-title d-flex align-items-start justify-content-between mb-4">
            <div class="avatar flex-shrink-0">
              <span class="avatar-initial rounded bg-label-primary">
                <i class="icon-base bx bx-file icon-lg"></i>
              </span>
            </div>
          </div>
          <p class="mb-1">Total Letters</p>
          <h4 class="card-title mb-0">{{ number_format($totalCount) }}</h4>
        </div>
      </div>
    </div>
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
            @if ($disciplinaryOverdueCount > 0)
              <span class="badge bg-label-danger">{{ $disciplinaryOverdueCount }} overdue</span>
            @endif
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
  </div>

  <div class="row">
    <div class="col-xxl-8 mb-6">
      <div class="card h-100">
        <div class="card-header d-flex align-items-center justify-content-between">
          <h5 class="mb-0">Activity (Last 6 Months)</h5>
        </div>
        <div class="card-body">
          <div id="lettersTrendChart"></div>
        </div>
      </div>
    </div>
    <div class="col-xxl-4 mb-6">
      <div class="card h-100">
        <div class="card-header">
          <h5 class="mb-0">Records by Type</h5>
        </div>
        <div class="card-body">
          <div class="d-flex justify-content-center">
            <div id="lettersTypeChart"></div>
          </div>
          <ul class="p-0 m-0 mt-4">
            <li class="d-flex align-items-center mb-4">
              <i class="icon-base bx bxs-circle text-success me-2"></i>
              <div class="d-flex w-100 flex-wrap align-items-center justify-content-between">
                <span>Attendance</span>
                <span class="fw-medium">{{ number_format($attendanceCount) }}</span>
              </div>
            </li>
            <li class="d-flex align-items-center mb-4">
              <i class="icon-base bx bxs-circle text-info me-2"></i>
              <div class="d-flex w-100 flex-wrap align-items-center justify-content-between">
                <span>Expected Graduation</span>
                <span class="fw-medium">{{ number_format($expectedGraduationCount) }}</span>
              </div>
            </li>
            <li class="d-flex align-items-center mb-4">
              <i class="icon-base bx bxs-circle text-danger me-2"></i>
              <div class="d-flex w-100 flex-wrap align-items-center justify-content-between">
                <span>LOA</span>
                <span class="fw-medium">{{ number_format($loaCount) }}</span>
              </div>
            </li>
            <li class="d-flex align-items-center mb-4">
              <i class="icon-base bx bxs-circle text-primary me-2"></i>
              <div class="d-flex w-100 flex-wrap align-items-center justify-content-between">
                <span>Readmission</span>
                <span class="fw-medium">{{ number_format($readmissionCount) }}</span>
              </div>
            </li>
            <li class="d-flex align-items-center">
              <i class="icon-base bx bxs-circle text-warning me-2"></i>
              <div class="d-flex w-100 flex-wrap align-items-center justify-content-between">
                <span>Disciplinary</span>
                <span class="fw-medium">{{ number_format($disciplinaryCount) }}</span>
              </div>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </div>

  <div class="row">
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
    <div class="col-xxl-8 mb-6">
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
      const trendEl = document.querySelector('#lettersTrendChart');
      const typeEl = document.querySelector('#lettersTypeChart');

      const cardColor = config.colors.cardColor;
      const labelColor = config.colors.textMuted;
      const legendColor = config.colors.bodyColor;
      const borderColor = config.colors.borderColor;
      const fontFamily = config.fontFamily;

      @php
        $trendPayload = [
            'categories' => $monthlyLabels->values(),
            'attendance' => $attendanceMonthly->values(),
            'expectedGraduation' => $expectedGraduationMonthly->values(),
            'loa' => $loaMonthly->values(),
            'readmission' => $readmissionMonthly->values(),
            'disciplinary' => $disciplinaryMonthly->values(),
        ];
      @endphp
      const trendData = @json($trendPayload);

      if (trendEl) {
        const trendChart = new ApexCharts(trendEl, {
          series: [
            { name: 'Attendance', data: trendData.attendance },
            { name: 'Expected Graduation', data: trendData.expectedGraduation },
            { name: 'LOA', data: trendData.loa },
            { name: 'Readmission', data: trendData.readmission },
            { name: 'Disciplinary', data: trendData.disciplinary }
          ],
          chart: {
            height: 340,
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
          colors: [config.colors.success, config.colors.info, config.colors.danger, config.colors.primary, config.colors.warning],
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
            labels: { style: { fontSize: '13px', fontFamily: fontFamily, colors: labelColor } }
          }
        });
        trendChart.render();
      }

      if (typeEl) {
        const typeChart = new ApexCharts(typeEl, {
          chart: { height: 165, width: 220, type: 'donut' },
          labels: ['Attendance', 'Expected Graduation', 'LOA', 'Readmission', 'Disciplinary'],
          series: [{{ $attendanceCount }}, {{ $expectedGraduationCount }}, {{ $loaCount }}, {{ $readmissionCount }}, {{ $disciplinaryCount }}],
          colors: [config.colors.success, config.colors.info, config.colors.danger, config.colors.primary, config.colors.warning],
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
        typeChart.render();
      }
    })();
  </script>
@endpush
