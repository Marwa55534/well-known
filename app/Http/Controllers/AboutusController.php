<?php

namespace App\Http\Controllers;

use App\Models\AboutUs;
use Illuminate\Http\Request;

class AboutusController extends Controller
{
    public function index()
    {
        $aboutUs = AboutUs::all();
        return $this->formatResponse($aboutUs, 'About us revited successfully');

    }

    public function show($id)
    {
        $aboutUs = AboutUs::find($id);
        if (!$aboutUs) {
        return $this->formatResponse(null, 'Not found',false,404);

        }
        return $this->formatResponse($aboutUs, 'About us revited successfully');

    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string',
            'description' => 'required|string',
        ]);



        $aboutUs = AboutUs::create([
            'title' => $request->title,
            'description' => $request->description,
           
            
        ]);
        return $this->formatResponse($aboutUs, 'About us revited successfully',true,201);

    }

    public function update(Request $request, $id)
    {
        $aboutUs = AboutUs::find($id);
        if (!$aboutUs) {
            return response()->json(['message' => 'Not found'], 404);
        }

        $request->validate([
            'title' => 'sometimes|string|max:255',
            'description' => 'sometimes|string',
        ]);

        $aboutUs->update($request->all());
        return $this->formatResponse($aboutUs, 'About us updated successfully');

    }

    public function destroy($id)
    {
        $aboutUs = AboutUs::find($id);
        if (!$aboutUs) {
        return $this->formatResponse(null, 'Not found',false,404);

        }

        $aboutUs->delete();
        return $this->formatResponse(null, 'Deleted successfully');

        
    }
}
