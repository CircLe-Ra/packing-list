<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Container>
 */
class ContainerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $ownerCode = $this->generateOwnerCode();
        $categoryIdentifier = $this->generateCategoryIdentifier();
        $serialNumber = $this->faker->numerify('######');
        $checkDigit = $this->calculateCheckDigit($ownerCode, $categoryIdentifier, $serialNumber);

        $containerNumber = sprintf('%s%s %s-%s', $ownerCode, $categoryIdentifier, $serialNumber, $checkDigit);

        return [
            'number_container' => $containerNumber
        ];
    }

    private function generateOwnerCode()
    {
        return strtoupper($this->faker->lexify('???'));
    }

    private function generateCategoryIdentifier()
    {
        $categories = ['U', 'J', 'Z', 'R'];
        return $this->faker->randomElement($categories);
    }

    private function calculateCheckDigit($ownerCode, $categoryIdentifier, $serialNumber)
    {
        $chars = $ownerCode . $categoryIdentifier . $serialNumber;
        $total = 0;
        $multipliers = [
            'A' => 10, 'B' => 12, 'C' => 13, 'D' => 14, 'E' => 15,
            'F' => 16, 'G' => 17, 'H' => 18, 'I' => 19, 'J' => 20,
            'K' => 21, 'L' => 23, 'M' => 24, 'N' => 25, 'O' => 26,
            'P' => 27, 'Q' => 28, 'R' => 29, 'S' => 30, 'T' => 31,
            'U' => 32, 'V' => 34, 'W' => 35, 'X' => 36, 'Y' => 37,
            'Z' => 38,
            '0' => 0,  '1' => 1,  '2' => 2,  '3' => 3,  '4' => 4,
            '5' => 5,  '6' => 6,  '7' => 7,  '8' => 8,  '9' => 9,
        ];

        for ($i = 0; $i < strlen($chars); $i++) {
            $char = $chars[$i];
            $value = $multipliers[$char] ?? 0;
            $total += $value * pow(2, $i);
        }

        $remainder = $total % 11;
        $checkDigit = $remainder == 10 ? 0 : $remainder;

        return $checkDigit;
    }

}
