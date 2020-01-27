<?php

namespace Kravinskiy\LaravelChassis\Http\Requests;

abstract class AbstractBaseDestroyRequest extends AbstractBaseRequest
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
