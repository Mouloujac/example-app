<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Book;
use App\Models\Commentaire;
use App\Models\Note;

class BookFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Book::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'googlebook_id' => $this->faker->regexify('[A-Za-z0-9]{200}'),
            'title' => $this->faker->sentence(4),
            'author' => $this->faker->regexify('[A-Za-z0-9]{250}'),
            'description' => $this->faker->text,
            'img' => $this->faker->text,
            'note_id' => Note::factory(),
            'commentaire_id' => Commentaire::factory(),
        ];
    }
}
