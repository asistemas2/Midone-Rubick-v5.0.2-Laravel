@extends('../layouts/' . $layout)

@section('subhead')
    <title>Información Personal - ZFP</title>
@endsection

@section('subcontent')
    <div class="intro-y mt-8 flex items-center">
        <h2 class="mr-auto text-lg font-medium">Información Personal</h2>
    </div>
    <div class="grid grid-cols-12 gap-6">
        @include('gestion.usuarios.partials._perfil-menu')

        <div class="col-span-12 lg:col-span-8 2xl:col-span-9">
            {{-- Basado en "Display Information" de la demo update-profile --}}
            <div class="intro-y box lg:mt-5">
                <div class="flex items-center border-b border-slate-200/60 p-5 dark:border-darkmode-400">
                    <h2 class="mr-auto text-base font-medium">Datos del Usuario</h2>
                </div>
                <form class="p-5" action="{{ route('profile.update') }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="flex flex-col xl:flex-row">
                        <div class="mt-6 flex-1 xl:mt-0">
                            <div class="grid grid-cols-12 gap-x-5 gap-y-3">
                                <div class="col-span-12 2xl:col-span-6">
                                    <x-base.form-label for="first_name">Nombre <span class="text-danger">*</span></x-base.form-label>
                                    <x-base.form-input class="w-full {{ $errors->has('first_name') ? 'border-danger' : '' }}" id="first_name" name="first_name" type="text" value="{{ old('first_name', $user->first_name) }}" required />
                                    @error('first_name') <div class="mt-1 text-xs text-danger">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-span-12 2xl:col-span-6">
                                    <x-base.form-label for="last_name">Apellido <span class="text-danger">*</span></x-base.form-label>
                                    <x-base.form-input class="w-full {{ $errors->has('last_name') ? 'border-danger' : '' }}" id="last_name" name="last_name" type="text" value="{{ old('last_name', $user->last_name) }}" required />
                                    @error('last_name') <div class="mt-1 text-xs text-danger">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-span-12 2xl:col-span-6">
                                    <x-base.form-label for="email">Correo electrónico <span class="text-danger">*</span></x-base.form-label>
                                    <x-base.form-input class="w-full {{ $errors->has('email') ? 'border-danger' : '' }}" id="email" name="email" type="email" value="{{ old('email', $user->email) }}" required />
                                    @error('email') <div class="mt-1 text-xs text-danger">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-span-12 2xl:col-span-6">
                                    <x-base.form-label for="position">Cargo</x-base.form-label>
                                    <x-base.form-input class="w-full {{ $errors->has('position') ? 'border-danger' : '' }}" id="position" name="position" type="text" value="{{ old('position', $user->position) }}" />
                                    @error('position') <div class="mt-1 text-xs text-danger">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-span-12 2xl:col-span-6">
                                    <x-base.form-label for="gender">Género</x-base.form-label>
                                    <x-base.form-select class="w-full" id="gender" name="gender">
                                        <option value="">Seleccionar</option>
                                        @foreach (['male' => 'Masculino', 'female' => 'Femenino', 'other' => 'Otro'] as $valor => $etiqueta)
                                            <option value="{{ $valor }}" {{ old('gender', $user->gender) === $valor ? 'selected' : '' }}>{{ $etiqueta }}</option>
                                        @endforeach
                                    </x-base.form-select>
                                </div>
                            </div>
                            <div class="mt-5 flex">
                                <a href="{{ route('profile.overview') }}">
                                    <x-base.button class="mr-2 w-24" type="button" variant="outline-secondary">Cancelar</x-base.button>
                                </a>
                                <x-base.button class="w-24" type="submit" variant="primary">Guardar</x-base.button>
                            </div>
                        </div>
                        <div class="mx-auto w-52 xl:ml-6 xl:mr-0">
                            <div class="rounded-md border-2 border-dashed border-slate-200/60 p-5 shadow-sm dark:border-darkmode-400">
                                <div class="image-fit relative mx-auto h-40">
                                    <img
                                        class="rounded-md"
                                        src="{{ $user->avatar ?? Vite::asset('resources/images/default-avatar.png') }}"
                                        alt="{{ $user->full_name }}"
                                    />
                                </div>
                                <div class="mt-4 text-center text-xs text-slate-500">
                                    @if ($user->provider)
                                        Foto tomada de tu cuenta de {{ ucfirst($user->provider) }}.
                                    @else
                                        Foto de perfil por defecto.
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
