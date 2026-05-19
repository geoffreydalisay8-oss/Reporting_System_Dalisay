<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    
    <!-- Bootstrap 5 for modern UI components -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <style>
        :root { --primary: #4a90e2; --bg: #f8f9fc; --sidebar: #2c3e50; }
        body { font-family: 'Segoe UI', sans-serif; background: var(--bg); margin: 0; }
        
        /* Sidebar Styling */
        .sidebar { width: 250px; height: 100vh; background: var(--sidebar); color: white; padding: 20px; position: fixed; z-index: 100; }
        .sidebar h2 { font-size: 1.1rem; margin-bottom: 2rem; border-bottom: 1px solid rgba(255,255,255,0.1); padding-bottom: 10px; font-weight: bold; }
        .sidebar a { display: block; color: #bdc3c7; text-decoration: none; padding: 12px 15px; transition: 0.3s; border-radius: 8px; margin-bottom: 5px; font-size: 0.9rem; }
        .sidebar a:hover { color: white; background: rgba(255,255,255,0.1); }
        .sidebar a.active { color: white; background: var(--primary); font-weight: bold; }

        /* Main Content Adjustments */
        .main-content { margin-left: 250px; padding: 20px; width: calc(100% - 250px); min-height: 100vh; }
        
        /* Overriding Bootstrap buttons to match your theme */
        .btn-primary { background: var(--primary); border: none; }
        .btn-primary:hover { background: #357abd; }
        
    </style>
</head>
<body>

<div class="sidebar">
    <h2>Reporting System</h2>
    
    <!-- Both Admin and Staff see the Dashboard -->
    <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">Dashboard</a>

    <!-- ONLY Admin can see Manage Staff -->
    @if(Auth::user()->role === 'admin')
        <a href="{{ route('admin.staff.index') }}" class="{{ request()->routeIs('admin.staff.index') ? 'active' : '' }}">Manage Staff</a>
    @endif

    <!-- Both see Tickets (But the Controller will filter the list) -->
    <a href="{{ route('admin.ticket.index') }}">
    {{ Auth::user()->role === 'admin' ? 'All Tickets' : 'My Assigned Tickets' }}
</a>    
    
<a href="{{ route('admin.activity.log') }}" class="{{ request()->routeIs('admin.activity.log') ? 'active' : '' }}">
    Activity Log
</a>


    <form action="{{ route('logout') }}" method="POST" style="margin-top: 20px;">
        @csrf
        <button type="submit" style="background:none; border:none; color:#e74c3c; cursor:pointer; padding: 12px 15px; text-align: left; width: 100%; font-size: 1rem;">Logout</button>
    </form>
</div>

<div class="main-content">
    @yield('content')
</div>

</body>
</html>