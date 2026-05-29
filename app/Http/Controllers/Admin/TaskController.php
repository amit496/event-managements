<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\TaskSaveRequest;
use App\Models\Event;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index(Request $request)
    {
        $tasks = Task::with(['event', 'assignee'])
            ->when($request->filled('q'), function ($query) use ($request): void {
                $term = trim((string) $request->input('q'));
                $query->where(function ($inner) use ($term): void {
                    $inner->where('title', 'like', '%'.$term.'%')
                        ->orWhere('status', 'like', '%'.$term.'%')
                        ->orWhere('priority', 'like', '%'.$term.'%')
                        ->orWhereHas('event', fn ($q) => $q->where('title', 'like', '%'.$term.'%'))
                        ->orWhereHas('assignee', fn ($q) => $q->where('name', 'like', '%'.$term.'%'));
                });
            })
            ->latest()
            ->paginate(10)
            ->appends($request->query());

        return view('admin.task.task', [
            'tasks' => $tasks,
            'events' => Event::query()->orderBy('title')->get(),
            'users' => User::query()->orderBy('name')->get(),
            'statuses' => Task::statusOptions(),
            'priorities' => Task::priorityOptions(),
        ]);
    }

    public function store(TaskSaveRequest $request): RedirectResponse
    {
        Task::create($request->validated());

        return back()->with('flash', ['type' => 'success', 'message' => 'Task created successfully.']);
    }

    public function update(TaskSaveRequest $request, Task $task): RedirectResponse
    {
        $task->update($request->validated());

        return back()->with('flash', ['type' => 'success', 'message' => 'Task updated successfully.']);
    }

    public function destroy(Task $task): RedirectResponse
    {
        $task->delete();

        return back()->with('flash', ['type' => 'warning', 'message' => 'Task deleted successfully.']);
    }
}
