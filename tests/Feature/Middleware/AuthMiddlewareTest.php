<?php

namespace Tests\Feature\Middleware;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthMiddlewareTest extends TestCase
{
    /**
     * @dataProvider provideRouters
     * @return void
     */
    public function test_forbid_an_access_for_an_unauthenticated_user(array $data)
    {
        $response = $this->json($data['method'], $data['path']);
        $response->assertUnauthorized();
    }

    /**
     * Data provider
     * @return array
     */
    public function provideRouters(): array
    {
        return [
            'home' => [
                [
                    'method' => 'GET',
                    'path' => '/',
                ]
            ],
            'getMonthData' => [
                [
                    'method' => 'GET',
                    'path' => '/month',
                ]
            ],
            'getWeekData' => [
                [
                    'method' => 'GET',
                    'path' => '/week',
                ]
            ],
            'getDateData' => [
                [
                    'method' => 'GET',
                    'path' => '/date',
                ]
            ],
            'removeObject' => [
                [
                    'method' => 'POST',
                    'path' => '/removeObject',
                ]
            ],
            'editReminder' => [
                [
                    'method' => 'GET',
                    'path' => '/reminders/edit',
                ]
            ],
            'createReminder' => [
                [
                    'method' => 'POST',
                    'path' => '/reminders',
                ]
            ],
            'updateReminder' => [
                [
                    'method' => 'PUT',
                    'path' => '/reminders',
                ]
            ],
            'holdReminder' => [
                [
                    'method' => 'PUT',
                    'path' => '/reminders/hold',
                ]
            ],
            'completeReminder' => [
                [
                    'method' => 'PUT',
                    'path' => '/reminders/complete',
                ]
            ],
            'editNews' => [
                [
                    'method' => 'GET',
                    'path' => '/news/edit',
                ]
            ],
            'createNews' => [
                [
                    'method' => 'POST',
                    'path' => '/news',
                ]
            ],
            'updateNews' => [
                [
                    'method' => 'PUT',
                    'path' => '/news',
                ]
            ],
            'markNews' => [
                [
                    'method' => 'PUT',
                    'path' => '/news/mark',
                ]
            ],
            'editEvent' => [
                [
                    'method' => 'GET',
                    'path' => '/events/edit',
                ]
            ],
            'createEvent' => [
                [
                    'method' => 'POST',
                    'path' => '/events',
                ]
            ],
            'updateEvent' => [
                [
                    'method' => 'PUT',
                    'path' => '/events',
                ]
            ],
            'markEvent' => [
                [
                    'method' => 'POST',
                    'path' => '/events/mark',
                ]
            ],
        ];

    }
}
