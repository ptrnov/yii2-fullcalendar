<?php

namespace ptrnovlab\fullcalendar\controllers;

use yii\web\Controller;
class TestController extends Controller
{
	/**
     * Before Action Index
	 * @author ptrnov  <piter@lukison.com>
	 * @since 1.1
     */
	/* public function beforeAction(){
			if (Yii::$app->user->isGuest)  {
				 Yii::$app->user->logout();
                   $this->redirect(array('/site/login'));  //
			}
            // Check only when the user is logged in
            if (!Yii::$app->user->isGuest)  {
               if (Yii::$app->session['userSessionTimeout']< time() ) {
                   // timeout
                   Yii::$app->user->logout();
                   $this->redirect(array('/site/login'));  //
               } else {
                   //Yii::$app->user->setState('userSessionTimeout', time() + Yii::app()->params['sessionTimeoutSeconds']) ;
				   Yii::$app->session->set('userSessionTimeout', time() + Yii::$app->params['sessionTimeoutSeconds']);
                   return true;
               }
            } else {
                return true;
            }
    } */
	
    public function actionIndex()
    {
			//$satu= Test::world();
			$satu='sip';
			return $this->render('index',[
				'satu'=>$satu
			]);
    
    }
	
	public function actionTestForm()
    {
		return $this->renderAjax('form');
	}
}
