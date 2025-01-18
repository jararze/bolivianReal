<?php

namespace App\Http\Controllers;

use App\Http\Requests\City\StoreRequest;
use App\Http\Requests\City\UpdateRequest;
use App\Models\City;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class CityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $cities = City::all();
        return view('backend.cities.index', compact('cities'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('backend.cities.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request): RedirectResponse
    {

        try {
            DB::transaction(function () use ($request) {
                City::create($request->validated());
            });

            flash()->success('Ciudad creada satisfactoriamente.');

            return redirect()->route($request->action === 'save'
                ? 'backend.cities.index'
                : 'backend.cities.create');

        } catch (ValidationException $ee) {
            return back()->withErrors($ee->errors())->withInput();
        } catch (QueryException $e) {
            flash()->warning('Error de base de datos al crear la ciudad: '.$e->getMessage());
        } catch (\Exception $e) {
            flash()->warning('Ocurrió un error al crear la ciudad: '.$e->getMessage());
        }

        return back()->withInput();
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(City $city): View
    {
        return view('backend.cities.edit', compact('city'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, City $city): RedirectResponse
    {
        try {
            DB::transaction(function () use ($request, $city) {
                $city->update($request->validated());
            });
            flash()->success('Ciudad modificada.');

            return redirect()->route('backend.cities.index');

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
    public function destroy(City $city): RedirectResponse
    {

        try {

            DB::transaction(function () use ($city) {
                $city->delete();
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
