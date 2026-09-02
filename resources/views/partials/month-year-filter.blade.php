@php
    $monthYearActive = $filterMonth || $filterYear;
@endphp

<div class="dropdown">
  <button
    type="button"
    class="btn btn-outline-secondary {{ $monthYearActive ? 'active' : '' }}"
    data-bs-toggle="dropdown"
    data-bs-auto-close="outside"
    aria-expanded="false"
    title="Filter by month/year">
    <i class="icon-base bx bx-calendar"></i>
  </button>
  <div class="dropdown-menu dropdown-menu-end p-3" style="min-width: 220px;">
    <label class="form-label small mb-1">Month</label>
    <select name="month" class="form-select form-select-sm mb-2">
      <option value="">All months</option>
      @foreach ($monthOptions as $value => $label)
        <option value="{{ $value }}" @selected($filterMonth == $value)>{{ $label }}</option>
      @endforeach
    </select>
    <label class="form-label small mb-1">Year</label>
    <select name="year" class="form-select form-select-sm {{ $monthYearActive ? 'mb-2' : 'mb-0' }}">
      <option value="">All years</option>
      @foreach ($yearOptions as $value)
        <option value="{{ $value }}" @selected($filterYear == $value)>{{ $value }}</option>
      @endforeach
    </select>
    <button type="submit" class="btn btn-primary btn-sm w-100 mt-2">Apply Filter</button>
    @if ($monthYearActive)
      <a href="{{ $clearMonthYearUrl }}" class="btn btn-outline-secondary btn-sm w-100 mt-2">Clear Filter</a>
    @endif
  </div>
</div>
