<?php

namespace Afup\Barometre\Filter;

use Symfony\Component\Form\FormBuilderInterface;
use Doctrine\ORM\QueryBuilder;

use Afup\BarometreBundle\Enums\CompanySizeEnums;
use Afup\Barometre\Form\Type\Select2MultipleFilterType;

class CompanySizeFilter implements FilterInterface
{
    /**
     * @var CompanySizeEnums
     */
    private $companySizes;

    /**
     * @param CompanySizeEnums $companySizes
     */
    public function __construct(CompanySizeEnums $companySizes)
    {
        $this->companySizes = $companySizes;
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder)
    {
        $builder->add($this->getName(), new Select2MultipleFilterType(), [
            'label'    => 'filter.company_size',
            'choices'  => $this->companySizes->getChoices()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function buildQuery(QueryBuilder $queryBuilder, array $values = array())
    {
        if (!array_key_exists($this->getName(), $values) || 0 === count($values[$this->getName()])) {
            return;
        }

        $queryBuilder
            ->andWhere($queryBuilder->expr()->in('response.companySize', $values[$this->getName()]));
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'company_size';
    }
}
