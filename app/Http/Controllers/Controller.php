<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Str;

abstract class Controller
{
    /**
     * Resolve a validated "per page" value from the request, restricted to
     * the options offered by the per-page selector on index views.
     */
    protected function perPage(Request $request, int $default = 10): int
    {
        $perPage = (int) $request->get('per_page', $default);

        return in_array($perPage, [10, 20, 50, 100], true) ? $perPage : $default;
    }

    /**
     * Render a filtered/sorted list (matching the current index view) as a
     * downloadable PDF, using the shared tabular export template.
     *
     * @param  array<int, string>  $columns
     * @param  array<int, array<int, string>>  $rows
     */
    protected function exportListPdf(string $title, array $columns, array $rows, string $filters = ''): Response
    {
        $pdf = Pdf::loadView('pdf.list-export', [
            'title' => $title,
            'columns' => $columns,
            'rows' => $rows,
            'filters' => $filters,
        ]);

        $filename = Str::slug($title).'-'.now()->format('Y-m-d-His').'.pdf';

        return $pdf->download($filename);
    }
}
