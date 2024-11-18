<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Driver>
 */
class DriverFactory extends Factory
{

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    public function definition(): array
    {
        $kodeWilayah = [
            'A', 'B', 'C', 'D', 'E', 'F', 'T', 'Z', 'G', 'H', 'K', 'R',
            'AA', 'AB', 'AD', 'AE', 'AG', 'S', 'L', 'M', 'N', 'P', 'W',
            'DK', 'DR', 'EA', 'DH', 'EB', 'ED', 'DA', 'KB', 'KH', 'KT',
            'BA', 'BB', 'BD', 'BE', 'BG', 'BH', 'BN', 'BM', 'BP', 'BK',
            'BL', 'DD', 'DM', 'DN', 'DT', 'DB', 'DC', 'DE', 'DG', 'DS',
            'PA', 'PB'
        ];

        $kodeDepan = $this->faker->randomElement($kodeWilayah);
        $angkaTengah = $this->faker->numberBetween(1, 9999);
        $jumlahHurufBelakang = $this->faker->numberBetween(1, 3);
        $hurufBelakang = strtoupper($this->faker->lexify(str_repeat('?', $jumlahHurufBelakang)));

        $platNomor = sprintf('%s %d %s', $kodeDepan, $angkaTengah, $hurufBelakang);

        return [
            'name' => fake()->name(),
            'phone' => fake()->phoneNumber(),
            'vehicle_number' => $platNomor,
        ];
    }
}
