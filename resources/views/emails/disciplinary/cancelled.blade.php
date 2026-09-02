<!doctype html>
<html>
<head>
  <meta charset="utf-8" />
</head>
<body style="font-family: Arial, sans-serif; font-size: 14px; color: #000;">
  <p>Dear {{ $disciplinaryRecord->student->name }},</p>

  <p>
    We are pleased to inform you that the disciplinary record raised against you regarding the
    following matter has been reviewed and closed:
  </p>

  <p>
    <strong>Offense:</strong> {{ $disciplinaryRecord->offense->name ?? 'Not specified' }}<br />
    <strong>Location:</strong> {{ $disciplinaryRecord->location }}<br />
    <strong>Date Recorded:</strong> {{ $disciplinaryRecord->created_at->format('d M Y') }}
  </p>

  <p>
    No further action is required on your part. Thank you for your cooperation in resolving
    this matter.
  </p>

  <p>Thank you.</p>

  <p>
    DDSDCE Office<br />
    Kulliyyah of Information and Communication Technology (KICT)<br />
    International Islamic University Malaysia (IIUM)
  </p>
</body>
</html>
