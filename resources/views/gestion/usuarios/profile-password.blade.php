@extends('../layouts/' . $layout)

@section('subhead')
    <title>Cambiar Contraseña - ZFP</title>
@endsection

@section('subcontent')
    <div class="intro-y mt-8 flex items-center">
        <h2 class="mr-auto text-lg font-medium">Cambiar Contraseña</h2>
    </div>
    <div class="grid grid-cols-12 gap-6">
        @include('gestion.usuarios.partials._perfil-menu')

        <div class="col-span-12 lg:col-span-8 2xl:col-span-9">
            {{-- Basado en la demo change-password --}}
            <div class="intro-y box lg:mt-5">
                <div class="flex items-center border-b border-slate-200/60 p-5 dark:border-darkmode-400">
                    <h2 class="mr-auto text-base font-medium">Cambiar Contraseña</h2>
                </div>
                <form class="p-5" action="{{ route('profile.password.update') }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div>
                        <x-base.form-label for="current_password">Contraseña actual</x-base.form-label>
                        <x-base.form-input class="w-full {{ $errors->has('current_password') ? 'border-danger' : '' }}" id="current_password" name="current_password" type="password" autocomplete="current-password" required />
                        @error('current_password') <div class="mt-1 text-xs text-danger">{{ $message }}</div> @enderror
                    </div>
                    <div class="mt-3">
                        <x-base.form-label for="password">Nueva contraseña</x-base.form-label>
                        <x-base.form-input class="w-full {{ $errors->has('password') ? 'border-danger' : '' }}" id="password" name="password" type="password" autocomplete="new-password" required />
                        <div class="mt-1 text-xs text-slate-500">Mínimo 8 caracteres.</div>
                        @error('password') <div class="mt-1 text-xs text-danger">{{ $message }}</div> @enderror
                    </div>
                    <div class="mt-3">
                        <x-base.form-label for="password_confirmation">Confirmar nueva contraseña</x-base.form-label>
                        <x-base.form-input class="w-full" id="password_confirmation" name="password_confirmation" type="password" autocomplete="new-password" required />
                    </div>
                    <x-base.button class="mt-4" type="submit" variant="primary">Cambiar Contraseña</x-base.button>
                </form>
            </div>
        </div>
    </div>
@endsection
