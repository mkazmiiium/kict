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
      font-size: 14px;
      color: #000;
    }
    .header-logo {
      width: 100%;
      margin-bottom: 10px;
    }
    hr {
      border: none;
      border-top: 2px solid #1F3864;
      margin: 10px 0 20px;
    }
    .ref-table {
      margin-bottom: 20px;
    }
    .ref-table td {
      padding: 2px 6px 2px 0;
      vertical-align: top;
    }
    .ref-label {
      width: 110px;
    }
    .colon {
      width: 12px;
    }
    .title {
      text-align: center;
      font-weight: bold;
      font-size: 14px;
      margin: 10px 0 4px;
    }
    .subtitle {
      text-align: center;
      font-weight: bold;
      font-size: 14px;
      margin-bottom: 20px;
    }
    .detail-table {
      margin: 15px 0;
    }
    .detail-table td {
      padding: 2px 6px 2px 0;
      vertical-align: top;
      font-weight: bold;
    }
    .detail-label {
      width: 130px;
    }
    p {
      line-height: 1.7;
      margin: 0 0 14px;
      text-align: justify;
    }
    .signature {
      margin-top: 10px;
    }
    .signature .signature-image-wrap {
      margin-bottom: -28px;
      margin-left: 120px;
    }
    .signature-image {
      height: 110px;
    }
    .signature .name {
      font-weight: bold;
      text-transform: uppercase;
      white-space: nowrap;
    }
    .signature .designation,
    .signature .kulliyyah {
      margin-bottom: 2px;
    }
    .page-footer {
      position: fixed;
      left: 0;
      right: -1.3cm;
      bottom: -1.2cm;
    }
    .page-footer table {
      width: auto;
      margin-left: auto;
    }
    .page-footer td {
      vertical-align: bottom;
    }
    .page-footer .footer-address {
      font-size: 8.5px;
      line-height: 1.35;
      color: #000;
      text-align: right;
      white-space: nowrap;
      padding-right: 6px;
      padding-bottom: 10px;
    }
    .page-footer .footer-badge {
      text-align: right;
    }
    .page-footer .footer-badge img {
      width: 100px;
    }
  </style>
</head>
<body>
  <div class="page-footer">
    <table>
      <tr>
        <td class="footer-address">
          Kulliyyah of Information and Communication Technology (KICT)<br />
          International Islamic University Malaysia (IIUM)<br />
          Jalan Gombak, 53100 Kuala Lumpur.<br />
          Contact No.: 0364215601 / 0364215603
        </td>
        <td class="footer-badge">
          <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('assets/img/mqa.png'))) }}" />
        </td>
      </tr>
    </table>
  </div>

  <img
    class="header-logo"
    src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('assets/img/iium-logo-image.png'))) }}" />

  <table class="ref-table">
    <tr>
      <td class="ref-label">Our Reference</td>
      <td class="colon">:</td>
      <td>{{ $expectedGraduationLetter->reference_no }}</td>
    </tr>
    <tr>
      <td class="ref-label">Date</td>
      <td class="colon">:</td>
      <td>{{ $formattedDate }}</td>
    </tr>
  </table>

  <div class="title">CERTIFICATION LETTER</div>
  <div class="subtitle">TO WHOM IT MAY CONCERN</div>

  <p>Assalamualaikum wrt. wbt.</p>
  <p>Dear Sir/Madam,</p>

  <table class="detail-table">
    <tr>
      <td class="detail-label">NAME</td>
      <td class="colon">:</td>
      <td>{{ strtoupper($expectedGraduationLetter->student->name) }}</td>
    </tr>
        <tr>
      <td class="detail-label">NRIC / PASSPORT</td>
      <td class="colon">:</td>
      <td>{{ collect([$expectedGraduationLetter->student->nric_no, $expectedGraduationLetter->student->passport_no])->filter()->implode(' / ') ?: '-' }}</td>
    </tr>
    <tr>
      <td class="detail-label">MATRIC NO.</td>
      <td class="colon">:</td>
      <td>{{ $expectedGraduationLetter->student->matric_no }}</td>
    </tr>
    <tr>
      <td class="detail-label">PROGRAM</td>
      <td class="colon">:</td>
      <td>{{ strtoupper($expectedGraduationLetter->student->program->name_en ?? '') }}</td>
    </tr>
  </table>

  @foreach (preg_split('/\n\s*\n/', trim($expectedGraduationLetter->body_text)) as $paragraph)
    <p>{{ trim($paragraph) }}</p>
  @endforeach

  <div class="signature">
    @if ($expectedGraduationLetter->signatory->signature_path && file_exists(public_path($expectedGraduationLetter->signatory->signature_path)))
      <div class="signature-image-wrap">
        <img
          class="signature-image"
          src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path($expectedGraduationLetter->signatory->signature_path))) }}" />
      </div>
    @endif
    <div class="name">{{ $expectedGraduationLetter->signatory->name }}</div>
    <div class="designation">{{ $expectedGraduationLetter->signatory->designation_en }}</div>
    <div class="kulliyyah">{{ $expectedGraduationLetter->student->department->kulliyyah->name_en ?? '' }}</div>
    <div class="kulliyyah">International Islamic University Malaysia (IIUM)</div>
  </div>
</body>
</html>
