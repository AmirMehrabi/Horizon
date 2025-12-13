<?php

namespace App\Console\Commands;

use App\Models\OpenStackInstance;
use App\Models\Wallet;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ProcessHourlyBilling extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'billing:process-hourly';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Process hourly billing for all active hourly-billed instances';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Processing hourly billing...');
        
        // Get all active instances with hourly billing (exclude deleted)
        $instances = OpenStackInstance::where('billing_cycle', 'hourly')
            ->where('status', 'active')
            ->where('auto_billing', true)
            ->whereNotNull('billing_started_at')
            ->get();
        
        $processed = 0;
        $failed = 0;
        $insufficient = 0;
        
        foreach ($instances as $instance) {
            try {
                DB::beginTransaction();
                
                $wallet = $instance->customer->getOrCreateWallet();
                $hourlyCost = (float) $instance->hourly_cost;
                
                // Check if wallet has sufficient balance
                if ($wallet->balance < $hourlyCost) {
                    $insufficient++;
                    $this->warn("Insufficient balance for instance {$instance->id}: {$instance->name}");
                    
                    // Log the issue
                    Log::warning('Hourly billing failed - insufficient balance', [
                        'instance_id' => $instance->id,
                        'customer_id' => $instance->customer_id,
                        'required' => $hourlyCost,
                        'available' => $wallet->balance,
                    ]);
                    
                    // Optionally, you could suspend the instance here
                    // $instance->update(['status' => 'suspended']);
                    
                    DB::rollBack();
                    continue;
                }
                
                // Deduct hourly cost
                $wallet->debit(
                    $hourlyCost,
                    "هزینه ساعتی سرور: {$instance->name}",
                    OpenStackInstance::class,
                    $instance->id,
                    [
                        'billing_cycle' => 'hourly',
                        'hour' => now()->format('Y-m-d H:00:00'),
                    ]
                );
                
                // Update last billed timestamp
                $instance->update(['last_billed_at' => now()]);
                
                DB::commit();
                $processed++;
                
                $this->line("Processed billing for instance: {$instance->name} (Customer: {$instance->customer->full_name})");
                
            } catch (\Exception $e) {
                DB::rollBack();
                $failed++;
                
                $this->error("Failed to process billing for instance {$instance->id}: {$e->getMessage()}");
                
                Log::error('Hourly billing processing failed', [
                    'instance_id' => $instance->id,
                    'customer_id' => $instance->customer_id ?? null,
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString(),
                ]);
            }
        }
        
        $this->info("Hourly billing completed. Processed: {$processed}, Failed: {$failed}, Insufficient balance: {$insufficient}");
        
        return Command::SUCCESS;
    }
}
