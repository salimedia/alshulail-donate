<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get categories
        $educationCategory = \App\Models\Category::where('slug', 'education')->first();
        $healthCategory = \App\Models\Category::where('slug', 'health')->first();
        $reliefCategory = \App\Models\Category::where('slug', 'relief')->first();
        $orphanCategory = \App\Models\Category::where('slug', 'orphan-sponsorship')->first();
        $studentCategory = \App\Models\Category::where('slug', 'student-sponsorship')->first();

        $projects = [
            [
                'title_ar' => 'بناء مدرسة في اليمن',
                'title_en' => 'Build a School in Yemen',
                'description_ar' => 'مشروع لبناء مدرسة تعليمية في المناطق المحتاجة في اليمن لخدمة 500 طالب وطالبة',
                'description_en' => 'A project to build an educational school in needed areas in Yemen to serve 500 male and female students',
                'slug' => 'build-school-yemen',
                'target_amount' => 500000,
                'raised_amount' => 325000,
                'donors_count' => 156,
                'category_id' => $educationCategory->id,
                'status' => 'active',
                'location_country' => 'Yemen',
                'location_region' => 'Sana\'a',
                'location_city' => 'Sana\'a',
                'expected_beneficiaries_count' => 500,
                'actual_beneficiaries_count' => 0,
                'expected_impact_ar' => 'توفير تعليم جيد لـ 500 طالب وطالبة في المناطق المحرومة',
                'expected_impact_en' => 'Providing quality education for 500 students in underserved areas',
                'start_date' => now()->subDays(30),
                'end_date' => now()->addDays(60),
                'is_featured' => true,
                'is_urgent' => false,
                'display_order' => 1,
            ],
            [
                'title_ar' => 'كفالة 100 يتيم',
                'title_en' => 'Sponsor 100 Orphans',
                'description_ar' => 'كفالة شهرية لـ 100 يتيم في سوريا لتوفير احتياجاتهم الأساسية من مأكل ومسكن وتعليم',
                'description_en' => 'Monthly sponsorship for 100 orphans in Syria to provide their basic needs including food, shelter, and education',
                'slug' => 'sponsor-100-orphans',
                'target_amount' => 360000,
                'raised_amount' => 180000,
                'donors_count' => 89,
                'category_id' => $orphanCategory->id,
                'status' => 'active',
                'location_country' => 'Syria',
                'location_region' => 'Idlib',
                'location_city' => 'Idlib',
                'expected_beneficiaries_count' => 100,
                'actual_beneficiaries_count' => 50,
                'expected_impact_ar' => 'رعاية شاملة لـ 100 يتيم وتوفير مستقبل أفضل لهم',
                'expected_impact_en' => 'Comprehensive care for 100 orphans and providing them with a better future',
                'start_date' => now()->subDays(15),
                'end_date' => now()->addDays(45),
                'is_featured' => true,
                'is_urgent' => true,
                'display_order' => 2,
            ],
            [
                'title_ar' => 'مستشفى ميداني في غزة',
                'title_en' => 'Field Hospital in Gaza',
                'description_ar' => 'إنشاء مستشفى ميداني لتوفير الرعاية الصحية الطارئة للمصابين والمرضى في غزة',
                'description_en' => 'Establishing a field hospital to provide emergency healthcare for the injured and sick in Gaza',
                'slug' => 'field-hospital-gaza',
                'target_amount' => 1000000,
                'raised_amount' => 750000,
                'donors_count' => 342,
                'category_id' => $healthCategory->id,
                'status' => 'active',
                'location_country' => 'Palestine',
                'location_region' => 'Gaza',
                'location_city' => 'Gaza City',
                'expected_beneficiaries_count' => 10000,
                'actual_beneficiaries_count' => 5000,
                'expected_impact_ar' => 'إنقاذ حياة الآلاف وتوفير رعاية طبية عاجلة',
                'expected_impact_en' => 'Saving thousands of lives and providing urgent medical care',
                'start_date' => now()->subDays(45),
                'end_date' => now()->addDays(15),
                'is_featured' => true,
                'is_urgent' => true,
                'display_order' => 3,
            ],
            [
                'title_ar' => 'إفطار صائم - رمضان 2025',
                'title_en' => 'Feed a Fasting Person - Ramadan 2025',
                'description_ar' => 'توفير وجبات إفطار للصائمين المحتاجين في شهر رمضان المبارك',
                'description_en' => 'Providing iftar meals for fasting people in need during the blessed month of Ramadan',
                'slug' => 'iftar-ramadan-2025',
                'target_amount' => 250000,
                'raised_amount' => 45000,
                'donors_count' => 67,
                'category_id' => $reliefCategory->id,
                'status' => 'active',
                'location_country' => 'Multiple',
                'location_region' => 'Middle East',
                'location_city' => 'Various Cities',
                'expected_beneficiaries_count' => 5000,
                'actual_beneficiaries_count' => 0,
                'expected_impact_ar' => 'إطعام 5000 صائم يومياً طوال شهر رمضان',
                'expected_impact_en' => 'Feeding 5000 fasting people daily throughout Ramadan',
                'start_date' => now(),
                'end_date' => now()->addDays(90),
                'is_featured' => false,
                'is_urgent' => false,
                'display_order' => 4,
            ],
            [
                'title_ar' => 'كفالة طلاب العلم',
                'title_en' => 'Sponsor Students of Knowledge',
                'description_ar' => 'كفالة طلاب العلم الشرعي في الجامعات الإسلامية لمدة عام دراسي كامل',
                'description_en' => 'Sponsoring Islamic knowledge students in Islamic universities for a full academic year',
                'slug' => 'sponsor-knowledge-students',
                'target_amount' => 150000,
                'raised_amount' => 95000,
                'donors_count' => 45,
                'category_id' => $studentCategory->id,
                'status' => 'active',
                'location_country' => 'Saudi Arabia',
                'location_region' => 'Madinah',
                'location_city' => 'Madinah',
                'expected_beneficiaries_count' => 50,
                'actual_beneficiaries_count' => 30,
                'expected_impact_ar' => 'تخريج 50 طالب علم شرعي يخدمون المجتمع',
                'expected_impact_en' => 'Graduating 50 Islamic knowledge students to serve the community',
                'start_date' => now()->subDays(60),
                'end_date' => now()->addDays(30),
                'is_featured' => false,
                'is_urgent' => false,
                'display_order' => 5,
            ],
            [
                'title_ar' => 'حفر آبار ماء في أفريقيا',
                'title_en' => 'Digging Water Wells in Africa',
                'description_ar' => 'حفر 20 بئر ماء في القرى الأفريقية الفقيرة لتوفير مياه نظيفة للشرب',
                'description_en' => 'Digging 20 water wells in poor African villages to provide clean drinking water',
                'slug' => 'water-wells-africa',
                'target_amount' => 200000,
                'raised_amount' => 145000,
                'donors_count' => 98,
                'category_id' => $reliefCategory->id,
                'status' => 'active',
                'location_country' => 'Somalia',
                'location_region' => 'South',
                'location_city' => 'Multiple Villages',
                'expected_beneficiaries_count' => 10000,
                'actual_beneficiaries_count' => 6000,
                'expected_impact_ar' => 'توفير مياه نظيفة لـ 10000 شخص في القرى الأفريقية',
                'expected_impact_en' => 'Providing clean water for 10,000 people in African villages',
                'start_date' => now()->subDays(90),
                'end_date' => now()->addDays(10),
                'is_featured' => false,
                'is_urgent' => false,
                'display_order' => 6,
            ],
        ];

        foreach ($projects as $project) {
            \App\Models\Project::create($project);
        }
    }
}
