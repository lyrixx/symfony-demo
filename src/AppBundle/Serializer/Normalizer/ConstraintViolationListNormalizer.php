<?php

namespace AppBundle\Serializer\Normalizer;

use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Validator\ConstraintViolationListInterface;

class ConstraintViolationListNormalizer implements NormalizerInterface
{
    public function normalize($violationsList, $format = null, array $context = [])
    {
        $violations = [];
        $messages = [];

        foreach ($violationsList as $violation) {
            $propertyPath = $violation->getPropertyPath();

            $violations[] = [
                'propertyPath' => $propertyPath,
                'message' => $violation->getMessage(),
            ];

            $prefix = $propertyPath ? sprintf('%s: ', $propertyPath) : '';

            $messages [] = $prefix.$violation->getMessage();
        }

        return [
            'title' => 'An error occurred',
            'detail' => $messages ? implode("\n", $messages) : (string) $violationsList,
            'violations' => $violations,
        ];
    }

    public function supportsNormalization($data, $format = null)
    {
        return $data instanceof ConstraintViolationListInterface;
    }
}
