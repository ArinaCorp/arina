<?php
/**
 * @author    Dmytro Karpovych
 * @copyright 2018 NRE
 */


namespace app\assets;


use yii\web\AssetBundle;

class DynamicFormAsset extends AssetBundle
{
    public $js = [
        //'tools.js',
        'dynamic-form.js',
    ];

    public $sourcePath = '@webroot/js';
}