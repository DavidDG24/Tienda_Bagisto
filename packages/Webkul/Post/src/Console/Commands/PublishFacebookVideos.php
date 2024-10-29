<?php

namespace Webkul\Post\Console\Commands;

use Illuminate\Console\Command;
use Webkul\Post\Models\FacebookVideo;
use Webkul\Post\Models\FacebookSetting;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Exception;

class PublishFacebookVideos extends Command
{
    protected $signature = 'publish:facebook-videos';
    protected $description = 'Publica videos programados en Facebook y elimina el archivo después de la publicación';

    public function handle()
    {
        $videos = FacebookVideo::where('status', 'pendiente')
                    ->where('publish_time', '<=', Carbon::now())
                    ->get();

        foreach ($videos as $video) {
            try {
                $this->publishToFacebook($video);
                $video->status = 'publicado';
                $video->save();

                Storage::disk('public')->delete($video->video_path);

                $this->info("Video {$video->id} publicado y eliminado correctamente.");
            } catch (Exception $e) {
                $video->status = 'error';
                $video->save();
                $this->error("Error al publicar el video {$video->id}: " . $e->getMessage());
            }
        }
        return 0;
    }

    protected function publishToFacebook(FacebookVideo $video)
    {
        $settings = FacebookSetting::first();

        if (!$settings || !$settings->access_token || !$settings->page_id) {
            throw new Exception("La configuración de Facebook no está completa.");
        }

        $client = new Client();

        $response = $client->post("https://graph.facebook.com/{$settings->page_id}/videos", [
            'form_params' => [
                'access_token' => $settings->access_token,
                'file_url' => Storage::disk('public')->url($video->video_path),
                'description' => $video->description,
                'published' => false,
                'scheduled_publish_time' => strtotime($video->publish_time),
            ],
        ]);

        if ($response->getStatusCode() !== 200) {
            throw new Exception("Error publicando el video en Facebook");
        }
    }
}
