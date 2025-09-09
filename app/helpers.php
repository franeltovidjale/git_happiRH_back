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

if (!function_exists('encodeModelStatusStory')) {
    function encodeModelStatusStory(string $status, ?string $note, int $statusBy): array
    {
        return [
            'date' => now(),
            'note' => $note,
            'status' => $status,
            'status_by' => $statusBy
        ];
    }
}

if (!function_exists('decodeModelStatusStory')) {
    function decodeModelStatusStory(?array $statusStory): array
    {
        if (!$statusStory) {
            return [];
        }

        return [
            'date' => $statusStory['date'] ?? null,
            'note' => $statusStory['note'] ?? null,
            'status' => $statusStory['status'] ?? null,
            'status_by' => $statusStory['status_by'] ?? null
        ];
    }
}

if (!function_exists('member')) {
    /**
     * Get the current authenticated user's member record for the active enterprise
     *
     * @return \App\Models\Member|null
     */
    function member(array $attributes = ['*']): ?\App\Models\Member
    {
        $user = auth()->user();

        if (!$user || !$user->activeEnterprise) {
            return null;
        }

        return \App\Models\Member::where('user_id', $user->id)
            ->where('enterprise_id', $user->activeEnterprise->id)
            ->latest()
            ->first($attributes);
    }
}

if (!function_exists('isMemberPartOfEnterprise')) {
    /**
     * Check if a member belongs to a specific enterprise
     *
     * @param int $memberId
     * @param int|null $enterpriseId If null, uses the current user's active enterprise
     * @return bool
     */
    function isMemberPartOfEnterprise(int $memberId, ?int $enterpriseId = null): bool
    {
        if (!$enterpriseId) {
            $user = auth()->user();
            
            if (!$user || !$user->activeEnterprise) {
                return false;
            }
            
            $enterpriseId = $user->activeEnterprise->id;
        }

        return \App\Models\Member::where('id', $memberId)
            ->where('enterprise_id', $enterpriseId)
            ->exists();
    }
}
