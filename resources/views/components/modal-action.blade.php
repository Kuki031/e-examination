@props(['text', 'class' => ''])

<button type="button" {{ $attributes->merge(['class' => "strict-confirmation-btn $class"]) }}>
    {{ $text }}
</button>
