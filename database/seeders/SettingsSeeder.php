<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingsSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            'site.ar01_status' => 'open',   // open | closed | waitlist
            'site.ar02_status' => 'open',
            'site.banner_message' => '',
            'office.address' => 'D1, Madni Heights, Soldier Bazar No.3, Karachi, Pakistan',
            'office.landline_1' => '+92 21 32293 244',
            'office.landline_2' => '+92 21 32293 644',
            'bank.name' => 'Bhojani Brothers Travel & Tour',
            'bank.account' => '',
            'bank.iban' => '',
            'bank.branch' => '',
        ];

        foreach ($settings as $key => $value) {
            Setting::updateOrCreate(['key' => $key], ['value' => $value]);
        }
    }
}
