<?php

namespace App\Http\Controllers;

use App\Models\CenterGovernorate;
use Illuminate\Http\Request;

class CenterGovernorateController extends Controller
{
    public function index()
    {
        $centerGovernorates = CenterGovernorate::with('governorate')->get();
        return $this->formatResponse($centerGovernorates, 'Data retrieved successfully');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|unique:center_governorates|max:255',
            'governorate_id' => 'required|exists:governorates,id',
        ]);

        $centerGovernorate = CenterGovernorate::create([
            'name' => $request->name,
            'governorate_id' => $request->governorate_id,
        ]);

        return $this->formatResponse($centerGovernorate, 'Data saved successfully');
    }


    public function show($id)
    {
        $centerGovernorate = CenterGovernorate::find($id);
        if (!$centerGovernorate) {
            return $this->formatResponse(null, 'Center governorate not found', false, 404);
        }

        return $this->formatResponse($centerGovernorate, 'Data retrieved successfully');
    }

    public function update(Request $request, $id)
    {
        $centerGovernorate = CenterGovernorate::find($id);
        if (!$centerGovernorate) {
            return $this->formatResponse(null, 'Center governorate not found', false, 404);
        }
        $request->validate([
            'name' => 'required|string|unique:center_governorates|max:255',
            'governorate_id' => 'required|exists:governorates,id',
        ]);

        $centerGovernorate->update([
            'name' => $request->name,
            'governorate_id' => $request->governorate_id,
        ]);

        return $this->formatResponse($centerGovernorate, 'Center governorate updated successfully');
    }

    public function destroy($id)
    {
        $centerGovernorate = CenterGovernorate::find($id);
        if (!$centerGovernorate) {
            return $this->formatResponse(null, 'Center governorate not found', false, 404);
        }
        $centerGovernorate->delete();
        return $this->formatResponse(null, 'Center governorate deleted successfully');
    }
}
