@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'border-[#e5e5e5] focus:border-ember focus:ring-ember/25 rounded-pill text-graphite placeholder:text-graphite/40']) }}>
