    @extends('layouts.employee')

    @section('content')
    <div style="max-width: 1400px; margin: 0 auto; padding: 20px;">
        
        <!-- Header Section -->
        <div style="margin-bottom: 40px;">
            <h1 style="color: #0f172a; margin: 0; font-size: 2.5rem; font-weight: 800; letter-spacing: -0.025em;">Dashboard Overview</h1>
            <p style="color: #64748b; margin-top: 8px; font-size: 1.1rem;">Welcome back! Here is a summary of your ticket activity.</p>
        </div>

        <!-- 1. Stats Grid (Enhanced Large Cards) -->
        <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 24px; margin-bottom: 50px;">
            
            
            @php
                $stats = [
                    ['label' => 'Total Tickets', 'count' => \App\Models\Ticket::where('user_id', auth()->id())->count(), 'icon' => '🎫', 'bg' => '#eff6ff', 'color' => '#3b82f6'],
                    ['label' => 'Pending', 'count' => \App\Models\Ticket::where('user_id', auth()->id())->where('status', 'Pending')->count(), 'icon' => '🕒', 'bg' => '#fffbeb', 'color' => '#f59e0b'],
                    ['label' => 'In Progress', 'count' => \App\Models\Ticket::where('user_id', auth()->id())->where('status', 'In Progress')->count(), 'icon' => '❗', 'bg' => '#fff7ed', 'color' => '#f97316'],
                    ['label' => 'Resolved', 'count' => \App\Models\Ticket::where('user_id', auth()->id())->where('status', 'Resolved')->count(), 'icon' => '✅', 'bg' => '#f0fdf4', 'color' => '#22c55e'],
                ];
            @endphp

            @foreach($stats as $stat)
            <div class="content-card" style="display: flex; justify-content: space-between; align-items: center; padding: 30px; background: white; border-radius: 16px; border: 1px solid #f1f5f9; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);">
                <div>
                    <p style="color: #64748b; font-size: 1rem; font-weight: 600; margin: 0; text-transform: uppercase; letter-spacing: 0.05em;">{{ $stat['label'] }}</p>
                    <h2 style="font-size: 2.5rem; margin: 10px 0 0 0; color: #0f172a; font-weight: 800;">{{ $stat['count'] }}</h2>
                </div>
                <div style="background: {{ $stat['bg'] }}; width: 60px; height: 60px; display: flex; align-items: center; justify-content: center; border-radius: 12px; font-size: 1.8rem;">
                    {{ $stat['icon'] }}
                </div>
            </div>
            @endforeach
        </div>

        <!-- 2. Recent Tickets Card (Large Table) -->
        <div class="content-card" style="background: white; border-radius: 16px; border: 1px solid #e2e8f0; box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1); overflow: hidden;">
            <div style="padding: 25px 35px; border-bottom: 2px solid #f8fafc; display: flex; justify-content: space-between; align-items: center;">
                <h3 style="margin: 0; color: #0f172a; font-size: 1.4rem; font-weight: 700;">Recent Tickets</h3>
                <a href="{{ route('tickets.index') }}" style="color: #3b82f6; text-decoration: none; font-weight: 600; font-size: 0.95rem;">View All Activity &rarr;</a>
            </div>
            
            <div style="overflow-x: auto;">
                <table style="width: 100%; border-collapse: collapse;">
                    <thead>
                        <tr style="background: #f8fafc;">
                            <th style="padding: 20px 35px; text-align: left; color: #475569; font-size: 0.85rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em;">Ticket ID</th>
                            <th style="padding: 20px 35px; text-align: left; color: #475569; font-size: 0.85rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em;">Subject</th>
                            <th style="padding: 20px 35px; text-align: left; color: #475569; font-size: 0.85rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em;">Category</th>
                            <th style="padding: 20px 35px; text-align: left; color: #475569; font-size: 0.85rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em;">Status</th>
                            <th style="padding: 20px 35px; text-align: left; color: #475569; font-size: 0.85rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em;">Created Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse(\App\Models\Ticket::where('user_id', auth()->id())->latest()->take(5)->get() as $ticket)
                        <tr style="border-bottom: 1px solid #f1f5f9; transition: background 0.2s; cursor: pointer;" 
                            onmouseover="this.style.background='#f8fafc'" 
                            onmouseout="this.style.background='transparent'"
                            onclick="window.location='{{ route('tickets.show', $ticket->id) }}'">
                            
                            <td style="padding: 25px 35px; font-weight: 700; color: #1e293b; font-size: 1rem;">
                                <span style="color: #94a3b8; font-weight: 400;">#</span>{{ str_pad($ticket->id, 4, '0', STR_PAD_LEFT) }}
                            </td>
                            <td style="padding: 25px 35px; color: #0f172a; font-weight: 600; font-size: 1.1rem;">{{ $ticket->title }}</td>
                            <td style="padding: 25px 35px;">
                                <span style="background: #eff6ff; color: #1d4ed8; padding: 6px 14px; border-radius: 8px; font-size: 0.85rem; font-weight: 700; border: 1px solid #dbeafe;">
                                    {{ $ticket->type ?? 'Incident' }}
                                </span>
                            </td>
                            <td style="padding: 25px 35px;">
                                <span style="background: {{ $ticket->status == 'In Progress' ? '#fff7ed' : ($ticket->status == 'Resolved' ? '#f0fdf4' : '#f8fafc') }}; 
                                            color: {{ $ticket->status == 'In Progress' ? '#9a3412' : ($ticket->status == 'Resolved' ? '#166534' : '#64748b') }}; 
                                            padding: 8px 16px; border-radius: 8px; font-size: 0.9rem; font-weight: 700; display: inline-block; min-width: 110px; text-align: center; border: 1px solid {{ $ticket->status == 'In Progress' ? '#ffedd5' : ($ticket->status == 'Resolved' ? '#dcfce7' : '#e2e8f0') }};">
                                    {{ $ticket->status }}
                                </span>
                            </td>
                            <td style="padding: 25px 35px; color: #64748b; font-size: 1rem;">{{ $ticket->created_at->format('M d, Y') }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" style="padding: 80px; text-align: center; color: #94a3b8; font-size: 1.2rem;">
                                No recent activity found. <br>
                                <a href="{{ route('tickets.create') }}" style="color: #3b82f6; text-decoration: none; font-weight: 700;">Submit a new ticket to get started.</a>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @endsection