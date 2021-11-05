<?php

namespace Tests\Feature\Controllers\NewsController;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UpdateNewsTest extends TestCase
{
    use RefreshDatabase;

    const ROUTE = '/news';
    const METHOD = 'PUT';
}
