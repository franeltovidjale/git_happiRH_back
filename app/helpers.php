<?php

use App\Models\Setting;

if (!function_exists('getSettings')) {
    /**
     * Retrieve multiple settings in one call, with defaults for missing keys
     *
     * @param array $keys
     * @param array $defaults
     * @return array
     */
    function getSettings(array $keys, array $defaults = []): array
    {
        // Filter out invalid keys
        $validKeys = array_filter($keys, function ($key) {
            return Setting::isValidKey($key);
        });

        if (empty($validKeys)) {
            return [];
        }

        $settings = Setting::whereIn('key', $validKeys)->get()->keyBy('key');
        $result = [];

        foreach ($keys as $key) {
            // Skip invalid keys
            if (!Setting::isValidKey($key)) {
                continue;
            }

            $setting = $settings->get($key);
            $result[$key] = $setting
                ? Setting::parseValue($setting->value, $setting->type)
                : ($defaults[$key] ?? null);
        }

        return $result;
    }
}