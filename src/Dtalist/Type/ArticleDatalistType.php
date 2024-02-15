<?php

namespace App\Dtalist\Type;

use App\Entity\Archive;
use App\Entity\Article;
use App\Entity\Type;
use App\Repository\ArchiveRepository;
use App\Repository\TypeRepository;
use EasyCorp\Bundle\EasyAdminBundle\Filter\TextFilter;
use Leapt\CoreBundle\Datalist\DatalistBuilder;
use Leapt\CoreBundle\Datalist\Field\Type\TextFieldType;
use Leapt\CoreBundle\Datalist\Filter\Type\EntityFilterType;
use Leapt\CoreBundle\Datalist\Filter\Type\SearchFilterType;
use Leapt\CoreBundle\Datalist\Type\DatalistType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ArticleDatalistType extends DatalistType
{
    public function configureOptions(OptionsResolver $resolver): void
    {
        parent::configureOptions($resolver);

        $resolver
            ->setDefaults([
                'limit_per_page' => 9,
                'data_class'     => Article::class,

            ])
        ;
    }

    public function buildDatalist(DatalistBuilder $builder, array $options): void
    {
        $builder
            ->addField('title', TextFieldType::class, [
                'label' => 'Titre',
            ])
            ->addFilter('title', SearchFilterType::class, [
                'search_fields'=> ['n.titre'],
                'label' => 'Titre',
            ])
            ->addFilter('type', EntityFilterType::class, [
                'class' => Type::class,
                'property_path' => 'n.type',
                'label' => 'Type d\'article',
                'query_builder' => function (TypeRepository $er) {
                    return $er->createQueryBuilder('u');
                },
            ])
            ->addFilter('annee', EntityFilterType::class, [
                'class' => Archive::class,
                'property_path' => 'n.annee',
                'label' => 'Edition de ronde',
                'query_builder' => function (ArchiveRepository $er) {
                    return $er->createQueryBuilder('f')
                        ->orderBy('f.annee','DESC');
                },
            ]);
    }
}