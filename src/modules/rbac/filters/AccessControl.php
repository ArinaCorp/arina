<?php
/**
 * @author    Yaroslav Velychko
 */

namespace app\modules\rbac\filters;

use app\modules\rbac\models\ActionAccess;
use app\modules\rbac\models\AuthItem;
use Yii;
use yii\base\InlineAction;
use yii\filters\AccessControl as BaseAccessControl;
use yii\filters\AccessRule;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\ErrorAction;
use yii\web\Response;

class AccessControl extends BaseAccessControl
{
    public $controller;

    public function init()
    {
        /** @var Controller $controller */
        $controllerClass = $this->controller;
        $module = $controllerClass->module->id;
        $controller = $controllerClass->id;
        $action = $controllerClass->action->id;
        $this->rules = $this->getRules($module, $controller, $action);
        /**
         * @param $rule AccessRule|null
         * @param $action ErrorAction|InlineAction
         * @return Response
         */
        $this->denyCallback = function ($rule, $action) {
            $controller = $action->controller;
            if (Yii::$app->user->isGuest) {
                return $controller->redirect('/user/login');
            }
            Yii::$app->session->setFlash('warning', Yii::t('rbac', 'You don\'t have permission to')
                . ' ' . Yii::t('rbac', 'do this action'));
            return $controller->redirect(Yii::$app->request->referrer);
        };
        parent::init();
    }

    public function getRules($module, $controller, $action)
    {
        $rules = $this->rules;

        if (Yii::$app->user->isGuest) {
            $rules[] = [
                'allow' => false,
                'actions' => [
                    $action
                ],
            ];
        } else {
            /** @var ActionAccess $actionAccess */
            $actionAccess = ActionAccess::find()
                ->with(['authItems'])
                ->where([
                    'module' => $module,
                    'controller' => $controller,
                    'action' => $action,
                ])
                ->one();
            if ($actionAccess) {
                $newRule = [];
                $roles = [];
                /** @var AuthItem[] $items */
                $items = $actionAccess->authItems;
                if ($items) {
                    foreach ($items as $item) {
                        $roles[] = $item->name;
                    }
                    $newRule = [
                        'allow' => true,
                        'actions' => [
                            $action
                        ],
                        'roles' => $roles,
                    ];
                }

                $isEdited = false;
                if (!empty($newRule)) {
                    foreach ($rules as $key => $rule) {
                        if (in_array($action, $rule['actions']) && $rule['allow']) {
                            if (count($rule['actions']) == 1) {
                                $isEdited = true;
                            }
                            $rules[$key]['roles'] = ArrayHelper::merge($rules[$key]['roles'], $roles);
                        }
                    }
                }
                if (!$isEdited) {
                    if (!$items) {
                        $rules[] = [
                            'allow' => true,
                            'actions' => [
                                $action
                            ],
                        ];
                    } else {
                        $rules[] = $newRule;
                    }

                }
            } else {
                $rules[] = [
                    'allow' => true,
                    'actions' => [
                        $action
                    ],
                ];
            }
            if (!count($rules) && !Yii::$app->user->isGuest) {
                $rules[] = [
                    'allow' => true,
                    'actions' => [
                        $action
                    ],
                ];
            }
        }

        return $rules;
    }


}