<?php

namespace App\Http\Controllers;

use App\Http\Requests\Package\StoreRequest;
use App\Http\Requests\Package\UpdateRequest;
use App\Models\Package;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class PackageController extends Controller
{
    public function index(): View
    {
        $packages = Package::all();
        return view('backend.packages.index', compact('packages'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('backend.packages.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request): RedirectResponse
    {
        try {
            DB::transaction(function () use ($request) {
                Package::create($request->validated());
            });

            flash()->success('Paquete creado satisfactoriamente.');

            return redirect()->route($request->action === 'save'
                ? 'backend.packages.index'
                : 'backend.packages.create');

        } catch (QueryException $e) {
            flash()->warning('Error de base de datos al crear el paquete: '.$e->getMessage());
        } catch (\Exception $e) {
            flash()->warning('Ocurrió un error al crear el paquete: '.$e->getMessage());
        }

        return back()->withInput();
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Package $package): View
    {
        return view('backend.packages.edit', compact('package'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, Package $package): RedirectResponse
    {
        try {
            DB::transaction(function () use ($request, $package) {
                $package->update($request->validated());
            });

            flash()->success('Paquete actualizado.');

            return redirect()->route('backend.packages.index');

        } catch (ValidationException $e) {
            return back()
                ->withErrors($e->errors())
                ->withInput();
        } catch (QueryException $e) {
            flash()->warning('Error de base de datos al actualizar el paquete: '.$e->getMessage());
        } catch (\Exception $e) {
            flash()->warning('Ocurrió un error al actualizar el paquete: '.$e->getMessage());
        }

        return back()->withInput();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Package $package): RedirectResponse
    {
        try {
            DB::transaction(function () use ($package) {
                $package->delete();
            });
            flash()->success('Paquete borrado satisfactoriamente.');
        } catch (ModelNotFoundException $e) {
            flash()->warning('El paquete no existe.');
        } catch (QueryException $e) {
            flash()->warning('Error de base de datos al borrar el paquete: '.$e->getMessage());
        } catch (\Exception $e) {
            flash()->warning('Ocurrió un error al borrar el paquete: '.$e->getMessage());
        }

        return redirect()->route('backend.packages.index');
    }
}
