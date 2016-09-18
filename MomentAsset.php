<?php

namespace ptrnov\fullcalendar;

/**
 * Class MomentAsset
 * @package ptrnov\fullcalendarscheduler\assets\js
 */
class MomentAsset extends \yii\web\AssetBundle
{
	public $js = [
		'js/moment.min.js',
	];
	public $sourcePath = '@vendor/ptrnov/yii2-fullcalendar/assets';
}