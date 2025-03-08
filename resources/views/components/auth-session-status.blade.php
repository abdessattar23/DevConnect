@props(['status'])

@if ($status)
    <div {{ $attributes->merge(['class' => 'retro-container !p-4 !border-2 text-yellow-400 font-["Press_Start_2P"] text-sm']) }}>
        {{ $status }}
    </div>
@endif
