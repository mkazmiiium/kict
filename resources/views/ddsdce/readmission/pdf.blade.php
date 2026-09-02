<!doctype html>
<html>
<head>
  <meta charset="utf-8" />
  <style>
    @page {
      size: A4;
      margin: 1.6cm 2cm;
    }
    body {
      font-family: Arial, sans-serif;
      font-size: 13px;
      color: #000;
    }
    .header-logo {
      width: 100%;
      margin-bottom: 8px;
    }
    .ref-date-table {
      width: 100%;
      margin-bottom: 14px;
    }
    .ref-date-table td {
      vertical-align: top;
    }
    .ref-date-table .date-cell {
      width: 35%;
    }
    .addressee {
      margin-bottom: 10px;
    }
    .addressee div {
      line-height: 1.4;
    }
    .title {
      font-weight: bold;
      font-size: 13px;
      margin: 10px 0 10px;
    }
    p {
      line-height: 1.45;
      margin: 0 0 9px;
      text-align: justify;
    }
    ol {
      margin: 0 0 9px;
      padding-left: 22px;
    }
    ol li {
      line-height: 1.45;
      text-align: justify;
      margin-bottom: 6px;
    }
    p.footnote {
      font-weight: bold;
      font-style: italic;
    }
    .signature {
      margin-top: 6px;
    }
    .signature .signature-image-wrap {
      margin-bottom: -24px;
      margin-left: 120px;
    }
    .signature-image {
      height: 90px;
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
    .cc-table {
      margin-top: 10px;
      font-size: 11.5px;
    }
    .cc-table td {
      padding: 1px 6px 1px 0;
      vertical-align: top;
    }
    .cc-label {
      width: 20px;
    }
    .cc-colon {
      width: 12px;
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

  <table class="ref-date-table">
    <tr>
      <td>Our Reference: {{ $readmissionLetter->reference_no }}</td>
      <td class="date-cell">Date: {{ $formattedDate }}</td>
    </tr>
  </table>

  @php
    $gender = $readmissionLetter->student->gender;
    $salutationTitle = $gender === 'female' ? 'Sister' : 'Brother';
  @endphp

  <div class="addressee">
    <div>{{ strtoupper($readmissionLetter->student->name) }}</div>
    <div>Matriculation no. {{ $readmissionLetter->student->matric_no }}</div>
  </div>

  <p>Assalamualaikum wrt. wbt.</p>
  <p>Dear {{ $salutationTitle }},</p>

  <div class="title">APPEAL FOR READMISSION FOR {{ strtoupper($readmissionLetter->readmissionAcademicSession->label()) }} SESSION</div>

  <p>
    Please be informed that your appeal for readmission (with condition) has been approved in the
    Kulliyyah Executive Meeting No. {{ $readmissionLetter->meeting_number ?: '-' }}@if ($readmissionLetter->meeting_date) dated {{ $readmissionLetter->meeting_date->format('jS F Y') }}@endif.
    You are readmitted with condition in <strong>{{ $readmissionLetter->readmissionAcademicSession->label() }} *on {{ $readmissionLetter->readmissionCondition->name }}</strong>.
    You are required to fulfil the following conditions:
  </p>

  <ol>
    <li>To achieve CGPA of at least 2.00 in the semester that you are being readmitted.</li>
    <li>To report your progress of studies to the Deputy Dean (Student Development &amp; Community Engagement), Kulliyyah of Information and Communication Technology when necessary.</li>
  </ol>

  <p>
    This serves as your final opportunity to successfully complete your programme of studies at this
    University. You are strongly advised to consult your academic advisor regularly for guidance on
    academic matters.
  </p>

  <p class="footnote">*{{ $readmissionLetter->readmissionCondition->footnote_text }}</p>

  <p>Thank you. Wassalam.</p>

  <div class="signature">
    @if ($readmissionLetter->signatory->signature_path && file_exists(public_path($readmissionLetter->signatory->signature_path)))
      <div class="signature-image-wrap">
        <img
          class="signature-image"
          src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path($readmissionLetter->signatory->signature_path))) }}" />
      </div>
    @endif
    <div class="name">{{ $readmissionLetter->signatory->name }}</div>
    <div class="designation">{{ $readmissionLetter->signatory->designation_en }}</div>
    <div class="kulliyyah">{{ $readmissionLetter->student->department->kulliyyah->name_en ?? '' }}</div>
    <div class="kulliyyah">International Islamic University Malaysia (IIUM)</div>
  </div>

  <table class="cc-table">
    <tr>
      <td class="cc-label">cc</td>
      <td class="cc-colon">:</td>
      <td>Dean, Kulliyyah of Information and Communication Technology</td>
    </tr>
    <tr>
      <td></td>
      <td class="cc-colon">:</td>
      <td>Head, {{ $readmissionLetter->student->department->name_en ?? 'Department' }}, KICT</td>
    </tr>
    <tr>
      <td></td>
      <td class="cc-colon">:</td>
      <td>Student Unit, Academic Management and Admission Division</td>
    </tr>
    <tr>
      <td></td>
      <td class="cc-colon">:</td>
      <td>Principal, Mahallah</td>
    </tr>
    <tr>
      <td></td>
      <td class="cc-colon">:</td>
      <td>Parent/Guardian</td>
    </tr>
  </table>
</body>
</html>
