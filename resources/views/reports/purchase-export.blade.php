<!DOCTYPE html>
<html>
<head>
    <title>Purchase Report</title>
    <style>
        body { 
            font-family: 'Helvetica', 'Arial', sans-serif; 
            font-size: 10px; 
            line-height: 1.4;
            color: #333;
        }
        .container {
            width: 100%;
            margin: 0;
            padding: 0;
        }
        .header-section h1 {
            margin: 0;
            font-size: 22px;
            color: #1a202c;
            text-align: center;
        }
        .header-section p {
            text-align: center;
            font-size: 11px;
            margin: 2px 0;
        }
        .filter-info {
            background-color: #f7f7f7;
            border: 1px solid #eee;
            padding: 10px;
            margin: 20px 0;
            border-radius: 4px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 6px;
            text-align: left;
            font-size: 9px;
            word-wrap: break-word;
        }
        th {
            background-color: #e8e8e8;
            font-weight: bold;
            text-transform: uppercase;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .text-right {
            text-align: right;
        }
        .footer-total {
            text-align: right;
            font-weight: bold;
            font-size: 11px;
            background-color: #e8e8e8;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header-section">
            <h1>Purchase Report</h1>
            <p>PT. Jonathan Axl</p>
        </div>

        <div class="filter-info">
            <strong>Generated Date:</strong> {{ now()->format('F d, Y') }} <br>
            <strong>Report Period:</strong> 
            {{ $startDate ? \Carbon\Carbon::parse($startDate)->format('M d, Y') : 'Start' }} - 
            {{ $endDate ? \Carbon\Carbon::parse($endDate)->format('M d, Y') : 'End' }} <br>
            <strong>Project:</strong> {{ $projectName ?? 'All Projects' }} <br>
            <strong>Status:</strong> {{ $status ?? 'All Statuses' }}
        </div>

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>PO Number</th>
                    <th>Project</th>
                    <th>Item Name</th>
                    <th>Qty</th>
                    <th>Grand Total</th>
                    <th>Purchase Date</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($data as $row)
                <tr>
                    <td>{{ $row->id }}</td>
                    <td>{{ $row->purchase_order_number }}</td>
                    <td>{{ $row->project_name }}</td>
                    <td>{{ $row->item_name }}</td>
                    <td class="text-right">{{ $row->quantity }}</td>
                    <td class="text-right">Rp {{ number_format($row->grand_total, 2, ',', '.') }}</td>
                    <td>{{ \Carbon\Carbon::parse($row->purchase_date)->format('Y-m-d') }}</td>
                    <td>{{ $row->status }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" style="text-align: center; padding: 20px;">No data found for the selected criteria.</td>
                </tr>
                @endforelse
                <tr>
                    <td colspan="5" class="footer-total">
                        <strong>Grand Total:</strong>
                    </td>
                    <td colspan="3" class="footer-total text-right">
                        <strong>Rp {{ number_format(collect($data)->sum('grand_total'), 2, ',', '.') }}</strong>
                    </td>
                </tr>
            </tbody>
        </table>
        
    </div>
</body>
</html>

