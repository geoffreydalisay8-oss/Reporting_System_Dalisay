<!DOCTYPE html>
<html lang="en" style="scroll-behavior: smooth;">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700;800&display=swap" rel="stylesheet">
    <style>
        :root { --brand-color: #38bdf8; }
        body { background-color: #050505; color: #e2e8f0; font-family: 'Inter', sans-serif; }
        html { scroll-padding-top: 80px; }
        
        .navbar { background: rgba(5, 5, 5, 0.95); border-bottom: 1px solid #1e293b; padding: 1.5rem 0; }
        .nav-link { color: #94a3b8 !important; font-weight: 500; }
        
        .text-brand { color: var(--brand-color); font-weight: 800; }
        .btn-primary { background-color: var(--brand-color); border: none; padding: 12px 30px; font-weight: 700; }
        .bg-card { background-color: #111827 !important; border: 1px solid #1e293b; }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg fixed-top">
        <div class="container">
            <a class="navbar-brand text-white fw-bold" href="#home">ReportPortal</a>
            <div class="navbar-nav mx-auto">
                <a class="nav-link" href="#home">Home</a>
                <a class="nav-link" href="#about">About</a>
                <a class="nav-link" href="#features">Features</a>
                <a class="nav-link" href="#how-it-works">How it Works</a>
            </div>
            <div>
                <a href="{{ route('login') }}" class="nav-link d-inline me-3">Sign in</a>
                <a href="{{ route('register') }}" class="btn btn-primary rounded-pill">Register</a>
            </div>
        </div>
    </nav>
    <main class="pt-5 mt-5">@yield('content')</main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>