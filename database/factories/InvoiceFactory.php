<?php

namespace Database\Factories;

use App\Models\Customer;
use App\Models\Invoice;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Invoice>
 */
class InvoiceFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Invoice::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'invoice_number' => $this->faker->unique()->numerify('SKT-#####'),
            'customer_id' => Customer::factory(),
            'issue_date' => $this->faker->date(),
            'invoice_title' => $this->faker->sentence(),
            'product_lines' => [],
            'subtotal' => 0,
            'tax' => 0,
            'total' => 0,
        ];
    }
}
