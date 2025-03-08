<button {{ $attributes->merge(['type' => 'button', 'class' => 'inline-flex items-center px-4 py-2 bg-vintage-cream border border-vintage-border rounded-md font-medium text-vintage-brown hover:text-vintage-dark focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-vintage-accent transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>
