<?php

namespace Webkul\Post\Listeners;

use Barryvdh\Debugbar\Facades\Debugbar;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Webkul\Product\Models\Product;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;


class PublicarFacebook
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @return void
     */
    public function handle(Product $event)
    {   
      
        $product = $event;
        $this->postToFacebook($product);
    }
   
    public function postToFacebook(Product $event)
{   
    $product = $event;
    if(!$product->is_completed){

        if (!isset($product->name) || empty($product->name)) {
            dd('El producto no tiene nombre o aún no se ha asignado.');
            Debugbar::error('El producto no tiene nombre o aún no se ha asignado.');
            return;
        }

        $baseUrl = env('APP_URL', 'http://127.0.0.1:8000');
        // Obtener la imagen del producto desde la relación de imágenes
        $productImage = $product->images->first(); // Obtiene la primera imagen del producto
        $imageUrl = $productImage ? $baseUrl . '/cache/medium/' . $productImage->path : null; // Genera la URL completa
            // URL del producto
        $productUrl = $baseUrl . '/' . $product->url_key;

        

    $token = 'EAAPLo1LkdJ4BO5BZAebZCsZBeyI0R8hQXWIMSEXWdtFugx3kc0Swv1qkLHvZBpVHVZBydaxftDHiyONbPmQo6xpJLS9qos0lZB1fGyZAYzaUtjYxBEUdHtD94KbzqvswQB4E9R7ZAAL9MUKjSzLkeSVCOZAiUh18ze4wcZAImT8iAVZCzhWvUBGCopTeU0lM2ZCDbbyBq3SIICJC4Dj2icb8'; // Asegúrate de usar el token correcto
    $pageId = '518962574638826'; // Asegúrate de usar el ID de página correcto

    $client = new \GuzzleHttp\Client();
    
    $facebookUrl  = "https://graph.facebook.com/$pageId/feed";   

    try {
        $formParams = [
            'message' => 'Nuevo producto: ' . $product->name,
            'link' => $productUrl, // La URL del producto
            'access_token' => $token,
        ];

        // Si hay una imagen disponible, agregamos su URL
        if ($imageUrl) {
            $formParams['url'] = $imageUrl;
        }

        $response = $client->post($facebookUrl, [
            'form_params' => $formParams,
        ]);
        $reponse="";

        $body = $response->getBody()->getContents();
        // Verificar el estado de la respuesta
        if ($response->getStatusCode() != 200) {
            Debugbar::error('Error publicando en Facebook. Código: ' . $response->getStatusCode());
        } else {
            Debugbar::info('Publicación en Facebook exitosa para el producto: ' . $product->name);
        }
        

        $product = Product::find($product->id);  // Recarga el modelo desde la base de datos para evitar problemas de concurrencia y tener los datos actualizados
        $product->is_completed = true;
        $product->save();         

    } catch (\Exception $e) {
        Debugbar::error('Excepción al publicar en Facebook');
    }
    }
}

}
