<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class ClientController extends Controller
{
    /**
     * Vista principal de clientes
     */
    public function index(Request $request)
    {
        $query = Client::with(['createdBy'])
            ->withCount('properties');

        // Filtros
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                    ->orWhere('lastname', 'LIKE', "%{$search}%")
                    ->orWhere('email', 'LIKE', "%{$search}%")
                    ->orWhere('phone', 'LIKE', "%{$search}%")
                    ->orWhere('ci', 'LIKE', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('client_type')) {
            $query->where('client_type', $request->client_type);
        }

        $clients = $query->orderBy('created_at', 'DESC')->paginate(20);

        // Estadísticas
        $stats = [
            'total' => Client::count(),
            'active' => Client::where('status', true)->count(),
            'inactive' => Client::where('status', false)->count(),
            'with_properties' => Client::has('properties')->count(),
        ];

        return view('backend.clients.index', compact('clients', 'stats'));
    }

    /**
     * Mostrar formulario de creación
     */
    public function create()
    {
        return view('backend.clients.create');
    }

    /**
     * Guardar nuevo cliente
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'lastname' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255|unique:clients,email',
            'phone' => 'nullable|string|max:20',
            'phone_secondary' => 'nullable|string|max:20',
            'ci' => 'nullable|string|max:50|unique:clients,ci',
            'address' => 'nullable|string|max:500',
            'city' => 'nullable|string|max:100',
            'notes' => 'nullable|string',
            'client_type' => 'required|in:owner,buyer,tenant,both',
            'status' => 'required|boolean',
        ]);

        $validated['created_by'] = auth()->id();

        $client = Client::create($validated);

        flash()->success('Cliente creado exitosamente.');
        return redirect()->route('backend.clients.index');
    }

    /**
     * Mostrar detalles del cliente
     */
    public function show(Client $client)
    {
        $client->load(['properties.propertyType', 'properties.citys', 'createdBy']);

        return view('backend.clients.show', compact('client'));
    }

    /**
     * Mostrar formulario de edición
     */
    public function edit(Client $client)
    {
        return view('backend.clients.edit', compact('client'));
    }

    /**
     * Actualizar cliente
     */
    public function update(Request $request, Client $client)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'lastname' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255|unique:clients,email,' . $client->id,
            'phone' => 'nullable|string|max:20',
            'phone_secondary' => 'nullable|string|max:20',
            'ci' => 'nullable|string|max:50|unique:clients,ci,' . $client->id,
            'address' => 'nullable|string|max:500',
            'city' => 'nullable|string|max:100',
            'notes' => 'nullable|string',
            'client_type' => 'required|in:owner,buyer,tenant,both',
            'status' => 'required|boolean',
        ]);

        $client->update($validated);

        flash()->success('Cliente actualizado exitosamente.');
        return redirect()->route('backend.clients.index');
    }

    /**
     * Eliminar cliente
     */
    public function destroy(Client $client)
    {
        // Verificar si tiene propiedades asociadas
        if ($client->properties()->count() > 0) {
            flash()->warning('No se puede eliminar el cliente porque tiene propiedades asociadas.');
            return back();
        }

        $client->delete();

        flash()->success('Cliente eliminado exitosamente.');
        return redirect()->route('backend.clients.index');
    }

    /**
     * Cambiar estado del cliente
     */
    public function toggleStatus(Client $client)
    {
        $client->update(['status' => !$client->status]);

        $message = $client->status ? 'Cliente activado' : 'Cliente desactivado';
        flash()->success($message);

        return back();
    }

    /**
     * API: Buscar clientes
     */
    public function search(Request $request)
    {
        $search = $request->get('q', '');

        $clients = Client::search($search)
            ->active()
            ->limit(10)
            ->get()
            ->map(function($client) {
                return [
                    'id' => $client->id,
                    'full_name' => $client->full_name,
                    'name' => $client->name,
                    'lastname' => $client->lastname,
                    'phone' => $client->phone,
                    'email' => $client->email,
                    'ci' => $client->ci,
                    'address' => $client->address,
                    'city' => $client->city,
                    'notes' => $client->notes,
                ];
            });

        return response()->json($clients);
    }

    /**
     * Guardar o actualizar cliente desde el formulario de propiedad
     */
    public function storeFromProperty(Request $request)
    {
        $validated = $request->validate([
            'client_name' => 'required|string|max:255',
            'client_lastname' => 'nullable|string|max:255',
            'client_phone' => 'nullable|string|max:20',
            'client_email' => 'nullable|email|max:255',
            'client_ci' => 'nullable|string|max:50',
            'client_address' => 'nullable|string|max:500',
            'client_city' => 'nullable|string|max:100',
            'client_notes' => 'nullable|string',
        ]);

        $clientId = $request->input('client_id');

        $clientData = [
            'name' => $validated['client_name'],
            'lastname' => $validated['client_lastname'] ?? null,
            'phone' => $validated['client_phone'] ?? null,
            'email' => $validated['client_email'] ?? null,
            'ci' => $validated['client_ci'] ?? null,
            'address' => $validated['client_address'] ?? null,
            'city' => $validated['client_city'] ?? null,
            'notes' => $validated['client_notes'] ?? null,
            'client_type' => 'owner', // Por defecto
            'created_by' => auth()->id(),
        ];

        if ($clientId) {
            // Actualizar cliente existente
            $client = Client::findOrFail($clientId);
            $client->update($clientData);
        } else {
            // Crear nuevo cliente
            $client = Client::create($clientData);
        }

        return $client;
    }
}
