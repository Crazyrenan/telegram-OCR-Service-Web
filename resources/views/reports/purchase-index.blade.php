@extends('layout')

@section('content')
<div class="p-6 bg-white rounded-lg shadow-md">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">Purchase Order Report</h1>

    <!-- Filters -->
    <div class="grid grid-cols-1 md:grid-cols-5 gap-4 mb-6 p-4 bg-gray-50 rounded-lg border">
        <div>
            <label for="filter-start-date" class="block text-sm font-medium text-gray-700">Start Date</label>
            <input type="date" id="filter-start-date" class="mt-1 block w-full form-input">
        </div>
        <div>
            <label for="filter-end-date" class="block text-sm font-medium text-gray-700">End Date</label>
            <input type="date" id="filter-end-date" class="mt-1 block w-full form-input">
        </div>
        <div>
            <label for="filter-project" class="block text-sm font-medium text-gray-700">Project</label>
            <select id="filter-project" class="mt-1 block w-full form-input">
                <option value="">All Projects</option>
                @foreach($projects as $project)
                    <option value="{{ $project->id }}">{{ $project->name }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label for="filter-status" class="block text-sm font-medium text-gray-700">Status</label>
            <select id="filter-status" class="mt-1 block w-full form-input">
                <option value="">All Statuses</option>
                <option value="Pending">Pending</option>
                <option value="Approved">Approved</option>
                <option value="Delivered">Delivered</option>
            </select>
        </div>
        <div class="flex items-end">
            <button id="apply-filters" class="w-full btn-primary py-2">Apply Filters</button>
        </div>
    </div>

    <!-- Action Buttons -->
    <div class="flex space-x-2 mb-4">
        <button id="export-csv-btn" class="btn-secondary">Export to CSV</button>
        <button id="export-pdf-btn" class="btn-secondary">Export to PDF</button>
    </div>

    <!-- Report Table -->
    <div class="overflow-x-auto">
        <table class="min-w-full bg-white">
            <thead class="bg-gray-800 text-white">
                <tr>
                    <th class="py-3 px-4 uppercase font-semibold text-sm">PO Number</th>
                    <th class="py-3 px-4 uppercase font-semibold text-sm">Project</th>
                    <th class="py-3 px-4 uppercase font-semibold text-sm">Item</th>
                    <th class="py-3 px-4 uppercase font-semibold text-sm">Qty</th>
                    <th class="py-3 px-4 uppercase font-semibold text-sm">Total</th>
                    <th class="py-3 px-4 uppercase font-semibold text-sm">Purchase Date</th>
                    <th class="py-3 px-4 uppercase font-semibold text-sm">Status</th>
                </tr>
            </thead>
            <tbody id="report-table-body" class="text-gray-700">
                <!-- Data will be loaded here by JavaScript -->
            </tbody>
        </table>
        <div id="loading-indicator" class="text-center py-8" style="display: none;">
            <p class="text-gray-500">Loading report data...</p>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        function loadReport() {
            $('#loading-indicator').show();
            $('#report-table-body').empty();

            $.ajax({
                // FIXED: This now uses the correct, secure web route
                url: "{{ route('reports.purchases.data') }}",
                method: "GET",
                data: {
                    start_date: $('#filter-start-date').val(),
                    end_date: $('#filter-end-date').val(),
                    project: $('#filter-project').val(),
                    status: $('#filter-status').val(),
                },
                success: function(data) {
                    let rows = '';
                    if (data.length > 0) {
                        data.forEach(function(row) {
                            rows += `<tr class="hover:bg-gray-100 border-b">
                                <td class="py-3 px-4">${row.purchase_order_number}</td>
                                <td class="py-3 px-4">${row.project_name}</td>
                                <td class="py-3 px-4">${row.item_name}</td>
                                <td class="py-3 px-4 text-right">${row.quantity} ${row.unit}</td>
                                <td class="py-3 px-4 text-right">Rp ${parseFloat(row.grand_total).toLocaleString('id-ID')}</td>
                                <td class="py-3 px-4">${new Date(row.purchase_date).toLocaleDateString('en-CA')}</td>
                                <td class="py-3 px-4">${row.status}</td>
                            </tr>`;
                        });
                    } else {
                        rows = '<tr><td colspan="7" class="text-center py-4">No data found for the selected criteria.</td></tr>';
                    }
                    $('#report-table-body').html(rows);
                },
                error: function() {
                    $('#report-table-body').html('<tr><td colspan="7" class="text-center py-4 text-red-500">Failed to load report data.</td></tr>');
                },
                complete: function() {
                    $('#loading-indicator').hide();
                }
            });
        }

        $('#apply-filters').on('click', loadReport);

        function exportReport(format) {
            const params = new URLSearchParams({
                start_date: $('#filter-start-date').val(),
                end_date: $('#filter-end-date').val(),
                project: $('#filter-project').val(),
                status: $('#filter-status').val(),
                format: format
            });
            // FIXED: This also now uses the correct route helper
            window.location.href = `{{ route('reports.purchases.export') }}?${params.toString()}`;
        }

        $('#export-csv-btn').on('click', function() { exportReport('csv'); });
        $('#export-pdf-btn').on('click', function() { exportReport('pdf'); });

        // Load initial report
        loadReport();
    });
</script>
@endsection

