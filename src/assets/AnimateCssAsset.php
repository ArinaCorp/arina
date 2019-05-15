<?php
/**
 * @author    Dmytro Karpovych
 * @copyright 2019 NRE
 */


namespace app\assets;


use yii\web\AssetBundle;

class AnimateCssAsset extends AssetBundle
{
    public $sourcePath = '@bower/animate.css';

    public $css = [
        'animate.css',
    ];
}