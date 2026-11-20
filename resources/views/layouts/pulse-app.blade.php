<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HabitPulse</title>
    <link rel="stylesheet" href="{{ asset('css/habits.css') }}">
</head>
<body>
    <main class="pulse-shell">
        <header class="pulse-header">
            <div>
                <h1>HabitPulse</h1>
                <p>Build daily momentum one check-in at a time.</p>
            </div>
            <span class="date-pill">{{ $todayString }}</span>
        </header>

        @if(session('status'))
            <div class="flash">{{ session('status') }}</div>
        @endif

        @if($errors->any())
            <div class="error-box">{{ $errors->first() }}</div>
        @endif

        @yield('content')
    </main>
</body>
</html>