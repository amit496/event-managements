<?php

namespace Database\Seeders;

use App\Models\Event;
use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Seeder;

class TaskSeeder extends Seeder
{
    public function run(): void
    {
        $events = Event::query()->orderBy('id')->take(20)->get();
        $users = User::query()->orderBy('id')->get();

        if ($events->isEmpty() || $users->isEmpty()) {
            return;
        }

        $taskTitles = [
            'Venue setup confirmation',
            'Catering final headcount',
            'Sound and light testing',
            'Guest registration desk setup',
            'Vendor coordination call',
            'Stage rehearsal run',
            'Final payment follow-up',
            'Post-event wrap-up checklist',
        ];

        $priorities = Task::priorityOptions();
        $statuses = Task::statusOptions();

        foreach ($events as $eventIndex => $event) {
            foreach (range(0, 2) as $offset) {
                $sequence = ($eventIndex * 3) + $offset;
                $title = $taskTitles[$sequence % count($taskTitles)];
                $status = $statuses[$sequence % count($statuses)];
                $dueAt = now()->addDays($eventIndex + $offset + 1)->setTime(10 + ($offset * 2), 0);

                Task::query()->updateOrCreate(
                    ['event_id' => $event->id, 'title' => $title],
                    [
                        'assigned_to' => $users[$sequence % $users->count()]->id,
                        'description' => 'Auto task for event operations workflow.',
                        'priority' => $priorities[$sequence % count($priorities)],
                        'status' => $status,
                        'due_at' => $dueAt,
                        'completed_at' => $status === 'done' ? (clone $dueAt)->subHours(2) : null,
                    ]
                );
            }
        }
    }
}
