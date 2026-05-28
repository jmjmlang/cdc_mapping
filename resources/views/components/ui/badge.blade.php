@props(['status' => 'pending'])

@php
$colors = match($status) {
    'approved'  => 'bg-emerald-100 text-emerald-800',
    'rejected'  => 'bg-rose-100 text-rose-800',
    'deleted'   => 'bg-rose-100 text-rose-800',
    'pending'   => 'bg-amber-100 text-amber-800',
    'Critical'  => 'bg-rose-100 text-rose-800',
    'High'      => 'bg-orange-100 text-orange-800',
    'Moderate'  => 'bg-amber-100 text-amber-800',
    'Low'       => 'bg-emerald-100 text-emerald-800',
    default     => 'bg-gray-100 text-gray-700',
};
@endphp

<span {{ $attributes->class(["inline-flex items-center justify-center px-2.5 py-0.5 text-xs font-semibold rounded-md whitespace-nowrap", $colors]) }}>
    {{ ucfirst($status) }}
</span>
