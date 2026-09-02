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
    .addressee {
      margin-bottom: 15px;
    }
    .addressee div {
      line-height: 1.5;
    }
    .title {
      text-align: center;
      font-weight: bold;
      font-size: 14px;
      margin: 15px 0 20px;
    }
    p {
      line-height: 1.7;
      margin: 0 0 14px;
      text-align: justify;
    }
    p.remarks {
      font-weight: bold;
      font-style: italic;
    }
    .check-table {
      margin: 0 0 16px 20px;
      border-collapse: collapse;
    }
    .check-table td {
      padding: 2px 0;
      vertical-align: middle;
    }
    .check-box {
      width: 30px;
      height: 20px;
      border: 1px solid #000;
      text-align: center;
      font-weight: bold;
    }
    .check-table td.check-label {
      padding-left: 14px;
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
      <td>{{ $loaLetter->reference_no }}</td>
    </tr>
    <tr>
      <td class="ref-label">Date</td>
      <td class="colon">:</td>
      <td>{{ $formattedDate }}</td>
    </tr>
  </table>

  @php
    $gender = $loaLetter->student->gender;
    $salutationTitle = $gender === 'female' ? 'Sr.' : 'Br.';
  @endphp

  <div class="addressee">
    <div>{{ $salutationTitle }} {{ $loaLetter->student->name }} / {{ $loaLetter->student->matric_no }}</div>
    <div>{{ $loaLetter->student->program->name_en ?? '' }}</div>
    <div>{{ $loaLetter->student->department->kulliyyah->name_en ?? '' }}</div>
  </div>

  <p>Assalamualaikum wrt. wbt.</p>
  <p>Dear {{ $salutationTitle }},</p>

  <div class="title">APPEAL FOR LEAVE OF ABSENCE FOR {{ strtoupper($loaLetter->leaveAcademicSession->label()) }}</div>

  <p>
    This is to inform you that the Kulliyyah Executive Management Meeting No.
    {{ $loaLetter->meeting_number ?: '-' }}@if ($loaLetter->meeting_date), dated {{ $loaLetter->meeting_date->format('jS F Y') }}@endif,
    has approved your application for Leave of Absence as follows: -
  </p>

  <table class="check-table">
    <tr>
      <td class="check-box">{{ $loaLetter->status === 'approved' ? '/' : '' }}</td>
      <td class="check-label">Approved</td>
    </tr>
    <tr>
      <td class="check-box">{{ $loaLetter->status === 'rejected' ? '/' : '' }}</td>
      <td class="check-label">Rejected</td>
    </tr>
  </table>

  @if ($loaLetter->remarks)
    <p class="remarks">Remarks: {{ $loaLetter->remarks }}</p>
  @endif

  <p>Reason for Study Leave:</p>

  <table class="check-table">
    <tr>
      <td class="check-box">{{ $loaLetter->reason_type === 'medical' ? '/' : '' }}</td>
      <td class="check-label">Medical</td>
    </tr>
    <tr>
      <td class="check-box">{{ $loaLetter->reason_type === 'maternity' ? '/' : '' }}</td>
      <td class="check-label">Maternity</td>
    </tr>
    <tr>
      <td class="check-box">{{ $loaLetter->reason_type === 'other' ? '/' : '' }}</td>
      <td class="check-label">Other reason{{ $loaLetter->reason_type === 'other' && $loaLetter->other_reason_note ? ' – '.$loaLetter->other_reason_note : '' }}</td>
    </tr>
  </table>

  <p>Thank you. Wassalam.</p>

  <div class="signature">
    @if ($loaLetter->signatory->signature_path && file_exists(public_path($loaLetter->signatory->signature_path)))
      <div class="signature-image-wrap">
        <img
          class="signature-image"
          src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path($loaLetter->signatory->signature_path))) }}" />
      </div>
    @endif
    <div class="name">{{ $loaLetter->signatory->name }}</div>
    <div class="designation">{{ $loaLetter->signatory->designation_en }}</div>
    <div class="kulliyyah">{{ $loaLetter->student->department->kulliyyah->name_en ?? '' }}</div>
    <div class="kulliyyah">International Islamic University Malaysia (IIUM)</div>
  </div>
</body>
</html>
