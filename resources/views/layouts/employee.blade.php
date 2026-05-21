<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Portal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary:      #3b82f6;
            --primary-dark: #2563eb;
            --primary-light:#eff6ff;
            --success:      #10b981;
            --warning:      #f59e0b;
            --danger:       #ef4444;
            --sidebar-bg:   #0f172a;
            --sidebar-text: #94a3b8;
            --sidebar-hover:#1e293b;
            --sidebar-active:#3b82f6;
            --bg:           #f1f5f9;
            --text:         #0f172a;
            --text-muted:   #64748b;
            --border:       #e2e8f0;
            --white:        #ffffff;
            --card-shadow:  0 1px 3px rgba(0,0,0,0.08), 0 4px 12px rgba(0,0,0,0.05);
        }

        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: var(--bg);
            color: var(--text);
            display: flex;
            min-height: 100vh;
        }

        /* ── Sidebar ── */
        .sidebar {
            width: 260px;
            height: 100vh;
            background: var(--sidebar-bg);
            position: fixed;
            top: 0; left: 0;
            display: flex;
            flex-direction: column;
            z-index: 100;
            overflow: hidden;
        }

        .sidebar-top {
            padding: 28px 24px 20px;
            border-bottom: 1px solid rgba(255,255,255,0.06);
        }

        .sidebar-brand {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 20px;
        }

        .sidebar-brand-icon {
            width: 38px; height: 38px;
            background: var(--primary);
            border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.1rem;
            color: white;
            flex-shrink: 0;
        }

        .sidebar-brand-text {
            font-size: 0.95rem;
            font-weight: 700;
            color: white;
            line-height: 1.2;
        }

        .sidebar-brand-sub {
            font-size: 0.72rem;
            color: var(--sidebar-text);
            font-weight: 500;
        }

        /* User profile block */
        .sidebar-user {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 12px 14px;
            background: rgba(255,255,255,0.04);
            border-radius: 10px;
        }

        .sidebar-avatar {
            width: 36px; height: 36px;
            background: linear-gradient(135deg, #3b82f6, #8b5cf6);
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            font-size: 0.85rem;
            font-weight: 700;
            color: white;
            flex-shrink: 0;
        }

        .sidebar-user-name {
            font-size: 0.85rem;
            font-weight: 600;
            color: white;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .sidebar-user-role {
            font-size: 0.7rem;
            color: var(--sidebar-text);
        }

        /* Nav */
        .sidebar-nav {
            flex: 1;
            padding: 16px 16px;
            overflow-y: auto;
        }

        .sidebar-nav-label {
            font-size: 0.65rem;
            font-weight: 700;
            color: #475569;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            padding: 0 8px;
            margin: 16px 0 8px;
        }

        .sidebar-nav a {
            display: flex;
            align-items: center;
            gap: 12px;
            color: var(--sidebar-text);
            text-decoration: none;
            padding: 10px 12px;
            border-radius: 8px;
            font-size: 0.88rem;
            font-weight: 500;
            transition: all 0.2s;
            margin-bottom: 2px;
        }

        .sidebar-nav a i {
            width: 18px;
            text-align: center;
            font-size: 0.9rem;
            opacity: 0.7;
        }

        .sidebar-nav a:hover {
            color: white;
            background: var(--sidebar-hover);
        }

        .sidebar-nav a:hover i { opacity: 1; }

        .sidebar-nav a.active {
            color: white;
            background: var(--primary);
            font-weight: 600;
        }

        .sidebar-nav a.active i { opacity: 1; }

        /* Notification badge */
        .nav-badge {
            margin-left: auto;
            background: var(--danger);
            color: white;
            font-size: 0.65rem;
            font-weight: 700;
            padding: 2px 6px;
            border-radius: 20px;
            min-width: 18px;
            text-align: center;
        }

        /* Sidebar bottom */
        .sidebar-bottom {
            padding: 16px;
            border-top: 1px solid rgba(255,255,255,0.06);
        }

        .sidebar-logout {
            display: flex;
            align-items: center;
            gap: 12px;
            width: 100%;
            padding: 10px 12px;
            background: none;
            border: none;
            border-radius: 8px;
            color: #f87171;
            font-size: 0.88rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s;
            font-family: inherit;
        }

        .sidebar-logout:hover {
            background: rgba(239,68,68,0.1);
            color: #ef4444;
        }

        .sidebar-logout i {
            width: 18px;
            text-align: center;
        }

        /* ── Main Content ── */
        .main-content {
            margin-left: 260px;
            width: calc(100% - 260px);
            min-height: 100vh;
            padding: 32px 36px;
        }

        /* ── Top bar ── */
        .topbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 32px;
        }

        .topbar-right {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .topbar-btn {
            width: 40px; height: 40px;
            border-radius: 10px;
            background: white;
            border: 1px solid var(--border);
            display: flex; align-items: center; justify-content: center;
            color: var(--text-muted);
            cursor: pointer;
            transition: all 0.2s;
            text-decoration: none;
            position: relative;
        }

        .topbar-btn:hover {
            background: var(--primary-light);
            border-color: var(--primary);
            color: var(--primary);
        }

        .topbar-notif-dot {
            position: absolute;
            top: 8px; right: 8px;
            width: 8px; height: 8px;
            background: var(--danger);
            border-radius: 50%;
            border: 2px solid white;
        }

        /* ── Cards ── */
        .card-base {
            background: white;
            border-radius: 16px;
            border: 1px solid var(--border);
            box-shadow: var(--card-shadow);
        }

        /* ── Badges ── */
        .badge-status {
            display: inline-flex;
            align-items: center;
            padding: 5px 12px;
            border-radius: 6px;
            font-size: 0.78rem;
            font-weight: 700;
            gap: 5px;
        }

        .badge-pending   { background: #fffbeb; color: #92400e; border: 1px solid #fde68a; }
        .badge-progress  { background: #fff7ed; color: #9a3412; border: 1px solid #fed7aa; }
        .badge-resolved  { background: #f0fdf4; color: #166534; border: 1px solid #bbf7d0; }
        .badge-cancelled { background: #fef2f2; color: #991b1b; border: 1px solid #fecaca; }

        .badge-priority-high   { background: #fef2f2; color: #b91c1c; border: 1px solid #fecaca; }
        .badge-priority-medium { background: #fffbeb; color: #92400e; border: 1px solid #fde68a; }
        .badge-priority-low    { background: #f0fdf4; color: #166534; border: 1px solid #bbf7d0; }

        .badge-dept {
            background: #eff6ff;
            color: #1d4ed8;
            border: 1px solid #bfdbfe;
            display: inline-flex;
            align-items: center;
            padding: 5px 12px;
            border-radius: 6px;
            font-size: 0.78rem;
            font-weight: 700;
        }

        /* ── Submit button ── */
        .btn-primary-custom {
            background: var(--primary);
            color: white;
            padding: 11px 22px;
            border-radius: 10px;
            text-decoration: none;
            font-weight: 600;
            font-size: 0.9rem;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            border: none;
            cursor: pointer;
            transition: all 0.2s;
        }

        .btn-primary-custom:hover {
            background: var(--primary-dark);
            color: white;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(59,130,246,0.35);
        }

        /* ── Scrollbar ── */
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 3px; }
    </style>
</head>
<body>

{{-- ── SIDEBAR ── --}}
<div class="sidebar">
    <div class="sidebar-top">
        <div class="sidebar-brand">
            <div class="sidebar-brand-icon"><i class="fas fa-ticket-alt"></i></div>
            <div>
                <div class="sidebar-brand-sub">Employee Portal</div>
            </div>
        </div>
    </div>

    <nav class="sidebar-nav">
        <div class="sidebar-nav-label">Main Menu</div>

        <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <i class="fas fa-home"></i> Dashboard
        </a>

        <a href="{{ route('tickets.index') }}" class="{{ request()->routeIs('tickets.index') ? 'active' : '' }}">
            <i class="fas fa-list-alt"></i> My Reports
        </a>

        <a href="{{ route('tickets.create') }}" class="{{ request()->routeIs('tickets.create') ? 'active' : '' }}">
            <i class="fas fa-plus-circle"></i> Submit Report
        </a>

       

    <div class="sidebar-bottom">
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="sidebar-logout">
                <i class="fas fa-sign-out-alt"></i> Sign Out
            </button>
        </form>
    </div>
</div>

{{-- ── MAIN CONTENT ── --}}
<div class="main-content">
    @yield('content')
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>