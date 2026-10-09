<button {{ $attributes->merge(['type' => 'button', 'class' => 'inline-flex items-center px-5 py-3 bg-paper border border-fog rounded-pill font-semibold text-[16px] text-graphite hover:bg-fog focus:outline-none focus-visible:outline-ember transition disabled:opacity-50']) }}>
    {{ $slot }}
</button>
