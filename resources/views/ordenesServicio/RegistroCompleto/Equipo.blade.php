<section>
    <div class="columns is-multiline">
        <div class="column is-half">
            <div class="field">
                <label class="label">Producto</label>
                <div class="control">
                    <input class="input" type="text" name="producto" value="{{ old('producto') }}"
                        placeholder="Ej: Laptop" @php
                            $metodoRegistro === 'registro_completo' ? 'required' : '';
                        @endphp>
                </div>
                @error('producto')
                    <p class="help is-danger">{{ $message }}</p>
                @enderror
            </div>
        </div>
        <div class="column is-half">
            <div class="field">
                <label class="label">Marca</label>
                <div class="control">
                    <input class="input" type="text" name="marca" value="{{ old('marca') }}"
                        placeholder="Ej: HP" @php
                            $metodoRegistro === 'registro_completo' ? 'required' : '';
                        @endphp>
                </div>
                @error('marca')
                    <p class="help is-danger">{{ $message }}</p>
                @enderror
            </div>
        </div>
        <div class="column is-half">
            <div class="field">
                <label class="label">Modelo</label>
                <div class="control">
                    <input class="input" type="text" name="modelo" value="{{ old('modelo') }}"
                        placeholder="Ej: Pavilion 15">
                </div>
                @error('modelo')
                    <p class="help is-danger">{{ $message }}</p>
                @enderror
            </div>
        </div>
        <div class="column is-half">
            <div class="field">
                <label class="label">Serial</label>
                <div class="control">
                    <input class="input" type="text" name="serial" value="{{ old('serial') }}"
                        placeholder="Ej: 5CD12345X">
                </div>
                @error('serial')
                    <p class="help is-danger">{{ $message }}</p>
                @enderror
            </div>
        </div>
        <div class="column is-full">
            <div class="field">
                <label class="label">Descripción del Equipo (Opcional)</label>
                <div class="control">
                    <textarea class="textarea" name="descripcion" placeholder="Detalles físicos, etc.">{{ old('descripcion') }}</textarea>
                </div>
                @error('descripcion')
                    <p class="help is-danger">{{ $message }}</p>
                @enderror
            </div>
        </div>
    </div>
</section>
