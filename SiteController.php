<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\EntryForm;
use app\models\Students;
use app\models\Results;
use app\models\SoapClientCurl;
use yii\widgets\ActiveForm;

class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
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
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
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
        return $this->render('index');
    }
    public function actionRegistration()
    {
    	$model = new Students();
    
    	if ($model->load(Yii::$app->request->post())) {
    		if ($model->validate()) {
    			// form inputs are valid, do something here
    			return;
    		}
    	}
    
    	return $this->render('Registration', [
    			'model' => $model,
    	]);
    }
    public function actionEntry()
    {
    	$model = new EntryForm();
    
    	if ($model->load(Yii::$app->request->post()) && $model->validate()) {
    		// valid data received in $model
    
    		// do something meaningful here about $model ...
    
    		return $this->render('entry-confirm', ['model' => $model]);
    	} else {
    		// either the page is initially displayed or there is some validation error
    		return $this->render('entry', ['model' => $model]);
    	}
    }
    public function actionDashboard()
    {   
    	$model = new EntryForm();
    	return $this->render('dashboard',['model' => $model]);
    }
    
    public function actionD3sample() {
    	return $this->render('d3Sample');
    }
    
    public function actionD3() {
    	echo "<br/><br/><br/><br/><pre>";
    	$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, "http://www.w3schools.com/xml/note.xml");
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/xml'));
		
		$result = curl_exec($curl);
		curl_close($curl);
		print_r(json_decode($result));//return amazone autocomplete suggestion
		
		print_r(($result));
		$array = json_decode ($result, true);
		echo "</pre>";
		$result =  new Results();
		print_r($result->toArray($result));

    	return $this->render('d3');
    }
    
    public function actionCharts() {
    	
    	
    	return $this->render('charts');
    	
    }
    public function action_uploadStatus() {
    	 
    	 
    	return $this->render('_uploadStatus');
    	 
    }
    
      // femy added
    public function actionSay($message = 'Hello')
    {
    	return $this->render('say', ['message' => $message]);
    }

    public function actionChumma($firstpara = 'njan', $secondpara = 'epool' , $thirdpara = 'evide')
    {
    	return $this->render('varuthe', ['firstpara' => $firstpara, 'secondpara' => $secondpara, 'thirdpara' => $thirdpara]);
    }
    /**
     * Login action.
     *
     * @return string
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
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return string
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }
}
