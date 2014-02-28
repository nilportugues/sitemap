<?php
/*
 * Author: Nil Portugués Calderó <contact@nilportugues.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sonrisa\Component\Sitemap\Collections;
use Sonrisa\Component\Sitemap\Items\ItemInterface;

/**
 * Class AbstractItemCollection
 * @package Sonrisa\Component\Sitemap\Collections
 */
abstract class AbstractItemCollection
{
    /**
     * @var array
     */
    protected $collection;

    /**
     *
     */
    public function __construct()
    {
        $this->collection = array();
    }

    /**
     * @param ItemInterface $item
     * @return mixed
     */
    abstract function add(ItemInterface $item);

    /**
     * @return array
     */
    public function get()
    {
        return $this->collection;
    }
}