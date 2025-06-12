<?php
namespace App\Http\Controllers;

use App\Models\Notification;
use App\Models\Service;
use App\Models\ServiceImage;
use App\Models\User;
use App\Models\Governorate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
class ServiceController extends Controller
{
public function index(Request $request)
{
    $serviceId = $request->input('id'); 
    $governorateId = $request->input('governorate_id');  
    $centerGovernorateId = $request->input('center_governorate_id');
    
    // $servicesQuery = Service::with(['images', 'subServices' => function($query) use ($governorateId, $centerGovernorateId) {
    //     $query->when($governorateId, function($q) use ($governorateId) {
    //         $q->where('governorate_id', $governorateId);
    //     })
    //     ->when($centerGovernorateId, function($q) use ($centerGovernorateId) {
    //         $q->where('center_governorate_id', $centerGovernorateId);
    //     });
    // }, 'subServices.governorate', 'subServices.centerGovernorate']);
    
    $servicesQuery = Service::with([
    'images',
    'subServices' => function($query) use ($governorateId, $centerGovernorateId) {
        $query
            ->when($governorateId, function($q) use ($governorateId) {
                $q->where('governorate_id', $governorateId);
            })
            ->when($centerGovernorateId, function($q) use ($centerGovernorateId) {
                $q->whereHas('subServicesGovernments', function ($subQ) use ($centerGovernorateId) {
                    $subQ->where('center_governorate_id', $centerGovernorateId);
                });
            });
    },
    'subServices.governorate',
    'subServices.centerGovernorate',
])
->when($centerGovernorateId, function($que) use ($centerGovernorateId) {
    $que->whereHas('subServices.subServicesGovernments', function($qu) use ($centerGovernorateId) {
        $qu->where('center_governorate_id', $centerGovernorateId);
    });
});

    
    if ($serviceId) {
        $servicesQuery->where('id', $serviceId);
    }
    
    
    // $servicesQuery = Service::with(['images', 'subServices' , 'subServices.governorate', 'subServices.centerGovernorate']);
    

    $services = $servicesQuery->get();

    foreach ($services as $service) {
        foreach ($service->images as $image) {
            $image->image_url = url($image->image_url); 
        }

        foreach ($service->subServices as $subService) {
            $subService->image = url($subService->image); 
        }
    }
if(count($services)==0){
                return $this->formatResponse([], 'الخدمه غير متوفره فى هذه المنطقه', false, 400);
}
    return $this->formatResponse($services, 'Services retrieved successfully');
}


    
    public function show($id)
    {
        $service = Service::with('images')->find($id);
        if (!$service) {
            return $this->formatResponse(null, 'Service not found', false, 404);
        }
        foreach ($service->images as $image) {
            $image->image_url = url($image->image_url);
        }
        return $this->formatResponse($service, 'Service retrieved successfully');
    }

    public function store(Request $request)
    {
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
    
    
        return $this->formatResponse($service, 'Service created successfully');

    }

    public function update(Request $request, $id)
    {
        $service = Service::find($id);
        if (!$service) {
            return response()->json(['message' => 'Service not found','fail'], 404);
        }
    
        $request->validate([
            'name' => 'sometimes|string|max:255',
            'description' => 'sometimes|string',
            'images' => 'sometimes|array',
            'images.*' => 'sometimes|file|mimes:jpg,jpeg,png,gif|max:2048',
            
        ]);
    
        $service->update($request->only(['name', 'description']));
    
        if ($request->has('images')) {
            ServiceImage::where('service_id', $service->id)->delete();
    
            foreach ($request->images as $image) {
                $imagePath = $image->store('service_images', 'public');
    
                ServiceImage::create([
                    'service_id' => $service->id,
                    'image_url' => $imagePath,
                ]);
            }
        }
    
        return $this->formatResponse($service, 'Service updated successfully');
    }
    
    public function destroy($id)
    {

        $service = Service::find($id);
        if (!$service) {
            return $this->formatResponse(null, 'Service not found', false, 404);
        }

        $service->delete();
        return $this->formatResponse(null, 'Service deleted successfully');
       
    }

    public function getAllServices() {
        $services = Service::get();
//with(['images', 'subServices.governorate', 'subServices.centerGovernorate'])->    
        // foreach ($services as $service) {
        //     foreach ($service->images as $image) {
        //         $image->image_url = url($image->image_url); 
        //     }
    
        //     foreach ($service->subServices as $subService) {
        //         $subService->image = url($subService->image); 

        //     }
        // }
    
        return $this->formatResponse($services, 'Services retrieved successfully');
    }
    
    
}
