@props(['session_variable'])

@if (session()->has("$session_variable"))
    <span {{ $attributes->merge(['class' => 'text-sm text-black dark:text-white space-y-1']) }}>
        {{ session("$session_variable") }}
    </span>
@endif
