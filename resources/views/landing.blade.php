<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>KICT Office Management System</title>
  <meta name="description" content="Kulliyyah of Information and Communication Technology (KICT), IIUM — Deputy Dean (Student Development & Community Engagement) Office Management System." />

  <link rel="icon" type="image/x-icon" href="{{ asset('assets') }}/img/favicon/favicon.ico" />

  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link
    href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,400&display=swap"
    rel="stylesheet" />
  <link rel="stylesheet" href="{{ asset('assets') }}/vendor/fonts/iconify-icons.css" />
  <link rel="stylesheet" href="{{ asset('assets') }}/vendor/css/core.css" />

  <style>
    :root {
      --iium-teal: #0e7c78;
      --iium-teal-dark: #0a5e5b;
      --iium-gold: #d5a129;
      --iium-navy: #17284a;
    }

    * { box-sizing: border-box; }

    html, body { overflow-x: hidden; max-width: 100%; }

    body {
      font-family: "Public Sans", sans-serif;
      color: #2b2f38;
      margin: 0;
      background: #fff;
    }

    a { text-decoration: none; }

    .container-nav {
      max-width: 1200px;
      margin: 0 auto;
      padding: 0 24px;
    }

    /* Navbar */
    .site-navbar {
      position: sticky;
      top: 0;
      z-index: 50;
      background: #fff;
      border-bottom: 1px solid #eef0f2;
    }
    .site-navbar .inner {
      display: flex;
      align-items: center;
      justify-content: space-between;
      gap: 16px;
      padding: 14px 0;
    }
    .brand {
      display: flex;
      align-items: center;
      gap: 12px;
      min-width: 0;
      flex: 1 1 auto;
    }
    .brand img { height: 42px; width: auto; flex-shrink: 0; }
    .brand .name {
      font-weight: 700;
      font-size: 1.05rem;
      color: var(--iium-navy);
      line-height: 1.2;
      min-width: 0;
    }
    .brand .name small {
      display: block;
      font-weight: 400;
      font-size: 0.72rem;
      color: #6b7280;
    }
    .btn-login { flex-shrink: 0; }
    .btn-login {
      background: var(--iium-teal);
      color: #fff;
      padding: 10px 26px;
      border-radius: 8px;
      font-weight: 600;
      font-size: 0.9rem;
      transition: background .15s ease, transform .15s ease;
      display: inline-flex;
      align-items: center;
      gap: 8px;
    }
    .btn-login:hover { background: var(--iium-teal-dark); color: #fff; transform: translateY(-1px); }

    /* Hero */
    .hero {
      background:
        radial-gradient(circle at 15% 20%, rgba(213,161,41,0.18), transparent 42%),
        linear-gradient(135deg, var(--iium-navy) 0%, #16403f 55%, var(--iium-teal) 100%);
      color: #fff;
      padding: 76px 0 90px;
      position: relative;
      overflow: hidden;
    }
    .hero::after {
      content: '';
      position: absolute;
      right: -120px;
      top: -120px;
      width: 420px;
      height: 420px;
      border-radius: 50%;
      background: rgba(255,255,255,0.05);
    }
    .hero-inner {
      max-width: 1200px;
      margin: 0 auto;
      padding: 0 24px;
      display: grid;
      grid-template-columns: 1.15fr 0.85fr;
      gap: 48px;
      align-items: center;
      position: relative;
      z-index: 1;
    }
    .eyebrow {
      display: inline-flex;
      align-items: center;
      gap: 8px;
      background: rgba(255,255,255,0.12);
      border: 1px solid rgba(255,255,255,0.25);
      color: #fce9b8;
      padding: 6px 14px;
      border-radius: 999px;
      font-size: 0.78rem;
      font-weight: 600;
      letter-spacing: .03em;
      text-transform: uppercase;
      margin-bottom: 22px;
    }
    .hero h1 {
      font-size: 2.6rem;
      font-weight: 800;
      line-height: 1.2;
      margin: 0 0 18px;
      color: #fff;
    }
    .hero h1 span { color: var(--iium-gold); }
    .hero p.lead {
      font-size: 1.05rem;
      color: rgba(255,255,255,0.85);
      line-height: 1.7;
      margin: 0 0 32px;
      max-width: 540px;
    }
    .hero-cta { display: flex; align-items: center; gap: 18px; flex-wrap: wrap; }
    .btn-hero-login {
      background: var(--iium-gold);
      color: #17284a;
      padding: 14px 32px;
      border-radius: 8px;
      font-weight: 700;
      font-size: 1rem;
      display: inline-flex;
      align-items: center;
      gap: 10px;
      transition: transform .15s ease, box-shadow .15s ease;
      box-shadow: 0 10px 24px -8px rgba(213,161,41,0.55);
    }
    .btn-hero-login:hover { transform: translateY(-2px); color: #17284a; box-shadow: 0 14px 28px -8px rgba(213,161,41,0.65); }
    .hero-note { color: rgba(255,255,255,0.65); font-size: 0.85rem; }

    .hero-card {
      background: rgba(255,255,255,0.06);
      border: 1px solid rgba(255,255,255,0.18);
      border-radius: 16px;
      padding: 30px;
      backdrop-filter: blur(6px);
    }
    .hero-card .kict-logo-wrap {
      background: #fff;
      border-radius: 12px;
      padding: 22px;
      display: flex;
      align-items: center;
      justify-content: center;
      margin-bottom: 20px;
    }
    .hero-card .kict-logo-wrap img { width: 100%; max-width: 220px; height: auto; }
    .hero-card ul { list-style: none; margin: 0; padding: 0; }
    .hero-card li {
      display: flex;
      align-items: flex-start;
      gap: 10px;
      color: rgba(255,255,255,0.9);
      font-size: 0.9rem;
      padding: 9px 0;
      border-top: 1px solid rgba(255,255,255,0.12);
    }
    .hero-card li:first-child { border-top: none; }
    .hero-card li i { color: var(--iium-gold); font-size: 1.15rem; margin-top: 1px; }

    /* Sections */
    .section { padding: 72px 0; }
    .section-alt { background: #f8f9fb; }
    .section-head { text-align: center; max-width: 640px; margin: 0 auto 46px; }
    .section-head .tag {
      color: var(--iium-teal);
      font-weight: 700;
      font-size: 0.78rem;
      letter-spacing: .06em;
      text-transform: uppercase;
      margin-bottom: 10px;
      display: block;
    }
    .section-head h2 { font-size: 1.9rem; font-weight: 800; color: var(--iium-navy); margin: 0 0 12px; }
    .section-head p { color: #667085; font-size: 1rem; line-height: 1.6; margin: 0; }

    .modules-grid {
      max-width: 1200px;
      margin: 0 auto;
      padding: 0 24px;
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      gap: 22px;
    }
    .module-card {
      background: #fff;
      border: 1px solid #eef0f2;
      border-radius: 14px;
      padding: 28px 26px;
      transition: transform .15s ease, box-shadow .15s ease, border-color .15s ease;
    }
    .module-card:hover {
      transform: translateY(-4px);
      box-shadow: 0 18px 32px -18px rgba(23,40,74,0.25);
      border-color: transparent;
    }
    .module-icon {
      width: 52px;
      height: 52px;
      border-radius: 12px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 1.5rem;
      color: #fff;
      margin-bottom: 18px;
    }
    .module-card h3 { font-size: 1.08rem; font-weight: 700; color: var(--iium-navy); margin: 0 0 8px; }
    .module-card p { font-size: 0.9rem; color: #667085; line-height: 1.6; margin: 0; }

    .about-wrap {
      max-width: 1200px;
      margin: 0 auto;
      padding: 0 24px;
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 48px;
      align-items: center;
    }
    .about-wrap img { max-width: 100%; height: auto; }
    .stat-row { display: flex; gap: 34px; margin-top: 28px; flex-wrap: wrap; }
    .stat-row .stat h4 { font-size: 1.6rem; font-weight: 800; color: var(--iium-teal); margin: 0; }
    .stat-row .stat span { font-size: 0.82rem; color: #667085; }

    /* Footer */
    footer.site-footer {
      background: var(--iium-navy);
      color: rgba(255,255,255,0.75);
      padding: 48px 0 24px;
    }
    .footer-inner {
      max-width: 1200px;
      margin: 0 auto;
      padding: 0 24px;
      display: grid;
      grid-template-columns: 1.3fr 1fr 1fr;
      gap: 36px;
    }
    .footer-inner h5 { color: #fff; font-size: 0.95rem; font-weight: 700; margin: 0 0 14px; }
    .footer-inner p, .footer-inner li { font-size: 0.87rem; line-height: 1.8; color: rgba(255,255,255,0.65); }
    .footer-inner ul { list-style: none; padding: 0; margin: 0; }
    .footer-brand { display: flex; align-items: center; gap: 10px; margin-bottom: 14px; }
    .footer-brand img { height: 34px; }
    .footer-brand span { font-weight: 700; color: #fff; font-size: 1rem; }
    .footer-bottom {
      max-width: 1200px;
      margin: 32px auto 0;
      padding: 18px 24px 0;
      border-top: 1px solid rgba(255,255,255,0.12);
      font-size: 0.8rem;
      color: rgba(255,255,255,0.5);
      text-align: center;
    }

    @media (max-width: 900px) {
      .hero-inner, .about-wrap { grid-template-columns: 1fr; }
      .modules-grid { grid-template-columns: repeat(2, 1fr); }
      .footer-inner { grid-template-columns: 1fr; }
      .hero h1 { font-size: 2rem; }
    }
    @media (max-width: 560px) {
      .modules-grid { grid-template-columns: 1fr; }
    }
    @media (max-width: 480px) {
      .brand .name small { display: none; }
      .hero h1 { font-size: 1.65rem; }
      .hero { padding: 56px 0 64px; }
    }
  </style>
</head>
<body>

  <nav class="site-navbar">
    <div class="container-nav inner">
      <div class="brand">
        <img src="{{ asset('assets/img/kict-logo.png') }}" alt="KICT" />
        <div class="name">
          KICT Office Management System
          <small>Deputy Dean (Student Development &amp; Community Engagement)</small>
        </div>
      </div>
      <a href="{{ route('login') }}" class="btn-login">
        <i class="icon-base bx bx-log-in"></i> Login
      </a>
    </div>
  </nav>

  <section class="hero">
    <div class="hero-inner">
      <div>
        <span class="eyebrow"><i class="icon-base bx bxs-graduation" style="font-size:1rem;"></i> Kulliyyah of ICT &middot; IIUM</span>
        <h1>Streamlining Student Affairs for the <span>DDSDCE Office</span></h1>
        <p class="lead">
          A single system for managing attendance letters, expected graduation letters, leave of
          absence, readmission, disciplinary records and the DSU student registry — built for the
          Kulliyyah of Information and Communication Technology.
        </p>
        <div class="hero-cta">
          <a href="{{ route('login') }}" class="btn-hero-login">
            <i class="icon-base bx bx-log-in-circle"></i> Login to System
          </a>
          <span class="hero-note">Authorized DDSDCE Office staff only</span>
        </div>
      </div>
      <div class="hero-card">
        <div class="kict-logo-wrap">
          <img src="{{ asset('assets/img/kict-logo.png') }}" alt="KICT Logo" />
        </div>
        <ul>
          <li><i class="icon-base bx bx-check-shield"></i> Auto-generated, print-protected official letters</li>
          <li><i class="icon-base bx bx-check-shield"></i> Centralized student &amp; case records</li>
          <li><i class="icon-base bx bx-check-shield"></i> Role-based access for office staff</li>
        </ul>
      </div>
    </div>
  </section>

  <section class="section">
    <div class="section-head">
      <span class="tag">What This System Manages</span>
      <h2>Every DDSDCE Process, One Platform</h2>
      <p>From letter generation to case management, each module keeps records consistent, searchable, and properly documented.</p>
    </div>
    <div class="modules-grid">
      <div class="module-card">
        <div class="module-icon" style="background:#3fb87e;"><i class="icon-base bx bx-calendar-check"></i></div>
        <h3>Attendance Letters</h3>
        <p>Generate and manage official attendance confirmation letters for students, complete with semester records.</p>
      </div>
      <div class="module-card">
        <div class="module-icon" style="background:#4c8cff;"><i class="icon-base bx bx-certification"></i></div>
        <h3>Expected Graduation</h3>
        <p>Issue expected graduation letters with CGPA and Industrial Attachment statements where required.</p>
      </div>
      <div class="module-card">
        <div class="module-icon" style="background:#e5484d;"><i class="icon-base bx bx-calendar-x"></i></div>
        <h3>Leave of Absence</h3>
        <p>Track LOA applications, approval status, and the reason for study leave in one structured record.</p>
      </div>
      <div class="module-card">
        <div class="module-icon" style="background:#0e7c78;"><i class="icon-base bx bx-user-check"></i></div>
        <h3>Readmission</h3>
        <p>Process readmission appeals under Clean Slate or Good Academic Standing conditions.</p>
      </div>
      <div class="module-card">
        <div class="module-icon" style="background:#f5a524;"><i class="icon-base bx bx-error-circle"></i></div>
        <h3>Disciplinary Records</h3>
        <p>Log and follow up on student conduct cases, with automated notices and escalation tracking.</p>
      </div>
      <div class="module-card">
        <div class="module-icon" style="background:#8b5cf6;"><i class="icon-base bx bx-accessibility"></i></div>
        <h3>DSU Student Registry</h3>
        <p>Maintain records for students under the Disabled Student Unit, including support needs and semester progress.</p>
      </div>
    </div>
  </section>

  <section class="section section-alt">
    <div class="about-wrap">
      <div>
        <span class="tag" style="color:var(--iium-teal); font-weight:700; font-size:0.78rem; letter-spacing:.06em; text-transform:uppercase; display:block; margin-bottom:10px;">About the Office</span>
        <h2 style="font-size:1.7rem; font-weight:800; color:var(--iium-navy); margin:0 0 14px;">Deputy Dean, Student Development &amp; Community Engagement</h2>
        <p style="color:#667085; line-height:1.75; font-size:0.97rem; margin:0;">
          The DDSDCE Office at the Kulliyyah of Information and Communication Technology (KICT)
          oversees student welfare, academic administration correspondence, and community
          engagement matters for KICT students throughout their studies at IIUM.
        </p>
        <div class="stat-row">
          <div class="stat">
            <h4>6</h4>
            <span>Active Modules</span>
          </div>
          <div class="stat">
            <h4>100%</h4>
            <span>Digital Records</span>
          </div>
          <div class="stat">
            <h4>24/7</h4>
            <span>Staff Access</span>
          </div>
        </div>
      </div>
      <div>
        <img src="{{ asset('assets/img/illustrations/man-with-laptop.png') }}" alt="" style="max-width:260px; margin:0 auto; display:block;" />
      </div>
    </div>
  </section>

  <footer class="site-footer">
    <div class="footer-inner">
      <div>
        <div class="footer-brand">
          <img src="{{ asset('assets/img/kict-logo.png') }}" alt="KICT" />
          <span>KICT Office System</span>
        </div>
        <p>
          Kulliyyah of Information and Communication Technology (KICT)<br />
          International Islamic University Malaysia (IIUM)<br />
          Jalan Gombak, 53100 Kuala Lumpur.
        </p>
      </div>
      <div>
        <h5>Contact</h5>
        <ul>
          <li>Phone: 03-6421 5601 / 03-6421 5603</li>
          <li>Email: kict_ddsdce@iium.edu.my</li>
        </ul>
      </div>
      <div>
        <h5>System</h5>
        <ul>
          <li><a href="{{ route('login') }}" style="color:rgba(255,255,255,0.65);">Staff Login</a></li>
          <li>Authorized DDSDCE personnel only</li>
        </ul>
      </div>
    </div>
    <div class="footer-bottom">
      &copy; {{ now()->year }} Kulliyyah of Information and Communication Technology, IIUM. All rights reserved.
    </div>
  </footer>

</body>
</html>
