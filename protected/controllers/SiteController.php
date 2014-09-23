<?php

class SiteController extends Controller
{
    public $layout='//layouts/modcopter';

	/**
	 * Declares class-based actions.
	 */
	public function actions()
	{
		return array(
			'page'=>array(
				'class'=>'CViewAction',
			),
            'upload'=>array(
                'subfolderVar' => Yii::app()->user->getId() . '-modCopter',
                'class'=>'xupload.actions.XUploadAction',
                'path' =>Yii::app() -> getBasePath() . "/../uploads",
                'publicPath' => Yii::app() -> getBaseUrl() . "/uploads"
            ),
		);
	}

    public function filters()
    {
        return array(
            'accessControl'
        );
    }

    public function accessRules()
    {
        return array(
            array('allow', // allow authenticated
                'users'=>array('@')
            ),
            array('deny',  // deny all users
                'users'=>array('*')
            ),
        );
    }

    /**
     * Start the execution of the model generation script
     */
    public function actionGenerateModel() {
        if(file_exists(Yii::app()->getBasePath() . '/../uploads/process.sh')) {
            chdir(Yii::app()->getBasePath() . '/../uploads/');
            //for debugging remove |at now and add 2>&1
            echo shell_exec('./process.sh|at now'); //runs processing script as a separate process
        }
    }

    /**
     * Checks if the model has finished generating
     */
    public function actionIsModelReady() {
        $result = array(
            'ready'=> false,
        );
        if(file_exists(Yii::app()->getBasePath() . '/../uploads/' .
                Yii::app()->user->getId() . '-modCopter' . '/output.zip')) {
            $result['ready'] = true;
        }

        $this->renderJSON($result);
    }

    /**
     * Downloads the 3D model when it's available
     * @return mixed
     */
    public function actionDownloadModel() {
        if(file_exists(Yii::app()->getBasePath() . '/../uploads/' .
            Yii::app()->user->getId() . '-modCopter' . '/output.zip')) {

            $file =  'output.zip';
            return Yii::app()->getRequest()->sendFile(basename($file), @file_get_contents(Yii::app()->getBasePath().
                '/../uploads/' . Yii::app()->user->getId() . '-modCopter/'.$file));
        }
    }

	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex()
	{
        Yii::import("xupload.models.XUploadForm");
        $model = new XUploadForm;
        $this -> render('index', array('model' => $model));
	}





	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
		if($error=Yii::app()->errorHandler->error)
		{
			if(Yii::app()->request->isAjaxRequest)
				echo $error['message'];
			else
				$this->render('error', $error);
		}
	}

	/**
	 * Displays the contact page
	 */
	public function actionContact()
	{
		$model=new ContactForm;
		if(isset($_POST['ContactForm']))
		{
			$model->attributes=$_POST['ContactForm'];
			if($model->validate())
			{
				$name='=?UTF-8?B?'.base64_encode($model->name).'?=';
				$subject='=?UTF-8?B?'.base64_encode($model->subject).'?=';
				$headers="From: $name <{$model->email}>\r\n".
					"Reply-To: {$model->email}\r\n".
					"MIME-Version: 1.0\r\n".
					"Content-type: text/plain; charset=UTF-8";

				mail(Yii::app()->params['adminEmail'],$subject,$model->body,$headers);
				Yii::app()->user->setFlash('contact','Thank you for contacting us. We will respond to you as soon as possible.');
				$this->refresh();
			}
		}
		$this->render('contact',array('model'=>$model));
	}

	/**
	 * Displays the login page
	 */
	public function actionLogin()
	{
		$model=new LoginForm;

		// if it is ajax validation request
		if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

		// collect user input data
		if(isset($_POST['LoginForm']))
		{
			$model->attributes=$_POST['LoginForm'];
			// validate user input and redirect to the previous page if valid
			if($model->validate() && $model->login())
				$this->redirect(Yii::app()->user->returnUrl);
		}
		// display the login form
		$this->render('login',array('model'=>$model));
	}

	/**
	 * Logs out the current user and redirect to homepage.
	 */
	public function actionLogout()
	{
		Yii::app()->user->logout();
		$this->redirect(Yii::app()->homeUrl);
	}
}