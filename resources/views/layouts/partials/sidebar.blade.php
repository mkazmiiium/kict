@php
    $ddsdceActive = request()->routeIs('ddsdce.*');
    $canSeeDdaa = auth()->user()->hasAnyRole(['Superadmin', 'DDAA Office']);
    $canSeeDdsdce = auth()->user()->hasAnyRole(['Superadmin', 'DDSDCE Office']);
    $canSeeAdministration = auth()->user()->hasAnyRole(['Superadmin', 'DDSDCE Office']);
    $canSeeUsers = auth()->user()->hasRole('Superadmin');
@endphp

<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
  <div class="app-brand demo">
    <a href="{{ route('dashboard') }}" class="app-brand-link">
      <img
        src="{{ asset('assets/img/kict-logo.png') }}"
        alt="KICT Office"
        style="height: 48px; width: auto; max-width: 100%;" />
    </a>

    <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto">
      <i class="bx bx-chevron-left d-none d-xl-block align-middle"></i>
    </a>
  </div>

  <div class="menu-divider mt-0"></div>

  <div class="menu-inner-shadow"></div>

  <ul class="menu-inner py-1">
    <li class="menu-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
      <a href="{{ route('dashboard') }}" class="menu-link">
        <i class="menu-icon tf-icons bx bx-home-smile"></i>
        <div class="text-truncate">Dashboard</div>
      </a>
    </li>

    @if ($canSeeDdaa || $canSeeDdsdce)
      <li class="menu-header small text-uppercase">
        <span class="menu-header-text">Offices</span>
      </li>
    @endif

    @if ($canSeeDdaa)
      <li class="menu-item {{ request()->routeIs('ddaa.*') ? 'active' : '' }}">
        <a href="{{ route('ddaa.index') }}" class="menu-link">
          <i class="menu-icon tf-icons bx bx-buildings"></i>
          <div class="text-truncate">DDAA Office</div>
          <div class="badge rounded-pill bg-label-secondary text-uppercase fs-tiny ms-auto">Phase 2</div>
        </a>
      </li>
    @endif

    @if ($canSeeDdsdce)
      <li class="menu-item {{ $ddsdceActive ? 'active open' : '' }}">
        <a href="{{ route('ddsdce.dashboard') }}" class="menu-link">
          <i class="menu-icon tf-icons bx bx-briefcase-alt-2"></i>
          <div class="text-truncate">DDSDCE Office</div>
        </a>
        <ul class="menu-sub">
          <li class="menu-item {{ request()->routeIs('ddsdce.dashboard') ? 'active' : '' }}">
            <a href="{{ route('ddsdce.dashboard') }}" class="menu-link">
              <div class="text-truncate">Dashboard</div>
            </a>
          </li>
          <li class="menu-item {{ request()->routeIs('ddsdce.attendance.*') ? 'active' : '' }}">
            <a href="{{ route('ddsdce.attendance.index') }}" class="menu-link">
              <div class="text-truncate">Attendance Letter</div>
            </a>
          </li>
          <li class="menu-item {{ request()->routeIs('ddsdce.expected-graduation.*') ? 'active' : '' }}">
            <a href="{{ route('ddsdce.expected-graduation.index') }}" class="menu-link">
              <div class="text-truncate">Expected Graduation Letter</div>
            </a>
          </li>
          <li class="menu-item {{ request()->routeIs('ddsdce.loa.*') ? 'active' : '' }}">
            <a href="{{ route('ddsdce.loa.index') }}" class="menu-link">
              <div class="text-truncate">LOA</div>
            </a>
          </li>
          <li class="menu-item {{ request()->routeIs('ddsdce.readmission.*') ? 'active' : '' }}">
            <a href="{{ route('ddsdce.readmission.index') }}" class="menu-link">
              <div class="text-truncate">Readmission</div>
            </a>
          </li>
          <li class="menu-item {{ request()->routeIs('ddsdce.dsu.*') ? 'active' : '' }}">
            <a href="{{ route('ddsdce.dsu.index') }}" class="menu-link">
              <div class="text-truncate">DSU Students</div>
            </a>
          </li>
          <li class="menu-item {{ request()->routeIs('ddsdce.disciplinary.*') ? 'active' : '' }}">
            <a href="{{ route('ddsdce.disciplinary.index') }}" class="menu-link">
              <div class="text-truncate">Disciplinary</div>
            </a>
          </li>
        </ul>
      </li>
    @endif

    @if ($canSeeAdministration)
      <li class="menu-header small text-uppercase">
        <span class="menu-header-text">Administration</span>
      </li>

      <li class="menu-item {{ request()->routeIs('administration.students.*') ? 'active' : '' }}">
        <a href="{{ route('administration.students.index') }}" class="menu-link">
          <i class="menu-icon tf-icons bx bx-user"></i>
          <div class="text-truncate">Students</div>
        </a>
      </li>
    @endif

    @if ($canSeeUsers)
      @unless ($canSeeAdministration)
        <li class="menu-header small text-uppercase">
          <span class="menu-header-text">Administration</span>
        </li>
      @endunless

      <li class="menu-item {{ request()->routeIs('administration.users.*') ? 'active' : '' }}">
        <a href="{{ route('administration.users.index') }}" class="menu-link">
          <i class="menu-icon tf-icons bx bx-group"></i>
          <div class="text-truncate">Users</div>
        </a>
      </li>

      <li class="menu-item {{ request()->routeIs('administration.offenses.*') ? 'active' : '' }}">
        <a href="{{ route('administration.offenses.index') }}" class="menu-link">
          <i class="menu-icon tf-icons bx bx-error-circle"></i>
          <div class="text-truncate">Offenses</div>
        </a>
      </li>

      <li class="menu-item {{ request()->routeIs('administration.readmission-conditions.*') ? 'active' : '' }}">
        <a href="{{ route('administration.readmission-conditions.index') }}" class="menu-link">
          <i class="menu-icon tf-icons bx bx-list-check"></i>
          <div class="text-truncate">Readmission Conditions</div>
        </a>
      </li>
    @endif
  </ul>
</aside>
<!-- / Menu -->
