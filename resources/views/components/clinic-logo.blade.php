<svg viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg" {{ $attributes }}>
    <defs>
        <linearGradient id="shieldGrad" x1="4" y1="4" x2="44" y2="44" gradientUnits="userSpaceOnUse">
            <stop offset="0%" stop-color="#047857"/>
            <stop offset="100%" stop-color="#065f46"/>
        </linearGradient>
        <linearGradient id="crossGrad" x1="16" y1="16" x2="32" y2="32" gradientUnits="userSpaceOnUse">
            <stop offset="0%" stop-color="#34d399"/>
            <stop offset="100%" stop-color="#10b981"/>
        </linearGradient>
    </defs>
    <!-- Protective Shield Outer -->
    <path d="M24 4L7 11V22C7 33.1 14.3 43.4 24 46C33.7 43.4 41 33.1 41 22V11L24 4Z" fill="url(#shieldGrad)" stroke="#10b981" stroke-width="1.5" stroke-linejoin="round"/>
    <!-- Medical Heartbeat / Cross Emblem Inside -->
    <path d="M24 14V34M14 24H34" stroke="white" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"/>
    <!-- Central Protection Star / Diamond -->
    <circle cx="24" cy="24" r="3.5" fill="#fef08a"/>
</svg>
