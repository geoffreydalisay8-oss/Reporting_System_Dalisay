@extends('layouts.staff')

@section('content')
<style>
    /* Content wrapper */
    .dashboard-container { padding: 30px 20px 30px 15px; }
    .header-section { margin-bottom: 25px; }
    .header-section h1 { font-size: 1.8rem; font-weight: 800; color: #334155; }
    
    /* Stats Grid */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr); /* 3 Columns for Staff instead of 4 */
        gap: 15px;
        margin-bottom: 30px;
    }

    .card-stat {
        background: white;
        padding: 20px;
        border-radius: 12px;
        box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1);
        border-bottom: 5px solid #3b82f6;
        display: flex;
        flex-direction: column;
        justify-content: center;
        min-height: 120px; 
    }

    /* Border Colors matching Admin theme */
    .card-stat.assigned { border-bottom-color: #4e73df; }
    .card-stat.pending { border-bottom-color: #f6c23e; }
    .card-stat.resolved { border-bottom-color: #1cc88a; }
    
    .card-stat .label { 
        font-size: 0.75rem; 
        font-weight: 700; 
        color: #64748b; 
        text-transform: uppercase; 
        margin-bottom: 5px;
    }

    .card-stat .value { 
        font-size: 2rem; 
        font-weight: 800; 
        color: #1e293b; 
        line-height: 1.2; 
    }

    /* Table Card */
    .table-card {
        background: white;
        border-radius: 12px;
        box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1);
        overflow: hidden;
        margin-bottom: 25px;
    }
    .table-header { padding: 20px; border-bottom: 1px solid #f1f5f9; font-weight: 700; color: #3b82f6; }
    
    .badge-status { 
        padding: 6px 12px; 
        border-radius: 8px; 
        font-weight: 600; 
        font-size: 0.75rem; 
    }
</style>

<div class="dashboard-container">
    <div class="header-section">
        <h1>Staff Workstation Dashboard</h1>
        <div class="text-muted small">
            <i class="fas fa-user-tie me-1"></i> Staff Member Panel: {{ Auth::user()->name }}
        </div>
    </div>

    <div class="stats-grid">
        <div class="card-stat assigned">
            <div class="label">Tickets Assigned to Me</div>
            <div class="value">{{ $myTicketsCount }}</div>
        </div>

        <div class="card-stat pending">
            <div class="label">My Open Tasks</div>
            <div class="value">{{ $myPendingTickets }}</div>
        </div>

        <div class="card-stat resolved">
            <div class="label">My Resolved Tickets</div>
            <div class="value">{{ $myResolvedTickets ?? 0 }}</div>
        </div>
    </div>

    <div class="table-card">
        <div class="table-header">My Active Assignment Queue</div>
        <div class="table-responsive">
            <table class="table mb-0 align-middle">
                <thead>
                    <tr>
                        <th class="ps-4">ID</th>
                        <th>Reporter</th>
                        <th>Status</th>
                        <th>Date Assigned</th>
                        <th class="text-end pe-4">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($myRecentTickets as $ticket)
                    <tr>
                        <td class="ps-4 fw-bold">#{{ str_pad($ticket->id, 4, '0', STR_PAD_LEFT) }}</td>
                        <td>{{ $ticket->user->name ?? 'Guest' }}</td>
                        <td>
                            <span class="badge-status" style="background: {{ $ticket->status == 'Resolved' ? '#dcfce7' : ($ticket->status == 'In Progress' ? '#e0f2fe' : '#ffedd5') }}; color: {{ $ticket->status == 'Resolved' ? '#166534' : ($ticket->status == 'In Progress' ? '#0369a1' : '#9a3412') }};">
                                {{ $ticket->status }}
                            </span>
                        </td>
                        <td class="small text-muted">{{ $ticket->created_at->diffForHumans() }}</td>
                        <td class="text-end pe-4">
                            <a href="{{ route('staff.tickets.show', $ticket->id) }}" class="btn btn-sm btn-primary px-3 shadow-sm" style="border-radius: 8px;">View</a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-4 text-muted">No tickets currently assigned to you.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div style="background: white; border-radius: 12px; padding: 25px; border: 1px solid #f1f5f9; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1);">
        <h2 style="font-size: 1.5rem; font-weight: 700; color: #0f172a; margin-bottom: 25px;">My Action History</h2>

        @forelse($recentActivities ?? [] as $activity)
            <div style="display: flex; gap: 15px; padding: 20px 0; border-bottom: 1px solid #f8fafc; align-items: flex-start;">
                @php
                    $color = '#3b82f6'; 
                    if($activity->status_to == 'Resolved') $color = '#10b981'; 
                    if($activity->status_to == 'In Progress') $color = '#f97316'; 
                @endphp
                <div style="width: 10px; height: 10px; border-radius: 50%; background-color: {{ $color }}; margin-top: 6px; flex-shrink: 0;"></div>
                <div>
                    <div style="color: #1e293b; font-size: 1rem; font-weight: 500;">
                        You updated Ticket <strong>#{{ str_pad($activity->ticket_id, 3, '0', STR_PAD_LEFT) }}</strong> status to <strong>{{ $activity->status_to }}</strong>
                    </div>
                    <div style="color: #94a3b8; font-size: 0.85rem; margin-top: 4px;">
                        {{ $activity->created_at->diffForHumans() }}
                    </div>
                </div>
            </div>
        @empty
            <div class="text-muted small py-2">No recent updates logged.</div>
        @endforelse
    </div>
</div>
@endsection