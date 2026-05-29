<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ClientSaveRequest;
use App\Models\Client;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function index(Request $request)
    {
        $clients = Client::query()
            ->when($request->filled('q'), function ($query) use ($request): void {
                $term = trim((string) $request->input('q'));
                $query->where(function ($inner) use ($term): void {
                    $inner->where('name', 'like', '%'.$term.'%')
                        ->orWhere('email', 'like', '%'.$term.'%')
                        ->orWhere('phone', 'like', '%'.$term.'%')
                        ->orWhere('company_name', 'like', '%'.$term.'%');
                });
            })
            ->latest()
            ->paginate(10)
            ->appends($request->query());

        return view('admin.client.client', [
            'clients' => $clients,
        ]);
    }

    public function store(ClientSaveRequest $request): RedirectResponse
    {
        Client::create($request->validated());

        return back()->with('flash', ['type' => 'success', 'message' => 'Client created successfully.']);
    }

    public function update(ClientSaveRequest $request, Client $client): RedirectResponse
    {
        $client->update($request->validated());

        return back()->with('flash', ['type' => 'success', 'message' => 'Client updated successfully.']);
    }

    public function destroy(Client $client): RedirectResponse
    {
        $client->delete();

        return back()->with('flash', ['type' => 'warning', 'message' => 'Client deleted successfully.']);
    }
}
