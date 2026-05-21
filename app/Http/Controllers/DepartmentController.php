<?php

namespace App\Http\Controllers;
use App\Models\Ticket;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    public function ticket(Request $request)
{
    $user = auth()->user();
    $query = Ticket::query();

    // STAFF RULE: Only see tickets belonging to their Department
    if ($user->role === 'staff') {
        $query->where('department_id', $user->department_id);
    } 
    // ADMIN RULE: Sees everything
    
    $tickets = $query->with(['department', 'user'])->latest()->get();
    return view('admin.ticket', compact('tickets'));
}

public function storeTicket(Request $request)
{
    $validated = $request->validate([
        'title' => 'required',
        'department_id' => 'required|exists:departments,id',
    ]);

    Ticket::create([
        'title' => $validated['title'],
        'department_id' => $validated['department_id'],
        'user_id' => auth()->id(),
        'status' => 'Pending'
    ]);

    return back()->with('success', 'Ticket routed to department.');
}
}
