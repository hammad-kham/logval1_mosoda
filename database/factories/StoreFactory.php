<?php

namespace Database\Factories;

use App\Models\Store;
use Illuminate\Database\Eloquent\Factories\Factory;

class StoreFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Store::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->word,
        'about' => $this->faker->text,
        'address' => $this->faker->word,
        'phone' => $this->faker->word,
        'preparation_time' => $this->faker->randomDigitNotNull,
        'logo' => $this->faker->word,
        'cover_photo' => $this->faker->word,
        'is_open' => $this->faker->randomDigitNotNull,
        'admin_user_id' => $this->faker->randomDigitNotNull,
        'created_at' => $this->faker->date('Y-m-d H:i:s'),
        'updated_at' => $this->faker->date('Y-m-d H:i:s')
        ];
    }
}
