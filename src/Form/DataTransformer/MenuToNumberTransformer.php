<?php
namespace App\Form\DataTransformer;
use App\Entity\Menu;
use Symfony\Component\Form\DataTransformerInterface;
use Doctrine\ORM\EntityManagerInterface;
class MenuToNumberTransformer implements DataTransformerInterface
{
    private $entityManager;
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
    /**
     * Transforms an object (assoc) to a string (number).
     *
     * @param Menu|null $menu
     * @return string
     */
    public function transform($menu)
    {
        if (null === $menu) {
            return '';
        }
        return $menu->getId();
    }
    /**
     * Transforms a string (number) to an object (assoc).
     *
     * @param string $menuNumber
     * @return Menu|null
     * @throws TransformationFailedException if object (assoc) is not found.
     */
    public function reverseTransform($menuNumber)
    {
        // no issue number? It's optional, so that's ok
        if (!$menuNumber) {
            return;
        }
        $menu = $this->entityManager
            ->getRepository(Menu::class)
            // query for the issue with this id
            ->find($menuNumber);
        if (null === $menuNumber) {
            // causes a validation error
            // this message is not shown to the user
            // see the invalid_message option
            throw new TransformationFailedException(sprintf(
                'price with number "%s" does not exist!',
                $menuNumber
            ));
        }
        return $menu;
    }
}
