<?php

namespace Webkul\Post\Http\Controllers\Admin;


use Webkul\Post\Models\FacebookSetting;
use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Webkul\Post\Models\FacebookVideo;


class FacebookSettingsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $settings=FacebookSetting::first();
        return view('post::admin.facebook-post',compact('settings'));
    }
    public function video()

    {        
        return view('post::admin.facebook-video');
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
    public function updatePost(Request $request)
    {
         
        $request->validate([
            'page_id' => 'required|string',
            'access_token' => 'required|string',
            'default_message' => 'nullable|string',
            'status' => 'sometimes|boolean',
        ]);

        
        $status = $request->has('status') ? 'active' : 'expired';

        $settings = FacebookSetting::firstOrCreate(
            [], // No hay condiciones, solo queremos el primer registro
            [ // Campos que se asignarán si el registro se crea
                'page_id' => $request->input('page_id'),
                'access_token' => $request->input('access_token'),
                'default_message' => $request->input('default_message', ''), // Valor por defecto si está vacío
                'status' => $status,
            ]
        );
        // Si ya existe, actualizamos los valores con los nuevos datos
        if (!$settings->wasRecentlyCreated) {
            $settings->update([
                'page_id' => $request->input('page_id'),
                'access_token' => $request->input('access_token'),
                'default_message' => $request->input('default_message', ''),
                'status' => $status,
            ]);
        }

        // Redirigir de vuelta a la vista con un mensaje de éxito
        return redirect()->route('admin.post.facebook-post.index')
                         ->with('success', 'Configuración actualizada correctamente.');
    }

    public function upVideo (Request $request){
         // Validar los datos del formulario
        $request->validate([
            'video' => 'required|mimes:mp4,mov|max:10240', // Max 10MB
            'description' => 'nullable|string|max:255',
            'publish_time' => 'required|date|after:now',
        ]);
         // Guardar el archivo de video temporalmente
        $videoPath = $request->file('video')->store('facebook_videos', 'public');
        
        $facebookVideo = FacebookVideo::create([
            'video_path' => $videoPath,
            'description' => $request->input('description'),
            'publish_time' => $request->input('publish_time'),
            'status' => 'pendiente',
        ]);
    
        return redirect()->back()->with('success', 'El video se ha guardado y programado correctamente.');
    
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
