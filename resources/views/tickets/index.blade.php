@extends('layouts.employee')

@section('content')

<style>
    .filter-bar {
        background: white;
        border: 1px solid var(--border);
        border-radius: 14px;
        padding: 16px 20px;
        box-shadow: var(--card-shadow);
        margin-bottom: 20px;
    }
    .search-input-wrap {
        position: relative;
        flex: 1;
    }
    .search-input-wrap i {
        position: absolute;
        left: 14px;
        top: 50%;
        transform: translateY(-50%);
        color: var(--text-muted);
        font-size: 0.85rem;
    }
    .search-input {
        width: 100%;
        padding: 10px 14px 10px 38px;
        border: 1px solid var(--border);
        border-radius: 10px;
        font-size: 0.88rem;
        font-family: inherit;
        color: var(--text);
        outline: none;
        transition: all 0.2s;
    }
    .search-input:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(59,130,246,0.1);
    }
    .filter-select {
        padding: 10px 14px;
        border: 1px solid var(--border);
        border-radius: 10px;
        font-size: 0.88rem;
        font-family: inherit;
        color: var(--text);
        outline: none;
        cursor: pointer;
        transition: all 0.2s;
        background: white;
        min-width: 180px;
    }
    .filter-select:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(59,130,246,0.1);
    }
    .tickets-table {
        width: 100%;
        border-collapse: collapse;
    }
    .tickets-table th {
        padding: 14px 20px;
        text-align: left;
        font-size: 0.72rem;
        font-weight: 700;
        color: var(--text-muted);
        text-transform: uppercase;
        letter-spacing: 0.06em;
        background: #f8fafc;
    }
    .tickets-table td {
        padding: 16px 20px;
        border-bottom: 1px solid #f1f5f9;
        vertical-align: middle;
    }
    .tickets-table tbody tr {
        cursor: pointer;
        transition: background 0.15s;
    }
    .tickets-table tbody tr:hover { background: #f8fafc; }
    .tickets-table tbody tr:last-child td { border-bottom: none; }
</style>

{{-- Header --}}
<div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 24px;">
    <div>
        <h1 style="font-size: 1.75rem; font-weight: 800; color: var(--text); margin-bottom: 4px;">My Reports</h1>
        <p style="color: var(--text-muted); font-size: 0.95rem;">View, track, and manage all your submitted reports.</p>
    </div>
    <a href="{{ route('tickets.create') }}" class="btn-primary-custom">
        <i class="fas fa-plus"></i> New Report
    </a>
</div>

{{-- Success/Error Messages --}}
@if(session('success'))
    <div style="background: #f0fdf4; border: 1px solid #bbf7d0; color: #166534; padding: 14px 18px; border-radius: 10px; margin-bottom: 20px; font-size: 0.9rem; font-weight: 500; display: flex; align-items: center; gap: 10px;">
        <i class="fas fa-check-circle"></i> {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div style="background: #fef2f2; border: 1px solid #fecaca; color: #991b1b; padding: 14px 18px; border-radius: 10px; margin-bottom: 20px; font-size: 0.9rem; font-weight: 500; display: flex; align-items: center; gap: 10px;">
        <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
    </div>
@endif

{{-- Filter Bar --}}
<div class="filter-bar">
    <form id="filterForm" action="{{ url()->current() }}" method="GET">
        <div style="display: flex; gap: 12px; align-items: center;">
            <div class="search-input-wrap">
                <i class="fas fa-search"></i>
                <input type="text" name="search" class="search-input"
                       placeholder="Search by subject or ticket ID..."
                       value="{{ request('search') }}">
            </div>
            <select name="category" class="filter-select">
                <option value="all">All Departments</option>
                @foreach(\App\Models\Department::all() as $dept)
                    <option value="{{ $dept->id }}" {{ request('category') == $dept->id ? 'selected' : '' }}>
                        {{ $dept->name }}
                    </option>
                @endforeach
            </select>
            <select name="status" class="filter-select" style="min-width: 150px;">
                <option value="all">All Status</option>
                <option value="Pending"     {{ request('status') == 'Pending'     ? 'selected' : '' }}>Pending</option>
                <option value="In Progress" {{ request('status') == 'In Progress' ? 'selected' : '' }}>In Progress</option>
                <option value="Resolved"    {{ request('status') == 'Resolved'    ? 'selected' : '' }}>Resolved</option>
            </select>
        </div>
    </form>
</div>

{{-- Table --}}
<div class="card-base" style="overflow: hidden;">
    <div style="overflow-x: auto;">
        <table class="tickets-table">
            <thead>
                <tr>
                    <th>Ticket ID</th>
                    <th>Subject</th>
                    <th>Department</th>
                    <th>Priority</th>
                    <th>Status</th>
                    <th>Date</th>
                    <th style="text-align: center;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($tickets as $ticket)
                <tr onclick="window.location='{{ route('tickets.show', $ticket->id) }}'">
                    <td style="font-weight: 700; color: var(--text-muted); font-size: 0.9rem;">
                        #{{ str_pad($ticket->id, 4, '0', STR_PAD_LEFT) }}
                    </td>
                    <td>
                        <div style="font-weight: 600; color: var(--text); font-size: 0.92rem;">{{ Str::limit($ticket->title, 40) }}</div>
                    </td>
                    <td>
                        <span class="badge-dept">{{ $ticket->department->name ?? 'N/A' }}</span>
                    </td>
                    <td>
                        @if($ticket->priority == 'High')
                            <span class="badge-status badge-priority-high"><i class="fas fa-circle" style="font-size:0.45rem;"></i> High</span>
                        @elseif($ticket->priority == 'Medium')
                            <span class="badge-status badge-priority-medium"><i class="fas fa-circle" style="font-size:0.45rem;"></i> Medium</span>
                        @else
                            <span class="badge-status badge-priority-low"><i class="fas fa-circle" style="font-size:0.45rem;"></i> Low</span>
                        @endif
                    </td>
                    <td>
                        @if($ticket->status == 'Pending')
                            <span class="badge-status badge-pending">⏳ Pending</span>
                        @elseif($ticket->status == 'In Progress')
                            <span class="badge-status badge-progress">🔄 In Progress</span>
                        @elseif($ticket->status == 'Resolved')
                            <span class="badge-status badge-resolved">✅ Resolved</span>
                        @else
                            <span class="badge-status badge-cancelled">✗ Cancelled</span>
                        @endif
                    </td>
                    <td style="font-size: 0.85rem; color: var(--text-muted);">
                        {{ $ticket->created_at->format('M d, Y') }}
                    </td>
                    <td style="text-align: center;" onclick="event.stopPropagation();">
                        <div style="display: flex; gap: 8px; justify-content: center; align-items: center;">
                            <a href="{{ route('tickets.show', $ticket->id) }}"
                               style="background: #f1f5f9; color: var(--text); padding: 7px 14px; border-radius: 8px; text-decoration: none; font-weight: 600; font-size: 0.82rem; white-space: nowrap;">
                                <i class="fas fa-eye"></i> View
                            </a>
                            @if($ticket->status === 'Pending')
                                <form action="{{ route('tickets.cancel', $ticket->id) }}" method="POST"
                                      onsubmit="return confirm('Cancel this ticket?');">
                                    @csrf
                                    <button type="submit"
                                            style="background: #fff1f2; color: #e11d48; border: 1px solid #fda4af; padding: 7px 14px; border-radius: 8px; font-weight: 600; font-size: 0.82rem; cursor: pointer; font-family: inherit; white-space: nowrap;">
                                        <i class="fas fa-times"></i> Cancel
                                    </button>
                                </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" style="padding: 80px; text-align: center;">
                        <div style="font-size: 2.5rem; margin-bottom: 12px;">🔍</div>
                        <div style="font-size: 1rem; font-weight: 600; color: var(--text-muted); margin-bottom: 8px;">No tickets found</div>
                        <a href="{{ route('tickets.create') }}" class="btn-primary-custom" style="font-size: 0.85rem; padding: 10px 20px;">
                            <i class="fas fa-plus"></i> Submit your first report
                        </a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('filterForm');
    const search = form.querySelector('input[name="search"]');
    const selects = form.querySelectorAll('select');

    selects.forEach(s => s.addEventListener('change', () => form.submit()));

    let timer;
    search.addEventListener('keyup', function() {
        clearTimeout(timer);
        timer = setTimeout(() => {
            if (search.value.length > 2 || search.value.length === 0) form.submit();
        }, 500);
    });

    if (search.value.length > 0) {
        search.focus();
        search.setSelectionRange(search.value.length, search.value.length);
    }
});
</script>

@endsection