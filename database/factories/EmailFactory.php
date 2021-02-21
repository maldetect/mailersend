<?php

namespace Database\Factories;

use App\Models\Email;
use Illuminate\Database\Eloquent\Factories\Factory;

class EmailFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Email::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'to' => $this->faker->email,
            'from' => $this->faker->email,
            'subject' => $this->faker->text(100),
            'text_content' => $this->faker->text(500),
            'html_content' => $this->faker->randomHtml(2, 3),
            'status' => 'Posted'
        ];
    }
}
