<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center justify-center px-5 py-3 bg-ember rounded-pill font-semibold text-[16px] text-white hover:bg-[#e64b05] focus:outline-none focus-visible:outline-ember transition disabled:opacity-50 disabled:cursor-not-allowed']) }}>
    {{ $slot }}
</button>
