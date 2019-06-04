<?php
/**
 * @author    Dmytro Karpovych
 * @copyright 2016 NRE
 */


namespace app\modules\directories\assets;


use yii\web\AssetBundle;

class SubjectCycleTreeAsset extends AssetBundle
{
    public $sourcePath = '@app/modules/directories/assets/subject-cycle';
    public $js = [
        'jquery.mjs.nestedSortable.js',
        'tree.js',
    ];
    public $css = [
        'tree.css',
    ];
    public $depends = [
        'yii\jui\JuiAsset',
    ];
}