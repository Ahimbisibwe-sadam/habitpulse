@extends('layouts.pulse-app')

@section('content')
    <p class="habit-meta" style="margin-bottom: 1rem;">
        Completed today: <strong>{{ $completedTodayCount }} / {{ $habits->count() }}</strong>
    </p>

    <form action="{{ route('habits.store') }}" method="POST" class="habit-form">
        @csrf
        <input
            type="text"
            name="name"
            value="{{ old('name') }}"
            placeholder="New habit (e.g. Read 15 pages)..."
            required
        >

        <select name="frequency">
            <option value="Daily" {{ old('frequency') === 'Daily' ? 'selected' : '' }}>Daily</option>
            <option value="Weekdays" {{ old('frequency') === 'Weekdays' ? 'selected' : '' }}>Weekdays</option>
        </select>

        <button type="submit" class="btn">Add Habit</button>
    </form>

    @if($habits->isEmpty())
        <p class="empty-state">No habits yet. Add your first habit above!</p>
    @else
        <ul class="habit-list">
            @foreach($habits as $habit)
                @php($isDoneToday = $habit->logs->isNotEmpty())
                <li class="habit-row">
                    <div>
                        <strong>{{ $habit->name }}</strong>
                        <div class="habit-meta">
                            <span class="tag">{{ $habit->frequency }}</span>
                            <span>Total check-ins: <strong>{{ $habit->logs_count }}</strong></span>
                        </div>
                    </div>

                    <div class="habit-actions">
                        <form action="{{ route('habits.checkIn', $habit) }}" method="POST">
                            @csrf
                            <button
                                type="submit"
                                class="btn {{ $isDoneToday ? 'btn-done' : '' }}"
                            >
                                {{ $isDoneToday ? 'Completed Today' : 'Check In' }}
                            </button>
                        </form>

                        <form action="{{ route('habits.destroy', $habit) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-delete">Delete</button>
                        </form>
                    </div>
                </li>
            @endforeach
        </ul>
    @endif
@endsection