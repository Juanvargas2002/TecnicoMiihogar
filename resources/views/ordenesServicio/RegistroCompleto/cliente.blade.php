<section>
    <div class="columns is-multiline">
        <div class="column is-half">
            <div class="field">
                <label class="label">Nombre Completo</label>
                <div class="control">
                    <input class="input" type="text" name="nombre" value="{{ old('nombre') }}"
                        placeholder="Ej: Juan Pérez" @php
                            $metodoRegistro === 'registro_completo' ? 'required' : '';
                        @endphp>
                </div>
                @error('nombre')
                    <p class="help is-danger">{{ $message }}</p>
                @enderror
            </div>
        </div>
        <div class="column is-half">
            <div class="field">
                <label class="label">Documento</label>
                <div class="control">
                    <input class="input" type="text" name="documento" value="{{ old('documento') }}"
                        placeholder="Cédula">
                </div>
                @error('documento')
                    <p class="help is-danger">{{ $message }}</p>
                @enderror
            </div>
        </div>
        <div class="column is-half">
            <div class="field">
                <label class="label">Email</label>
                <div class="control">
                    <input class="input" type="email" name="email" value="{{ old('email') }}"
                        placeholder="cliente@correo.com">
                </div>
                @error('email')
                    <p class="help is-danger">{{ $message }}</p>
                @enderror
            </div>
        </div>
        <div class="column is-half">
            <div class="field">
                <label class="label">Teléfono</label>
                <div class="control">
                    <input class="input" type="text" name="telefono" value="{{ old('telefono') }}"
                        placeholder="+57 300 123 4567">
                </div>
                @error('telefono')
                    <p class="help is-danger">{{ $message }}</p>
                @enderror
            </div>
        </div>
        <div class="column is-full">
            <div class="field">
                <label class="label">Dirección</label>
                <div class="control">
                    <input class="input" type="text" name="direccion" value="{{ old('direccion') }}"
                        placeholder="Calle 123 # 45-67">
                </div>
                @error('direccion')
                    <p class="help is-danger">{{ $message }}</p>
                @enderror
            </div>
        </div>
    </div>
</section>
