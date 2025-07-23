<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Illuminate\Support\Str;
use Carbon\Carbon; // Import Carbon for date/time manipulation

class GenericExport implements FromCollection, WithHeadings, WithMapping
{
    protected $data;
    protected $modelName;
    protected $rowIndex = 0; // For sequential numbering in Excel

    /**
     * Constructor for GenericExport.
     *
     * @param \Illuminate\Support\Collection $data Collection of data to be exported.
     * @param string $modelName Name of the model (used for heading determination).
     */
    public function __construct(Collection $data, string $modelName)
    {
        $this->data = $data;
        $this->modelName = $modelName;
    }

    /**
     * Returns the collection of data to be exported.
     *
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return $this->data;
    }

    /**
     * Defines the column headers for the Excel file.
     *
     * @return array
     */
    public function headings(): array
    {
        // Dynamic headers based on model name
        if ($this->modelName === 'Presence') {
            return [
                'No',
                'Nama Member',
                'Tanggal', // New header
                'Jam Scan In',      // New header
                'Jam Scan Out',     // New header
                // Add other columns if they exist in the Presence model
            ];
        } elseif ($this->modelName === 'Transaction') {
            return [
                'No',
                'Nama Member',
                'Paket',
                'Harga',
                'Tanggal Transaksi',
                'Metode Pembayaran'
                // Add other columns if they exist in the Transaction model
            ];
        }
        // For other models, try to get headers from the keys of the first data item
        if ($this->data->isNotEmpty()) {
            $firstItem = $this->data->first();
            $headings = array_keys($firstItem->toArray());
            return array_map(function($heading) {
                return Str::title(str_replace('_', ' ', $heading));
            }, $headings);
        }
        return [];
    }

    /**
     * Maps each row of data to the desired format for Excel.
     *
     * @param mixed $row Data object (e.g., an instance of Presence or Transaction model).
     * @return array
     */
    public function map($row): array
    {
        $this->rowIndex++; // Increment sequential number

        // Specific data mapping based on model name
        if ($this->modelName === 'Presence') {
            // Separate date and time for scan_in_at
            $scanInDate = $row->scan_in_at ? Carbon::parse($row->scan_in_at)->format('Y-m-d') : '';
            $scanInTime = $row->scan_in_at ? Carbon::parse($row->scan_in_at)->format('H:i:s') : '';
            $scanOutTime = $row->scan_out_at ? Carbon::parse($row->scan_out_at)->format('H:i:s') : '';

            return [
                $this->rowIndex,
                $row->member->user->name ?? 'N/A', // Get member name from relationship
                $scanInDate,
                $scanInTime,
                $scanOutTime,
                // Add other data according to headings
            ];
        } elseif ($this->modelName === 'Transaction') {
            return [
                $this->rowIndex,
                $row->user->name ?? 'N/A', // Assuming user relationship
                $row->package->name ?? 'N/A', // Assuming item relationship
                isset($row->package->price) ? 'Rp ' . number_format($row->package->price, 0, ',', '.') : 'N/A',
                $row->created_at,
                $row->payment_method,
                // Add other data according to headings
            ];
        }

        // For other models, return all attributes as an array
        return array_values($row->toArray());
    }
}

