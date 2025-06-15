<?php

namespace App\Http\Controllers;

use App\Models\SubService;
use App\Models\SubServiceGovernment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class SubServiceController extends Controller
{
    public function index(Request $request)
    {
        $query = SubService::query();

        if ($request->has('service_id')) {
            $query->where('service_id', $request->service_id);
        }

        $subServices = $query->get();

        if ($subServices->isEmpty()) {
            return $this->formatResponse(null, 'SubServices not found', false, 404);
        }
        foreach ($subServices as $subService) {
            $subService->image = !empty($subService->image) ? url($subService->image) : null;
            
        }

        return $this->formatResponse($subServices, 'SubServices retrieved successfully');
    } 
    public function show($id)
    {
        $subService = SubService::find($id);
        if (!$subService) {
            return $this->formatResponse(null, 'SubService not found', false, 404);
        }
        
$subService->image = !empty($subService->image) ? url($subService->image) : null;
        return $this->formatResponse($subService, 'SubService retrieved successfully');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'required|file|mimes:jpg,jpeg,png,gif|max:2048',
            'whatsapp' => 'required|numeric|digits:11|unique:sub_services',
            'phone' => 'required|numeric|digits:11|unique:sub_services',
            'service_id' => 'required|exists:services,id',
            'governorate_id' => 'required|exists:governorates,id',
            // 'center_governorate_id' => 'required|exists:center_governorates,id',
            // 'center_governorate_id' => 'required|array|min:1', 
            'center_governorate_id.*' => 'required|exists:center_governorates,id',

        ]);

        $imagePath = $request->file('image')->store('sub_service_images', 'public');
        
        $subService = SubService::create([
            'title' => $request->title,
            'description' => $request->description,
           
            'whatsapp' => $request->whatsapp,
            'phone' => $request->phone,
            'service_id' => $request->service_id,
            'image' => $imagePath,
           'governorate_id' => $request->governorate_id,
            // 'center_governorate_id' => $request->center_governorate_id, 
            'center_governorate_id' => $request->center_governorate_id[0], 
        ]);



        foreach ($request->center_governorate_id as $center_id) {
    SubServiceGovernment::create([
        'sub_service_id' => $subService->id,
        'government_id' => $request->governorate_id,
        'center_governorate_id' => $center_id,
    ]);
        }
   
       

        $subService->load(['governorate', 'centerGovernorate']);
        return $this->formatResponse($subService, 'Sub-service created successfully', true, 201);
    
    } 

    // public function update(Request $request, $id)
    // {
    //     $subService = SubService::findOrFail($id);

    //     $request->validate([
    //         'title' => 'sometimes|string|max:255',
    //         'description' => 'sometimes|string',
           
    //         'image' => 'sometimes|string',
    //         'whatsapp' => 'sometimes|string',
    //         'phone' => 'sometimes|string',
    //         'service_id' => 'sometimes|exists:services,id',
    //         'governorate_id' => 'sometimes|exists:governorates,id',
    //         'center_governorate_id' => 'sometimes|exists:center_governorates,id',
    //     ]);

    //     $subService->update($request->all());
    //     return $this->formatResponse($subService, 'Sub-service updated successfully');
    // }


    public function update(Request $request, $id)
{
    $request->validate([
        'title' => 'required|string|max:255',
        'description' => 'required|string',
        'image' => 'nullable|file|mimes:jpg,jpeg,png,gif|max:2048',
        'whatsapp' => ['required', 'numeric', 'digits:11', Rule::unique('sub_services')->ignore($id)],
        'phone' => ['required', 'numeric', 'digits:11', Rule::unique('sub_services')->ignore($id)],
        'service_id' => 'required|exists:services,id',
        'governorate_id' => 'required|exists:governorates,id',
        'center_governorate_id' => 'required|exists:center_governorates,id',
        'center_governorate_id.*' => 'exists:center_governorates,id',
    ]);

    $subService = SubService::findOrFail($id);

    // Handle image upload if provided
   if ($request->hasFile('image')) {
        $image = $request->file('image');
        // هشيك ان الصور موجود في ال puplice

        $oldPhotoPath = public_path('uploads/sub_services/' . basename($subService->image));

        if (File::exists($oldPhotoPath)) {
            File::delete($oldPhotoPath);
        }

            // store new photo in local
        $fileName = Str::uuid() . time() . '.' . $image->getClientOriginalExtension();

            // Store the photo in the teachers disk
        $path = $image->storeAs('', $fileName, 'sub_services');

            // إضافة المسار إلى البيانات المحدثة
        $validated['image'] = $path;
        }
    $subService->update($validated);


    // Clear existing SubServiceGovernment records
    SubServiceGovernment::where('sub_service_id', $subService->id)->delete();

    // Create new SubServiceGovernment records
    foreach ($request->center_governorate_id as $centerId) {
        SubServiceGovernment::create([
            'sub_service_id' => $subService->id,
            'center_governorate_id' => $centerId,
            'government_id' => $request->governorate_id,
        ]);
    }

    // Load relationships
    $subService->load(['governorate', 'centerGovernorate']);

    return $this->formatResponse($subService, 'Sub-service updated successfully', true, 200);
}

    public function destroy($id)
    {
        $subService = SubService::find($id);
        if (!$subService) {
            return $this->formatResponse(null, 'SubService not found', false, 404);
        }
        if ($subService->image) {
            $oldPhotoPath = public_path('uploads/sub_services/' . basename($subService->photo));

            if (File::exists($oldPhotoPath)) {
                File::delete($oldPhotoPath);
            }
        }
        $subService->delete();
        return $this->formatResponse(null, 'Sub-service deleted successfully', true, 200);
    }
}


