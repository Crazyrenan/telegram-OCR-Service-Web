<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProjectController extends Controller
{
    public function projectSummary()
    {
        // This query assumes you have a 'projects' table and a 'project_id' in your 'pembelian' table.
        $data = DB::connection('mysql_application')
            ->table('pembelian')
            ->join('projects', 'pembelian.project_id', '=', 'projects.id')
            ->select('projects.name as project_name', 'projects.id as project_id', DB::raw('SUM(pembelian.grand_total) as total_spending'))
            ->groupBy('projects.id', 'projects.name')
            ->orderBy('total_spending', 'desc')
            ->get();

        return response()->json($data);
    }

    /**
     * Provides a detailed list of purchases for a single project.
     */
    public function projectDetails($project_id)
    {
        $details = DB::connection('mysql_application')
            ->table('pembelian')
            ->select('item_name', 'quantity', 'grand_total', 'purchase_date')
            ->where('project_id', '=', $project_id)
            ->orderBy('purchase_date', 'desc')
            ->get();
            
        // Also get the project name for the report title
        $project = DB::connection('mysql_application')
            ->table('projects')
            ->where('id', '=', $project_id)
            ->first();

        return response()->json([
            'project_name' => $project ? $project->name : 'Unknown Project',
            'details' => $details,
        ]);
    }
}
