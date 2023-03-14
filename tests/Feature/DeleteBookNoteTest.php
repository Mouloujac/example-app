<?php

use App\Models\Book;
use App\Models\Collection;
use App\Models\Note;
use Symfony\Component\HttpFoundation\Response;

test('a guest cannot delete a note from a book in a collection', function () {
    // Preparation de l'appli
    $collection = Collection::factory()->create();
    $note = Note::factory()->create();
    $collection->book->note()->associate($note);

    // Fait l'action
    $response = $this->deleteJson('note/' . $note->id);

    // Assertions
    $response->assertStatus(401);
});

test('a user can delete a note from a book in a collection', function () {
    // Preparation de l'appli
    $collection = Collection::factory()->create();
    $note = Note::factory()->create();
    $collection->book->note()->associate($note);

    // Fait l'action
    $response = $this->actingAs($collection->user)->deleteJson('note/' . $note->id);

    // Assertions
    $response->assertSuccessful();

    expect(Note::count())->toEqual(0);
});
