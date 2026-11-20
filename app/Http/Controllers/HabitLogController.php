<?php

namespace App\Http\Controllers;

use App\Models\Habit;
use App\Models\HabitLog;
use Illuminate\Http\Request;

class HabitLogController extends Controller
{
    public function index()
    {
        $todayString = today()->toDateString();

        // Eager-load today's log (if any) for each habit so we avoid extra queries
        $habits = Habit::with(['logs' => function ($query) use ($todayString) {
            $query->whereDate('completed_on', $todayString);
        }])
            ->withCount('logs')
            ->latest()
            ->get();

        $completedTodayCount = $habits->filter(fn ($habit) => $habit->logs->isNotEmpty())->count();

        return view('habits.index', compact('habits', 'completedTodayCount', 'todayString'));
    }

    public function storeHabit(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'frequency' => ['required', 'in:Daily,Weekdays'],
        ]);

        Habit::create($validated);

        return redirect()
            ->route('habits.index')
            ->with('status', 'Habit added!');
    }

    public function toggleToday(Habit $habit)
    {
        $todayString = today()->toDateString();

        $existingLog = HabitLog::where('habit_id', $habit->id)
            ->whereDate('completed_on', $todayString)
            ->first();

        if ($existingLog) {
            $existingLog->delete();
            $message = 'Checked off removed for today.';
        } else {
            HabitLog::create([
                'habit_id' => $habit->id,
                'completed_on' => $todayString,
            ]);
            $message = 'Great job! Habit completed for today.';
        }

        return redirect()
            ->route('habits.index')
            ->with('status', $message);
    }

    public function destroyHabit(Habit $habit)
    {
        $habit->delete();

        return redirect()
            ->route('habits.index')
            ->with('status', 'Habit deleted.');
    }
}