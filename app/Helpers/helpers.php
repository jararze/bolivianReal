<?php

if (!function_exists('site_config')) {
    function site_config($key = null, $default = null)
    {
        try {
            $config = \App\Models\Configuration::where('key', explode('.', $key)[0])
                ->where('status', true)
                ->first();

            if (!$config) return $default;

            // Navegar por arrays anidados
            $value = $config->value;
            $keys = explode('.', $key);
            array_shift($keys);

            foreach ($keys as $nestedKey) {
                $value = $value[$nestedKey] ?? $default;
            }

            return $value ?? $default;
        } catch (\Exception $e) {
            // Log the error if needed
            return $default;
        }
    }
}

if (!function_exists('site_logo')) {
    function site_logo($default = '/default-logo.png')
    {
        return site_config('appearance_settings.logo.path', $default);
    }
}

if (!function_exists('site_phone')) {
    function site_phone($default = '')
    {
        return site_config('general_info.phone', $default);
    }
}
