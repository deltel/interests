<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\data\Pagination;
use app\models\Interests;
use app\models\Instruments;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
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

    public function actionIndex()
	{
		$query = Interests::find();

		$pagination = new Pagination([
			'defaultPageSize' => 5,
            'totalCount' => $query->count()
		]);

		$interests = $query->orderBy('interest_id')
            ->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();

		return $this->render('index', [
            'interests' => $interests,
            'pagination' => $pagination,
        ]);
	}

	public function actionNew()
	{
		$query = Instruments::find();

		$instruments = $query->all();
		$instrumentsOptions = ArrayHelper::map($instruments, 'ins_code', 'description');


		$model = new Interests();
		if ($model->load(Yii::$app->request->post()) && $model->new()) {
            return $this->redirect(array('site/index'));
        }

		return $this->render('new', [
			'model' => $model,
			'instruments' => $instrumentsOptions,
			'edit' => false,
		]);
	}
	
	public function actionEdit()
	{
		$query = Interests::findOne($this->request->queryParams['id']);

		$dropdownQuery = Instruments::find();
		$instruments = $dropdownQuery->all();
		$instrumentsOptions = ArrayHelper::map($instruments, 'ins_code', 'description');


		$model = $query;
		if ($model->load(Yii::$app->request->post()) && $model->new()) {
            return $this->redirect(array('site/index'));
        }

		return $this->render('new', [
			'model' => $model,
			'instruments' => $instrumentsOptions,
			'edit' => true
		]);
	}
	
	public function actionDelete()
	{
		$model = Interests::findOne($this->request->queryParams['id']);

		if ($model->remove()) {
            return $this->redirect(array('site/index'));
        }
	}
	
	public function actionApprove()
	{
		$model = Interests::findOne($this->request->queryParams['id']);

		if ($model->approve()) {
            return $this->redirect(array('site/index'));
        }
	}
	
	public function actionCancel()
	{
		$model = Interests::findOne($this->request->queryParams['id']);

		if ($model->cancel()) {
            return $this->redirect(array('site/index'));
        }
	}

}
