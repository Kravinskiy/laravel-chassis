<?php

namespace Kravinskiy\LaravelChassis\Rules;

use Illuminate\Contracts\Validation\Rule;

class ElementsAreInArrayRule implements Rule
{
    /**
     * @var array
     */
    private $haystack;

    /**
     * @var array
     */
    private $elements;

    /**
     * ElementsAreInArrayRule constructor.
     * @param array $haystack
     * @param array $elements
     */
    public function __construct(array $haystack, array $elements)
    {
        $this->haystack = $haystack;
        $this->elements = $elements;
    }

    /**
     * @param string $attribute
     * @param mixed $value
     * @return bool
     */
    public function passes($attribute, $value): bool
    {
        foreach ($this->elements as $element) {
            if (!in_array($element, $this->haystack)) {
                return false;
            }
        }

        return true;
    }

    /**
     * @return string
     */
    public function message()
    {
        return 'Element should be part of ' . implode(', ', $this->haystack);
    }
}
