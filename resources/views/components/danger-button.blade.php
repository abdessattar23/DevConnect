<button {{ $attributes->merge(['type' => 'submit', 'class' => 'retro-button !bg-red-600 !text-white hover:!bg-red-500 active:!bg-red-700']) }}>
    {{ $slot }}
</button>
