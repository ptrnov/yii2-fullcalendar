<?php

namespace ptrnov\fullcalendar;

/**
 * Class MomentAsset
 * @package edofre\fullcalendarscheduler
 */
class MomentAsset extends \yii\web\AssetBundle
{
	/** @var  array  The javascript file for the Moment library */
	public $js = [
		'js/moment.min.js',
	];
	/** @var  string  The location of the Moment.js library */
	public $sourcePath = '@vendor/ptrnov/yii2-fullcalendar/assets';
}