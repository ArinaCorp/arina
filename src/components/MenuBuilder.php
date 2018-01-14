<?php
/**
 * @author    Dmytro Karpovych
 * @copyright 2018 NRE
 */

namespace app\components;


use nullref\admin\components\MenuBuilder as BaseMenuBuilder;

class MenuBuilder extends BaseMenuBuilder
{
    /**
     * Modify menu items
     *
     * @param array $items
     * @return array
     */
    public function build($items)
    {
        /** Move geo module to directories section */
        $items['directories']['items'][] = $items['geo'];
        unset($items['geo']);

        return $this->filterByRole($items, 'admin');
    }
}