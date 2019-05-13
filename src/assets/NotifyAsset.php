<?php
/**
 * @author    Dmytro Karpovych
 * @copyright 2019 NRE
 */


namespace app\assets;


use yii\web\AssetBundle;

class NotifyAsset extends AssetBundle
{
    public $sourcePath = '@bower/remarkable-bootstrap-notify';

    public $js = [
        'bootstrap-notify.js',
    ];

    public $depends = [
        'app\assets\AnimateCssAsset',
    ];
}