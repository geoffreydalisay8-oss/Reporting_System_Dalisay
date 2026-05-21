<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use App\Models\TicketHistory;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Notifications\NewComment;

class TicketController extends Controller
{
    // List all tickets for the logged-in employee
public function index(Request $request)
{
    $user = auth()->user();
    $search = $request->input('search');
    $category = $request->input('category');
    $status   = $request->input('status');

    // 1. Start the query (Do NOT use ->get() yet)
    $query = Ticket::where('user_id', $user->id)
                   ->where('status', '!=', 'Cancelled')
                   ->with('department'); // ← added

    // 2. Add Search Filter if provided
    if ($search) {
        $query->where(function($q) use ($search) {
            $q->where('title', 'like', "%{$search}%")
              ->orWhere('id', 'like', "%{$search}%");
        });
    }

    // 3. Add Category Filter if provided
    if ($category && $category !== 'all') {
        $query->where('department_id', $category); // ← fixed typo was 'departmnet'
    }

    if ($status && $status !== 'all') {
        $query->where('status', $status);
    }

    // 4. Finalize: Sort and then Fetch the data
    $tickets = $query->latest()->get();

    return view('tickets.index', compact('tickets'));
}
    // Show the creation form
    public function create()
    {
        // Removed Category::all() since you are using a 'type' string field now
        return view('tickets.create');
    }

    // Save a new incident/complaintpublic function store(Request $request)
public function store(Request $request)
{
    $validated = $request->validate([
        'title'         => 'required|string|max:255',
        'description'   => 'required|string',
        'department_id' => 'required|exists:departments,id',
        'priority'      => 'required|in:Low,Medium,High',
        'attachment'    => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
    ]);

    DB::beginTransaction();

    try {
        $ticket = Ticket::create([
            'user_id'       => Auth::id(),
            'department_id' => $validated['department_id'],
            'title'         => $validated['title'],
            'description'   => $validated['description'],
            'priority'      => $validated['priority'],
            'status'        => 'Pending',
        ]);

        if ($request->hasFile('attachment')) {
            $file = $request->file('attachment');
            $path = $file->store('attachments', 'public');

            $ticket->attachments()->create([
                'file_name' => $file->getClientOriginalName(),
                'file_path' => $path,
            ]);
        }

        DB::commit();
        return redirect()->route('tickets.index')->with('success', 'Report submitted successfully!');

    } catch (\Exception $e) {
        DB::rollback();
        return back()->with('error', 'Failed to submit report: ' . $e->getMessage())->withInput();
    }
}

    
    public function show($id)
{
    // 1. Fetch the ticket with its relationships
    $ticket = Ticket::with(['user', 'comments.user', 'attachments', 'assigned'])->findOrFail($id);

    // 2. BLOCK VIEWING IF CANCELLED
    // This prevents users from accessing the URL directly for a cancelled ticket
    if ($ticket->status === 'Cancelled') {
        abort(404, 'The ticket you are looking for has been cancelled and is no longer available.');
    }

    // 3. Logic to decide which "Detailed View" to show
    if (Auth::user()->role === 'admin' || Auth::user()->role === 'staff') {
        // NOTE: If you want ADMINS to still see cancelled tickets, 
        // move the 'abort' logic inside an 'else' block for employees only.
        return view('admin.tickets.show', compact('ticket'));
    }

    return view('tickets.show', compact('ticket'));
}
    // Dashboard statistics
public function dashboard()
{
    $userId = Auth::id();

   
     $statsResult = DB::select('CALL GetUserStats(?)', [$userId]);
     $stats = [
        'total'      => $statsResult[0]->total,
        'pending'    => $statsResult[0]->pending,
        'resolved'   => $statsResult[0]->resolved,
        'in_progress'=> $statsResult[0]->in_progress,
        'cancelled'  => $statsResult[0]->cancelled,
    ];


    
    $recentTickets = DB::select('CALL GetUserRecentTickets(?, ?)', [$userId, 5]);

    return view('tickets.dashboard', compact('stats', 'recentTickets'));
}

    
 public function storeComment(Request $request, Ticket $ticket)
{
    $request->validate(['body' => 'required|string']);

    // 1. Save comment data to the database
    $comment = $ticket->comments()->create([
        'user_id' => Auth::id(),
        'message' => $request->body, 
    ]);

    // 2. Database routing logic
    if (Auth::id() === $ticket->user_id) {
        // Logged-in user is the ticket creator -> Send notification to the Staff ID
        $recipient = $ticket->assigned; 
    } else {
        // Logged-in user is Staff/Admin -> Send notification to the Creator's User ID
        $recipient = $ticket->user; 
    }

    // 3. Trigger the insert query into 'notifications' table
    if ($recipient && $recipient->id !== Auth::id()) {
        $recipient->notify(new NewComment($ticket, $comment));
    }

    return back()->with('success', 'Comment saved to database!');
}

public function cancel($id)
{
    $ticket = Ticket::findOrFail($id);

    if ($ticket->user_id !== auth()->id()) {
        abort(403);
    }

    if (in_array($ticket->status, ['In Progress', 'Resolved', 'Cancelled'])) {
        return back()->with('error', 'You cannot cancel a ticket that is already in progress or completed.');
    }

    DB::beginTransaction();
    try {
        $ticket->update(['status' => 'Cancelled']);

        // ← REMOVED manual TicketHistory::create() — trigger handles it now

        DB::commit();
        return back()->with('success', 'Ticket successfully cancelled.');
        
    } catch (\Exception $e) {
        DB::rollback();
        return back()->with('error', $e->getMessage());
    }
}
public function markAsReadAndRedirect($id)
{
    $notification = auth()->user()->notifications()->findOrFail($id);
    
    // Mark it as read so it disappears from the unread list
    $notification->markAsRead();

    // Redirect to the ticket mentioned in the notification data
    return redirect()->route('admin.tickets.show', $notification->data['ticket_id']);
}

}