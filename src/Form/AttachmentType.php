<?php

namespace App\Form;

use App\Entity\Attachment;
use App\Form\DataTransformer\FilesToAttachements;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\DataMapperInterface;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AttachmentType extends AbstractType  implements DataMapperInterface
{

    /**
     * @inheritDoc
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('file', FileType::class, [
                'required' => false,
                'label' => false,
                'multiple' => true,
                'setter' => function (&$task): void {
                    dd($task);
                },
                'attr' => ['class' => 'custom-file-input'],
            ])
        ;

    }

    public function configureOptions(OptionsResolver $resolver): void
    {

    }

    public function mapDataToForms(mixed $viewData, \Traversable $forms): void
    {
        // TODO: Implement mapDataToForms() method.
    }

    public function mapFormsToData(\Traversable $forms, mixed &$viewData): void
    {
        dd($forms, $viewData);

        // TODO: Implement mapFormsToData() method.
    }
}
