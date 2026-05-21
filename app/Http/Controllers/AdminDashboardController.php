<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use App\Models\TicketHistory;
use App\Models\Ticket; 
use App\Models\Department; 
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminDashboardController extends Controller
{
    /**
     * Dashboard Index: Role-based stats for Admin and Staff
     */
    public function index(Request $request)
{
    $user = Auth::user();
    

    if ($user->role === 'admin') { 
        $totalIncidents = Ticket::count();
        $pendingIncidents = Ticket::where('status', 'Pending')->count();
        $resolvedIncidents = Ticket::where('status', 'Resolved')->count();
        $inProgressIncidents = Ticket::where('status', 'In Progress')->count();
        
        $staffMembers = User::where('role', 'staff')->get(); 
        $totalStaff = $staffMembers->count();

        $recentIncidents = Ticket::with('user')->latest()->take(5)->get();
        $recentActivities = TicketHistory::with(['user', 'ticket'])->latest()->take(3)->get();
    } else {
        // --- STAFF BLOCK (Where the error was) ---
        $totalIncidents = Ticket::where('assigned_to', $user->id)->count();
        
        // Define these so compact() doesn't fail
        $pendingIncidents = Ticket::where('assigned_to', $user->id)->where('status', 'Pending')->count();
        $resolvedIncidents = Ticket::where('assigned_to', $user->id)->where('status', 'Resolved')->count();
        $inProgressIncidents = Ticket::where('assigned_to', $user->id)->where('status', 'In Progress')->count();
        
        $staffMembers = collect(); 
        $totalStaff = 0; 
        
        $recentIncidents = Ticket::where('assigned_to', $user->id)->with('user')->latest()->take(5)->get();
        $recentActivities = TicketHistory::whereHas('ticket', function($q) use ($user) {
            $q->where('assigned_to', $user->id);
        })->with(['user', 'ticket'])->latest()->take(3)->get();
    }

    // Now all variables exist regardless of the user's role
    return view('admin.dashboard', compact(
        'totalIncidents', 
        'pendingIncidents', 
        'resolvedIncidents', 
        'inProgressIncidents',
        'totalStaff',
        'recentIncidents',
        'recentActivities',
        'staffMembers'
    ));
}

    /**
     * View Detailed Ticket (Only one instance to avoid redeclare error)
     */
    public function showTicket($id)
    {
        $ticket = Ticket::with(['user', 'comments.user', 'attachments', 'histories.user'])->findOrFail($id);

        // Ensure this file exists: resources/views/admin/tickets-show.blade.php
        return view('admin.tickets-show', compact('ticket')); 
    }

    /**
     * Ticket Management List
     */
   public function ticket(Request $request)
    {
        $user = auth()->user();
        
        // 1. Initialize the query
        $ticketQuery = Ticket::query();

        // 2. Apply Role-Based Security
        if ($user->role !== 'admin') {
            // FIX: Staff ONLY see tickets assigned to them. 
            // We removed the 'orWhere' that was causing unassigned tickets to show up.
            $ticketQuery->where('assigned_to', $user->id);
        }

        // 3. Apply Search Filter
        $search = $request->input('search');
        if ($search) {
            $ticketQuery->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('id', 'like', "%{$search}%")
                  ->orWhereHas('user', function($userQuery) use ($search) {
                      $userQuery->where('name', 'like', "%{$search}%");
                  });
            });
        }

        // 4. Apply Department Filter
        $category = $request->input('category');
        if ($category && $category !== 'all') {
            $ticketQuery->where('department_id', $category);
        }

        // 5. Execute query with relationships
        $tickets = $ticketQuery->with(['user', 'department'])
                               ->orderBy('created_at', 'desc')
                               ->get();

        $staffMembers = User::where('role', 'staff')->get();

        return view('admin.ticket', compact('tickets', 'staffMembers'));
    }
    /**
     * Assign Ticket to Staff and auto-update status
     */
 public function assignTicket(Request $request, $id)
{
    $ticket = Ticket::findOrFail($id);
    $newStaffId = $request->assigned_to;

    DB::beginTransaction();

    try {
        if (empty($newStaffId)) {
            $ticket->update([
                'assigned_to' => null,
                'status' => 'Pending' 
            ]);
        } else {
            $ticket->update([
                'assigned_to' => $newStaffId,
                'status' => 'In Progress'
            ]);
        }

        // ← REMOVED manual TicketHistory::create() — trigger handles it now

        DB::commit();
        return back()->with('success', 'Assignment updated.');

    } catch (\Exception $e) {
        DB::rollback();
        return back()->with('error', $e->getMessage());
    }
}
    /**
     * General Status Update
     */
public function updateStatus(Request $request, $id)
{
    $ticket = Ticket::findOrFail($id);

    $ticket->update(['status' => $request->status]);

    // ← REMOVED manual TicketHistory::create() — trigger handles it now

    return back()->with('success', 'Status updated!');
}

public function editStaff($id)
{
    if (Auth::user()->role !== 'admin') {
        abort(403, 'Unauthorized action.');
    }

    $staff = User::findOrFail($id);
     $departments = Department::all();
    return view('admin.edit-staff', compact('staff', 'departments'));
}
    public function createStaff()
    {
        // Security check: Only Admins can create staff
        if (Auth::user()->role !== 'admin') { 
            abort(403, 'Unauthorized action.'); 
        }
         $departments = Department::all(); // 
        return view('admin.create-staff', compact('departments'));
    }
    public function manageStaff() 
    {
        if (Auth::user()->role !== 'admin') { abort(403); }
        $staff = User::where('role', 'staff')->with('department')->get();
        return view('admin.staff', compact('staff'));
    }

    public function storeStaff(Request $request)
    {
        if (Auth::user()->role !== 'admin') { abort(403); }

        $validated = $request->validate([
            'name'       => 'required|string|max:255|unique:users,name',
            'email'      => 'required|email|unique:users,email',
            'password'   => 'required|min:8', 
            'department_id' => 'required|exists:departments,id',
        ]);

        User::create([
            'name'              => $validated['name'],
            'email'             => $validated['email'],
            'password'          => Hash::make($validated['password']),
            'department_id'     => $validated['department_id'],
            'role'              => 'staff', 
            'email_verified_at' => now(),
        ]);

        return redirect()->route('admin.staff.index')->with('success', 'Staff account created!');
    }

    public function updateStaff(Request $request, $id)
{
    if (Auth::user()->role !== 'admin') { abort(403); }

    $staff = User::findOrFail($id);
    
    $request->validate([
        'name'  => 'required|string|max:255|unique:users,name,' . $id,
        'email' => 'required|email|unique:users,email,' . $id,
        'department_id' => 'required|exists:departments,id',
        'password' => 'nullable|min:8', // Allow password to be empty (not changed)
    ]);

    // Prepare data to update
    $data = $request->only('name', 'email', 'department_id');

    // Only update password if a new one was provided
    if ($request->filled('password')) {
        $data['password'] = Hash::make($request->password);
    }

    $staff->update($data);

    return redirect()->route('admin.staff.index')->with('success', 'Staff updated successfully!');
}


    public function destroyStaff($id)
    {
        if (Auth::user()->role !== 'admin') { abort(403); }
        User::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Staff member deleted.');
    }


  public function activityLog()
{
    $user = auth()->user();

    // 1. Initialize Query
    $query = TicketHistory::with(['user', 'ticket']);

    // 2. Strict Filter: If not admin, only show activities performed by this specific staff member
    if ($user->role !== 'admin') {
        $query->where('user_id', $user->id);
    }

    // 3. Get results
    $activities = $query->latest()->paginate(15);

    return view('admin.activity-log', compact('activities'));
}

public function indexDepartments()
{
    if (auth()->user()->role !== 'admin') abort(403);
    
    $departments = Department::withCount('users')->get();
    return view('admin.departments.index', compact('departments'));
}

/**
 * Store New Department
 */
public function storeDepartment(Request $request)
{
    if (auth()->user()->role !== 'admin') abort(403);

    $validated = $request->validate([
        'name' => 'required|string|max:255|unique:departments,name',
    ]);

    Department::create(['name' => $validated['name']]);

    return redirect()->back()->with('success', 'New department added successfully!');
}
}