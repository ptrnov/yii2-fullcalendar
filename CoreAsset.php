<?php

namespace ptrnov\fullcalendar;

/**
 * Class CoreAsset
 * @package ptrnov\fullcalendarscheduler\assets
 */
class CoreAsset extends \yii\web\AssetBundle
{
	/**
	 * @var  boolean
	 * Whether to automatically generate the needed language js files.
	 * If this is true, the language js files will be determined based on the actual usage of [[DatePicker]]
	 * and its language settings. If this is false, you should explicitly specify the language js files via [[js]].
	 */
	//public $autoGenerate = true;
	/** @var  array Required CSS files for the fullcalendar */
	public $css = [
		'css/cupertino/jquery-ui.min.css',
		'css/fullcalendar.min.css',
		'css/scheduler.css',
	];
	/** @var  array List of the dependencies this assets bundle requires */
	public $depends = [
		'yii\web\YiiAsset',
		'ptrnov\fullcalendar\MomentAsset',
		'ptrnov\fullcalendar\PrintAsset',
	];
	/**
	 * @var  boolean
	 * FullCalendar can display events from a public Google Calendar. Google Calendar can serve as a backend that manages and persistently stores event data (a feature that FullCalendar currently lacks).
	 * Please read http://fullcalendar.io/docs/google_calendar/ for more information
	 */
	public $googleCalendar = false;
	/** @var  array Required JS files for the fullcalendar */
	public $js = [
		'js/fullcalendar.min.js',			
		'js/scheduler.js',
		//'fullcalendar-scheduler/lib/lang-all.js',
		//'fullcalendar-scheduler/lib/lang/id.js',
		//'fullcalendar-scheduler/lib/jquery.min.js',
	];
	/** @var  string Language for the fullcalendar */
	//public $language = null;
	public $language = null;
	/** @var  string Location of the fullcalendar scheduler distribution */
	//public $sourcePath = '@bower';
	public $sourcePath = '@vendor/ptrnov/yii2-fullcalendar/assets';

	/**
	 * @inheritdoc
	 */
	/* public function registerAssetFiles($view)
	{
		$language = empty($this->language) ? \Yii::$app->language : $this->language;
		if (file_exists($this->sourcePath . "fullcalendar/dist/lang/$language.js")) {
			$this->js[] = "fullcalendar/dist/lang/$language.js";
		}

		if ($this->googleCalendar) {
			$this->js[] = 'fullcalendar/dist/gcal.js';
		}

		parent::registerAssetFiles($view);
	} */
}
