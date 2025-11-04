<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Area;
use App\Models\Customer;
use App\Models\Grave;
use App\Models\Service;
use App\Models\Task;
use App\Models\TaskType;
use App\Models\User;
use App\Models\WorkType;

class TaskFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Task::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'task_type_id' => TaskType::factory(),
            'area_id' => Area::factory(),
            'grave_id' => Grave::factory(),
            'service_id' => Service::factory(),
            'customer_id' => Customer::factory(),
            'user_id' => User::factory(),
            'work_type_id' => WorkType::factory(),
            'work_date' => fake()->dateTime(),
            'hours' => fake()->randomFloat(2, 0, 999.99),
            'break_hours' => fake()->randomFloat(2, 0, 999.99),
            'comment' => fake()->text(),
        ];
    }
}
