<?php
namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\AboutUs;
use Illuminate\Http\Request;

class AboutusController extends Controller
{
    public function index()
    {
        $aboutus = AboutUs::all();
    
        return view('aboutus', compact('aboutus'));

    }
    public function editAboutUs($id)
{
    $aboutus = AboutUs::find($id); 
    
    if (!$aboutus) {
        return response()->json(['message' => 'AboutUs not found'], 404);
    }
    return response()->json([
        'id' => $aboutus->id,
        'title' => $aboutus->title,
        'description' => $aboutus->description,
       
    ]);
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
    $aboutUs = AboutUs::all();


    return redirect()->route('about-us')->with('success', 'تم إضافة  معلمومات عنكم بنجاح');
}
public function updateAboutUs(Request $request, $id)
{
    $request->validate([
        'title' => 'required|string|max:255',
        'description' => 'required|string',
    ]);

    $question = AboutUs::find($id);

    $question->update($request->only(['title', 'description']));

    return redirect()->route('about-us')->with('success', 'تم تحديث معلومات عنكم بنجاح');
}
}
