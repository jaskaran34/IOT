<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Module;
use App\Models\ModuleMeasurement;
use App\Models\SkippedModule;

use Carbon\Carbon;

class SimulateModuleMalfunction extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'simulate:module-malfunction';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Simulate a module malfunction by skipping data for one module and updating the rest.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $modules = Module::where('status', 'active')->get();

        $failedModuleId = $modules->random()->id;

        foreach ($modules as $module) {

            if ($module->id === $failedModuleId) {
                $this->info("Simulating failure for module ID {$module->id}. No data will be inserted.");

                SkippedModule::create([
                    'module_id' => $module->id,
                    'skipped_at' => Carbon::now(),
                    'reason' => 'Failed to report data',
                ]);

                continue; // Skip data update for this module
            }
            
            $latestMeasurement = ModuleMeasurement::where('module_id', $module->id)
                ->orderBy('created_at', 'desc')
                ->first();

                if (!$latestMeasurement) {
                    $this->info("No measurements for module ID yet");
                    $newMeasurement = new ModuleMeasurement();
                    $newMeasurement->module_id = $module->id;
                    $newMeasurement->value = rand(0, 3000); // Example: Generate a random value, replace this with actual data logic
                    $newMeasurement->reading_type = 'current';
                    $newMeasurement->save();
                    $this->info("Module ID: {$module->id} updated successfully with a new 'current' measurement value {$newMeasurement->value}.");
                        continue;
                }       
                

            $lastUpdated = $latestMeasurement->created_at;
            $now = Carbon::now('Asia/Kolkata');
            $minutesDifference = $lastUpdated->diffInMinutes($now);



           // $this->info($latestMeasurement->module_id);
           // $this->info($lastUpdated);
           // $this->info($now);  
           //  $this->info($hoursDifference);exit;
            // Check if the module is inactive based on the condition
            if ($minutesDifference > 1) {

                if ($latestMeasurement->reading_type === 'current') {
                    $latestMeasurement->reading_type = 'historical';
                    $latestMeasurement->save(); // Save the change
                }

                $newMeasurement = new ModuleMeasurement();
                $newMeasurement->module_id = $module->id;
                $newMeasurement->value = rand(0, 3000); // Example: Generate a random value, replace this with actual data logic
                $newMeasurement->reading_type = 'current';
                $newMeasurement->save();

            
        
                $this->info("Module ID: {$module->id} updated successfully with a new 'current' measurement value: {$newMeasurement->value}");
            } else {
                    $this->info("Module ID: {$module->id} is up to date.");
            }

            // Save the updated status to the database
            $module->save();
    }
    $this->info('Module statuses have been updated successfully!');
    }
}
