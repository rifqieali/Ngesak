<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-5 py-3 bg-signal border border-transparent rounded-pill font-semibold text-[16px] text-white hover:bg-[#e62e00] focus:outline-none focus-visible:outline-signal transition']) }}>
    {{ $slot }}
</button>
