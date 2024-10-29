<x-admin::layouts>
    <x-slot:title>
        Social Media
    </x-slot:title>

    <div class="page-content min-h-screen flex items-center justify-center bg-gray-100 dark:bg-gray-900 transition-colors duration-300">
        <form method="POST" action="{{ route('admin.facebook-post.update') }}" class="w-full max-w-md p-8 bg-white dark:bg-gray-800 shadow-lg rounded-lg transition-colors duration-300">
            @csrf
            @method('PUT')

            <h2 class="text-2xl font-semibold text-gray-800 dark:text-gray-200 mb-6">Configuración de Facebook para Postear y Subir Videos</h2>

            <div class="mb-4">
                <div class="mb-6 flex items-center">
                    <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mr-4 ">¿Activar configuración para realizar publicaciones? </label>                    
                    <input class="h-5 w-5 mx-6" type="checkbox" name="status" id="status" value="1" {{ isset($settings->status) && $settings->status == 'active' ? 'checked' : '' }}>                   
                    
                </div>
            </div>


            <div class="mb-4">
                <label for="page_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">ID de la Página de Facebook</label>
                <input type="text" name="page_id" id="page_id" class="mt-1 block w-full px-4 py-2 bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-100 border border-gray-300 dark:border-gray-600 rounded-md focus:ring focus:ring-blue-500 focus:border-blue-500 dark:focus:border-blue-500 transition-colors duration-300" value="{{ $settings->page_id ?? '' }}">
            </div>

            <div class="mb-4">
                <label for="access_token" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Token de Acceso</label>
                <input type="text" name="access_token" id="access_token" class="mt-1 block w-full px-4 py-2 bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-100 border border-gray-300 dark:border-gray-600 rounded-md focus:ring focus:ring-blue-500 focus:border-blue-500 dark:focus:border-blue-500 transition-colors duration-300" value="{{ $settings->access_token ?? '' }}">
            </div>

            <div class="mb-6">
                <label for="default_message" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Mensaje por Defecto</label>
                <input type="text" name="default_message" id="default_message" class="mt-1 block w-full px-4 py-2 bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-100 border border-gray-300 dark:border-gray-600 rounded-md focus:ring focus:ring-blue-500 focus:border-blue-500 dark:focus:border-blue-500 transition-colors duration-300" value="{{ $settings->default_message ?? '' }}">
            </div>

            <button type="submit" class="w-full px-4 py-2 text-white bg-blue-600 dark:bg-blue-500 hover:bg-blue-700 dark:hover:bg-blue-600 rounded-md transition-colors duration-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 focus:ring-offset-gray-100 dark:focus:ring-offset-gray-900">
                Guardar Configuración
            </button>
        </form>
    </div>
</x-admin::layouts>
