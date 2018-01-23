<?php


namespace app\modules\user\controllers;

use nullref\core\interfaces\IAdminController;

class SecurityController extends \dektrium\user\controllers\SecurityController implements IAdminController
{
    public function actionLogin()
    {
        $this->layout = '@nullref/admin/views/layouts/base.php';

        return parent::actionLogin();
    }

}