<?php
/**
 * @author    Yaroslav Velychko
 */

namespace app\modules\rbac\models\rules;

use app\modules\project\models\Project;
use Yii;
use yii\rbac\Item;
use yii\rbac\Rule;


/**
 * Check if Project belongs to user
 */
class ProjectRule extends Rule
{
    public $name = 'isProjectBelongsToUser';

    /**
     * @param string|int $userId the user ID.
     * @param Item $item the role or permission that this rule is associated width.
     * @param array $params parameters passed to ManagerInterface::checkAccess().
     * @return bool a value indicating whether the rule permits the role or permission it is associated with.
     */
    public function execute($userId, $item, $params)
    {
        if (isset($params['project'])) {
            /** @var Project $project */
            $project = $params['project'];
            $userIds = ($project->userIds) ?: [];
            if (in_array($userId, $userIds)) {
                return true;
            }
        }

        if (strpos($item->name, 'update') !== false) {
            Yii::$app->session->setFlash('warning', Yii::t('rbac', 'You don\'t have permission to')
                . ' ' . Yii::t('rbac', 'update this project'));
        }

        if (strpos($item->name, 'delete') !== false) {
            Yii::$app->session->setFlash('warning', Yii::t('rbac', 'You don\'t have permission to')
                . ' ' . Yii::t('rbac', 'delete this project'));
        }

        return false;
    }
}