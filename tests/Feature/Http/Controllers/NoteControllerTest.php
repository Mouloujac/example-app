<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Collection;
use App\Models\Note;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\NoteController
 */
class NoteControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    /**
     * @test
     */
    public function index_displays_view(): void
    {
        $notes = Note::factory()->count(3)->create();

        $response = $this->get(route('note.index'));

        $response->assertOk();
        $response->assertViewIs('note.index');
        $response->assertViewHas('notes');
    }


    /**
     * @test
     */
    public function create_displays_view(): void
    {
        $response = $this->get(route('note.create'));

        $response->assertOk();
        $response->assertViewIs('note.create');
    }


    /**
     * @test
     */
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\NoteController::class,
            'store',
            \App\Http\Requests\NoteStoreRequest::class
        );
    }

    /**
     * @test
     */
    public function store_saves_and_redirects(): void
    {
        $collection = Collection::factory()->create();
        $content = $this->faker->paragraphs(3, true);

        $response = $this->post(route('note.store'), [
            'collection_id' => $collection->id,
            'content' => $content,
        ]);

        $notes = Note::query()
            ->where('collection_id', $collection->id)
            ->where('content', $content)
            ->get();
        $this->assertCount(1, $notes);
        $note = $notes->first();

        $response->assertRedirect(route('note.index'));
        $response->assertSessionHas('note.id', $note->id);
    }


    /**
     * @test
     */
    public function show_displays_view(): void
    {
        $note = Note::factory()->create();

        $response = $this->get(route('note.show', $note));

        $response->assertOk();
        $response->assertViewIs('note.show');
        $response->assertViewHas('note');
    }


    /**
     * @test
     */
    public function edit_displays_view(): void
    {
        $note = Note::factory()->create();

        $response = $this->get(route('note.edit', $note));

        $response->assertOk();
        $response->assertViewIs('note.edit');
        $response->assertViewHas('note');
    }


    /**
     * @test
     */
    public function update_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\NoteController::class,
            'update',
            \App\Http\Requests\NoteUpdateRequest::class
        );
    }

    /**
     * @test
     */
    public function update_redirects(): void
    {
        $note = Note::factory()->create();
        $collection = Collection::factory()->create();
        $content = $this->faker->paragraphs(3, true);

        $response = $this->put(route('note.update', $note), [
            'collection_id' => $collection->id,
            'content' => $content,
        ]);

        $note->refresh();

        $response->assertRedirect(route('note.index'));
        $response->assertSessionHas('note.id', $note->id);

        $this->assertEquals($collection->id, $note->collection_id);
        $this->assertEquals($content, $note->content);
    }


    /**
     * @test
     */
    public function destroy_deletes_and_redirects(): void
    {
        $note = Note::factory()->create();

        $response = $this->delete(route('note.destroy', $note));

        $response->assertRedirect(route('note.index'));

        $this->assertModelMissing($note);
    }
}
