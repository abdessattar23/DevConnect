@props(['value' => '', 'required' => false])

<label {{ $attributes->merge(['class' => 'block font-medium text-vintage-dark mb-1']) }}>
    {{ $value ?? $slot }}
    @if($required)
        <span class="text-vintage-brown">*</span>
    @endif
</label>
