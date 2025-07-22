<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Cooperado;

class CooperadoSeeder extends Seeder {
    /**
     * Run the database seeds.
     */
    public function run(): void {
        Cooperado::factory(10)->create();
    }
}
