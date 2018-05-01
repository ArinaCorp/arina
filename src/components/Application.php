<?php
/**
 * @author    Dmytro Karpovych
 * @copyright 2018 NRE
 */


namespace app\components;


use Yii;
use yii\web\Application as WebApplication;

class Application extends WebApplication
{
    /**
     * Sets the directory that stores vendor files.
     * @param string $path the directory that stores vendor files.
     */
    public function setVendorPath($path)
    {
        parent::setVendorPath($path);
        $vendorPath = $this->getVendorPath();
        Yii::setAlias('@bower', $vendorPath . DIRECTORY_SEPARATOR . 'bower-asset');
        Yii::setAlias('@npm', $vendorPath . DIRECTORY_SEPARATOR . 'npm-asset');
    }

}