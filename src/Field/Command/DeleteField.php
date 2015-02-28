<?php namespace Anomaly\Streams\Platform\Field\Command;

use Anomaly\Streams\Platform\Field\Contract\FieldInterface;

/**
 * Class DeleteField
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Field\Command
 */
class DeleteField
{

    /**
     * The field interface.
     *
     * @var FieldInterface
     */
    protected $field;

    /**
     * Create a new DeleteField instance.
     *
     * @param FieldInterface $field
     */
    public function __construct(FieldInterface $field)
    {
        $this->field = $field;
    }

    /**
     * Get the field.
     *
     * @return FieldInterface
     */
    public function getField()
    {
        return $this->field;
    }
}
