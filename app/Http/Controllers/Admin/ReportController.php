<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    /**
     * Display the admin reports dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // 1. Top Stat Cards
        $monthlyRevenue = 15500000; // Mock: Rp 15,500,000
        $newEnrolledStudents = 38; // Mock
        $activeTeachers = 3; // Mock

        // 2. Charts Data
        // Line Chart: Student growth over 6 months
        $studentGrowthData = [
            'labels' => ['Oct', 'Nov', 'Dec', 'Jan', 'Feb', 'Mar'],
            'data' => [12, 19, 25, 30, 35, 42]
        ];

        // Pie Chart: Program Popularity
        $programPopularityData = [
            'labels' => ['IELTS Prep', 'TOEFL ITP Prep', 'General English'],
            'data' => [60, 30, 10]
        ];

        // 3. Tables Data
        $topPerformingStudents = [
            ['name' => 'Budi Santoso', 'program' => 'IELTS Prep', 'progress' => '85%', 'score_improvement' => '+2.0 Band'],
            ['name' => 'Siti Aminah', 'program' => 'TOEFL ITP Prep', 'progress' => '90%', 'score_improvement' => '+150 Points'],
            ['name' => 'Ahmad Riza', 'program' => 'IELTS Prep', 'progress' => '75%', 'score_improvement' => '+1.5 Band'],
            ['name' => 'Dewi Lestari', 'program' => 'General English', 'progress' => '80%', 'score_improvement' => 'N/A'],
        ];

        $highestRatedTeachers = [
            ['name' => 'Sarah Johnson', 'specialty' => 'IELTS', 'rating' => 4.9, 'students_active' => 15],
            ['name' => 'Michael Smith', 'specialty' => 'TOEFL', 'rating' => 4.8, 'students_active' => 12],
            ['name' => 'Lisa Wong', 'specialty' => 'General', 'rating' => 4.7, 'students_active' => 11],
        ];

        // 4. Additional Mock Metrics for Detailed Reporting
        $metrics = [
            'financial' => [
                'conversion_rate' => '42%',
            ],
            'academic' => [
                'retention_rate' => '65%',
                'avg_nps' => '4.8/5.0',
            ],
            'teacher' => [
                'grading_time' => '1.5 Days',
                'class_completion' => '98%',
            ],
            'operational' => [
                'peak_hours' => '19:00 - 21:00 WIB',
                'attendance_summary' => 'Students: 92% | Teachers: 99%',
            ]
        ];

        return view('admin.reports.index', compact(
            'monthlyRevenue',
            'newEnrolledStudents',
            'activeTeachers',
            'studentGrowthData',
            'programPopularityData',
            'topPerformingStudents',
            'highestRatedTeachers',
            'metrics'
        ));
    }
}
