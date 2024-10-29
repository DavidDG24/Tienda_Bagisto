<x-admin::layouts>
    <x-slot:title>
        Facebook Video
    </x-slot:title>

      <!-- Cargar CSS y JS con Vite -->
    @vite('packages/Webkul/Post/src/Resources/assets/css/fbvideo.css')
  

    <div class="page-content min-h-screen flex items-center justify-center bg-gray-100 dark:bg-gray-900 transition-colors duration-300 px-4 sm:px-6 lg:px-8">
        <form method="POST" action="{{ route('admin.facebook-video.up') }}" enctype="multipart/form-data" class="w-full max-w-lg p-6 sm:p-8 bg-white dark:bg-gray-800 shadow-lg rounded-lg transition-colors duration-300">
            @csrf
            
            <h2 class="text-xl sm:text-2xl font-semibold text-gray-800 dark:text-gray-200 mb-4 sm:mb-6 text-center">Subir Reels para Facebook Programado</h2>
            
            <div class="mb-4">
                <p><span class="text-red-500">*</span> <small class="text-gray-500 dark:text-gray-400">Recuerda haber configurado tus tokens y el ID de tu página de Facebook</small></p>
            </div>
            
            <!-- Video Upload Input -->
            <div class="mb-4 max-w-sm">
                <label for="video" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Selecciona un video (MP4 o MOV, máximo 1 minuto)</label>
                <input type="file" name="video" id="video" accept="video/mp4,video/mov" class="mt-1 block w-full text-gray-800 dark:text-gray-100 bg-gray-100 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md focus:ring-blue-500 focus:border-blue-500 dark:focus:border-blue-500 transition-colors duration-300" onchange="previewVideo(event)">
            </div>

            <!-- Video Preview -->
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Vista previa del video</label>
                <video id="videoPreview" class="w-full max-w-xs sm:max-w-sm md:max-w-md lg:max-w-lg xl:max-w-xl rounded-md border border-gray-300 dark:border-gray-600" controls style="display: none;"></video>
            </div>

            <!-- Publication Date and Time -->
            <div class="mb-4">
                <label for="publish_time" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Fecha y hora de publicación</label>
                <input type="datetime-local" name="publish_time" id="publish_time" class="mt-1 block w-full px-4 py-2 bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-100 border border-gray-300 dark:border-gray-600 rounded-md focus:ring focus:ring-blue-500 focus:border-blue-500 dark:focus:border-blue-500 transition-colors duration-300">
            </div>

            <!-- un input para agregar una descripcion a los videos -->
            <div class="mb-4">
                <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Descripción del video</label>
                <textarea name="description" id="description" class="mt-1 block w-full px-4 py-2 bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-100 border border-gray-300 dark:border-gray-600 rounded-md focus:ring focus:ring-blue-500 focus:border-blue-500 dark:focus:border-blue-500 transition-colors duration-300" rows="4" cols="20"></textarea> 
            </div> 

            <button type="submit" class="w-full px-4 py-2 text-white bg-blue-600 dark:bg-blue-500 hover:bg-blue-700 dark:hover:bg-blue-600 rounded-md transition-colors duration-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 focus:ring-offset-gray-100 dark:focus:ring-offset-gray-900">
                Subir y Programar Publicación
            </button>
        </form>
    </div>
    @vite('packages/Webkul/Post/src/Resources/assets/js/fbvideo.js')
</x-admin::layouts>
