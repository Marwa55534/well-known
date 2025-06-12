<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Document;
use App\Models\ExtractFile;

class DocumentController extends Controller
{
     public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string',
            'description' => 'nullable|string',
            'files.*' => 'nullable|file|mimes:jpg,png,pdf,doc,docx,zip|max:2048'
        ]);

        $document = Document::create($request->only('title', 'description'));

        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $file) {
                $path = $file->store('extracts', 'public');
                ExtractFile::create([
                    'document_id' => $document->id,
                    'file_path' => $path
                ]);
            }
        }

        return $this->formatResponse($document, 'document created successfully', true, 201);

    }
}
