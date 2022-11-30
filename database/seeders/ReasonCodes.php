<?php

namespace Database\Seeders;
use Database\Seeders\Traits\DisableForeignKeys;
use App\Models\ReasonCode;

use Illuminate\Database\Seeder;

class ReasonCodes extends Seeder
{
    use DisableForeignKeys;
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $this->disableForeignKeys();

        ReasonCode::updateOrCreate([
            'code' => 'Wrong Rate',
            'level' => 0,
        ]);

        ReasonCode::updateOrCreate([
            'code' => 'Incorrect RCN',
            'level' => 0,
        ]);
        ReasonCode::updateOrCreate([
            'code' => 'RCN has a short delivery or damages',
            'level' => 0,
        ]);
        ReasonCode::updateOrCreate([
            'code' => 'No RCN / Wrong RCN',
            'level' => 0,
        ]);
        ReasonCode::updateOrCreate([
            'code' => 'Container Interchange missing/ not attached',
            'level' => 0,
        ]);
        ReasonCode::updateOrCreate([
            'code' => 'Debit / Wrong disbursement amount',
            'level' => 0,
        ]);
        ReasonCode::updateOrCreate([
            'code' => 'Wrong recovery invoice amount',
            'level' => 1,
        ]);
        ReasonCode::updateOrCreate([
            'code' => 'Wrong recovery invoice number',
            'level' => 1,
        ]);
        ReasonCode::updateOrCreate([
            'code' => 'Blacklisted supplier',
            'level' => 0,
        ]);
        ReasonCode::updateOrCreate([
            'code' => 'Other',
            'level' => 0,
        ]);

        $this->enableForeignKeys();
    }
}
