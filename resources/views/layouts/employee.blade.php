<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Portal</title>
    <style>
        :root { --primary: #4a90e2; --bg: #f4f7f6; --sidebar: #2c3e50; }
        body { font-family: 'Segoe UI', sans-serif; background: var(--bg); margin: 0; display: flex; }
        
        .sidebar { width: 250px; height: 100vh; background: var(--sidebar); color: white; padding: 20px; position: fixed; }
        .sidebar h2 { font-size: 1.2rem; margin-bottom: 2rem; border-bottom: 1px solid #3e4f5f; padding-bottom: 10px; }
        .sidebar a { display: block; color: #bdc3c7; text-decoration: none; padding: 12px 15px; transition: 0.3s; border-radius: 8px; margin-bottom: 5px; }
        .sidebar a:hover { color: white; background: rgba(255,255,255,0.1); }
        .sidebar a.active { color: white; background: rgba(255,255,255,0.2); font-weight: bold; }

        .main-content { margin-left: 250px; padding: 40px; width: calc(100% - 250px); }
        .content-card { background: white; border-radius: 12px; padding: 25px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); }
        
        /* Matching Table styles from your design */
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th { text-align: left; color: #777; padding: 12px; border-bottom: 2px solid #eee; font-size: 0.85rem; text-transform: uppercase; }
        td { padding: 15px 12px; border-bottom: 1px solid #eee; color: #333; }
        
        .btn-primary { background: var(--primary); color: white; padding: 10px 20px; border-radius: 8px; text-decoration: none; font-size: 0.9rem; font-weight: 500; display: inline-block; }
        .badge { padding: 4px 10px; border-radius: 20px; font-size: 0.75rem; font-weight: bold; }
        .badge-pending { background: #fff3cd; color: #856404; }
        .badge-resolved { background: #d4edda; color: #155724; }
    </style>
</head>
<body>

<div class="sidebar">
    <h2>Employee Portal</h2>
    <!-- Employee specific routes -->
    <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">Dashboard</a>
    <a href="{{ route('tickets.index') }}" class="{{ request()->routeIs('tickets.index') ? 'active' : '' }}">My Tickets</a>
    <a href="{{ route('tickets.create') }}" class="{{ request()->routeIs('tickets.create') ? 'active' : '' }}">New Tickets</a>

    
    
    <form action="{{ route('logout') }}" method="POST" style="margin-top: 20px;">
        @csrf
        <button type="submit" style="background:none; border:none; color:#e74c3c; cursor:pointer; padding: 12px 15px; text-align: left; width: 100%; font-size: 1rem; font-family: inherit;">Logout</button>
    </form>
</div>



<div class="main-content">
    @yield('content')
</div>

</body>
</html>