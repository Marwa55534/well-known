<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\CenterGovernorate;
use App\Models\Governorate;
use Illuminate\Http\Request;

class GovernorateController extends Controller
{
    //
    public function index(){
        $governorates = Governorate::with('centerGovernorates')->get();
        return view('governorates',compact('governorates'));
    }

    public function storeGovernate(Request $request)
    {
        $request->validate([
            'name' => 'required|string|unique:governorates|max:255',
        ]);
        Governorate::create($request->only(['name']));
        $governorate = Governorate::all();

        return redirect()->route('governorates')->with('success', 'تم إضافة المحافظة بنجاح');
    }


    public function editGovernorate($id)
    {
        $governorate = Governorate::find($id); 
        
        if (!$governorate) {
            return response()->json(['message' => 'Governorate not found'], 404);
        }
        return response()->json([
            'id' => $governorate->id,
            'name' => $governorate->name,

           
        ]);
    }
    public function updateGovernorates(Request $request, $id)
    {
        $request->validate([
            'name' => 'sometimes|string|unique:governorates|max:255',
        ]);
    
        $governorate = Governorate::find($id);
    
        if (!$governorate) {
            return redirect()->back()->with('error', 'لم يتم العثور على المحافظة.');
        }
    
        $governorate->name = $request->name;
        $governorate->save(); 
    
        return redirect()->route('governorates')->with('success', 'تم تحديث المحافظة بنجاح');
    }
    



    public function deleteGovernate($id)
    {
        $governorate = Governorate::find($id);
    
        if (!$governorate) {
            return redirect()->route('governorates')->with('error', 'المحافظة غير موجودة');
        }
    
        $governorate->delete();
        return redirect()->route('governorates')->with('delete', 'تم حذف المحافظة بنجاح');
    }
    

}
