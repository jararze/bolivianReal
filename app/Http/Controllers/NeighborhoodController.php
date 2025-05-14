<?php

namespace App\Http\Controllers;

use App\Http\Requests\Neighborhood\StoreRequest;
use App\Http\Requests\Neighborhood\UpdateRequest;
use App\Models\City;
use App\Models\Neighborhood;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class NeighborhoodController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $neighborhoods = Neighborhood::all();
        return view('backend.neighborhood.index', compact('neighborhoods'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $cities = City::select(['id', 'name'])->get();
        return view('backend.neighborhood.create', [
            'cities' => $cities,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request): RedirectResponse
    {
        try {
//            dd($request->validated());
            DB::transaction(function () use ($request) {
                $validatedData = $request->validated();

                // Generar el slug a partir del nombre
                $validatedData['slug'] = \Str::slug($validatedData['name']);

                Neighborhood::create($validatedData);
            });

            flash()->success('Ciudad creada satisfactoriamente.');

            return redirect()->route($request->action === 'save'
                ? 'backend.neighborhood.index'
                : 'backend.neighborhood.create');

        } catch (ValidationException $ee) {
            return back()->withErrors($ee->errors())->withInput();
        } catch (QueryException $e) {
            flash()->warning('Error de base de datos al crear el; barrio: '.$e->getMessage());
        } catch (\Exception $e) {
            flash()->warning('Ocurrió un error al crear el barrio: '.$e->getMessage());
        }

        return back()->withInput();
    }

    /**
     * Display the specified resource.
     */
    public function show(Neighborhood $neighborhood)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Neighborhood $neighborhood): View
    {
        // Carga la relación city para asegurar que esté disponible en la vista
        $neighborhood->load('city');

        // Obtén todas las ciudades para el select
        $cities = City::pluck('name', 'id');

        return view('backend.neighborhood.edit', compact('neighborhood', 'cities'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, Neighborhood $neighborhood): RedirectResponse
    {
        try {
            DB::transaction(function () use ($request, $neighborhood) {
                $neighborhood->update($request->validated());
            });
            flash()->success('Barrio modificada.');

            return redirect()->route('backend.neighborhood.index');

        } catch (ValidationException $e) {
            return back()
                ->withErrors($e->errors())
                ->withInput();
        } catch (QueryException $e) {
            flash()->warning('Error de base de datos al actualizar la ciudad: '.$e->getMessage());
        } catch (\Exception $e) {
            flash()->warning('Ocurrió un error al actualizar la ciudad: '.$e->getMessage());
        }

        return back()->withInput();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Neighborhood $neighborhood)
    {
        try {

            DB::transaction(function () use ($neighborhood) {
                $neighborhood->delete();
            });
            flash()->success('Ciudad borrada satisfactoriamente.');
        } catch (ModelNotFoundException $e) {
            flash()->warning('La ciudad no existe.');
        } catch (QueryException $e) {
            flash()->warning('Error de base de datos al borrar la ciudad: '.$e->getMessage());
        } catch (\Exception $e) {
            flash()->warning('Ocurrió un error al borrar la ciudad: '.$e->getMessage());
        }

        return redirect()->route('backend.cities.index');
    }
}
