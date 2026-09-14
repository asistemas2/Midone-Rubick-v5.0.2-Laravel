@extends('../layouts/' . $layout)

@section('subhead')
    <title>Crear Usuario - ZFP</title>
@endsection

@section('subcontent')
    <div class="intro-y mt-8 flex items-center">
        <h2 class="mr-auto text-lg font-medium">Crear Nuevo Usuario</h2>
    </div>
    <div class="intro-y mt-2 flex items-center text-sm text-slate-500">
        <a href="{{ route('gestion.usuarios.index') }}" class="hover:text-primary">Usuarios</a>
        <x-base.lucide class="mx-2 h-3 w-3" icon="ChevronRight" />
        <span>Crear</span>
    </div>

    <div class="mt-5 grid grid-cols-12 gap-6">
        <div class="intro-y col-span-12 lg:col-span-8">
            <div class="intro-y box p-5">
                <form action="{{ route('gestion.usuarios.store') }}" method="POST">
                    @csrf
                    <div class="border-b border-slate-200/60 pb-4 mb-4">
                        <h3 class="text-base font-medium">Información del Usuario</h3>
                    </div>
                    <div class="grid grid-cols-12 gap-4">
                        <div class="col-span-12 sm:col-span-6">
                            <x-base.form-label for="first_name">Nombre <span class="text-danger">*</span></x-base.form-label>
                            <x-base.form-input class="w-full @error('first_name') border-danger @enderror" id="first_name" name="first_name" type="text" value="{{ old('first_name') }}" required />
                            @error('first_name') <div class="mt-1 text-xs text-danger">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-span-12 sm:col-span-6">
                            <x-base.form-label for="last_name">Apellido <span class="text-danger">*</span></x-base.form-label>
                            <x-base.form-input class="w-full @error('last_name') border-danger @enderror" id="last_name" name="last_name" type="text" value="{{ old('last_name') }}" required />
                            @error('last_name') <div class="mt-1 text-xs text-danger">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-span-12 sm:col-span-6">
                            <x-base.form-label for="email">Email <span class="text-danger">*</span></x-base.form-label>
                            <x-base.form-input class="w-full @error('email') border-danger @enderror" id="email" name="email" type="email" value="{{ old('email') }}" required />
                            @error('email') <div class="mt-1 text-xs text-danger">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-span-12 sm:col-span-6">
                            <x-base.form-label for="position">Cargo</x-base.form-label>
                            <x-base.form-input class="w-full" id="position" name="position" type="text" value="{{ old('position') }}" />
                        </div>
                        <div class="col-span-12 sm:col-span-6">
                            <x-base.form-label for="password">Contraseña <span class="text-danger">*</span></x-base.form-label>
                            <x-base.form-input class="w-full @error('password') border-danger @enderror" id="password" name="password" type="password" required />
                            @error('password') <div class="mt-1 text-xs text-danger">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-span-12 sm:col-span-6">
                            <x-base.form-label for="password_confirmation">Confirmar Contraseña <span class="text-danger">*</span></x-base.form-label>
                            <x-base.form-input class="w-full" id="password_confirmation" name="password_confirmation" type="password" required />
                        </div>
                        <div class="col-span-12 sm:col-span-6">
                            <x-base.form-label for="gender">Género</x-base.form-label>
                            <x-base.form-select class="w-full" id="gender" name="gender">
                                <option value="">Seleccionar</option>
                                <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Masculino</option>
                                <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Femenino</option>
                                <option value="other" {{ old('gender') == 'other' ? 'selected' : '' }}>Otro</option>
                            </x-base.form-select>
                        </div>
                        <div class="col-span-12 sm:col-span-6">
                            <x-base.form-label for="active">Estado</x-base.form-label>
                            <x-base.form-switch class="mt-2">
                                <x-base.form-switch.input type="checkbox" name="active" value="1" {{ old('active', true) ? 'checked' : '' }} />
                                <x-base.form-switch.label>Activo</x-base.form-switch.label>
                            </x-base.form-switch>
                        </div>
                        <div class="col-span-12">
                            <x-base.form-label for="roles">Roles</x-base.form-label>
                            <x-base.form-select class="w-full" id="roles" name="roles[]" multiple>
                                @foreach($roles as $role)
                                    <option value="{{ $role->id }}" {{ in_array($role->id, old('roles', [])) ? 'selected' : '' }}>{{ $role->name }}</option>
                                @endforeach
                            </x-base.form-select>
                            <div class="text-xs text-slate-500 mt-1">Mantén presionada la tecla Ctrl para seleccionar múltiples roles.</div>
                        </div>
                    </div>
                    <div class="mt-5 text-right">
                        <a href="{{ route('gestion.usuarios.index') }}">
                            <x-base.button class="mr-1 w-24" type="button" variant="outline-secondary">Cancelar</x-base.button>
                        </a>
                        <x-base.button class="w-24" type="submit" variant="primary">Guardar</x-base.button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection