<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Module;
use App\Models\ModuleMeasurement;

use Carbon\Carbon;

class UpdateModuleStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update-module-status';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Automatically update the status of modules based on predefined conditions';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $modules = Module::where('status', 'active')->get();

        foreach ($modules as $module) {
            // Condition: If the module has not been updated for 24 hours, mark it as inactive
            $latestMeasurement = ModuleMeasurement::where('module_id', $module->id)
                ->orderBy('created_at', 'desc')
                ->first();

                if (!$latestMeasurement) {
                    $this->info("No measurements for module ID yet");
                    $newMeasurement = new ModuleMeasurement();
                    $newMeasurement->module_id = $module->id;
                    $newMeasurement->value = rand(20, 30); // Example: Generate a random value, replace this with actual data logic
                    $newMeasurement->reading_type = 'current';
                    $newMeasurement->save();
                    $this->info("Module ID: {$module->id} updated successfully with a new 'current' measurement value {$newMeasurement->value}.");
                        continue;
                }       
                
                $lastUpdated = $latestMeasurement->created_at;    
            $now = Carbon::now('Asia/Kolkata');
            $hoursDifference = $lastUpdated->diffInHours($now);

           // $this->info($latestMeasurement->module_id);
           // $this->info($lastUpdated);
           // $this->info($now);  
           //  $this->info($hoursDifference);exit;
            // Check if the module is inactive based on the condition
            if ($hoursDifference > 1) {

                if ($latestMeasurement->reading_type === 'current') {
                    $latestMeasurement->reading_type = 'historical';
                    $latestMeasurement->save(); // Save the change
                }

                $newMeasurement = new ModuleMeasurement();
                $newMeasurement->module_id = $module->id;
                $newMeasurement->value = rand(20, 30); // Example: Generate a random value, replace this with actual data logic
                $newMeasurement->reading_type = 'current';
                $newMeasurement->save();

            
        
                $this->info("Module ID: {$module->id} updated successfully with a new 'current' measurement value: {$newMeasurement->value}");
            } else {
                    $this->info("Module ID: {$module->id} is up to date. Last measurement is within 1 hour.");
            }

            // Save the updated status to the database
            $module->save();
        }

        $this->info('Module statuses have been updated successfully!');
    }
    
}

