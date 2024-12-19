<?php

use Illuminate\Support\Facades\Request;
use Illuminate\Support\Str;

if (! function_exists('active_route')) {
    function active_route(string $route, $active = true, $default = false)
    {
        $current = (string) str(url()->current())->remove(config('app.url'))->trim('/');
        $route = (string) str($route)->trim('/');

        if ($current === $route) {
            return $active;
        }

        return $default;
    }
}

if (! function_exists('is_panel_auth_route')) {
    function is_panel_auth_route(): bool
    {
        $authRoutes = [
            '/login',
            '/password-reset',
            '/register',
            '/email-verification',
        ];

        return Str::of(Request::path())->contains($authRoutes);
    }
}

if (! function_exists('removeEmptyValues')) {
    function removeEmptyValues(array $array): array
    {
        // Applica array_map per garantire la ricorsività su tutti gli elementi
        return array_filter(array_map(function ($value) {
            return is_array($value) ? removeEmptyValues($value) : $value;
        }, $array), function ($value) {
            // Filtra valori vuoti mantenendo 0 e '0' come validi
            return !empty($value) || $value === 0 || $value === '0';
        });
    }
}
