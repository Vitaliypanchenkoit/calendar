<?php

namespace Tests\Feature\Controllers\NewsController;

use App\Models\News;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UpdateNewsTest extends TestCase
{
    use RefreshDatabase;

    const ROUTE = '/news';
    const METHOD = 'PUT';

    /**
     *
     * @return void
     */
    public function test_update_news_successfully()
    {
        $news = News::factory()->create();
        $user = User::find($news->author_id);

        $response = $this->actingAs($user)->json(self::METHOD, self::ROUTE, ['id' => $news->id, 'title' => 'new title', 'content' => 'new content']);
        $response->assertStatus(200);
    }

    /**
     * @dataProvider provideInvalidData
     * @return void
     */
    public function test_fail_validation(array|\Closure $data)
    {
        if (is_object($data)) {
            $data = $data();
        }

        if (!empty($data['id'])) {
            $news = News::find($data['id']);
            $user = User::find($news->author_id);
        } else {
            $user = User::factory()->create();
        }

        $response = $this->actingAs($user)->json( self::METHOD, self::ROUTE, $data);

        $response->assertStatus(422);
    }

    /**
     * @return void
     */
    public function test_user_hasnt_access_to_update_a_news()
    {
        $news = News::factory()->create();
        $user = User::factory()->create();

        $response = $this->actingAs($user)->json( self::METHOD, self::ROUTE, ['id' => $news->id, 'title' => 'new title', 'content' => 'new content']);

        $response->assertForbidden();
    }

    /**
     * Data provider
     * @return array
     */
    public function provideInvalidData(): array
    {
        return [
            'missing all fields' => [[]],
            'missing id' => [
                [
                    'title' => 'test',
                    'content' => 'test',
                ]
            ],
            'not existing id' => [
                [
                    'id' => 0,
                    'title' => 'test',
                    'content' => 'test',
                ]
            ],
            'missing title' => [
                function () {
                    $news = News::factory()->create();
                    return [
                        'id' => $news->id,
                        'content' => 'test',
                    ];
                }
            ],
            'missing content' => [
                function () {
                    $news = News::factory()->create();
                    return [
                        'id' => $news->id,
                        'title' => 'test',
                    ];
                }
            ],

        ];
    }
}
