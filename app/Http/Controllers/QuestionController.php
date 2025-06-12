<?php

namespace App\Http\Controllers;

use App\Models\Question;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    public function index()
    {
        $questions = Question::all();
        return $this->formatResponse($questions, 'Questions retrieved successfully');
    }

    public function store(Request $request)
    {
        $request->validate([
            'question' => 'required|string|max:255',
            'answer' => 'required|string',
        ]);

        $question = Question::create($request->all());
        return $this->formatResponse($question, 'Question created successfully', true, 201);
    }

    public function update(Request $request, $id)
    {
        $question = Question::find($id);
        if (!$question) {
            return $this->formatResponse(null, 'Question not found', false, 404);
        }

        $question->update($request->all());
        return $this->formatResponse($question, 'Question updated successfully');
    }

    public function destroy($id)
    {
        $question = Question::find($id);
        if (!$question) {
            return $this->formatResponse(null, 'Question not found', false, 404);
        }

        $question->delete();
        return $this->formatResponse(null, 'Question deleted successfully');
    }
}
