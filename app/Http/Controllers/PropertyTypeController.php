<?php

namespace App\Http\Controllers;

use App\Http\Requests\PropertyType\StoreRequest;
use App\Http\Requests\PropertyType\UpdateRequest;
use App\Models\PropertyType;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class PropertyTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $propertyTypes = PropertyType::all();
        return view('backend.property_types.index', compact('propertyTypes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('backend.property_types.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request): RedirectResponse
    {
        try {
            DB::transaction(function () use ($request) {
                PropertyType::create($request->validated());
            });

            flash()->success('Tipo de propiedad creada satisfactoriamente.');

            return redirect()->route($request->action === 'save'
                ? 'backend.property-types.index'
                : 'backend.property-types.create');

        } catch (QueryException $e) {
            flash()->warning('Error de base de datos al crear el tipo de propiedad: '.$e->getMessage());
        } catch (\Exception $e) {
            flash()->warning('Ocurrió un error al crear el tipo de propiedad: '.$e->getMessage());
        }

        return back()->withInput();
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PropertyType $propertyType): View
    {
        return view('backend.property_types.edit', compact('propertyType'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, PropertyType $propertyType): RedirectResponse
    {
        try {
            DB::transaction(function () use ($request, $propertyType) {
                $propertyType->update($request->validated());
            });

            flash()->success('Tipo de propiedad actualizada.');

            return redirect()->route('backend.property-types.index');

        } catch (ValidationException $e) {
            return back()
                ->withErrors($e->errors())
                ->withInput();
        } catch (QueryException $e) {
            flash()->warning('Error de base de datos al actualizar el tipo de propiedad: '.$e->getMessage());
        } catch (\Exception $e) {
            flash()->warning('Ocurrió un error al actualizar el tipo de propiedad: '.$e->getMessage());
        }

        return back()->withInput();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PropertyType $propertyType): RedirectResponse
    {
        try {
            DB::transaction(function () use ($propertyType) {
                $propertyType->delete();
            });
            flash()->success('Tipo de propiedad borrada satisfactoriamente.');
        } catch (ModelNotFoundException $e) {
            flash()->warning('El tipo de propiedad no existe.');
        } catch (QueryException $e) {
            flash()->warning('Error de base de datos al borrar el tipo de propiedad: '.$e->getMessage());
        } catch (\Exception $e) {
            flash()->warning('Ocurrió un error al borrar el tipo de propiedad: '.$e->getMessage());
        }

        return redirect()->route('backend.property_types.index');
    }
}
