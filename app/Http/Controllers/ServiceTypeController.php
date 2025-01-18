<?php

namespace App\Http\Controllers;

use App\Http\Requests\ServiceType\StoreRequest;
use App\Http\Requests\ServiceType\UpdateRequest;
use App\Models\ServiceType;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class ServiceTypeController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $serviceType = ServiceType::all();
        return view('backend.service-types.index', compact('serviceType'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('backend.service-types.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request): RedirectResponse
    {
        try {
            DB::transaction(function () use ($request) {
                ServiceType::create($request->validated());
            });

            flash()->success('Tipo de servicio creado satisfactoriamente.');

            return redirect()->route($request->action === 'save'
                ? 'backend.service-types.index'
                : 'backend.service-types.create');

        } catch (QueryException $e) {
            flash()->warning('Error de base de datos al crear el tipo de servicio: '.$e->getMessage());
        } catch (\Exception $e) {
            flash()->warning('Ocurrió un error al crear el tipo de servicio: '.$e->getMessage());
        }

        return back()->withInput();
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ServiceType $serviceType): View
    {
        return view('backend.service-types.edit', compact('serviceType'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, ServiceType $serviceType): RedirectResponse
    {
        try {
            DB::transaction(function () use ($request, $serviceType) {
                $serviceType->update($request->validated());
            });

            flash()->success('Tipo de servicio actualizado.');

            return redirect()->route('backend.service-types.index');

        } catch (ValidationException $e) {
            return back()
                ->withErrors($e->errors())
                ->withInput();
        } catch (QueryException $e) {
            flash()->warning('Error de base de datos al actualizar el tipo de servicio: '.$e->getMessage());
        } catch (\Exception $e) {
            flash()->warning('Ocurrió un error al actualizar el tipo de servicio: '.$e->getMessage());
        }

        return back()->withInput();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ServiceType $serviceType): RedirectResponse
    {
        try {
            DB::transaction(function () use ($serviceType) {
                $serviceType->delete();
            });
            flash()->success('Tipo de propiedad borrada satisfactoriamente.');
        } catch (ModelNotFoundException $e) {
            flash()->warning('El tipo de propiedad no existe.');
        } catch (QueryException $e) {
            flash()->warning('Error de base de datos al borrar el tipo de propiedad: '.$e->getMessage());
        } catch (\Exception $e) {
            flash()->warning('Ocurrió un error al borrar el tipo de propiedad: '.$e->getMessage());
        }

        return redirect()->route('backend.service-types.index');
    }

}
