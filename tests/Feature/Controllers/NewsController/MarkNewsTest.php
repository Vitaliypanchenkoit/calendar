<?php

namespace Tests\Feature\Controllers\NewsController;

use App\Models\News;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Tests\TestCase;

class MarkNewsTest extends TestCase
{
    use RefreshDatabase;

    const ROUTE = '/news/mark';
    const METHOD = 'PUT';
    const KEY_READ = 'read';
    const KEY_IMPORTANT = 'important';

    private static User $user;
    private static News $news;

    public static function setUpBeforeClass(): void
    {
        $now = now();
        self::$user = User::create([
            'name' => 'test name',
            'email' => 'randomemail@mail.com',
            'password' => 1234545656,
            'role' => User::ROLE_USER
        ]);
        self::$news = News::create([
            'title' => 'test',
            'date' => $now->format('Y-m-d'),
            'time' => $now->format('H:i:s'),
            'author_id' => self::$user->id,
            'content' => 'Some content'
        ]);
    }

    /**
     * @dataProvider provideMarkVariants
     *
     * @return void
     */
    public function test_mark_news_successfully(array $data)
    {
        $response = $this->actingAs(self::$user)->json(self::METHOD, self::ROUTE, ['newsId' => self::$news->id, 'key' => $data['key'], 'value' => $data['value']]);
        $response->assertStatus(200);
    }

    /**
     * @dataProvider provideInvalidData
     * @return void
     */
    public function test_fail_validation(array $data)
    {
        $response = $this->actingAs(self::$user)->json( self::METHOD, self::ROUTE, $data);
        $response->assertStatus(422);
    }

    /**
     * Data provider of invalid user input
     * @return array
     */
    public function provideInvalidData(): array
    {
        return [
            'missing all fields' => [[]],
            'missing id' => [
                [
                    'key' => self::KEY_IMPORTANT,
                    'value' => 1
                ]
            ],
            'not existing id' => [
                [
                    'newsId' => 0,
                    'key' => self::KEY_IMPORTANT,
                    'value' => 1
                ]
            ],
            'missing key' => [
                [
                    'newsId' => self::$news->id,
                    'value' => 1
                ]
            ],
            'invalid key' => [
                [
                    'newsId' => self::$news->id,
                    'key' => 'invalid',
                    'value' => 1
                ]
            ],
            'missing value' => [
                [
                    'newsId' => self::$news->id,
                    'key' => self::KEY_READ,
                ]
            ],
            'invalid value' => [
                [
                    'newsId' => self::$news->id,
                    'key' => self::KEY_READ,
                    'value' => 2
                ]
            ],

        ];
    }

    /**
     * Data provider of mark variants
     * @return array
     */
    public function provideMarkVariants(): array
    {
        return [
            'read-1' => [
                [
                    'key' => self::KEY_READ,
                    'value' => 1
                ]
            ],
            'important-1' => [
                [
                    'key' => self::KEY_IMPORTANT,
                    'value' => 1
                ]
            ],
            'read-0' => [
                [
                    'key' => self::KEY_READ,
                    'value' => 0
                ]
            ],
            'important-0' => [
                [
                    'key' => self::KEY_IMPORTANT,
                    'value' => 0
                ]
            ],

        ];

    }
}
