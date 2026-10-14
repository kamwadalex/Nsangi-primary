@props(['name', 'class' => ''])

@php
$icon = match($name) {
    'book' => '<svg class="'.$class.'" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/><path d="M8 7h8M8 11h8"/></svg>',
    'building' => '<svg class="'.$class.'" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><rect x="4" y="2" width="16" height="20" rx="1"/><path d="M9 22v-4h6v4M9 6h1M14 6h1M9 10h1M14 10h1M9 14h1M14 14h1"/></svg>',
    'trophy' => '<svg class="'.$class.'" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path d="M6 9H4.5a2.5 2.5 0 0 1 0-5H6M18 9h1.5a2.5 2.5 0 0 0 0-5H18"/><path d="M4 22h16"/><path d="M10 14.66V17c0 .55-.47.98-.97 1.21C7.85 18.75 7 20 7 22"/><path d="M14 14.66V17c0 .55.47.98.97 1.21C16.15 18.75 17 20 17 22"/><path d="M18 2H6v7a6 6 0 0 0 12 0V2z"/></svg>',
    'heart' => '<svg class="'.$class.'" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/></svg>',
    'users' => '<svg class="'.$class.'" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75"/></svg>',
    'music' => '<svg class="'.$class.'" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path d="M9 18V5l12-2v13"/><circle cx="6" cy="18" r="3"/><circle cx="18" cy="16" r="3"/></svg>',
    'calendar' => '<svg class="'.$class.'" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><rect x="3" y="4" width="18" height="18" rx="2"/><path d="M16 2v4M8 2v4M3 10h18"/></svg>',
    'image' => '<svg class="'.$class.'" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><path d="M21 15l-5-5L5 21"/></svg>',
    'user' => '<svg class="'.$class.'" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>',
    'mail' => '<svg class="'.$class.'" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><rect x="2" y="4" width="20" height="16" rx="2"/><path d="M22 7l-10 7L2 7"/></svg>',
    'phone' => '<svg class="'.$class.'" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z"/></svg>',
    'map' => '<svg class="'.$class.'" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path d="M1 6v16l7-4 8 4 7-4V2l-7 4-8-4-7 4z"/><path d="M8 2v16M16 6v16"/></svg>',
    'target' => '<svg class="'.$class.'" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><circle cx="12" cy="12" r="10"/><circle cx="12" cy="12" r="6"/><circle cx="12" cy="12" r="2"/></svg>',
    'compass' => '<svg class="'.$class.'" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><circle cx="12" cy="12" r="10"/><path d="m16.24 7.76-2.12 6.36-6.36 2.12 2.12-6.36 6.36-2.12z"/></svg>',
    'star' => '<svg class="'.$class.'" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87L18.18 22 12 18.56 5.82 22 7 14.14l-5-4.87 6.91-1.01L12 2z"/></svg>',
    'award' => '<svg class="'.$class.'" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><circle cx="12" cy="8" r="6"/><path d="M15.477 12.89L17 22l-5-3-5 3 1.523-9.11"/></svg>',
    'sport' => '<svg class="'.$class.'" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><circle cx="12" cy="12" r="10"/><path d="M12 2a14.5 14.5 0 0 0 0 20 14.5 14.5 0 0 0 0-20M2 12h20"/></svg>',
    'flask' => '<svg class="'.$class.'" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path d="M9 3h6M10 3v6.76L4.5 19.5A1.5 1.5 0 0 0 6 22h12a1.5 1.5 0 0 0 1.5-2.5L14 9.76V3"/><path d="M8.5 14h7"/></svg>',
    'church' => '<svg class="'.$class.'" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path d="M12 2v4M8 6h8M10 6V4h4v2"/><path d="M12 6v4"/><path d="M6 22V10l6-4 6 4v12"/><path d="M6 22h12M9 22v-6h6v6"/></svg>',
    default => '',
};
@endphp

{!! $icon !!}
