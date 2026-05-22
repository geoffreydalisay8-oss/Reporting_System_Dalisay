@extends('layouts.admin')

@section('content')
<style>
    /* Content wrapper */
    .dashboard-container { padding: 30px 20px 30px 15px; }
    .header-section { margin-bottom: 25px; }
    .header-section h1 { font-size: 1.8rem; font-weight: 800; color: #334155; }
    
    /* Stats Grid */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 15px;
        margin-bottom: 30px;
    }

    .card-stat {
        background: white;
        padding: 20px;
        border-radius: 12px;
        box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1);
        border-bottom: 5px solid #4e73df; /* Default Blue */
        
        /* FIX: Ensure consistent height and alignment */
        display: flex;
        flex-direction: column;
        justify-content: center;
        min-height: 120px; 
    }

    /* Dynamic Border Colors */
    .card-stat.pending { border-bottom-color: #f6c23e; }
    .card-stat.progress { border-bottom-color: #36b9cc; } 
    .card-stat.resolved { border-bottom-color: #1cc88a; }
    .card-stat.staff { border-bottom-color: #9b59b6; }
    
    .card-stat .label { 
        font-size: 0.75rem; 
        font-weight: 700; 
        color: #64748b; 
        text-transform: uppercase; 
        margin-bottom: 5px;
    }

    .card-stat .value { 
        font-size: 2rem; /* Increased size slightly */
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
    }
    .table-header { padding: 20px; border-bottom: 1px solid #f1f5f9; font-weight: 700; color: #4e73df; }
    
    .badge-status { 
        padding: 6px 12px; 
        border-radius: 8px; 
        font-weight: 600; 
        font-size: 0.75rem; 
    }
</style>

<div class="dashboard-container">
    <div class="header-section">
        <h1>Welcome, {{ Auth::user()->name }}</h1>
        <div class="text-muted small">
            <i class="fas fa-user-shield me-1"></i> Role: <span class="badge bg-secondary">{{ ucfirst(Auth::user()->role) }}</span>
        </div>
    </div>

    <div class="stats-grid">
        <div class="card-stat">
            <div class="label">{{ Auth::user()->role === 'admin' ? 'Total Tickets' : 'Assigned to Me' }}</div>
            <div class="value">{{ $totalIncidents }}</div>
        </div>

        @if(Auth::user()->role !== 'admin')
            <div class="card-stat progress">
                <div class="label">In Progress</div>
                <div class="value">{{ $inProgressIncidents }}</div>
            </div>
        @else
            <div class="card-stat pending">
                <div class="label">Pending</div>
                <div class="value">{{ $pendingIncidents }}</div>
            </div>
        @endif

        <div class="card-stat resolved">
            <div class="label">Resolved</div>
            <div class="value">{{ $resolvedIncidents }}</div>
        </div>

        <div class="card-stat staff">
            @if(Auth::user()->role === 'admin')
                <div class="label">Active Staff</div>
                <div class="value">{{ $totalStaff }}</div>
            @else
                <div class="label">Pending Action</div>
                <div class="value">{{ $pendingIncidents }}</div>
            @endif
        </div>
    </div>

    <div class="table-card">
        <div class="table-header">
            {{ Auth::user()->role === 'admin' ? 'Recent Activity' : 'My Recent Tasks' }}
        </div>
        <div class="table-responsive">
            <table class="table mb-0 align-middle">
                <thead>
                    <tr>
                        <th class="ps-4">ID</th>
                        <th>Reporter</th>
                        <th>Status</th>
                        <th>Date</th>
                        <th class="text-end pe-4">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($recentIncidents as $ticket)
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
                            <a href="{{ route('admin.tickets.show', $ticket->id) }}" class="btn btn-sm btn-primary px-3 shadow-sm" style="border-radius: 8px;">View</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection