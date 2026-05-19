<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>IncidentPortal</title>
    
    <script src="https://cdn.tailwindcss.com"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet">
    
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-[#eef4ff] antialiased">
    <div class="min-h-screen flex flex-col sm:justify-center items-center py-12 px-4">
        
        <div class="w-full sm:max-w-md px-10 py-12 bg-white shadow-[0_10px_40px_rgba(0,0,0,0.04)] rounded-[2.5rem] border border-[#f1f5f9]">
            {{ $slot }}
        </div>
        
    </div>
</body>
</html>