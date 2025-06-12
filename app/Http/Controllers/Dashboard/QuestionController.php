<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Question;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    //
    public function index() {
        $questions = Question::all();
    
        return view('questions', compact('questions'));
    }

    public function deleteQuestion($id){
        $questions = Question::find($id);

        $questions->delete();
        return redirect()->route('questions')->with('delete', 'تم حذف الخدمة بنجاح');
    }

    public function store(Request $request)
    {
        $request->validate([
            'question' => 'required|string|min:3|max:255',
            'answer' => 'required|string|min:3',
        ]);
        
    
        Question::create($request->only(['question', 'answer']));
    
        $questions = Question::all();
    
        return redirect()->route('questions')->with('success', 'تم إضافة السؤال بنجاح');
    }
    public function editQuestion($id)
{
    $question = Question::find($id); 
    
    if (!$question) {
        return response()->json(['message' => 'Question not found'], 404);
    }
    return response()->json([
        'id' => $question->id,
        'question' => $question->question,
        'answer' => $question->answer,
       
    ]);
}
public function updateQuestions(Request $request, $id)
{
    $request->validate([
        'question' => 'required|string|max:255',
        'answer' => 'required|string',
    ]);

    $question = Question::find($id);

    $question->update($request->only(['question', 'answer']));

    return redirect()->route('questions')->with('success', 'تم تحديث السؤال بنجاح');
}


    
}
