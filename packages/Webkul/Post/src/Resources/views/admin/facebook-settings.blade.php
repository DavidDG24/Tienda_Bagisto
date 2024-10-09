<!-- packages/Webkul/Post/src/Resources/views/admin/facebook-settings.blade.php -->
<x-admin::layouts>

    <!-- Title of the page -->
    <x-slot:title>
        Social Media
    </x-slot>
    <!-- Page Content -->
    <div class="page-content">
    <form method="POST" action="{{ route('admin.facebook-settings.update') }}">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="page_id">ID de la Página de Facebook</label>
            <input type="text" name="page_id" id="page_id" class="form-control" value="{{ $settings->page_id ?? '' }}">
        </div>

        <div class="form-group">
            <label for="access_token">Token de Acceso</label>
            <input type="text" name="access_token" id="access_token" class="form-control" value="{{ $settings->access_token ?? '' }}">
        </div>

        <div class="form-group">
            <label for="default_message">Mensaje por Defecto</label>
            <input type="text" name="default_message" id="default_message" class="form-control" value="{{ $settings->default_message ?? '' }}">
        </div>

        <button type="submit" class="btn btn-primary">Guardar Configuración</button>
    </form>
    </div>

</x-admin::layouts>