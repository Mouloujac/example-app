<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Book;
use App\Models\Commentaire;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\CommentaireController
 */
class CommentaireControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    /**
     * @test
     */
    public function index_displays_view(): void
    {
        $commentaires = Commentaire::factory()->count(3)->create();

        $response = $this->get(route('commentaire.index'));

        $response->assertOk();
        $response->assertViewIs('commentaire.index');
        $response->assertViewHas('commentaires');
    }


    /**
     * @test
     */
    public function create_displays_view(): void
    {
        $response = $this->get(route('commentaire.create'));

        $response->assertOk();
        $response->assertViewIs('commentaire.create');
    }


    /**
     * @test
     */
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\CommentaireController::class,
            'store',
            \App\Http\Requests\CommentaireStoreRequest::class
        );
    }

    /**
     * @test
     */
    public function store_saves_and_redirects(): void
    {
        $book = Book::factory()->create();
        $content = $this->faker->paragraphs(3, true);

        $response = $this->post(route('commentaire.store'), [
            'book_id' => $book->id,
            'content' => $content,
        ]);

        $commentaires = Commentaire::query()
            ->where('book_id', $book->id)
            ->where('content', $content)
            ->get();
        $this->assertCount(1, $commentaires);
        $commentaire = $commentaires->first();

        $response->assertRedirect(route('commentaire.index'));
        $response->assertSessionHas('commentaire.id', $commentaire->id);
    }


    /**
     * @test
     */
    public function show_displays_view(): void
    {
        $commentaire = Commentaire::factory()->create();

        $response = $this->get(route('commentaire.show', $commentaire));

        $response->assertOk();
        $response->assertViewIs('commentaire.show');
        $response->assertViewHas('commentaire');
    }


    /**
     * @test
     */
    public function edit_displays_view(): void
    {
        $commentaire = Commentaire::factory()->create();

        $response = $this->get(route('commentaire.edit', $commentaire));

        $response->assertOk();
        $response->assertViewIs('commentaire.edit');
        $response->assertViewHas('commentaire');
    }


    /**
     * @test
     */
    public function update_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\CommentaireController::class,
            'update',
            \App\Http\Requests\CommentaireUpdateRequest::class
        );
    }

    /**
     * @test
     */
    public function update_redirects(): void
    {
        $commentaire = Commentaire::factory()->create();
        $book = Book::factory()->create();
        $content = $this->faker->paragraphs(3, true);

        $response = $this->put(route('commentaire.update', $commentaire), [
            'book_id' => $book->id,
            'content' => $content,
        ]);

        $commentaire->refresh();

        $response->assertRedirect(route('commentaire.index'));
        $response->assertSessionHas('commentaire.id', $commentaire->id);

        $this->assertEquals($book->id, $commentaire->book_id);
        $this->assertEquals($content, $commentaire->content);
    }


    /**
     * @test
     */
    public function destroy_deletes_and_redirects(): void
    {
        $commentaire = Commentaire::factory()->create();

        $response = $this->delete(route('commentaire.destroy', $commentaire));

        $response->assertRedirect(route('commentaire.index'));

        $this->assertModelMissing($commentaire);
    }
}
