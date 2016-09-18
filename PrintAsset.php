<?php

namespace ptrnov\fullcalendar;

/**
 * Class PrintAsset
 * @package edofre\fullcalendarscheduler
 */
class PrintAsset extends \yii\web\AssetBundle
{
	/** @var  array The CSS file for the print style */
	public $css = [
		'css/fullcalendar.print.css',
	];
	/** @var  array The CSS options */
	public $cssOptions = [
		'media' => 'print',
	];
	/** @var  string Bower path for the print settings */
	public $sourcePath = '@vendor/ptrnov/yii2-fullcalendar/assets';
}

