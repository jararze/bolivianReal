<?php

namespace App\Http\Controllers;

use App\Http\Requests\Facility\StoreRequest;
use App\Http\Requests\Facility\UpdateRequest;
use App\Models\Facility;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class FacilityController extends Controller
{
    public function index(): View
    {
        $facilities = Facility::all();
        return view('backend.facilities.index', compact('facilities'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('backend.facilities.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request): RedirectResponse
    {
        try {
            DB::transaction(function () use ($request) {
                Facility::create($request->validated());
            });

            flash()->success('Servicio creado satisfactoriamente.');

            return redirect()->route($request->action === 'save'
                ? 'backend.facilities.index'
                : 'backend.facilities.create');

        } catch (QueryException $e) {
            flash()->warning('Error de base de datos al crear el servicio: '.$e->getMessage());
        } catch (\Exception $e) {
            flash()->warning('Ocurrió un error al crear el servicio: '.$e->getMessage());
        }

        return back()->withInput();
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Facility $facility): View
    {
        return view('backend.facilities.edit', compact('facility'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, Facility $facility): RedirectResponse
    {
        try {
            DB::transaction(function () use ($request, $facility) {
                $facility->update($request->validated());
            });

            flash()->success('Servicio actualizado.');

            return redirect()->route('backend.facilities.index');

        } catch (ValidationException $e) {
            return back()
                ->withErrors($e->errors())
                ->withInput();
        } catch (QueryException $e) {
            flash()->warning('Error de base de datos al actualizar el servicio: '.$e->getMessage());
        } catch (\Exception $e) {
            flash()->warning('Ocurrió un error al actualizar el servicio: '.$e->getMessage());
        }

        return back()->withInput();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Facility $facility): RedirectResponse
    {
        try {
            DB::transaction(function () use ($facility) {
                $facility->delete();
            });
            flash()->success('Servicio borrado satisfactoriamente.');
        } catch (ModelNotFoundException $e) {
            flash()->warning('El servicio no existe.');
        } catch (QueryException $e) {
            flash()->warning('Error de base de datos al borrar el servicio: '.$e->getMessage());
        } catch (\Exception $e) {
            flash()->warning('Ocurrió un error al borrar el servicio: '.$e->getMessage());
        }

        return redirect()->route('backend.facilities.index');
    }
}
