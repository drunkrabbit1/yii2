<?php

namespace app\controllers;

use app\models\FeedbackForm;
use app\models\FeedbackSearch;
use app\models\User;
use yii\filters\AccessControl;
use yii\web\Controller;

class BackendController extends Controller
{
    /**
     * @return array[]
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['backend'],
                'rules' => [
                    [
                        'actions' => ['backend'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * @return string
     */
    public function actionListFeedbackAll()
    {
        $searchModel = new FeedbackSearch();
        $dataProvider = $searchModel->search(\Yii::$app->request->get());

        $this->view->title = 'Список всех писем форм обратной связи';

        return $this->render('feedback-table', compact('dataProvider', 'searchModel'));
    }

    /**
     * @return string
     */
    public function actionListFeedbackForAuthorized()
    {
        $listAuthorizedUsers = User::find()->where(['auth_status' => true])->select('email')->asArray();
        $listAuthorizedUsers = array_column($listAuthorizedUsers->all(), 'email');
        $query = FeedbackForm::find()->where(['in', 'email', $listAuthorizedUsers]);

        $searchModel = new FeedbackSearch();

        $dataProvider = $searchModel->search(\Yii::$app->request->get(), $query);

        $this->view->title = 'Письма обратной связи только авторизированых пользователей';

        return $this->render('feedback-table', compact('dataProvider', 'searchModel'));
    }
}