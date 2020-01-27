<?php

namespace Kravinskiy\LaravelChassis\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

abstract class AbstractBaseRequest extends FormRequest
{
    /**
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [];
    }

    /**
     * @param array $keys
     * @return array
     */
    public function all($keys = null): array
    {
        /** @var array $query */
        $query = $this->query();

        /** @var array $route */
        $route = $this->route()->parameters();

        $mergedArray = array_replace_recursive(
            $query,
            parent::all(),
            $route
        );

        if (empty($mergedArray)) {
            return [];
        }

        return $mergedArray;
    }
}
