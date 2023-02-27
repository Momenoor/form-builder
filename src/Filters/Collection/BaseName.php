<?php

namespace Momenoor\FormBuilder\Filters\Collection;

use Momenoor\FormBuilder\Filters\FilterInterface;

/**
 * Class BaseName
 *
 * @package Momenoor\FormBuilder\Filters\Collection
 * @author  Djordje Stojiljkovic <djordjestojilljkovic@gmail.com>
 */
class BaseName implements FilterInterface
{
    /**
     * @param string $value
     * @param array $options
     *
     * @return string
     */
    public function filter($value, $options = [])
    {
        $value = (string) $value;
        return basename($value);
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'BaseName';
    }
}
