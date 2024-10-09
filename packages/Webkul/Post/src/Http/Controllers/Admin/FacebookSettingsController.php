<?php

namespace Webkul\Post\Http\Controllers\Admin;


use Webkul\Post\Models\FacebookSetting;
use Illuminate\Routing\Controller;
use Illuminate\Http\Request;


class FacebookSettingsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $settings=FacebookSetting::first();
        return view('post::admin.facebook-settings',compact('settings'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'page_id' => 'required|string',
            'access_token' => 'required|string',
            'default_message' => 'nullable|string',
        ]);

        $settings = FacebookSetting::firstOrCreate(
            [], // No hay condiciones, solo queremos el primer registro
            [ // Campos que se asignarán si el registro se crea
                'page_id' => $request->input('page_id'),
                'access_token' => $request->input('access_token'),
                'default_message' => $request->input('default_message', ''), // Valor por defecto si está vacío
            ]
        );
        // Si ya existe, actualizamos los valores con los nuevos datos
        if (!$settings->wasRecentlyCreated) {
            $settings->update([
                'page_id' => $request->input('page_id'),
                'access_token' => $request->input('access_token'),
                'default_message' => $request->input('default_message', ''),
            ]);
        }

        // Redirigir de vuelta a la vista con un mensaje de éxito
        return redirect()->route('admin.facebook-settings.index')
                         ->with('success', 'Configuración actualizada correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
