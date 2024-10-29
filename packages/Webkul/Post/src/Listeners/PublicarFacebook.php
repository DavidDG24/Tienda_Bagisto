<?php

namespace Webkul\Post\Listeners;

use Illuminate\Support\Facades\Log;
use Barryvdh\Debugbar\Facades\Debugbar;
use Webkul\Product\Models\Product;
use Webkul\Post\Models\FacebookSetting;
use GuzzleHttp\Client;


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
   
    public function postToFacebook(Product $product)
{   
    // Obtener las configuraciones de Facebook desde la base de datos
    $settings = FacebookSetting::first();
    if (!$settings) {
        Log::warning('No se encontraron configuraciones de Facebook.');
        return;
    }
    $token = $settings->access_token;  
    $pageId = $settings->page_id;
    $message = $settings->default_message;

    if(!$product->is_completed && $settings->status=='active'){
        
        
        if (!isset($product->name) || empty($product->name)) {
            Log::info('El producto no tiene nombre, no se puede publicar: ' . $product->id);
            return;
        }

        $baseUrl = env('APP_URL', 'http://127.0.0.1:8000');
        // Obtener la imagen del producto desde la relación de imágenes
        $productImage = $product->images->first(); // Obtiene la primera imagen del producto
        $imageUrl = $productImage ? $baseUrl . '/cache/medium/' . $productImage->path : null; // Genera la URL completa
            // URL del producto
        $productUrl = $baseUrl . '/' . $product->url_key;     
     
    $client = new Client();
    
    $facebookUrl  = "https://graph.facebook.com/$pageId/feed";   

    try {
        $formParams = [
            'message' => $message .' ' . $product->name,
            'link' => $productUrl, // La URL de produccion del producto fb no acepta urls locales, arrojara error
            'access_token' => $token,
        ];

        // Si hay una imagen disponible, agregamos su URL
        if ($imageUrl) {
            $formParams['url'] = $imageUrl;
        } 
       
        $response = $client->post($facebookUrl, [
            'form_params' => $formParams,
        ]);
              
        $body = $response->getBody()->getContents();
        
        if ($response->getStatusCode() != 200) {
            Log::error('Error publicando en Facebook: Código ' . $response->getStatusCode() . ' - Respuesta: ' . $response->getBody()->getContents());
            throw new \Exception('Hubo un problema al publicar en Facebook. Inténtalo de nuevo más tarde.');
        }

        Log::info('Publicación en Facebook exitosa para el producto: ' . $product->name);        
        // Marcar el producto como completado
        $product = Product::find($product->id);  // Recarga el modelo desde la base de datos para evitar problemas de concurrencia y tener los datos actualizados
        $product->is_completed = true;
        $product->save();         

    } catch (\GuzzleHttp\Exception\RequestException $e) {
        $response = $e->getResponse();
                if ($response) {
                    Log::error('Error en la solicitud HTTP: Código ' . $response->getStatusCode() . ' - Respuesta: ' . $response->getBody()->getContents());
                } else {
                    Log::error('Error en la solicitud HTTP: ' . $e->getMessage());
                }
                throw new \Exception('Hubo un problema de comunicación con Facebook. Inténtalo de nuevo más tarde.');
    }catch (\Exception $e) {
        Log::error('Error inesperado: ' . $e->getMessage());
        throw new \Exception('Hubo un problema al procesar la publicación. Inténtalo de nuevo más tarde.');
    }

    }else{
        Log::info('El producto ya ha sido publicado en Facebook o la configuración de Facebook no está activa: ' . $product->id);
    }
}

}
