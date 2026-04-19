<?php

namespace Tests\Feature\Http\Controllers;

use App\Http\Controllers\CommentController;
use App\Models\Beer;
use App\Models\Comment;
use Carbon\Carbon;
use Tests\TestCase;

/**
 * @see CommentController
 */
class CommentControllerTest extends TestCase
{

    private Beer $beer;
    private Comment $comment;

    protected function setUp(): void
    {
        parent::setUp();
        Carbon::setTestNow('2026-04-19 17:22');
    }

    private function seedBeerComment(): void
    {
        $this->beer    = Beer::factory()->create();
        $this->comment = Comment::factory()->create([
            'entity_type' => 'beer',
            'entity_id'   => $this->beer->getKey(),
            'value'       => 'my dummy beer comment',
        ]);
    }

    public function test_list_comments()
    {
        $this->seedBeerComment();
        $this->get('/api/comments')
            ->assertOk()
            ->assertExactJson([
                [
                    'id'          => $this->comment->getKey(),
                    'entity_type' => 'beer',
                    'entity_id'   => $this->beer->getKey(),
                    'value'       => 'my dummy beer comment',
                    'created_at'  => '2026-04-19T17:22:00.000000Z',
                ],
            ]);
    }

}
