<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\CenterGovernorate;
use App\Models\Governorate;
use App\Models\Service;
use App\Models\SubServiceGovernment;
use App\Models\SubService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SubServiceController extends Controller
{


    public function editPage($id)
    {
        $subService = SubService::find($id);
        if (!$subService) {
            return abort(404, 'الخدمة غير موجودة');
        }
    
        $governorates = Governorate::all(); 
        $centerGovernorates = CenterGovernorate::where('governorate_id', $subService->governorate_id)->get(); 
    
        return view('sub-services.edit', compact('subService', 'governorates', 'centerGovernorates'));
    }
    


    public function index(Request $request)
    {
        // return 'weew';
        $subservices = SubService::paginate(10);
        $services = Service::all();
$governorates = Governorate::all();
$centerGovernorates = CenterGovernorate::all();
// return $centerGovernorates;
        return view('ownerservice',compact('subservices','services', 'governorates', 'centerGovernorates'));

    }

    public function store(Request $request)
    {
        // dd($request->all());
        // return $request;
        // $centerGovernorateIds = $request->input('center_governorate_id'); // هذه مصفوفة
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'required|file|mimes:jpg,jpeg,png,gif|max:2048',
            'whatsapp' => 'required|numeric|digits:11|unique:sub_services',
            'phone' => 'required|numeric|digits:11|unique:sub_services',
            'service_id' => 'required|exists:services,id',
            'governorate_id' => 'required|exists:governorates,id',
            // 'center_governorate_id' => 'required|exists:center_governorates,id',
            'center_governorate_id' => 'required',
        ]);
        
        $imagePath = $request->hasFile('image') 
        ? $request->file('image')->store('sub_service_images', 'public') 
        : null;
        $subService = SubService::create([ 
            'title' => $request->title,
            'description' => $request->description,
           
            'whatsapp' => $request->whatsapp,
            'phone' => $request->phone,
            'service_id' => $request->service_id,
            'image' => $imagePath,
            'governorate_id' => $request->governorate_id,
            'center_governorate_id' => $request->center_governorate_id[0],

        ]);
        // $subService->load(['governorate', 'centerGovernorate','services']);
        
        if($subService){
            $center_governorate_id=$request->center_governorate_id;
            // return $center_governorate_id;
            foreach($center_governorate_id as $id){
                $new_center=SubServiceGovernment::create([
                        'sub_service_id'=>$subService->id,
                        'center_governorate_id'=>$id,
                        'government_id'=>$request->governorate_id,
                    ]);
            } 
        }

        return redirect()->route('sub-services')->with('success', 'تمت اضافة صاحب الخدمة بنجاح');
    }



    

    public function editSubService($id)
{
    $subService = SubService::with('subServicesGovernments')->where('id',$id)->first();
    if (!$subService) {
        return abort(404, 'الخدمة غير موجودة');
    }

    $governorates = Governorate::all(); 
    $centerGovernorates = CenterGovernorate::where('governorate_id', $subService->governorate_id)->get(); 
// return $subService;
    // dd($subService->image);
    return view('edit', compact('subService', 'governorates', 'centerGovernorates'));
}

public function updateSubService(Request $request, $id)
{
    // return $request;
    $request->validate([
        'title' => 'sometimes|string|max:255',
        'description' => 'sometimes|string',
        'image' => 'sometimes|file|mimes:jpg,jpeg,png,gif|max:2048',
        'whatsapp' => 'sometimes|string',
        'phone' => 'sometimes|string',
        'service_id' => 'sometimes|exists:services,id',
        'governorate_id' => 'sometimes|exists:governorates,id',
        'center_governorate_id' => 'sometimes',
        // 'center_governorate_id' => 'sometimes|exists:center_governorates,id',
    ]);

    $subService = SubService::find($id);
    if (!$subService) {
        return response()->json(['message' => 'SubService not found'], 404);
    }

    if ($request->hasFile('image')) {
        if ($subService->image && Storage::exists('public/' . $subService->image)) {
            Storage::delete('public/' . $subService->image);
        }

        $imagePath = $request->file('image')->store('sub-services-images', 'public');
        $subService->image = $imagePath;
    }
    // return $id;
    SubServiceGovernment::where('sub_service_id',$id)->delete();
    $center_governorate_id=$request->center_governorate_id;
    foreach($center_governorate_id as $centid){
                $new_center=SubServiceGovernment::create([
                        'sub_service_id'=>$id,
                        'center_governorate_id'=>$centid,
                        'government_id'=>$request->governorate_id,
                    ]);
            }

    $subService->update($request->except('image','center_governorate_id'));
$subService->update(['center_governorate_id'=>$center_governorate_id[0]]);
    return redirect()->route('sub-services')->with('success', 'تم تحديث صاحب الخدمة بنجاح');
}





public function destroy($id)
{
    $subService = SubService::find($id);
    if (!$subService) {
        return redirect()->route('sub-services')->with('error', 'خطأ في حذف صاحب الخدمة');
    }

    if ($subService->image && Storage::exists('public/' . $subService->image)) {
        Storage::delete('public/' . $subService->image);
    }

    $subService->delete();

    return redirect()->route('sub-services')->with('error', 'تم  حذف صاحب الخدمة');
}

}
