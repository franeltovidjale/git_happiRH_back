<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settings = [
            [
                'key' => 'logoPath',
                'value' => '/logo.svg',
                'type' => 'public-file',
                'label' => 'Logo Path',
                'description' => 'Path to the application logo',
                'editable' => true,
            ],
            [
                'key' => 'appName',
                'value' => config('app.name'),
                'type' => 'input',
                'label' => 'Application Name',
                'description' => 'Application name displayed throughout the system',
                'editable' => true,
            ],
            [
                'key' => 'authPasswordRequired',
                'value' => '1',
                'type' => 'boolean',
                'label' => 'Require Password for Login',
                'description' => 'Enable password requirement for user authentication',
                'editable' => true,
            ],
            [
                'key' => 'authEnabledOtp',
                'value' => '0',
                'type' => 'boolean',
                'label' => 'Enable OTP Login',
                'description' => 'Enable OTP-based login functionality',
                'editable' => true,
            ],
            [
                'key' => 'signingCodeRequired',
                'value' => '1',
                'type' => 'boolean',
                'label' => 'Require Signing Code',
                'description' => 'Employee must enter a signing code  before registering',
                'editable' => true,
            ],
            [
                'key' => 'autoLogoutDelay',
                'value' => '15',
                'type' => 'number',
                'label' => 'Auto Logout Delay',
                'description' => 'Minutes before automatic logout (default: 15)',
                'editable' => true,
            ],
            [
                'key' => 'notifOnProjetUpdated',
                'value' => '1',
                'type' => 'boolean',
                'label' => 'Project Update Notifications',
                'description' => 'Notify users when projects are updated',
                'editable' => true,
            ],
            [
                'key' => 'notifOnAnnoncement',
                'value' => '1',
                'type' => 'boolean',
                'label' => 'Announcement Notifications',
                'description' => 'Notify users about new announcements',
                'editable' => true,
            ],
            [
                'key' => 'notifOnCalendarEvent',
                'value' => '1',
                'type' => 'boolean',
                'label' => 'Calendar Event Notifications',
                'description' => 'Notify users about calendar events',
                'editable' => true,
            ],
            [
                'key' => 'overtimeRequests',
                'value' => '1',
                'type' => 'boolean',
                'label' => 'Allow Overtime Requests',
                'description' => 'Enable overtime request functionality',
                'editable' => true,
            ],
            [
                'key' => 'leaveRequests',
                'value' => '1',
                'type' => 'boolean',
                'label' => 'Allow Leave Requests',
                'description' => 'Enable leave request functionality',
                'editable' => true,
            ],
            [
                'key' => 'securityAlerts',
                'value' => '1',
                'type' => 'boolean',
                'label' => 'Security Alerts',
                'description' => 'Send security alerts to users',
                'editable' => true,
            ],
            [
                'key' => 'specialOffers',
                'value' => '1',
                'type' => 'boolean',
                'label' => 'Special Offers Notifications',
                'description' => 'Notify users about special offers',
                'editable' => true,
            ],
            [
                'key' => 'feedbackRequests',
                'value' => '1',
                'type' => 'boolean',
                'label' => 'Feedback Requests',
                'description' => 'Request user feedback periodically',
                'editable' => true,
            ],
            [
                'key' => 'defaultLang',
                'value' => 'fr',
                'type' => 'input',
                'label' => 'Default Language',
                'description' => 'Default language code for the application (default: fr)',
                'editable' => true,
            ],
            [
                'key' => 'defaultTheme',
                'value' => 'system',
                'type' => 'input',
                'label' => 'Default Theme',
                'description' => 'Default theme: dark, light, or system',
                'editable' => true,
            ],
            [
                'key' => 'appDescription',
                'value' => 'A comprehensive HR management system for modern workplaces',
                'type' => 'textarea',
                'label' => 'Application Description',
                'description' => 'Detailed description of the application',
                'editable' => true,
            ],
            [
                'key' => 'appSlogan',
                'value' => 'Making HR Happy',
                'type' => 'input',
                'label' => 'Application Slogan',
                'description' => 'Application slogan or tagline',
                'editable' => true,
            ],

            [
                'key' => 'yearlyPlanRate',
                'value' => '0.1',
                'type' => 'number',
                'label' => 'Yearly Plan Discount Rate',
                'description' => 'Discount rate for yearly plans (0.05 = 5% discount)',
                'editable' => true,
            ],

        ];

        foreach ($settings as $settingData) {
            // Only insert if the key is valid
            if (Setting::isValidKey($settingData['key'])) {
                Setting::updateOrCreate(
                    ['key' => $settingData['key']],
                    $settingData
                );
            }
        }
    }
}
