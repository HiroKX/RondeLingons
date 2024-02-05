<?php

namespace App\Form\DataTransformer;

use Symfony\Component\Form\DataTransformerInterface;

class FilesToAttachements implements DataTransformerInterface
{

    public function transform(mixed $value): mixed
    {
        dd($value);

        // TODO: Implement transform() method.
    }

    public function reverseTransform(mixed $value): mixed
    {
        dd($value);
        // TODO: Implement reverseTransform() method.
    }
}