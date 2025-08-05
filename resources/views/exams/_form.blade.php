
    <div class="exam-form-form-wrap">
        <div>
            <label for="name">Naziv: </label>
            <input type="text" name="name" id="name" autocomplete="off" value="{{ $exam?->name ?? old('name') }}">
        </div>
    </div>
    @error('name')
        <div class="error-div">
            <span>{{ $message }}</span>
        </div>
    @enderror

    <div class="exam-form-form-wrap">
        <div>
            <label for="time_to_solve">Vrijeme trajanja (u min): </label>
            <input type="number" name="time_to_solve" id="time_to_solve" min="10" autocomplete="off" value="{{ $exam?->time_to_solve ?? old('time_to_solve') }}">
        </div>
    </div>
    @error('time_to_solve')
        <div class="error-div">
            <span>{{ $message }}</span>
        </div>
    @enderror

    <div class="exam-form-form-wrap">
        <div>
            <label for="user_id">Kreirao: </label>
            <input type="text" name="user_id" id="user_id" value="{{ auth()->user()->full_name }}" readonly autocomplete="off">
        </div>
    </div>

    @error('user_id')
        <div class="error-div">
            <span>{{ $message }}</span>
        </div>
    @enderror
    <div class="exam-form-form-wrap">
        <div>
            <label for="description">Ostale informacije: </label>
            <textarea cols="50" rows="20" name="description" id="description" spellcheck="false">{{ $exam?->description ?? old('description') }}</textarea>
        </div>
    </div>
