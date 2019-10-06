<?php

namespace RequirementsApp\Action\Foo;

use CodexSoft\JsonApi\Form\AbstractForm;
use CodexSoft\JsonApi\Form\Field;
use CodexSoft\JsonApi\Documentation\Collector\Interfaces\SwagenInterface;
use Symfony\Component\Form\FormBuilderInterface;

class BarForm extends AbstractForm implements SwagenInterface
{
    
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);
        Field::import($builder, [
            'name' => Field::text(),
            'age' => Field::integer()->notNull(),
        ]);
    }
    
}