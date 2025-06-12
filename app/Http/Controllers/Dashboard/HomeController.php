<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Governorate;
use App\Models\Notification;
use App\Models\Service;
use App\Models\ServiceImage;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HomeController extends Controller
{
    //
    public function home(){
        return view('welcome');
    }
    public function index(){
        $users = User::all();

        return view('users',compact('users'));
    }

public function services(){
    $services = Service::with(['images','subServices'])->get();

    return view('services',compact('services'));
}

public function creatServices(Request $request){
    $request->validate([
        'name' => 'required|string|max:255',
        'description' => 'required|string',
        'images' => 'required|array',
        'images.*' => 'required|file|mimes:jpg,jpeg,png,gif|max:2048',

    ]);

    $service = Service::create($request->only(['name', 'description']));

    foreach ($request->images as $image) {
        $imagePath = $image->store('service_images', 'public');

        ServiceImage::create([
            'service_id' => $service->id, 
            'image_url' => $imagePath, 
        ]);
    }

    $users = User::all();
    foreach ($users as $user) {
        Notification::create([
            'user_id' => $user->id, 
            'title' => 'New Service Added', 
            'description' => 'A new service "' . $service->name . '" has been added.', 
        ]);
    }

    // $service->load(['governorate', 'centerGovernorate']);
    return redirect()->route('services')->with('success', 'تمت اضافة الخدمة بنجاح');

}
public function editService($id) {
    $service = Service::with(['images'])->find($id);

    if (!$service) {
    return redirect()->route('services')->with('error', 'حدث خطأ في تعديل الخدمة');
    }

    // Return the service data in JSON format
    return response()->json([
        'id' => $service->id,
        'name' => $service->name,
        'description' => $service->description,

    ]);
}

public function updateServices(Request $request, $id)
{
    $service = Service::find($id);
    if (!$service) {
        return redirect()->route('services')->with('error', 'حدث خطأ في تعديل الخدمة');
    }

    $request->validate([
        'name' => 'sometimes|string|max:255',
        'description' => 'sometimes|string',
        'images' => 'sometimes|array',
        'images.*' => 'sometimes|file|mimes:jpg,jpeg,png,gif|max:2048',
    ]);

    $service->update($request->only(['name', 'description']));

    if ($request->has('images')) {
        $oldImages = ServiceImage::where('service_id', $service->id)->get();
        foreach ($oldImages as $oldImage) {
            if (Storage::exists('public/' . $oldImage->image_url)) {
                Storage::delete('public/' . $oldImage->image_url);
            }
        }

        ServiceImage::where('service_id', $service->id)->delete();

        foreach ($request->images as $image) {
            $imagePath = $image->store('service_images', 'public');

            ServiceImage::create([
                'service_id' => $service->id,
                'image_url' => $imagePath,
            ]);
        }
    }

    return redirect()->route('services')->with('success', 'تمت تعديل الخدمة بنجاح');
}


public function deleteService(Service $service)
{
    $images = ServiceImage::where('service_id', $service->id)->get();
    
    foreach ($images as $image) {
        if (Storage::exists('public/' . $image->image_url)) {
            Storage::delete('public/' . $image->image_url);
        }
    }

    ServiceImage::where('service_id', $service->id)->delete();

    $service->delete();

    return redirect()->route('services')->with('delete', 'تم حذف الخدمة بنجاح');
}

}
