<?php

namespace Database\Factories;

use App\Models\Communicationmessage;
use Illuminate\Database\Eloquent\Factories\Factory;

class CommunicationmessageFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Communicationmessage::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        do {
            $sender = rand(1, 30);
            $receiver = rand(1, 30);
            $is_viewed = rand(0, 1);
        } while ($sender === $receiver);

        return [
            'sender' => $sender,
            'receiver' => $receiver,
            'communicationmessage' => $this->faker->sentence,
            'is_viewed' => $is_viewed
        ];
    }
}
