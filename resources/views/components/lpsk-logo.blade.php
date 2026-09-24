<svg viewBox="0 0 120 120" fill="none" xmlns="http://www.w3.org/2000/svg" {{ $attributes }}>
    <defs>
        <!-- Golden Outer Gradient -->
        <linearGradient id="goldBorder" x1="0" y1="0" x2="120" y2="120" gradientUnits="userSpaceOnUse">
            <stop offset="0%" stop-color="#fbbf24"/>
            <stop offset="50%" stop-color="#d97706"/>
            <stop offset="100%" stop-color="#b45309"/>
        </linearGradient>
        <!-- Navy Blue Inner Circle -->
        <linearGradient id="navyInner" x1="15" y1="15" x2="105" y2="105" gradientUnits="userSpaceOnUse">
            <stop offset="0%" stop-color="#1e3a8a"/>
            <stop offset="50%" stop-color="#0f265c"/>
            <stop offset="100%" stop-color="#091838"/>
        </linearGradient>
        <!-- Gold Text & Wreath Gradient -->
        <linearGradient id="goldElem" x1="20" y1="20" x2="100" y2="100" gradientUnits="userSpaceOnUse">
            <stop offset="0%" stop-color="#fef08a"/>
            <stop offset="100%" stop-color="#f59e0b"/>
        </linearGradient>
        <!-- Red Shield Gradient -->
        <linearGradient id="redShield" x1="45" y1="35" x2="75" y2="65" gradientUnits="userSpaceOnUse">
            <stop offset="0%" stop-color="#dc2626"/>
            <stop offset="100%" stop-color="#991b1b"/>
        </linearGradient>
    </defs>

    <!-- Outer Gold Scalloped / Roped Ring -->
    <circle cx="60" cy="60" r="58" stroke="url(#goldBorder)" stroke-width="3.5" fill="#f8fafc"/>
    <circle cx="60" cy="60" r="54" stroke="#d97706" stroke-width="1.2" fill="none" stroke-dasharray="2.5 2"/>

    <!-- Navy Ring Area for Institution Name -->
    <circle cx="60" cy="60" r="50" fill="url(#navyInner)"/>
    <circle cx="60" cy="60" r="50" stroke="url(#goldBorder)" stroke-width="2"/>

    <!-- Text Path Arcs -->
    <path id="upperArc" d="M 18,60 A 42,42 0 1,1 102,60" fill="none"/>
    <path id="lowerArc" d="M 102,60 A 42,42 0 0,1 18,60" fill="none"/>

    <text font-family="'Inter', sans-serif" font-size="7.5" font-weight="900" fill="url(#goldElem)" letter-spacing="1.2">
        <textPath href="#upperArc" startOffset="50%" text-anchor="middle">
            LEMBAGA PERLINDUNGAN
        </textPath>
    </text>
    <text font-family="'Inter', sans-serif" font-size="7.2" font-weight="900" fill="url(#goldElem)" letter-spacing="1.1">
        <textPath href="#lowerArc" startOffset="50%" text-anchor="middle">
            SAKSI DAN KORBAN
        </textPath>
    </text>

    <!-- Inner Golden Border -->
    <circle cx="60" cy="60" r="31" fill="#ffffff" stroke="url(#goldBorder)" stroke-width="2.5"/>

    <!-- Center Emblem: Red & White Merah Putih Shield with Garuda Silhouette -->
    <!-- Red Top Half -->
    <path d="M40 50 Q60 44 80 50 V60 Q60 76 40 60 Z" fill="url(#redShield)"/>
    <!-- White Bottom Half overlay -->
    <path d="M40 57 Q60 62 80 57 V60 Q60 76 40 60 Z" fill="#ffffff"/>
    <path d="M40 50 Q60 44 80 50 V60 Q60 76 40 60 Z" stroke="#b45309" stroke-width="1.2" fill="none"/>

    <!-- Golden Garuda Wings & Star Emblem -->
    <!-- Center 5-pointed star -->
    <path d="M60 49 L61.5 53.5 L66 53.5 L62.5 56 L64 60.5 L60 57.5 L56 60.5 L57.5 56 L54 53.5 L58.5 53.5 Z" fill="#fbbf24" stroke="#d97706" stroke-width="0.5"/>

    <!-- Garuda Wings spread -->
    <path d="M54 54 C48 50 43 53 41 57 C45 57 50 56 53 58 Z" fill="#f59e0b"/>
    <path d="M66 54 C72 50 77 53 79 57 C75 57 70 56 67 58 Z" fill="#f59e0b"/>

    <!-- Golden Ribbon below shield with 'LPSK' -->
    <path d="M43 73 Q60 70 77 73 L75 79 Q60 76 45 79 Z" fill="url(#goldElem)" stroke="#92400e" stroke-width="0.8"/>
    <text x="60" y="77.5" font-family="'Inter', sans-serif" font-size="6.5" font-weight="900" fill="#1e1b4b" text-anchor="middle" letter-spacing="1.2">
        LPSK
    </text>
</svg>
