<?php

namespace Kravinskiy\LaravelChassis\Http\Requests;

abstract class AbstractBaseUpdateRequest extends AbstractBaseRequest
{
    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'id' => 'required|integer'
        ];
    }
}
