<?php

namespace App\Services;

use App\Models\LetterType;
use Illuminate\Support\Facades\DB;

class LetterNumberingService
{
    /**
     * @return array{reference_no: string, letter_type_id: int}
     */
    public function generate(string $code): array
    {
        return DB::transaction(function () use ($code) {
            $letterType = LetterType::where('code', $code)
                ->where('year', (string) now()->year)
                ->lockForUpdate()
                ->firstOrFail();

            $letterType->current_running_number++;
            $letterType->save();

            $referenceNo = str_replace(
                '{running}',
                (string) $letterType->current_running_number,
                $letterType->reference_no_pattern
            );

            return [
                'reference_no' => $referenceNo,
                'letter_type_id' => $letterType->id,
            ];
        });
    }
}
