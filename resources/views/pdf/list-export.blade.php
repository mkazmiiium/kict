<!doctype html>
<html>
<head>
  <meta charset="utf-8" />
  <style>
    @page {
      size: A4 landscape;
      margin: 1.5cm;
    }
    body {
      font-family: Arial, sans-serif;
      font-size: 11px;
      color: #000;
    }
    .header {
      display: table;
      width: 100%;
      margin-bottom: 10px;
    }
    .header-logo {
      display: table-cell;
      width: 55px;
      vertical-align: middle;
    }
    .header-logo img {
      width: 45px;
    }
    .header-text {
      display: table-cell;
      vertical-align: middle;
      padding-left: 10px;
    }
    .header-text .kulliyyah {
      font-size: 10px;
      color: #444;
    }
    h1 {
      font-size: 16px;
      margin: 0 0 4px;
    }
    .meta {
      font-size: 10px;
      color: #444;
      margin-bottom: 14px;
    }
    .meta strong {
      color: #000;
    }
    hr {
      border: none;
      border-top: 1.5px solid #1F3864;
      margin: 8px 0 14px;
    }
    table.data {
      width: 100%;
      border-collapse: collapse;
    }
    table.data th {
      background-color: #1F3864;
      color: #fff;
      text-align: left;
      padding: 5px 6px;
      font-size: 10.5px;
    }
    table.data td {
      border-bottom: 1px solid #ddd;
      padding: 5px 6px;
      font-size: 10.5px;
      vertical-align: top;
    }
    table.data tr:nth-child(even) td {
      background-color: #f7f7f9;
    }
    .empty {
      padding: 20px 0;
      text-align: center;
      color: #666;
    }
    .footer-note {
      margin-top: 12px;
      font-size: 9px;
      color: #666;
    }
  </style>
</head>
<body>
  <div class="header">
    <div class="header-logo">
      <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('assets/img/kict-logo.png'))) }}" />
    </div>
    <div class="header-text">
      <h1>{{ $title }}</h1>
      <div class="kulliyyah">Kulliyyah of Information and Communication Technology (KICT), IIUM</div>
    </div>
  </div>

  <hr />

  <div class="meta">
    <strong>Generated:</strong> {{ now()->format('d M Y, g:i A') }} by {{ auth()->user()->name }}
    &nbsp;|&nbsp; <strong>Total Records:</strong> {{ count($rows) }}
    @if (! empty($filters))
      <br /><strong>Filters Applied:</strong> {{ $filters }}
    @endif
  </div>

  @if (empty($rows))
    <div class="empty">No records match the current filters.</div>
  @else
    <table class="data">
      <thead>
        <tr>
          @foreach ($columns as $column)
            <th>{{ $column }}</th>
          @endforeach
        </tr>
      </thead>
      <tbody>
        @foreach ($rows as $row)
          <tr>
            @foreach ($row as $cell)
              <td>{{ $cell }}</td>
            @endforeach
          </tr>
        @endforeach
      </tbody>
    </table>
  @endif

  <div class="footer-note">KICT Information System — exported list, reflects filters and sorting active at the time of export.</div>
</body>
</html>
