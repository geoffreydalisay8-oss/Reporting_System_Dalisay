<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AttachmentController extends Controller
{
   public function store(Request $request) 
{
    // 1. Validate
    $request->validate([
        'title' => 'required',
        'description' => 'required',
        'type' => 'required',
        'priority' => 'required',
        'file' => 'nullable|file|mimes:pdf,jpg,png,doc,docx|max:2048',
    ]);

    // 2. Create the Ticket
    $ticket = \App\Models\Ticket::create([
        'user_id' => auth()->id(),
        'title' => $request->title,
        'description' => $request->description,
        'type' => $request->type,
        'priority' => $request->priority,
        'status' => 'Pending',
    ]);

    // 3. Handle the File Upload
    if ($request->hasFile('file')) {
        $file = $request->file('file');
        
        // This saves to storage/app/public/attachments
        $path = $file->store('attachments', 'public');

        \App\Models\Attachment::create([
            'ticket_id' => $ticket->id, // Link to the ticket we just made
            'file_name' => $file->getClientOriginalName(),
            'file_path' => $path,
        ]);
    }

    return redirect()->route('dashboard')->with('success', 'Report submitted successfully!');
}
}