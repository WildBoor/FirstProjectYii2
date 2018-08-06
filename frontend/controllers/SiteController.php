<?php
namespace frontend\controllers;

use common\models\UserSearch;
use Yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use common\models\SignupForm;
use frontend\models\ContactForm;
use common\models\User;
use yii\base\Security;
use yii\helpers\Url;
use yii\data\ActiveDataProvider;
use common\models\OperationForm;
use common\models\Operation;
use common\models\AccountSearch;
use common\models\OperationSearch;
use common\models\UploadForm;
use yii\web\UploadedFile;
use common\models\Bill;


/**
 * Site controller
 */
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
                'only' => ['logout', 'signup'],
                'rules' => [
                    [
                        'actions' => ['signup'],
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
//                'actions' => [
//                    'logout' => ['post'],
//                ],
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

    /**
     * Displays homepage.
     *
     * @return mixed
     */

    public function actionIndex()
    {
            return $this->render('index');
    }

    /**
     * Logs in a user.
     *
     * @return mixed
     */
    public function actionLogin()
    {
        $model = new LoginForm();
        if(Yii::$app->user->isGuest)
        {
            if ($model->load(Yii::$app->request->post()) &&
                $model->validate() && $model->login())      //Проверка на загрузку методом POST,
            {                                               //на валидацию данных и залогинен ли пользователь

                $obj = User::findOne(Yii::$app->user->id);
                $bill = $obj->bill;                         //Используем связанные данные, в данном случае
                $role = $obj->role;                         // связь в таблице user и  bill один к одному,
                                                            //поэтому $bill - это строка из соотв. таблицы
                                                            //Эквивалент запроса на SQL:
                                                            //SELECT*FROM 'bill' WHERE 'user_id' = (id пользователя)
                return $this->render('account',
                    [
                        'username' => $username = $obj->username,
                        'bill' => $bill->bill,
                        'amount' => $bill->amount,
                        'role' => $role,
                    ]);

            } else {

                $model->password = '';
                return $this->render('login',
                    [
                        'model' => $model,
                    ]);

            }
        } else {

            $obj = User::findOne(Yii::$app->user->id);
            $bill = $obj->bill;
            $role = $obj->role;

            return $this->render('account',
                [
                    'username' => $username = $obj->username,
                    'bill' => $bill->bill,
                    'amount' => $bill->amount,
                    'role' => $role,
                ]);
        }
    }

    /**
     * Logs out the current user.
     *
     * @return mixed
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /*Перечисление средств другому пользователю
     * 
     */
    public function actionTransfer()
    {
        
        $model = new OperationForm();
        $obj = User::findOne(Yii::$app->user->id);
        
        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->operation())
        {
            $bill = $obj->bill;
            
            return $this->render('transfer',
                [
                    'model' => $model,
                    'username' => $username = $obj->username,
                    'bill' => $bill->bill,
                    'amount' => $bill->amount,
                ]);
        }
        
        $bill = User::findOne(Yii::$app->user->id)->bill;
        
        return $this->render('transfer',
            [
                'model' => $model,
                'username' => $username = $obj->username,
                'bill' => $bill->bill,
                'amount' => $bill->amount,
            ]);
    }


    /*Для администратора загружается список всех пользователей, а пользовтель  
     *  видит список всех операций, в которых он учавствовал. 
     */
    public function actionList()
    {
        $obj = User::findOne(Yii::$app->user->id);
        $bill = $obj->bill;
        $role = $obj->role;

        if ($role !== 1)
        {
            $searchModel = new OperationSearch();
        } else {
            $searchModel = new UserSearch();
        }
            
        $dataProvider = $searchModel->search(Yii::$app->request->get());
        
        return $this->render('list',
            [
                'dataProvider' => $dataProvider,
                'searchModel' => $searchModel,
                'username' => $username = $obj->username,
                'bill' => $bill->bill,
                'amount' => $bill->amount,
                'role' => $role,
            ]);
    }
    
    /*Страница со списком всех операций: админ(отпр.)-юзер(получ.),  
     * юзер(отпр.)-админ(получ.),юзер(отпр.)-юзер(получ.). Данная страница, как 
     * и страница списка всех пользователей, есть только у администратора.
     */
    public function actionOperations()
    {

        $searchModel = new OperationSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->get());

        $obj = User::findOne(Yii::$app->user->id);
        $role = $obj->role;
        $bill = $obj->bill;

        return $this->render('operations',
            [
                'dataProvider' => $dataProvider,
                'searchModel' => $searchModel,
                'username' => $username = $obj->username,
                'bill' => $bill->bill,
                'amount' => $bill->amount,
                'role' => $role,
            ]);
    }




    /**
     * Signs user up.
     *
     * @return mixed
     */
    public function actionSignup()
    {
        $obj = User::findOne(Yii::$app->user->id);
        
        if (!Yii::$app->user->isGuest) 
        {
            $role = $obj->role;
            $bill = $obj->bill;

            return $this->render('account',
                [
                    'username' => $username = $obj->username,
                    'bill' => $bill->bill,
                    'amount' => $bill->amount,
                    'role' => $role,
                ]);
        }

       $model = new SignupForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) 
        {
            if ($user = $model->signup()) 
            {
                if (Yii::$app->getUser()->login($user)) 
                {
                    $role = $obj->role;
                    $bill = $obj->bill;

                    return $this->render('account',
                        [
                            'username' => $username = $obj->username,
                            'bill' => $bill->bill,
                            'amount' => $bill->amount,
                            'role' => $role,
                        ]);
               }
           }
        }


        return $this->render('signup',
            [
                'model' => $model,
            ]);
    }

}
