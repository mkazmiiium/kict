@php
    $ddsdceActive = request()->routeIs('ddsdce.*');
    $canSeeDdai = auth()->user()->hasAnyRole(['Superadmin', 'DDAI Office']);
    $canSeeDdsdce = auth()->user()->hasAnyRole(['Superadmin', 'DDSDCE Office']);
    $canSeeAdministration = auth()->user()->hasAnyRole(['Superadmin', 'DDSDCE Office']);
    $canSeeUsers = auth()->user()->hasRole('Superadmin');
    $canSeeStudentActivity = auth()->user()->hasAnyRole(['Superadmin', 'ICTSS']);
    $isIctssOnly = auth()->user()->isIctssOnly();
    $studentActivityActive = request()->routeIs('student-activity.*');
    $pendingProposalCount = $canSeeDdsdce ? \App\Models\Proposal::where('status', 'under_review')->count() : 0;
    $studentProposalActive = request()->routeIs('ddsdce.student-proposal.*') || request()->routeIs('ddsdce.proposal-letters.*');
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
    @unless ($isIctssOnly)
      <li class="menu-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
        <a href="{{ route('dashboard') }}" class="menu-link">
          <i class="menu-icon tf-icons bx bx-home-smile"></i>
          <div class="text-truncate">Dashboard</div>
        </a>
      </li>
    @endunless

    @if ($canSeeDdai || $canSeeDdsdce || $canSeeStudentActivity)
      <li class="menu-header small text-uppercase">
        <span class="menu-header-text">Offices</span>
      </li>
    @endif

    @if ($canSeeDdai)
      <li class="menu-item {{ request()->routeIs('ddai.*') ? 'active' : '' }}">
        <a href="{{ route('ddai.index') }}" class="menu-link">
          <i class="menu-icon tf-icons bx bx-buildings"></i>
          <div class="text-truncate">DDAI Office</div>
          <div class="badge rounded-pill bg-label-secondary text-uppercase fs-tiny ms-auto">Phase 2</div>
        </a>
      </li>
    @endif

    @if ($canSeeDdsdce)
      <li class="menu-item {{ $ddsdceActive ? 'active open' : '' }}" id="ddsdce-menu-item">
        <a href="javascript:void(0);" class="menu-link menu-toggle" id="ddsdce-menu-toggle" data-hover="true">
          <i class="menu-icon tf-icons bx bx-briefcase-alt-2"></i>
          <div class="text-truncate">DDSDCE Office</div>
        </a>
        <ul class="menu-sub ddsdce-submenu">
          <li class="menu-item {{ request()->routeIs('ddsdce.dashboard') ? 'active' : '' }}">
            <a href="{{ route('ddsdce.dashboard') }}" class="menu-link">
              <i class="menu-icon tf-icons bx bx-grid-alt"></i>
              <div class="text-truncate">Dashboard</div>
            </a>
          </li>
          <li class="menu-item {{ request()->routeIs('ddsdce.attendance.*') ? 'active' : '' }}">
            <a href="{{ route('ddsdce.attendance.index') }}" class="menu-link">
              <i class="menu-icon tf-icons bx bx-calendar-check"></i>
              <div class="text-truncate">Attendance Letter</div>
            </a>
          </li>
          <li class="menu-item {{ request()->routeIs('ddsdce.expected-graduation.*') ? 'active' : '' }}">
            <a href="{{ route('ddsdce.expected-graduation.index') }}" class="menu-link">
              <i class="menu-icon tf-icons bx bx-certification"></i>
              <div class="text-truncate">Expected Graduation Letter</div>
            </a>
          </li>
          <li class="menu-item {{ request()->routeIs('ddsdce.completion.*') ? 'active' : '' }}">
            <a href="{{ route('ddsdce.completion.index') }}" class="menu-link">
              <i class="menu-icon tf-icons bx bx-badge-check"></i>
              <div class="text-truncate">Completion Letter</div>
            </a>
          </li>
          <li class="menu-item {{ request()->routeIs('ddsdce.loa.*') ? 'active' : '' }}">
            <a href="{{ route('ddsdce.loa.index') }}" class="menu-link">
              <i class="menu-icon tf-icons bx bx-calendar-x"></i>
              <div class="text-truncate">LOA</div>
            </a>
          </li>
          <li class="menu-item {{ request()->routeIs('ddsdce.readmission.*') ? 'active' : '' }}">
            <a href="{{ route('ddsdce.readmission.index') }}" class="menu-link">
              <i class="menu-icon tf-icons bx bx-user-check"></i>
              <div class="text-truncate">Readmission</div>
            </a>
          </li>
          <li class="menu-item {{ request()->routeIs('ddsdce.reinstate.*') ? 'active' : '' }}">
            <a href="{{ route('ddsdce.reinstate.index') }}" class="menu-link">
              <i class="menu-icon tf-icons bx bx-reset"></i>
              <div class="text-truncate">Reinstatement</div>
            </a>
          </li>
          <li class="menu-item {{ request()->routeIs('ddsdce.provisional.*') ? 'active' : '' }}">
            <a href="{{ route('ddsdce.provisional.index') }}" class="menu-link">
              <i class="menu-icon tf-icons bx bx-timer"></i>
              <div class="text-truncate">Provisional</div>
            </a>
          </li>
          <li class="menu-item {{ request()->routeIs('ddsdce.counselling.*') ? 'active' : '' }}">
            <a href="{{ route('ddsdce.counselling.index') }}" class="menu-link">
              <i class="menu-icon tf-icons bx bx-conversation"></i>
              <div class="text-truncate">Counselling</div>
            </a>
          </li>
          <li class="menu-item {{ request()->routeIs('ddsdce.dsu.*') ? 'active' : '' }}">
            <a href="{{ route('ddsdce.dsu.index') }}" class="menu-link">
              <i class="menu-icon tf-icons bx bx-accessibility"></i>
              <div class="text-truncate">DSU Students</div>
            </a>
          </li>
          <li class="menu-item {{ request()->routeIs('ddsdce.disciplinary.*') ? 'active' : '' }}">
            <a href="{{ route('ddsdce.disciplinary.index') }}" class="menu-link">
              <i class="menu-icon tf-icons bx bx-error-circle"></i>
              <div class="text-truncate">Disciplinary</div>
            </a>
          </li>
          <li class="menu-item {{ $studentProposalActive ? 'active open' : '' }}" id="student-proposal-menu-item">
            <a href="javascript:void(0);" class="menu-link menu-toggle" id="student-proposal-menu-toggle" data-hover="true">
              <i class="menu-icon tf-icons bx bx-inbox"></i>
              <div class="text-truncate">Student Proposal</div>
              @if ($pendingProposalCount > 0)
                <div class="badge rounded-pill bg-danger ms-auto">{{ $pendingProposalCount }}</div>
              @endif
            </a>
            <ul class="menu-sub ddsdce-submenu">
              <li class="menu-item {{ request()->routeIs('ddsdce.student-proposal.*') ? 'active' : '' }}">
                <a href="{{ route('ddsdce.student-proposal.index') }}" class="menu-link">
                  <i class="menu-icon tf-icons bx bx-list-ul"></i>
                  <div class="text-truncate">Inbox</div>
                </a>
              </li>
              <li class="menu-item {{ request()->routeIs('ddsdce.proposal-letters.sponsorship.*') ? 'active' : '' }}">
                <a href="{{ route('ddsdce.proposal-letters.sponsorship.index') }}" class="menu-link">
                  <i class="menu-icon tf-icons bx bx-envelope"></i>
                  <div class="text-truncate">Sponsorship Letter</div>
                </a>
              </li>
              <li class="menu-item {{ request()->routeIs('ddsdce.proposal-letters.invitation.*') ? 'active' : '' }}">
                <a href="{{ route('ddsdce.proposal-letters.invitation.index') }}" class="menu-link">
                  <i class="menu-icon tf-icons bx bx-envelope"></i>
                  <div class="text-truncate">Invitation Letter</div>
                </a>
              </li>
              <li class="menu-item {{ request()->routeIs('ddsdce.proposal-letters.appointment.*') ? 'active' : '' }}">
                <a href="{{ route('ddsdce.proposal-letters.appointment.index') }}" class="menu-link">
                  <i class="menu-icon tf-icons bx bx-envelope"></i>
                  <div class="text-truncate">Appointment Letter</div>
                </a>
              </li>
              <li class="menu-item {{ request()->routeIs('ddsdce.proposal-letters.approval.*') ? 'active' : '' }}">
                <a href="{{ route('ddsdce.proposal-letters.approval.index') }}" class="menu-link">
                  <i class="menu-icon tf-icons bx bx-envelope"></i>
                  <div class="text-truncate">Approval Letter</div>
                </a>
              </li>
            </ul>
          </li>
        </ul>
      </li>
    @endif

    @if ($canSeeStudentActivity)
      <li class="menu-item {{ $studentActivityActive ? 'active open' : '' }}" id="student-activity-menu-item">
        <a href="javascript:void(0);" class="menu-link menu-toggle" id="student-activity-menu-toggle" data-hover="true">
          <i class="menu-icon tf-icons bx bx-group"></i>
          <div class="text-truncate">Student Activity</div>
        </a>
        <ul class="menu-sub ddsdce-submenu">
          <li class="menu-item {{ request()->routeIs('student-activity.proposal.*') ? 'active' : '' }}">
            <a href="{{ route('student-activity.proposal.index') }}" class="menu-link">
              <i class="menu-icon tf-icons bx bx-file"></i>
              <div class="text-truncate">Proposal</div>
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

<style>
  .ddsdce-submenu .menu-link {
    display: flex;
    align-items: center;
    gap: 0.65rem;
    border-radius: 0.5rem;
    position: relative;
    transition: background-color 0.2s ease, color 0.2s ease, padding-inline-start 0.2s ease;
  }
  .ddsdce-submenu .menu-link .menu-icon {
    font-size: 1rem;
    line-height: 1;
    opacity: 0.7;
    transition: opacity 0.2s ease, color 0.2s ease;
  }
  .ddsdce-submenu .menu-item:not(.active) > .menu-link:hover {
    background-color: rgba(var(--bs-primary-rgb), 0.08);
    padding-inline-start: calc(2.9375rem + 0.35rem);
  }
  .ddsdce-submenu .menu-item:not(.active) > .menu-link:hover .menu-icon {
    opacity: 1;
    color: var(--bs-primary);
  }
  .ddsdce-submenu > .menu-item.active > .menu-link {
    background-color: rgba(var(--bs-primary-rgb), 0.12) !important;
    color: var(--bs-primary) !important;
    font-weight: 600;
  }
  .ddsdce-submenu > .menu-item.active > .menu-link .menu-icon {
    opacity: 1;
    color: var(--bs-primary);
  }
  .ddsdce-submenu > .menu-item.active > .menu-link::after {
    content: '';
    position: absolute;
    inset-inline-end: 0;
    top: 20%;
    bottom: 20%;
    width: 3px;
    border-radius: 4px 0 0 4px;
    background-color: var(--bs-primary);
  }
</style>

<script>
  document.addEventListener('DOMContentLoaded', function () {
    function initSubmenuToggle(toggleId, itemId, storageKey) {
      var toggle = document.getElementById(toggleId);
      var item = document.getElementById(itemId);
      if (!toggle || !item) return;

      // Respect a previously chosen "collapsed" state even on pages where the
      // section would otherwise auto-expand because it's the active section.
      try {
        if (localStorage.getItem(storageKey) === '1') {
          item.classList.remove('open');
        }
      } catch (e) {
        // Storage unavailable (e.g. Safari private browsing) — fall back to
        // the server-rendered default and skip persistence below.
      }

      toggle.addEventListener('click', function (e) {
        e.preventDefault();
        var isOpen = item.classList.toggle('open');
        try {
          localStorage.setItem(storageKey, isOpen ? '0' : '1');
        } catch (e) {
          // Ignore — collapsed state just won't persist across page loads.
        }
      });
    }

    initSubmenuToggle('ddsdce-menu-toggle', 'ddsdce-menu-item', 'kict-ddsdce-submenu-collapsed');
    initSubmenuToggle('student-activity-menu-toggle', 'student-activity-menu-item', 'kict-student-activity-submenu-collapsed');
    initSubmenuToggle('student-proposal-menu-toggle', 'student-proposal-menu-item', 'kict-student-proposal-submenu-collapsed');
  });
</script>
