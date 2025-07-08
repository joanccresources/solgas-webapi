<?php

namespace App\Console\Commands;

use Illuminate\Support\Facades\DB;
use Illuminate\Console\Command;

class FixPhoneNumbers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:fix-phone-numbers';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $updated = DB::table('maps')
            ->where('phone', 'like', '%16133333%')
            ->where('phone', 'not like', '0%')
            ->update([
                'phone' => DB::raw("CONCAT('0', phone)")
            ]);

        $this->info("Se actualizaron $updated registros.");
    }
}
