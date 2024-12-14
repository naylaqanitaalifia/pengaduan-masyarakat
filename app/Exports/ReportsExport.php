<?php

namespace App\Exports;

use App\Models\Report;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class ReportsExport implements FromCollection, WithHeadings, WithTitle
{
    /**
    * @return \Illuminate\Support\Collection
    */
    protected $date;

    // Konstruktor untuk menerima tanggal
    public function __construct($date = null)
    {
        $this->date = $date;
    }

    public function collection()
    {
        $query = Report::with(['user', 'response', 'staffProvince']);

        if ($this->date) {
            $query->whereDate('created_at', $this->date);
        }
        
        return $query->get()->map(function ($report) {
            return [
                'Email Pelapor' => $report->user->email,
                'Dilaporkan pada Tanggal' => $report->created_at->locale('id')->translatedFormat('d F Y'),
                'Deskripsi Pengaduan' => $report->description,
                'URL Gambar' => asset('images/' . $report->image),
                'Lokasi' => $report->village . ', ' . $report->subdistrict . ', ' . $report->regency . ', ' . $report->province,
                'Jumlah Voting' => $report->voting,
                'Status Pengaduan' => $report->response_status ?: 'Belum ada tanggapan',  
                'Progress Tanggapan' => $report->histories ?: 'Belum ada tanggapan',
                // 'Progress Tanggapan' => $report->response->pluck('progress')->implode(', ') ?: 'Belum ada tanggapan',
                'Staff Terkait' => $report->staffProvince ? $report->staffProvince->name : 'Staff tidak ditemukan',
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Email Pelapor',
            'Dilaporkan pada Tanggal',
            'Deskripsi Pengaduan',
            'URL Gambar',
            'Lokasi',
            'Jumlah Voting',
            'Status Pengaduan',
            'Progress Tanggapan',
            'Staff Terkait',
        ];
    }

    public function title(): string
    {
        return 'Reports';
    }

    public function getDateTimeFormatting(): array
    {
        return [
            'Dilaporkan pada Tanggal' => 'yyyy-mm-dd',
        ];
    }
}
