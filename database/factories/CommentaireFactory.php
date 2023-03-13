<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Collection;
use App\Models\Commentaire;

class CommentaireFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Commentaire::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'collection_id' => Collection::factory(),
            'content' => $this->faker->paragraphs(3, true),
        ];
    }
}
