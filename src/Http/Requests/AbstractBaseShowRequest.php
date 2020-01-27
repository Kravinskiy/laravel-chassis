<?php

namespace Kravinskiy\LaravelChassis\Http\Requests;

abstract class AbstractBaseShowRequest extends AbstractBaseRequest
{
    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'id' => 'required|uuid'
        ];
    }
}
