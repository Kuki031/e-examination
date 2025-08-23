@props(['show', 'subtitle'])

<div class="modal-overlay {{ $show ?? false ? 'active' : '' }}">
    <div class="modal-box">
        <h2 class="modal-title">Želite li izvršiti sljedeću radnju?</h2>
        <p class="modal-subtitle">{{ $subtitle ?? 'generic' }}</p>
        <p style="color: red" class="modal-subtitle alert hidden">UPOZORENJE: Imate neodgovorenih pitanja!</p>
        <div class="modal-actions">
            <button type="submit" class="modal-button confirm">Da</button>
            <button type="button" class="modal-button cancel">Ne</button>
        </div>
    </div>
</div>
