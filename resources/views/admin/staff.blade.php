@extends('layouts.admin')

@section('content')
<style>
    .main-wrapper { 
        padding: 20px; 
        max-width: 100%; 
    }

    .header-section { 
        display: flex; 
        justify-content: space-between; 
        align-items: center; 
        margin-bottom: 40px; 
    }
    .header-section h1 { 
        font-size: 2.2rem; 
        font-weight: 800; 
        color: #2c3e50; 
    }

    .content-card { 
        background: white; 
        border-radius: 15px; 
        box-shadow: 0 10px 30px rgba(0,0,0,0.08); 
        padding: 10px;
    }

    .staff-table { 
        width: 100%; 
        border-collapse: collapse; 
        font-size: 1.1rem;
    }
    .staff-table th { 
        background: #f8f9fa; 
        padding: 20px; 
        text-align: left; 
        color: #4e73df; 
        text-transform: uppercase; 
        font-size: 0.9rem; 
        letter-spacing: 1px;
    }
    .staff-table td { 
        padding: 25px 20px;
        border-bottom: 1px solid #eee; 
        vertical-align: middle;
    }

    .dept-badge { 
        padding: 8px 16px; 
        font-size: 0.85rem; 
        border-radius: 30px; 
        font-weight: bold; 
    }

    .btn-action { 
        padding: 10px 20px; 
        font-size: 0.9rem; 
        font-weight: 600; 
        border-radius: 8px; 
        transition: 0.3s;
    }
    
    .btn-add {
        font-size: 1.1rem;
        padding: 10px 20px;
        border-radius: 10px;
    }
</style>

<div class="main-wrapper">
    <div class="header-section">
        <h1>Manage Staff</h1>
        <a href="{{ route('admin.staff.create') }}" class="btn-outline-primary btn-add">+ Add New Staff</a>
    </div>

    @if(session('success'))
        <div style="background: #d4edda; color: #155724; padding: 20px; border-radius: 12px; margin-bottom: 30px; font-size: 1.1rem; border-left: 6px solid #28a745;">
            {{ session('success') }}
        </div>
    @endif

    <div class="content-card">
        <table class="staff-table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Department</th>
                    <th>Joined Date</th>
                    <th style="text-align: center;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($staff as $member)
                <tr>
                    <td style="font-weight: bold; color: #333;">{{ $member->name }}</td>
                    <td style="color: #666;">{{ $member->email }}</td>
                    <td>
                        @if($member->department)
                            <span class="dept-badge" style="background: #e3f0fb; color: #4a90e2; border: 1px solid #b3d4f5;">
                                {{ $member->department->name }}
                            </span>
                        @else
                            <span class="dept-badge" style="background: #e9ecef; color: #495057; border: 1px solid #dee2e6;">
                                Unassigned
                            </span>
                        @endif
                    </td>
                    <td style="color: #888;">{{ $member->created_at->format('M d, Y') }}</td>
                    <td>
                        <div style="display: flex; gap: 12px; justify-content: center;">
                            <a href="{{ route('admin.staff.edit', $member->id) }}" 
                               class="btn-action" style="background: #f39c12; color: white; text-decoration: none;">
                                Edit
                            </a>

                            <form action="{{ route('admin.staff.destroy', $member->id) }}" method="POST" onsubmit="return confirm('Delete this staff member?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-action" style="background: #e74c3c; color: white; border: none; cursor: pointer;">
                                    Delete
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" style="text-align: center; padding: 100px; color: #999; font-size: 1.2rem;">
                        No staff members found.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection