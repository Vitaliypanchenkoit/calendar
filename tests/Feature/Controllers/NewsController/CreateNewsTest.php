<?php

namespace Tests\Feature\Controllers\NewsController;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CreateNewsTest extends TestCase
{
    use RefreshDatabase;

    const ROUTE = '/news';
    const METHOD = 'POST';

    /**
     * @return void
     */
    public function test_create_a_news_successfully()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->json( self::METHOD, self::ROUTE, [
            'title' => 'test title',
            'content' => 'test content',
        ]);

        $response->assertStatus(201);
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
            'missing all fields' => [[]],
            'missing title' => [
                [
                    'content' => 'test content',
                ]
            ],
            'missing content' => [
                [
                    'title' => 'test title',
                ]
            ]
        ];
    }
}
