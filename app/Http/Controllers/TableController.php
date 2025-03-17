<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Table;

class TableController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Admin/AddTable');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $topping = new Table;
        $topping->name = $request->input('name');
        $topping->guest_number = $request->input('guest_number');
        $topping->status = $request->input('status');
        
        $topping->save();
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $Table = Table::findOrFail($id);

        $Table->name = $request->input('name');
        $Table->guest_number = $request->input('guest_number');
        $Table->status = $request->input('status');
        $Table->save();

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Table::findOrFail($id)->delete();
        return redirect()->back();
    }
}
