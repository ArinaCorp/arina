#Components

##Calendar 

`app\modules\plans\components\Calendar`

Provide current study week and year for current session

Public methods:
- `getCurrentYear(): StudyYear`
- `getCurrentMonth(): int`
- `getCurrentWeek(): int`

Example of usage:
```php
//Define field to store component

/** @var Calendar */
protected $_calendar;

//Inject component at constructor arguments

/**
 * SiteController constructor.
 * @param Calendar $calendar
 * @param string $id
 * @param Module $module
 * @param array $config
 */
public function __construct(string $id, Module $module, Calendar $calendar, array $config = [])
{
    $this->_calendar = $calendar;
    parent::__construct($id, $module, $config);
}

//Using at method

/**
 * @return \yii\web\Response
 * @throws BadRequestHttpException
 */
public function actionDomeSomething()
{
    $studyYear = $this->_calendar->getCurrentYear();
    return $this->asJson($studyYear);
}
```