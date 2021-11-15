<?php

namespace Tests\Feature\Controllers\NewsController;

use App\Models\News;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class EditNewsTest extends TestCase
{
    use RefreshDatabase;

    const ROUTE = '/news/edit';
    const METHOD = 'GET';

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_get_edit_news_page_successfully()
    {
        $object = News::factory()->create();
        $user = User::find($object->author_id);
        $response = $this->actingAs($user)->json(self::METHOD, self::ROUTE, ['id' => $object->id]);

        $response->assertStatus(200);
    }

    /**
     * @dataProvider provideInvalidData
     * @return void
     */
    public function test_fail_validation(array $data)
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->json( self::METHOD, self::ROUTE, $data);

        $response->assertStatus(422);
    }

    /**
     * Data provider
     * @return array
     */
    public function provideInvalidData(): array
    {
        return [
            'missing id' => [[]],
            'not existing id' => [
                [
                    'id' => 0
                ]
            ],

        ];
    }
}
