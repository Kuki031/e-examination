@props(['show', 'subtitle', 'confirmAction', 'method'])

<div class="modal-overlay {{ $show ?? false ? 'active' : '' }}">
    <div class="modal-box">
        <h2 class="modal-title">Želite li izvršiti sljedeću radnju?</h2>
        <p class="modal-subtitle">{{ $subtitle ?? 'generic' }}</p>

        <div class="modal-actions">
            <form method="POST" action="{{ $confirmAction }}">
                @csrf
                @method($method)
                <button type="submit" class="modal-button confirm">Da</button>
            </form>
            <button type="button" class="modal-button cancel">Ne</button>
        </div>
    </div>
</div>
