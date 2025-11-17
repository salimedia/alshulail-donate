<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settings = [
            // General Settings
            [
                'key' => 'site_name_ar',
                'value' => 'منصة الشلايل للتبرعات',
                'type' => 'string',
                'group' => 'general',
                'description_ar' => 'اسم الموقع بالعربية',
                'description_en' => 'Site name in Arabic',
                'is_public' => true,
            ],
            [
                'key' => 'site_name_en',
                'value' => 'Al-Shulail Donate',
                'type' => 'string',
                'group' => 'general',
                'description_ar' => 'اسم الموقع بالإنجليزية',
                'description_en' => 'Site name in English',
                'is_public' => true,
            ],
            [
                'key' => 'site_description_ar',
                'value' => 'منصة تبرعات موثوقة لدعم المشاريع الخيرية',
                'type' => 'string',
                'group' => 'general',
                'description_ar' => 'وصف الموقع بالعربية',
                'description_en' => 'Site description in Arabic',
                'is_public' => true,
            ],
            [
                'key' => 'site_description_en',
                'value' => 'A trusted donation platform supporting charitable projects',
                'type' => 'string',
                'group' => 'general',
                'description_ar' => 'وصف الموقع بالإنجليزية',
                'description_en' => 'Site description in English',
                'is_public' => true,
            ],
            [
                'key' => 'contact_email',
                'value' => 'info@alshulail-donate.org',
                'type' => 'string',
                'group' => 'general',
                'description_ar' => 'البريد الإلكتروني للتواصل',
                'description_en' => 'Contact email',
                'is_public' => true,
            ],
            [
                'key' => 'contact_phone',
                'value' => '+966 11 234 5678',
                'type' => 'string',
                'group' => 'general',
                'description_ar' => 'رقم الهاتف للتواصل',
                'description_en' => 'Contact phone',
                'is_public' => true,
            ],

            // Payment Settings
            [
                'key' => 'currency',
                'value' => 'SAR',
                'type' => 'string',
                'group' => 'payment',
                'description_ar' => 'العملة الافتراضية',
                'description_en' => 'Default currency',
                'is_public' => true,
            ],
            [
                'key' => 'minimum_donation',
                'value' => '10',
                'type' => 'integer',
                'group' => 'payment',
                'description_ar' => 'الحد الأدنى للتبرع',
                'description_en' => 'Minimum donation amount',
                'is_public' => true,
            ],
            [
                'key' => 'payment_gateway',
                'value' => 'hyperpay',
                'type' => 'string',
                'group' => 'payment',
                'description_ar' => 'بوابة الدفع الافتراضية',
                'description_en' => 'Default payment gateway',
                'is_public' => false,
            ],
            [
                'key' => 'payment_fee_percentage',
                'value' => '2.5',
                'type' => 'string',
                'group' => 'payment',
                'description_ar' => 'نسبة رسوم الدفع',
                'description_en' => 'Payment fee percentage',
                'is_public' => false,
            ],

            // Donation Settings
            [
                'key' => 'enable_recurring_donations',
                'value' => 'true',
                'type' => 'boolean',
                'group' => 'donation',
                'description_ar' => 'تفعيل التبرعات المتكررة',
                'description_en' => 'Enable recurring donations',
                'is_public' => true,
            ],
            [
                'key' => 'enable_gift_donations',
                'value' => 'true',
                'type' => 'boolean',
                'group' => 'donation',
                'description_ar' => 'تفعيل التبرعات كهدايا',
                'description_en' => 'Enable gift donations',
                'is_public' => true,
            ],
            [
                'key' => 'enable_anonymous_donations',
                'value' => 'true',
                'type' => 'boolean',
                'group' => 'donation',
                'description_ar' => 'تفعيل التبرعات المجهولة',
                'description_en' => 'Enable anonymous donations',
                'is_public' => true,
            ],

            // Email Settings
            [
                'key' => 'send_receipt_email',
                'value' => 'true',
                'type' => 'boolean',
                'group' => 'email',
                'description_ar' => 'إرسال إيصال بالبريد الإلكتروني',
                'description_en' => 'Send receipt via email',
                'is_public' => false,
            ],
            [
                'key' => 'send_gift_notification',
                'value' => 'true',
                'type' => 'boolean',
                'group' => 'email',
                'description_ar' => 'إرسال إشعار الهدية',
                'description_en' => 'Send gift notification',
                'is_public' => false,
            ],

            // Platform Stats (updated dynamically)
            [
                'key' => 'total_donations_count',
                'value' => '0',
                'type' => 'integer',
                'group' => 'stats',
                'description_ar' => 'إجمالي عدد التبرعات',
                'description_en' => 'Total donations count',
                'is_public' => true,
            ],
            [
                'key' => 'total_donations_amount',
                'value' => '0',
                'type' => 'string',
                'group' => 'stats',
                'description_ar' => 'إجمالي مبلغ التبرعات',
                'description_en' => 'Total donations amount',
                'is_public' => true,
            ],
            [
                'key' => 'total_beneficiaries',
                'value' => '0',
                'type' => 'integer',
                'group' => 'stats',
                'description_ar' => 'إجمالي عدد المستفيدين',
                'description_en' => 'Total beneficiaries',
                'is_public' => true,
            ],
            [
                'key' => 'countries_served',
                'value' => '0',
                'type' => 'integer',
                'group' => 'stats',
                'description_ar' => 'عدد الدول المستفيدة',
                'description_en' => 'Countries served',
                'is_public' => true,
            ],

            // Compliance
            [
                'key' => 'organization_license',
                'value' => 'License #123456',
                'type' => 'string',
                'group' => 'compliance',
                'description_ar' => 'رقم ترخيص المنظمة',
                'description_en' => 'Organization license number',
                'is_public' => true,
            ],
            [
                'key' => 'tax_number',
                'value' => '123456789',
                'type' => 'string',
                'group' => 'compliance',
                'description_ar' => 'الرقم الضريبي',
                'description_en' => 'Tax number',
                'is_public' => true,
            ],
        ];

        foreach ($settings as $setting) {
            \App\Models\Setting::create($setting);
        }
    }
}
