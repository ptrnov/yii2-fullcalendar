<?php

namespace ptrnov\fullcalendar;

/**
 * Class PrintAsset
 * @package ptrnov\fullcalendarscheduler\assets\css
 */
class PrintAsset extends \yii\web\AssetBundle
{
	public $css = [
		'css/fullcalendar.print.css',
	];
	public $cssOptions = [
		'media' => 'print',
	];
	public $sourcePath = '@vendor/ptrnov/yii2-fullcalendar/assets';
}

