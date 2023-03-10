<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Book;
use App\Models\Collection;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\CollectionController
 */
class CollectionControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    /**
     * @test
     */
    public function index_displays_view(): void
    {
        $collections = Collection::factory()->count(3)->create();

        $response = $this->get(route('collection.index'));

        $response->assertOk();
        $response->assertViewIs('collection.index');
        $response->assertViewHas('collections');
    }


    /**
     * @test
     */
    public function create_displays_view(): void
    {
        $response = $this->get(route('collection.create'));

        $response->assertOk();
        $response->assertViewIs('collection.create');
    }


    /**
     * @test
     */
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\CollectionController::class,
            'store',
            \App\Http\Requests\CollectionStoreRequest::class
        );
    }

    /**
     * @test
     */
    public function store_saves_and_redirects(): void
    {
        $user = User::factory()->create();
        $book = Book::factory()->create();

        $response = $this->post(route('collection.store'), [
            'user_id' => $user->id,
            'book_id' => $book->id,
        ]);

        $collections = Collection::query()
            ->where('user_id', $user->id)
            ->where('book_id', $book->id)
            ->get();
        $this->assertCount(1, $collections);
        $collection = $collections->first();

        $response->assertRedirect(route('collection.index'));
        $response->assertSessionHas('collection.id', $collection->id);
    }


    /**
     * @test
     */
    public function show_displays_view(): void
    {
        $collection = Collection::factory()->create();

        $response = $this->get(route('collection.show', $collection));

        $response->assertOk();
        $response->assertViewIs('collection.show');
        $response->assertViewHas('collection');
    }


    /**
     * @test
     */
    public function edit_displays_view(): void
    {
        $collection = Collection::factory()->create();

        $response = $this->get(route('collection.edit', $collection));

        $response->assertOk();
        $response->assertViewIs('collection.edit');
        $response->assertViewHas('collection');
    }


    /**
     * @test
     */
    public function update_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\CollectionController::class,
            'update',
            \App\Http\Requests\CollectionUpdateRequest::class
        );
    }

    /**
     * @test
     */
    public function update_redirects(): void
    {
        $collection = Collection::factory()->create();
        $user = User::factory()->create();
        $book = Book::factory()->create();

        $response = $this->put(route('collection.update', $collection), [
            'user_id' => $user->id,
            'book_id' => $book->id,
        ]);

        $collection->refresh();

        $response->assertRedirect(route('collection.index'));
        $response->assertSessionHas('collection.id', $collection->id);

        $this->assertEquals($user->id, $collection->user_id);
        $this->assertEquals($book->id, $collection->book_id);
    }


    /**
     * @test
     */
    public function destroy_deletes_and_redirects(): void
    {
        $collection = Collection::factory()->create();

        $response = $this->delete(route('collection.destroy', $collection));

        $response->assertRedirect(route('collection.index'));

        $this->assertModelMissing($collection);
    }
}
