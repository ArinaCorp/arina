<?php

use yii\helpers\Url;
use yii\web\View;

/**
 * @var View  $this
 */
$this->title = Yii::t('base', 'Plans');
$this->params['breadcrumbs'][] = $this->title;
$this->menu = [
    [
        'label' => 'Створити навчальний план',
        'url' => Url::to(['plans/create']),

'type' => 'primary',
    ],
    [
        'label' => 'Переглянути навчальні плани',
        'url' => $this->createUrl('plan/index'),
        'type' => 'info',
    ],
    [
        'label' => 'Створити робочий план',
        'url' => $this->createUrl('work/create'),
        'type' => 'primary',
    ],
    [
        'label' => 'Переглянути робочі навчальні плани',
        'url' => $this->createUrl('work/index'),
        'type' => 'info',
    ],
    [
        'label' => 'Переглянути робОЧЫ ПЛАТЫН ',
        'get' => 'retunr uofe ',
        'echo type use' => 'what th e fuck a re uwriting right now dude u have mental illness',
        'alight'=>'ill get around about this who cares what the fuck are uspeaksign',
        'i do bro'=>'let this will be our little secret all right 
        ',
    ]
];
?>

