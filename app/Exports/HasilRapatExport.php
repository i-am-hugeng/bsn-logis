<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithStyles;

class HasilRapatExport implements WithHeadings, ShouldAutoSize, WithStyles
{
    protected $id;

    function __construct($id)
    {
        $this->id = $id;
    }

    /**
    * @return \Illuminate\Support\Collection
    */

    public function headings(): array
    {
        return[
            'SNI Revisi',
            'SNI Direvisi',
            'Komtek',
            'Status',
            'Batas Transisi',
            'Catatan',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $toRow = DB::table('meeting_materials')
        ->join('meeting_schedules','meeting_materials.id_meeting_schedule','=','meeting_schedules.id')
        ->join('old_standards','meeting_materials.nmr_sni_lama','=','old_standards.nmr_sni_lama')
        ->join('revision_decrees','old_standards.id_sk_revisi','=','revision_decrees.id')
        ->join('identifications','revision_decrees.id','=','identifications.id_sk_revisi')
        ->join('standard_implementers','identifications.id','=','standard_implementers.id_identifikasi')
        ->leftJoin('transition_times','meeting_materials.id','transition_times.id_sni_lama')
        ->select('meeting_materials.nmr_sni_lama')
        ->groupBy('meeting_materials.nmr_sni_lama')
        ->where('meeting_materials.id_meeting_schedule','=',$this->id)
        ->get();

        $alfabet = 'F';

        $sheet->getStyle('A1:'.$alfabet.($toRow->count()+1))->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,    
                ]    
            ]    
        ])->getAlignment()->setWrapText(true);

        $pembahasan = DB::table('meeting_materials')
        ->join('meeting_schedules','meeting_materials.id_meeting_schedule','=','meeting_schedules.id')
        ->join('old_standards','meeting_materials.nmr_sni_lama','=','old_standards.nmr_sni_lama')
        ->join('revision_decrees','old_standards.id_sk_revisi','=','revision_decrees.id')
        ->join('identifications','revision_decrees.id','=','identifications.id_sk_revisi')
        ->join('standard_implementers','identifications.id','=','standard_implementers.id_identifikasi')
        ->leftJoin('transition_times','meeting_materials.id','transition_times.id_sni_lama')
        ->select('revision_decrees.nmr_sni_baru','revision_decrees.jdl_sni_baru',
        'meeting_materials.nmr_sni_lama','meeting_materials.jdl_sni_lama','identifications.komtek',
        'meeting_materials.status_sni_lama','transition_times.batas_transisi','meeting_materials.catatan')
        ->groupBy('meeting_materials.nmr_sni_lama')
        ->where('meeting_schedules.id','=',$this->id)
        ->get();

        $i = 2;
        foreach($pembahasan as $data) {
            $joinSNIBaru = $data->nmr_sni_baru.' '.$data->jdl_sni_baru;
            $sheet->setCellValue('A'.$i, $joinSNIBaru);
            $joinSNILama = $data->nmr_sni_lama.' '.$data->jdl_sni_lama;
            $sheet->setCellValue('B'.$i, $joinSNILama);
            $sheet->setCellValue('C'.$i, $data->komtek);
            if($data->status_sni_lama == 0) {
                $sheet->setCellValue('D'.$i,'Pencabutan');
            }
            else {
                $sheet->setCellValue('D'.$i,'Transisi');
            }
            $sheet->setCellValue('E'.$i, $data->batas_transisi);
            $sheet->setCellValue('F'.$i, $data->catatan = str_replace('<br />','', $data->catatan));
            $i += 1;
        }

        return [
            //entire row 1 get bold font
            1 => ['font' => ['bold' => true]],
        ];
    }
}
