<?php

namespace app\controllers;

use app\models\FeedbackForm;
use app\models\SignupForm;
use app\models\User;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['login', 'logout', 'signup'],
                'rules' => [
                    [
                        'actions' => ['login', 'signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                    'feedback' => ['post'],
                ],
            ]
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
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
        $model = new FeedbackForm();

        return $this->render('index', compact('model'));
    }

    /**
     * @return string
     */
    public function actionFeedback()
    {
        $model = new FeedbackForm();
        $data = \Yii::$app->request->post('FeedbackForm', []);

        $model->setAttribute('firstname', $data['firstname']);
        $model->setAttribute('lastname', $data['lastname']);
        $model->setAttribute('phone', $data['phone']);
        $model->setAttribute('email', $data['email']);
        $model->setAttribute('body', $data['body']);
        $model->save(false);

        return $this->render('feedback-confirm', compact('model'));
    }

    /**
     * Signup action.
     *
     * @return string|Response
     */
    public function actionSignup(){
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new SignupForm();
        if ($model->load(\Yii::$app->request->post()) && $model->signup()) {
            return $this->response->redirect('/login');
        }

        return $this->render('signup', compact('model'));
    }


    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        $user = User::findOne(Yii::$app->user->id);
        $user->setAttribute('auth_status', false);
        $user->save();

        Yii::$app->user->logout();

        return $this->goHome();
    }
}
