<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithStyles;

class BahanRapatExport implements FromCollection, WithHeadings, ShouldAutoSize, WithStyles
{
    protected $id;

    function __construct($id)
    {
        $this->id = $id;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return DB::table('meeting_materials')
        ->join('old_standards','meeting_materials.nmr_sni_lama','=','old_standards.nmr_sni_lama')
        ->join('revision_decrees','old_standards.id_sk_revisi','revision_decrees.id')
        ->join('identifications','revision_decrees.id','=','identifications.id_sk_revisi')
        ->join('standard_implementers','identifications.id','=','standard_implementers.id_identifikasi')
        ->selectRaw('revision_decrees.nmr_sni_baru')
        ->selectRaw('meeting_materials.nmr_sni_lama')
        ->selectRaw('identifications.komtek')
        ->selectRaw("REPLACE(identifications.sekretariat_komtek, '<br />','')")
        ->selectRaw('standard_implementers.penerap')
        ->where('meeting_materials.id_meeting_schedule','=',$this->id)
        ->get();
    }

    public function headings(): array
    {
        return[
            'Nomor SNI Baru',
            'Nomor SNI Lama',
            'Komite Teknis',
            'Sekretariat Komtek',
            'Penerap',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $toRow = DB::table('meeting_materials')
        ->join('old_standards','meeting_materials.nmr_sni_lama','=','old_standards.nmr_sni_lama')
        ->join('revision_decrees','old_standards.id_sk_revisi','revision_decrees.id')
        ->join('identifications','revision_decrees.id','=','identifications.id_sk_revisi')
        ->join('standard_implementers','identifications.id','=','standard_implementers.id_identifikasi')
        ->select('standard_implementers.penerap')
        ->where('meeting_materials.id_meeting_schedule','=',$this->id)
        ->get();

        $alfabet = 'E';

        $sheet->getStyle('A1:'.$alfabet.($toRow->count()+1))->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,    
                ]    
            ]    
        ])->getAlignment()->setWrapText(true);

        return [
            //entire row 1 get bold font
            1 => ['font' => ['bold' => true]],
        ];
    }
}
