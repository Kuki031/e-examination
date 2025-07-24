@props(['search' => 'default'])

<div class="search-bar-wrap">
    <form action="#" method="GET">
        <input class="search-input" type="text" name="search" placeholder="Pretraži {{ $search }}..." autocomplete="off">
    </form>
</div>
