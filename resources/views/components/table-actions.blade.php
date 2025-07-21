@props(["success", "failure", "details"])

<div class="table-options">
    <button class="table-options-btn positive">{{ $success }}</button>
    <button class="table-options-btn negative">{{ $failure }}</button>
    <button class="table-options-btn details">{{ $details }}</button>
</div>
