<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Contactus;
use Illuminate\Http\Request;

class ContactusController extends Controller
{
    public function index()
    {
        $contactus = Contactus::all();
    
        return view('contactus', compact('contactus'));

    }
    public function editContactus($id)
{
    $contactus = Contactus::find($id); 
    
    if (!$contactus) {
        return response()->json(['message' => 'contactus not found'], 404);
    }
    return response()->json([
        'id' => $contactus->id,
        'name' => $contactus->name,
        'phone' => $contactus->phone,
       
    ]);
}

public function store(Request $request)
{
    $request->validate([
        'name' => 'required|string',
        'phone' => 'required|numeric|digits:11|unique:users',
    ]);
    $contactus = Contactus::create([
        'name' => $request->name,
        'phone' => $request->phone,
       
        
    ]);
    $contactus = Contactus::all();


    return redirect()->route('contact-us')->with('success', 'تم إضافة  معلمومات عنكم بنجاح');
}
public function updateContactus(Request $request, $id)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'phone' => 'required|numeric|digits:11|unique:users',
    ]);

    $contactus = Contactus::find($id);

    $contactus->update($request->only(['name', 'phone']));

    return redirect()->route('contact-us')->with('success', 'تم تحديث معلومات عنكم بنجاح');
}
}

