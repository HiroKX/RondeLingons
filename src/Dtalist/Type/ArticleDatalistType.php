<?php

namespace App\Dtalist\Type;

use App\Entity\Article;
use EasyCorp\Bundle\EasyAdminBundle\Filter\TextFilter;
use Leapt\CoreBundle\Datalist\DatalistBuilder;
use Leapt\CoreBundle\Datalist\Field\Type\TextFieldType;
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
                'limit_per_page' => 10,
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
        ;
    }
}