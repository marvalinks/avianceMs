<?php

namespace App\Exports;

use App\Models\AcceptancePool;
use Maatwebsite\Excel\Concerns\FromCollection;

class AirbillExport implements FromCollection
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return AcceptancePool::all();
    }
}
