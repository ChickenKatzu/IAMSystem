<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AssetController extends Controller
{
    /**
     * Display a listing of the assets.
     */
    public function index()
    {
        return view('assets.index');
    }

    /**
     * Show the form for creating a new asset.
     */
    public function create()
    {
        return view('assets.create');
    }

    /**
     * Store a newly created asset in storage.
     */
    public function store(Request $request)
    {
        // Implement store logic here
        return redirect()->route('assets.index')->with('success', 'Asset berhasil ditambahkan');
    }

    /**
     * Display the specified asset.
     */
    public function show($id)
    {
        return view('assets.show');
    }

    /**
     * Show the form for editing the specified asset.
     */
    public function edit($id)
    {
        return view('assets.edit');
    }

    /**
     * Update the specified asset in storage.
     */
    public function update(Request $request, $id)
    {
        // Implement update logic here
        return redirect()->route('assets.index')->with('success', 'Asset berhasil diupdate');
    }

    /**
     * Remove the specified asset from storage.
     */
    public function destroy($id)
    {
        // Implement delete logic here
        return redirect()->route('assets.index')->with('success', 'Asset berhasil dihapus');
    }
}