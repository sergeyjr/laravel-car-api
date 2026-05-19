<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{

    use CreatesApplication;

    protected function debug($response)
    {
        fwrite(STDERR, "\n");
        fwrite(STDERR, json_encode($response->json(), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
        fwrite(STDERR, "\n");
    }

}

