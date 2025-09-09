<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SettingController extends Controller
{
    /**
     * Get all settings as key-value array
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        try {
            $settings = Setting::all();
            $settingsArray = [];

            foreach ($settings as $setting) {
                $settingsArray[$setting->key] = Setting::parseValue($setting->value, $setting->type);
            }

            return $this->ok('Settings retrieved successfully', $settingsArray);
        } catch (\Exception $e) {
            Log::error('Error retrieving settings: '.$e->getMessage());

            return $this->serverError('Failed to retrieve settings', null, $e->getMessage());
        }
    }

    /**
     * Update a setting value
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, string $key)
    {
        try {
            if (! Setting::isValidKey($key)) {
                return $this->badRequest('Invalid setting key');
            }

            $value = $request->input('value');

            if ($value === null) {
                return $this->badRequest('Value is required');
            }

            DB::beginTransaction();

            $success = Setting::setSetting($key, $value);

            if (! $success) {
                DB::rollback();

                return $this->notFound('Setting not found or not editable');
            }

            DB::commit();

            $updatedValue = Setting::getSetting($key);

            return $this->ok('Setting updated successfully', [$key => $updatedValue]);
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Error updating setting: '.$e->getMessage());

            return $this->serverError('Failed to update setting', null, $e->getMessage());
        }
    }
}
