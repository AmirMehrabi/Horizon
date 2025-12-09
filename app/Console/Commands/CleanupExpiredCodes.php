<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\CustomerVerificationCode;

class CleanupExpiredCodes extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'verification:cleanup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clean up expired verification codes';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $deletedCount = CustomerVerificationCode::cleanupExpired();
        
        $this->info("Cleaned up {$deletedCount} expired verification codes.");
        
        return 0;
    }
}
