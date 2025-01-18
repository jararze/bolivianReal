<?php

namespace App\Http\Controllers;

use App\Http\Requests\Amenity\StoreAmenityRequest;
use App\Http\Requests\Amenity\UpdateAmenityRequest;
use App\Models\Amenity;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class AmenityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $amenities = Amenity::all();
        return view('backend.amenities.index', compact('amenities'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('backend.amenities.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAmenityRequest $request): RedirectResponse
    {
        try {
            DB::transaction(function () use ($request) {
                Amenity::create($request->validated());
            });

            flash()->success('Amenity creada satisfactoriamente.');

            return redirect()->route($request->action === 'save'
                ? 'backend.amenities.index'
                : 'backend.amenities.create');

        } catch (ValidationException $ee) {
            return back()->withErrors($ee->errors())->withInput();
        } catch (QueryException $e) {
            flash()->warning('Error de base de datos al crear el amenitie: '.$e->getMessage());
        } catch (\Exception $e) {
            flash()->warning('Ocurrió un error al crear el amenitie: '.$e->getMessage());
        }

        return back()->withInput();
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Amenity $amenity): View
    {
        return view('backend.amenities.edit', compact('amenity'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAmenityRequest $request, Amenity $amenity): RedirectResponse
    {
        try {

            DB::transaction(function () use ($request, $amenity) {

                $amenity->update($request->validated());

            });
            flash()->success('Amenity actualizada.');

            return redirect()->route('backend.amenities.index');


        } catch (ValidationException $e) {
            return back()
                ->withErrors($e->errors())
                ->withInput();
        } catch (QueryException $e) {
            flash()->warning('Error de base de datos al actualizar el amenity: '.$e->getMessage());
        } catch (\Exception $e) {
            flash()->warning('Ocurrió un error al actualizar el amenity: '.$e->getMessage());
        }

        return back()->withInput();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Amenity $amenity): RedirectResponse
    {

        try {
            DB::transaction(function () use ($amenity) {
                $amenity->delete();
            });

            flash()->success('Tipo de propiedad borrada satisfactoriamente.');
        } catch (ModelNotFoundException $e) {
            flash()->warning('El amenity no existe.');
        } catch (QueryException $e) {
            flash()->warning('Error de base de datos al borrar amenity: '.$e->getMessage());
        } catch (\Exception $e) {
            flash()->warning('Ocurrió un error al borrar amenity: '.$e->getMessage());
        }

        return redirect()->route('backend.amenities.index');
    }
}
