<?php

namespace App\Http\Controllers\DDSDCE;

use App\Http\Controllers\Controller;
use App\Models\ProposalLetter;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

/**
 * One controller backs all 4 letter-type menus (Sponsorship, Invitation,
 * Appointment, Approval) — the type is injected via a route default
 * (see routes/web.php) rather than 4 near-identical controllers.
 */
class ProposalLetterController extends Controller
{
    public function index(Request $request, string $type)
    {
        $search = $request->get('search');

        $letters = ProposalLetter::query()
            ->where('type', $type)
            ->with('proposal')
            ->when($search, function ($query) use ($search) {
                $query->where(function ($inner) use ($search) {
                    $inner->where('reference_no', 'like', "%{$search}%")
                        ->orWhereHas('proposal', fn ($p) => $p->where('name', 'like', "%{$search}%"));
                });
            })
            ->orderByDesc('id')
            ->paginate($this->perPage($request))
            ->withQueryString();

        return view('ddsdce.proposal-letters.index', [
            'letters' => $letters,
            'type' => $type,
            'label' => ProposalLetter::TYPES[$type]['label'],
            'search' => $search,
            'perPage' => $this->perPage($request),
        ]);
    }

    public function viewPdf(ProposalLetter $proposalLetter, string $type)
    {
        abort_unless($proposalLetter->type === $type, 404);

        return $this->buildPdf($proposalLetter)->stream($this->pdfFilename($proposalLetter));
    }

    public function print(ProposalLetter $proposalLetter, string $type)
    {
        abort_unless($proposalLetter->type === $type, 404);

        return $this->buildPdf($proposalLetter)->download($this->pdfFilename($proposalLetter));
    }

    private function buildPdf(ProposalLetter $proposalLetter)
    {
        $proposalLetter->load(['proposal', 'signatory']);

        $pdf = Pdf::loadView('ddsdce.proposal-letters.pdf', [
            'letter' => $proposalLetter,
            'label' => ProposalLetter::TYPES[$proposalLetter->type]['label'],
        ]);

        $pdf->setEncryption('', config('pdf.password'), ['print' => true]);

        return $pdf;
    }

    private function pdfFilename(ProposalLetter $proposalLetter): string
    {
        $reference = str_replace('/', '-', $proposalLetter->reference_no);

        return $reference.'-'.Str::slug($proposalLetter->proposal->name).'.pdf';
    }
}
