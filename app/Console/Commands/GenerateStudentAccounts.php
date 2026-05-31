<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Applicant;
use App\Models\SmpApplicant;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class GenerateStudentAccounts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:generate-student-accounts';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate user accounts for existing applicants';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Generating accounts for SMK Applicants...');
        $smkApplicants = Applicant::whereNull('user_id')->get();
        $smkCount = 0;
        foreach ($smkApplicants as $applicant) {
            if (!User::where('username', $applicant->registration_number)->exists()) {
                $user = User::create([
                    'name' => $applicant->full_name,
                    'username' => $applicant->registration_number,
                    'password' => Hash::make($applicant->nik),
                    'role' => 'applicant',
                ]);
                $applicant->update(['user_id' => $user->id]);
                $smkCount++;
            }
        }
        $this->info("Created $smkCount accounts for SMK.");

        $this->info('Generating accounts for SMP Applicants...');
        $smpApplicants = SmpApplicant::whereNull('user_id')->get();
        $smpCount = 0;
        foreach ($smpApplicants as $applicant) {
            if (!User::where('username', $applicant->registration_number)->exists()) {
                $user = User::create([
                    'name' => $applicant->full_name,
                    'username' => $applicant->registration_number,
                    'password' => Hash::make($applicant->nik),
                    'role' => 'applicant',
                ]);
                $applicant->update(['user_id' => $user->id]);
                $smpCount++;
            }
        }
        $this->info("Created $smpCount accounts for SMP.");
        
        $this->info('Done!');
    }
}
