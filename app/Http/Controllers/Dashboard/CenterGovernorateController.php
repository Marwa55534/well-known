<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\CenterGovernorate;
use App\Models\Governorate;
use Illuminate\Http\Request;

class CenterGovernorateController extends Controller
{
    //
    public function index(){
        $centergovernorates = CenterGovernorate::with('governorate')->get();
        $governorates = Governorate::all();
        return view('centergovernorates',compact('centergovernorates','governorates'));
    }
    public function editCenterGovernorate($id)
    {
        $centergovernorate = CenterGovernorate::find($id); 
        
        if (!$centergovernorate) {
            return response()->json(['message' => 'CenterGovernorate not found'], 404);
        }
        return response()->json([
            'id' => $centergovernorate->id,
            'name' => $centergovernorate->name,
            'governorate_id' => $centergovernorate->governorate_id

           
        ]);
    }
    
    public function updateCenterGovernorate(Request $request, $id)
    {
        $request->validate([
            'name' => 'sometimes|string|unique:center_governorates|max:255',
            'governorate_id' => 'sometimes|exists:governorates,id',
        ]);
    
        $centergovernorate = CenterGovernorate::find($id);
    
        if (!$centergovernorate) {
            return redirect()->back()->with('error', 'لم يتم العثور على المركز.');
        }
    
        $centergovernorate->name = $request->name;
        $centergovernorate->governorate_id = $request->governorate_id;

        $centergovernorate->save(); 
    
        return redirect()->route('center-governate')->with('success', 'تم تحديث المحافظة بنجاح');
    }
    
    public function deleteCeterGovernate($id){
        $centerGovernorate = CenterGovernorate::find($id);

        $centerGovernorate->delete();
        return redirect()->route('governorates')->with('delete', 'تم حذف المركز بنجاح');
    }
    public function storeCeterGovernate(Request $request)
    {
        $request->validate([
            'name' => 'required|string|unique:center_governorates|max:255',
            'governorate_id' => 'required|exists:governorates,id',
        ]);

        $centerGovernorate = CenterGovernorate::create([
            'name' => $request->name,
            'governorate_id' => $request->governorate_id,
        ]);

        $centerGovernorate = CenterGovernorate::all();


        return redirect()->route('center-governate')->with('success', 'تم إضافة مركز المحافظة بنجاح');
    }
}
