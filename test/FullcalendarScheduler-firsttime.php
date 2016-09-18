<?php

namespace ptrnov\fullcalendar;

use yii\helpers\Html;
use yii\helpers\Json;
use yii\web\JsExpression;
use yii\web\View;

/**
 * Class FullcalendarScheduler
 * @package edofre\fullcalendarscheduler
 */
class FullcalendarScheduler extends \yii\base\Widget
{
	/**
	 * @var array  The fullcalendar options, for all available options check http://fullcalendar.io/docs/
	 */
	public $clientOptions = [
		'weekends' => true,
		'default'  => 'timelineDay',
		'editable' => false,
	];
	/**
	 * @var array  Array containing the events, can be JSON array, PHP array or URL that returns an array containing JSON events
	 */
	public $events = [];
	
	/**
     * Will hold an url to json formatted events!
     * @var url to json service
     */
    public $ajaxEvents = NULL;
	/**
	 * @var array  Array containing the resources, can be JSON array, PHP array or URL that returns an array containing JSON resources
	 */
	public $resources = [];
	/** @var boolean  Determines whether or not to include the gcal.js */
	public $googleCalendar = false;
	/**
	 * @var array
	 * Possible header keys
	 * - center
	 * - left
	 * - right
	 * Possible options:
	 * - title
	 * - prevYear
	 * - nextYear
	 * - prev
	 * - next
	 * - today
	 * - basicDay
	 * - agendaDay
	 * - basicWeek
	 * - agendaWeek
	 * - month
	 */
	public $header = [
		'center' => 'title',
		'left'   => 'prev,next, today',
		'right'  => 'timelineDay,timelineWeek,timelineMonth,timelineYear',
	];
	/** @var string  Text to display while the calendar is loading */
	public $loading = 'Please wait, calendar is loading';
	/**
	 * @var array  Default options for the id and class HTML attributes
	 */
	public $options = [
		'id'    => 'calendar',
		'class' => 'fullcalendar',
	];
	/**
	 * @var boolean  Whether or not we need to include the ThemeAsset bundle
	 */
	public $theme = false;

	/**
     * The javascript function to us as en eventRender callback
     * @var string the javascript code that implements the eventRender function
     */
    public $eventRender = "";

    /**
     * The javascript function to us as en eventAfterRender callback
     * @var string the javascript code that implements the eventAfterRender function
     */
    public $eventAfterRender = "";

    /**
     * The javascript function to us as en eventAfterAllRender callback
     * @var string the javascript code that implements the eventAfterAllRender function
     */
    public $eventAfterAllRender = "";
	/**
	 * Always make sure we have a valid id and class for the Fullcalendar widget
	 */
	public function init()
	{
		if (!isset($this->options['id'])) {
			$this->options['id'] = $this->getId();
		}
		if (!isset($this->options['class'])) {
			$this->options['class'] = 'fullcalendar';
		}
		if (isset($this->options['language'])) {
			$this->options['class'] = $this->options['language'];
		}

		parent::init();
		//print_r($this->clientOptions);
	}

	/**
	 * Load the options and start the widget
	 */
	public function run()
	{
		echo Html::beginTag('div', $this->options) . "\n";
		echo Html::beginTag('div', ['class' => 'fc-loading', 'style' => 'display:none;']);
		echo Html::encode($this->loading);
		echo Html::endTag('div') . "\n";
		echo Html::endTag('div') . "\n";

		//$assets = CoreAsset::register($this->view);
		$this->registerPlugin();
	}

	
	 /**
    * Registers the FullCalendar javascript assets and builds the requiered js  for the widget and the related events
    */
    protected function registerPlugin()
    {        
        $id = $this->options['id'];
        $view = $this->getView();

        /** @var \yii\web\AssetBundle $assetClass */
        $assets = CoreAsset::register($view);

        //by default we load the jui theme, but if you like you can set the theme to false and nothing gets loaded....
        if($this->theme == true)
        {
            ThemeAsset::register($view);
        }

        if (isset($this->options['language'])) 
        {
            $assets->language = $this->options['language'];
        }        
        
        if ($this->googleCalendar) 
        {
            $assets->googleCalendar = $this->googleCalendar;
        }

        $js = array();

        if($this->ajaxEvents != NULL){
            $this->clientOptions['events'] = $this->ajaxEvents;
        }

        if(is_array($this->header) && isset($this->clientOptions['header']))
        {
            $this->clientOptions['header'] = array_merge($this->header,$this->clientOptions['header']);
        } else {
            $this->clientOptions['header'] = $this->header;
        }
	
		// clear existing calendar display before rendering new fullcalendar instance
		// this step is important when using the fullcalendar widget with pjax
		$js[] = "var loading_container = jQuery('#$id .fc-loading');"; // take backup of loading container
		$js[] = "jQuery('#$id').empty().append(loading_container);"; // remove/empty the calendar container and append loading container bakup

		$cleanOptions = $this->getClientOptions();
		$js[] = "jQuery('#$id').fullCalendar($cleanOptions);";
        
        $view->registerJs(implode("\n", $js),View::POS_READY);
    }
	
	/**
	 * @return string
	 * Returns an JSON array containing the fullcalendar options,
	 * all available callbacks will be wrapped in JsExpressions objects if they're set
	 */
	private function getClientOptions()
	{
		$id = $this->options['id'];
		$options['loading'] = new JsExpression("function(isLoading, view ) {
			jQuery('#{$this->options['id']}').find('.fc-loading').toggle(isLoading);
        }");
		 if ($this->eventRender){
            $options['eventRender'] = new JsExpression($this->eventRender);
        }
        if ($this->eventAfterRender){
            $options['eventAfterRender'] = new JsExpression($this->eventAfterRender);
        }
        if ($this->eventAfterAllRender){
            $options['eventAfterAllRender'] = new JsExpression($this->eventAfterAllRender);
        }
		
		// Load the events
		$options['events'] = $this->events;
		$options['resources'] = $this->resources;
		$options = array_merge($options,$this->clientOptions);

		return Json::encode($options);
	}

}
