<?php

namespace App\Http\Controllers;

use App\Models\Governorate;
use Illuminate\Http\Request;

class GovernorateController extends Controller
{
    public function index()
    {
        $governorates = Governorate::with('centerGovernorates')->get();
        return $this->formatResponse($governorates, 'Governorates retrieved successfully');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|unique:governorates|max:255',
        ]);

        $governorate = Governorate::create([
            'name' => $request->name,
        ]);

        return $this->formatResponse($governorate, 'Governorate created successfully', true, 201);
    }

    public function show($id)
    {
        $governorate = Governorate::find($id);
        if (!$governorate) {
            return $this->formatResponse(null, 'Governorate not found', false, 404);
        }

        $centerGovernorates = $governorate->centerGovernorates; 
        return $this->formatResponse($centerGovernorates, 'Center governorates retrieved successfully');
    }

    public function update(Request $request, $id)
    {
        $governorate = Governorate::find($id);
        if (!$governorate) {
            return $this->formatResponse(null, 'Governorate not found', false, 404);
        }

        $request->validate([
            'name' => 'required|string|unique:governorates|max:255',
        ]);

        $governorate->update([
            'name' => $request->name,
        ]);

        return $this->formatResponse($governorate, 'Governorate updated successfully');
    }

    public function destroy($id)
    {
        $governorate = Governorate::find($id);
        if (!$governorate) {
            return $this->formatResponse(null, 'Governorate not found', false, 404);
        }

        $governorate->delete();
        return $this->formatResponse(null, 'Governorate deleted successfully');
    }
}
