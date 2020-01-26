<?php

namespace Kravinskiy\LaravelChassis\Helpers;

class StubHelper
{
    /**
     * @param string $type
     * @return string
     */
    public static function getResourceStubs(string $type) : string
    {
        $content = file_get_contents(resource_path(sprintf('stubs/%s.stub', $type)));

        if ($content === false) {
            return '';
        }

        return $content;
    }
}
