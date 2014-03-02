<?php
/*
 * Author: Nil Portugués Calderó <contact@nilportugues.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Sonrisa\Component\Sitemap;

use Sonrisa\Component\Sitemap\Items\IndexItem;
use Sonrisa\Component\Sitemap\Validators\IndexValidator;

/**
 * Class IndexSitemap
 * @package Sonrisa\Component\Sitemap
 */
class IndexSitemap extends AbstractSitemap implements SitemapInterface
{

    /**
     * @var ImageItem
     */
    protected $lastItem;

    /**
     *
     */
    public function __construct()
    {
        $this->validator = new IndexValidator();
    }

    /**
     * @param $item
     * @return $this
     */
    public function add(IndexItem $item)
    {
        $loc = $item->getLoc();

        if (!empty($loc) && !in_array($loc,$this->used_urls,true)) {

            //Mark URL as used.
            $this->used_urls[] = $loc;

            $item = new IndexItem($this->validator);

            //Check constrains
            $current = $this->current_file_byte_size + $item->getHeaderSize() + $item->getFooterSize();

            //Check if new file is needed or not. ONLY create a new file if the constrains are met.
            if ( ($current <= $this->max_filesize) && ( $this->total_items <= $this->max_items_per_sitemap) ) {
                //add bytes to total
                $this->current_file_byte_size = $item->getItemSize();

                //add item to the item array
                $built = $item->build();
                if (!empty($built)) {
                    $this->items[] = $built;

                    $this->files[$this->total_files] = implode("\n",$this->items);

                    $this->total_items++;
                }

            } else {
                //reset count
                $this->current_file_byte_size = 0;

                //copy items to the files array.
                $this->total_files=$this->total_files+1;
                $this->files[$this->total_files] = implode("\n",$this->items);

                //reset the item count by inserting the first new item
                $this->items = array($item);
                $this->total_items=1;
            }
            $this->lastItem = $item;
        }

        return $this;
    }

    /**
     * @param  IndexCollection $collection
     * @return $this
     */
    public function addCollection(IndexCollection $collection)
    {
        return $this;
    }

    /**
     * @return array
     */
    public function build()
    {
        return self::buildFiles($this->lastItem);
    }
}
