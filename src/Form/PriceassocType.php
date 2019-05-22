<?php
namespace App\Form;
use App\Entity\Priceassoc;
use App\Form\DataTransformer\AssocToNumberTransformer;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
class PriceassocType extends AbstractType
{
    protected $em;
    public function __construct(EntityManager $em){
        $this->em = $em;
    }
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $tranformer = new AssocToNumberTransformer($this->em);
        $builder
            ->add('value')
            ->add('assoc', HiddenType::class)
            ->add('type')
        ;
        $builder->get('assoc')
            ->addModelTransformer($tranformer);
    }
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Priceassoc::class,
        ]);
    }
}
