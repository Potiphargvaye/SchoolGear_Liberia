@php
    $initials = '';
    $name = trim($user->name);
    if (!empty($name)) {
        $words = preg_split('/\s+/', $name);
        foreach ($words as $word) {
            $initials .= strtoupper(substr($word, 0, 1));
            if (strlen($initials) >= 2) break;
        }
    }
@endphp
<span class="text-gray-500 text-xs">{{ $initials ?: '?' }}</span>
