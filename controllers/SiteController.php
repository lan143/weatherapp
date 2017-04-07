<?php

namespace app\controllers;

use app\forms\FilterForm;
use app\models\City;
use app\models\WeatherData;
use app\weather\Weather;
use Yii;
use yii\web\Controller;

class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        $filter = new FilterForm();

        if (Yii::$app->request->isPost)
            $filter->load(Yii::$app->request->post());

        $cities = City::find()->all();

        $data = WeatherData::find()
            ->select(['ROUND(5/9 * (avg(temp) - 32)) as temp', 'DATE_FORMAT(FROM_UNIXTIME(`date`), \'%Y-%m-%d\') as `date`', 'IF(HOUR(FROM_UNIXTIME(`date`)) < 7, 1, 0) as `night`'])
            ->andWhere(['>=', 'date', $filter->unixFrom])
            ->andWhere(['<=', 'date', $filter->unixTo])
            ->andWhere(['city_id' => $filter->city_id])
            ->groupBy(['DATE_FORMAT(FROM_UNIXTIME(`date`), \'%Y%m%d\')', 'HOUR(FROM_UNIXTIME(`date`)) < 7'])
            ->asArray()
            ->all();

        $weather = new Weather();
        $days_data = $weather->generateData($data);

        return $this->render('index', [
            'filter' => $filter,
            'cities' => $cities,
            'days_data' => $days_data,
            'from' => $filter->unixFrom,
            'to' => $filter->unixTo
        ]);
    }
}
