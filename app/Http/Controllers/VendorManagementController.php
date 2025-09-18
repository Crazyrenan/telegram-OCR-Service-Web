<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class VendorManagementController extends Controller
{
    /**
     * Display a listing of all vendors.
     */
    public function index()
    {
        Gate::authorize('manage-users'); 

        $vendors = DB::connection('mysql_application')
            ->table('vendors')
            ->paginate(10);

        return view('manage.vendor.index', ['vendors' => $vendors]);
    }

    /**
     * Show the form for creating a new vendor.
     */
    public function create()
    {
        Gate::authorize('manage-users');
        return view('manage.vendor.create');
    }

    /**
     * Store a newly created vendor in storage.
     */
    public function store(Request $request)
    {
        Gate::authorize('manage-users');

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:255',
            'address' => 'nullable|string',
        ]);

        DB::connection('mysql_application')->table('vendors')->insert($validated);

        return redirect()->route('vendors.manage.index')->with('success', 'New vendor added successfully!');
    }

    /**
     * Show the form for editing the specified vendor.
     */
    public function edit($id)
    {
        Gate::authorize('manage-users');

        $vendor = DB::connection('mysql_application')->table('vendors')->find($id);

        if (!$vendor) {
            return redirect()->route('vendors.manage.index')->with('error', 'Vendor not found.');
        }

        return view('manage.vendor.edit', ['vendor' => $vendor]);
    }

    /**
     * Update the specified vendor in storage.
     */
    public function update(Request $request, $id)
    {
        Gate::authorize('manage-users');

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:255',
            'address' => 'nullable|string',
        ]);

        DB::connection('mysql_application')->table('vendors')->where('id', $id)->update($validated);

        return redirect()->route('vendors.manage.index')->with('success', 'Vendor information updated successfully!');
    }
}
