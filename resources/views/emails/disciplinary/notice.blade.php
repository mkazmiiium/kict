<!doctype html>
<html>
<head>
  <meta charset="utf-8" />
</head>
<body style="font-family: Arial, sans-serif; font-size: 14px; color: #000;">
  <p>Dear {{ $disciplinaryRecord->student->name }},</p>

  <p>
    This is to inform you that a disciplinary record has been raised against you by the
    Kulliyyah of Information and Communication Technology (KICT), Deputy Dean (Student
    Development and Community Engagement) Office (DDSDCE), for the following matter:
  </p>

  <p>
    <strong>Offense:</strong> {{ $disciplinaryRecord->offense->name ?? 'Not specified' }}<br />
    <strong>Location:</strong> {{ $disciplinaryRecord->location }}<br />
    <strong>Date Recorded:</strong> {{ $disciplinaryRecord->created_at->format('d M Y') }}
  </p>

  <p>
    You are required to visit the DDSDCE Office within <strong>14 days</strong> from the date of
    this email (by <strong>{{ $disciplinaryRecord->due_date->format('d M Y') }}</strong>) to
    address this matter. Failure to do so may result in your case being referred to the Office
    of Security Management (OSEM) for further action.
  </p>

  <p>Thank you.</p>

  <p>
    DDSDCE Office<br />
    Kulliyyah of Information and Communication Technology (KICT)<br />
    International Islamic University Malaysia (IIUM)
  </p>
</body>
</html>
