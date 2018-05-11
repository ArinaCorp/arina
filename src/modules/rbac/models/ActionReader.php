<?php
/**
 * @author    Yaroslav Velychko
 */

namespace app\modules\rbac\models;


use app\modules\rbac\interfaces\IAccessibleModule;
use Yii;

class ActionReader
{
    public $map;

    function __construct()
    {
        $this->map = self::getControllersAndActions();
    }

    /**
     * @return array
     */
    public static function getControllersAndActions()
    {
        $aliases = self::prepareAliases();

        $controllerList = [];
        foreach ($aliases as $alias) {
            $dirPath = Yii::getAlias($alias['alias']);
            $realPath = realpath($dirPath);
            if ($realPath && $handle = opendir($realPath)) {
                while (false !== ($file = readdir($handle))) {
                    if ($file != "." && $file != ".." && substr($file, strrpos($file, '.') - 10) == 'Controller.php') {
                        $controllerList[] = [
                            'file' => $file,
                            'path' => $realPath,
                            'module' => $alias['module'],
                        ];
                    }
                }
                closedir($handle);
            }
        }
        asort($controllerList);
        $fullList = [];
        foreach ($controllerList as $controller) {
            $handle = fopen($controller['path'] . '/' . $controller['file'], "r");
            if ($handle) {
                while (($line = fgets($handle)) !== false) {
                    if (preg_match('/public function action(.*?)\(/', $line, $display)) {
                        if (strlen($display[1]) > 2) {
                            $name = substr($controller['file'], 0, -14);
                            $matches = [];
                            preg_match_all('/[A-Z]/', $name, $matches, PREG_OFFSET_CAPTURE);
                            if (isset($matches[0])) {
                                $matches = $matches[0];
                                $length = count($matches);
                                if ($length > 1) {
                                    for ($i = 1; $i < $length; $i++) {
                                        $name = substr($name, 0, $matches[$i][1]) . '-' . substr($name, $matches[$i][1]);
                                    }
                                }
                            }
                            $name = strtolower($name);
                            $fullList[$controller['module']][$name][] = strtolower($display[1]);
                        }
                    }
                }
            }
            fclose($handle);
        }

        return $fullList;
    }

    /**
     * Get controller aliases for module if possible
     *
     * @param $module
     * @return bool|array
     */
    protected static function getAccessibleControllerAliases($module)
    {
        $methodName = 'getAccessibleControllerAliases';

        if ($module instanceof IAccessibleModule) {
            return $module::getAccessibleControllerAliases();
        } elseif (is_array($module) && isset($module['class']) && method_exists($module['class'], $methodName)) {
            $reflection = new \ReflectionMethod($module['class'], $methodName);
            if ($reflection->isStatic() && $reflection->isPublic()) {

                return call_user_func(array($module['class'], $methodName));
            }
        }
        return false;
    }

    /**
     * @return array
     */
    public static function prepareAliases()
    {
        $aliases = [];

        $modules = Yii::$app->modules;
        foreach ($modules as $id => $module) {
            $result = self::getAccessibleControllerAliases($module);
            if ($result) {
                foreach ($result as $alias) {
                    $aliases[] = [
                        'alias' => $alias,
                        'module' => $id,
                    ];
                }
            }

        }

        return $aliases;
    }

    /**
     * @return array
     */
    public function getModulesJs()
    {
        $items = [];
        foreach ($this->getModules() as $key => $val) {
            $items[$key] = [
                'id' => $val,
                'name' => $val,
            ];
        }
        return $items;
    }

    /**
     * @return array
     */
    public function getModules()
    {
        $items = [];
        foreach (array_keys($this->map) as $val) {
            $items[$val] = $val;
        }
        return $items;
    }

    /**
     * @param $module
     * @return array
     */
    public function getControllersJs($module)
    {
        $items = [];
        if ($module) {
            foreach ($this->getControllers($module) as $key => $val) {
                $items[$key] = [
                    'id' => $val,
                    'name' => $val,
                ];
            }
        }
        return $items;
    }

    public function getControllers($module)
    {
        $items = [];
        if ($module) {
            if (isset($this->map[$module])) {
                foreach (array_keys($this->map[$module]) as $val) {
                    $items[$val] = $val;
                }
            }
        }
        return $items;
    }

    public function getActionsJs($module, $controller)
    {
        $items = [];
        if ($module && $controller) {
            foreach ($this->getActions($module, $controller) as $key => $val) {
                $items[$key] = [
                    'id' => $val,
                    'name' => $val,
                ];
            }
        }
        return $items;
    }

    public function getActions($module, $controller)
    {
        $items = [];
        if ($module && $controller) {
            if (isset($this->map[$module][$controller])) {
                foreach ($this->map[$module][$controller] as $val) {
                    $items[$val] = $val;
                }
            }

        }
        return $items;
    }
}