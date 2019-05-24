<?php

namespace App\Form\DataTransformer;

use App\Entity\Assoc;
use Symfony\Component\Form\DataTransformerInterface;
use Doctrine\ORM\EntityManagerInterface;

class AssocToNumberTransformer implements DataTransformerInterface
{
    private $entityManager;
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
    /**
     * Transforms an object (assoc) to a string (number).
     *
     * @param Assoc|null $assoc
     * @return string
     */
    public function transform($assoc)
    {
        if (null === $assoc) {
            return '';
        }
        return $assoc->getId();
    }
    /**
     * Transforms a string (number) to an object (assoc).
     *
     * @param string $productNumber
     * @return Assoc|null
     * @throws TransformationFailedException if object (assoc) is not found.
     */
    public function reverseTransform($assocNumber)
    {
        // no issue number? It's optional, so that's ok
        if (!$assocNumber) {
            return;
        }
        $assoc = $this->entityManager
            ->getRepository(Assoc::class)
            // query for the issue with this id
            ->find($assocNumber);
        if (null === $assocNumber) {
            // causes a validation error
            // this message is not shown to the user
            // see the invalid_message option
            throw new TransformationFailedException(sprintf(
                'price with number "%s" does not exist!',
                $assocNumber
            ));
        }
        return $assoc;
    }
}
