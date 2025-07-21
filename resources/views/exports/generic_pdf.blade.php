{{-- resources/views/exports/generic_pdf.blade.php --}}
<!DOCTYPE html>
<html>
<head>
    <title>{{ $title ?? 'Data Export' }}</title>
    <style>
        body { font-family: sans-serif; font-size: 10px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th, td { border: 1px solid #ddd; padding: 6px; text-align: left; }
        th { background-color: #f2f2f2; }
        h1 { text-align: center; font-size: 18px; margin-bottom: 20px; }
    </style>
</head>
<body>
    <h1>{{ $title ?? 'Data Export' }}</h1>
    <table>
        <thead>
            <tr>
                {{-- Dynamic headers based on model name --}}
                @if($modelName === 'Presence')
                    <th>No</th>
                    <th>Nama Member</th>
                    <th>Tanggal</th>
                    <th>Jam Scan In</th>
                    <th>Jam Scan Out</th>
                @elseif($modelName === 'Transaction')
                    <th>No</th>
                    <th>Nama Pengguna</th>
                    <th>Nama Item</th>
                    <th>Jumlah</th>
                    <th>Total Harga</th>
                    <th>Tanggal Transaksi</th>
                @else
                    {{-- Default: get headers from the keys of the first data item --}}
                    @if($data->isNotEmpty())
                        @php
                            $firstItem = $data->first();
                            $headers = array_keys($firstItem->toArray());
                        @endphp
                        @foreach($headers as $header)
                            <th>{{ Illuminate\Support\Str::title(str_replace('_', ' ', $header)) }}</th>
                        @endforeach
                    @endif
                @endif
            </tr>
        </thead>
        <tbody>
            @php $rowIndex = 0; @endphp
            @foreach($data as $row)
            @php $rowIndex++; @endphp
            <tr>
                {{-- Dynamic data based on model name --}}
                @if($modelName === 'Presence')
                    <td>{{ $rowIndex }}</td>
                    <td>{{ $row->member->user->name ?? 'N/A' }}</td>
                    <td>{{ $row->scan_in_at ? \Carbon\Carbon::parse($row->scan_in_at)->format('Y-m-d') : '' }}</td>
                    <td>{{ $row->scan_in_at ? \Carbon\Carbon::parse($row->scan_in_at)->format('H:i:s') : '' }}</td>
                    <td>{{ $row->scan_out_at ? \Carbon\Carbon::parse($row->scan_out_at)->format('H:i:s') : '' }}</td>
                @elseif($modelName === 'Transaction')
                    <td>{{ $rowIndex }}</td>
                    <td>{{ $row->user->name ?? 'N/A' }}</td>
                    <td>{{ $row->item->name ?? 'N/A' }}</td>
                    <td>{{ $row->quantity }}</td>
                    <td>{{ $row->total_price }}</td>
                    <td>{{ $row->transaction_date }}</td>
                @else
                    {{-- Default: display all attribute values --}}
                    @foreach($row->toArray() as $value)
                        <td>{{ $value }}</td>
                    @endforeach
                @endif
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>

