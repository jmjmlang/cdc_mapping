<?php

namespace Database\Seeders;

use App\Models\Barangay;
use App\Models\CaseReport;
use App\Models\HealthCategory;
use App\Models\User;
use Illuminate\Database\Seeder;

class CaseReportSeeder extends Seeder
{
    public function run(): void
    {
        $johnMichael = User::where('email', 'johnmichael.talbo@gmail.com')->firstOrFail();
        $engiemar    = User::where('email', 'engiemar.balanay@gmail.com')->firstOrFail();
        $admin       = User::where('email', 'admin@gmail.com')->firstOrFail();

        $barangays  = Barangay::all()->keyBy('name');
        $categories = HealthCategory::all()->keyBy('name');

        if ($barangays->isEmpty() || $categories->isEmpty()) {
            $this->command->warn('Skipping CaseReportSeeder — no barangays or categories.');
            return;
        }

        $reports = [
            // 7 approved reports
            [
                'user_id'            => $johnMichael->id,
                'barangay_id'        => $barangays['Bacsay']->id,
                'health_category_id' => $categories['Dengue']->id,
                'number_of_cases'    => 4,
                'status'             => 'approved',
                'report_date'        => now()->subDays(3)->toDateString(),
                'reviewed_by'        => $admin->id,
                'reviewed_at'        => now()->subDays(2),
            ],
            [
                'user_id'            => $engiemar->id,
                'barangay_id'        => $barangays['Turod']->id,
                'health_category_id' => $categories['Tuberculosis']->id,
                'number_of_cases'    => 2,
                'status'             => 'approved',
                'report_date'        => now()->subDays(5)->toDateString(),
                'reviewed_by'        => $admin->id,
                'reviewed_at'        => now()->subDays(4),
            ],
            [
                'user_id'            => $johnMichael->id,
                'barangay_id'        => $barangays['Zumigui']->id,
                'health_category_id' => $categories['Malnutrition']->id,
                'number_of_cases'    => 3,
                'status'             => 'approved',
                'report_date'        => now()->subDays(7)->toDateString(),
                'reviewed_by'        => $admin->id,
                'reviewed_at'        => now()->subDays(6),
            ],
            [
                'user_id'            => $engiemar->id,
                'barangay_id'        => $barangays['Luna']->id,
                'health_category_id' => $categories['Hypertension']->id,
                'number_of_cases'    => 5,
                'status'             => 'approved',
                'report_date'        => now()->subDays(10)->toDateString(),
                'reviewed_by'        => $admin->id,
                'reviewed_at'        => now()->subDays(9),
            ],
            [
                'user_id'            => $johnMichael->id,
                'barangay_id'        => $barangays['Bacsay']->id,
                'health_category_id' => $categories['Diarrhea']->id,
                'number_of_cases'    => 6,
                'status'             => 'approved',
                'report_date'        => now()->subDays(12)->toDateString(),
                'reviewed_by'        => $admin->id,
                'reviewed_at'        => now()->subDays(11),
            ],
            [
                'user_id'            => $engiemar->id,
                'barangay_id'        => $barangays['Turod']->id,
                'health_category_id' => $categories['Dengue']->id,
                'number_of_cases'    => 2,
                'status'             => 'approved',
                'report_date'        => now()->subDays(15)->toDateString(),
                'reviewed_by'        => $admin->id,
                'reviewed_at'        => now()->subDays(14),
            ],
            [
                'user_id'            => $johnMichael->id,
                'barangay_id'        => $barangays['Zumigui']->id,
                'health_category_id' => $categories['Tuberculosis']->id,
                'number_of_cases'    => 1,
                'status'             => 'approved',
                'report_date'        => now()->subDays(20)->toDateString(),
                'reviewed_by'        => $admin->id,
                'reviewed_at'        => now()->subDays(19),
            ],
            // 2 pending reports
            [
                'user_id'            => $engiemar->id,
                'barangay_id'        => $barangays['Luna']->id,
                'health_category_id' => $categories['Malnutrition']->id,
                'number_of_cases'    => 3,
                'status'             => 'pending',
                'report_date'        => now()->subDays(1)->toDateString(),
            ],
            [
                'user_id'            => $johnMichael->id,
                'barangay_id'        => $barangays['Bacsay']->id,
                'health_category_id' => $categories['Hypertension']->id,
                'number_of_cases'    => 2,
                'status'             => 'pending',
                'report_date'        => now()->subDays(2)->toDateString(),
            ],
            // 1 rejected report
            [
                'user_id'            => $engiemar->id,
                'barangay_id'        => $barangays['Zumigui']->id,
                'health_category_id' => $categories['Diarrhea']->id,
                'number_of_cases'    => 1,
                'status'             => 'rejected',
                'report_date'        => now()->subDays(8)->toDateString(),
                'notes'              => 'Insufficient information provided',
                'reviewed_by'        => $admin->id,
                'reviewed_at'        => now()->subDays(7),
            ],
        ];

        foreach ($reports as $data) {
            CaseReport::updateOrCreate(
                [
                    'user_id'            => $data['user_id'],
                    'barangay_id'        => $data['barangay_id'],
                    'health_category_id' => $data['health_category_id'],
                    'report_date'        => $data['report_date'],
                ],
                $data
            );
        }

        $this->command->info('Seeded ' . count($reports) . ' case reports.');
    }
}
