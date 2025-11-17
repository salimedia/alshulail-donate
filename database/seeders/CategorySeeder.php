<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            // Project Categories
            [
                'name_ar' => 'تعليم',
                'name_en' => 'Education',
                'slug' => 'education',
                'description_ar' => 'مشاريع تعليمية لدعم الطلاب والمعلمين',
                'description_en' => 'Educational projects to support students and teachers',
                'type' => 'project',
                'icon' => 'book',
                'color' => '#3498db',
                'is_active' => true,
                'display_order' => 1,
            ],
            [
                'name_ar' => 'صحة',
                'name_en' => 'Health',
                'slug' => 'health',
                'description_ar' => 'مشاريع صحية لتوفير الرعاية الطبية',
                'description_en' => 'Health projects to provide medical care',
                'type' => 'project',
                'icon' => 'heart',
                'color' => '#e74c3c',
                'is_active' => true,
                'display_order' => 2,
            ],
            [
                'name_ar' => 'إغاثة',
                'name_en' => 'Relief',
                'slug' => 'relief',
                'description_ar' => 'مشاريع إغاثية للمحتاجين',
                'description_en' => 'Relief projects for those in need',
                'type' => 'project',
                'icon' => 'hands-helping',
                'color' => '#f39c12',
                'is_active' => true,
                'display_order' => 3,
            ],
            [
                'name_ar' => 'تنمية',
                'name_en' => 'Development',
                'slug' => 'development',
                'description_ar' => 'مشاريع تنموية مستدامة',
                'description_en' => 'Sustainable development projects',
                'type' => 'project',
                'icon' => 'leaf',
                'color' => '#27ae60',
                'is_active' => true,
                'display_order' => 4,
            ],
            [
                'name_ar' => 'كفالة يتيم',
                'name_en' => 'Orphan Sponsorship',
                'slug' => 'orphan-sponsorship',
                'description_ar' => 'كفالة الأيتام ورعايتهم',
                'description_en' => 'Sponsoring and caring for orphans',
                'type' => 'project',
                'icon' => 'child',
                'color' => '#9b59b6',
                'is_active' => true,
                'display_order' => 5,
            ],
            [
                'name_ar' => 'كفالة طالب',
                'name_en' => 'Student Sponsorship',
                'slug' => 'student-sponsorship',
                'description_ar' => 'كفالة الطلاب المحتاجين',
                'description_en' => 'Sponsoring students in need',
                'type' => 'project',
                'icon' => 'graduation-cap',
                'color' => '#16a085',
                'is_active' => true,
                'display_order' => 6,
            ],

            // Donation Types
            [
                'name_ar' => 'زكاة',
                'name_en' => 'Zakat',
                'slug' => 'zakat',
                'description_ar' => 'زكاة المال',
                'description_en' => 'Zakat on wealth',
                'type' => 'donation',
                'icon' => 'moon',
                'color' => '#006341',
                'is_active' => true,
                'display_order' => 1,
            ],
            [
                'name_ar' => 'صدقة',
                'name_en' => 'Sadaqah',
                'slug' => 'sadaqah',
                'description_ar' => 'صدقة جارية',
                'description_en' => 'Continuous charity',
                'type' => 'donation',
                'icon' => 'hand-holding-heart',
                'color' => '#FFB81C',
                'is_active' => true,
                'display_order' => 2,
            ],
            [
                'name_ar' => 'وقف',
                'name_en' => 'Waqf',
                'slug' => 'waqf',
                'description_ar' => 'أوقاف خيرية',
                'description_en' => 'Charitable endowment',
                'type' => 'donation',
                'icon' => 'mosque',
                'color' => '#8e44ad',
                'is_active' => true,
                'display_order' => 3,
            ],

            // Beneficiary Types
            [
                'name_ar' => 'أيتام',
                'name_en' => 'Orphans',
                'slug' => 'orphans',
                'description_ar' => 'الأطفال الأيتام',
                'description_en' => 'Orphaned children',
                'type' => 'beneficiary',
                'icon' => 'child',
                'color' => '#e67e22',
                'is_active' => true,
                'display_order' => 1,
            ],
            [
                'name_ar' => 'طلاب',
                'name_en' => 'Students',
                'slug' => 'students',
                'description_ar' => 'الطلاب المحتاجين',
                'description_en' => 'Students in need',
                'type' => 'beneficiary',
                'icon' => 'user-graduate',
                'color' => '#3498db',
                'is_active' => true,
                'display_order' => 2,
            ],
            [
                'name_ar' => 'أسر',
                'name_en' => 'Families',
                'slug' => 'families',
                'description_ar' => 'الأسر المحتاجة',
                'description_en' => 'Families in need',
                'type' => 'beneficiary',
                'icon' => 'users',
                'color' => '#2ecc71',
                'is_active' => true,
                'display_order' => 3,
            ],
        ];

        foreach ($categories as $category) {
            \App\Models\Category::create($category);
        }
    }
}
