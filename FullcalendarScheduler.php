<?php

namespace ptrnov\fullcalendar;

use yii\helpers\Html;
use yii\helpers\Json;
use yii\bootstrap\Modal;
use yii\web\JsExpression;
use yii\web\View;

/**
 * Class FullcalendarScheduler
 * @author piter novian [ptr.nov@gmail.com]
 */
class FullcalendarScheduler extends \yii\base\Widget
{
	/**
	 * @var array  The fullcalendar options
	 * Reff http://fullcalendar.io/docs/
	 */
	public $clientOptions = [
		'weekends' => true,
		'default'  => 'timelineDay',
		'editable' => false,
	];
	/**
	 * @var string url controller Drop url.
	 */	
	public $optionsEventAdd=[
		'eventDropUrl'=>'',			//@var string url controler save drop move select.
		'events' =>[],				//@var array  Array containing the events, can be JSON array,PHP array or URL that returns an array containing JSON events
		'resources'=>[],			//@var array  Array containing the resources.
		'eventSelectUrl'=>[],		//@var string url controler select.
	];
	
	/*JS google Calendar*/
	public $googleCalendar = false;
	
	/**
	 * @var array
	 * Possible header keys
	 * - center|- left| - right
	 * Possible options:
	 * - title|- prevYear |- nextYear |- prev |- next |- today|- basicDay|- agendaDay|- basicWeek|- agendaWeek|- month
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
	 * @var boolean, ThemeAsset bundle
	 */
	public $theme = false;
	
	/**
	 * Modal Form, 'SELECT INPUT' for fullcalendar schedule
	 * @var array
	 * Example js select : JsExpression
	 * $JSSelect = <<<EOF
	 * 	function( start, end, jsEvent, view) {
	 * 		//$.get('/fullcalendar/test/test-form',{'tgl1':tgl1,'tgl2':tgl2},function(data){
	 * 		$.get('/fullcalendar/test/test-form',function(data){ // URL Controller render
	 *			$('#modal-select').modal('show')				 // Id of Modal select
	 *			.find('#modalContent')							 // Content Id rendered
	 *			.html(data);									 
	 *		});
	 * 	}
	 * * EOF;
	 * @author piter novian [ptr.nov@gmail.com]
	 */
	public $modalSelect=[
		'id'=> 'modal-select',
		'id_content'=>'modalSelectContent',
		'headerLabel' => 'Model Header Label',		
		'modal-size'=>'modal-sm',
	];
	
	/**
	 * Modal Form, 'CLICK SHOW' for fullcalendar schedule
	 * @var array
	 * Example click views : JsExpression
	 * $JSEventClick = <<<EOF = <<<EOF
	 *	 function( start, end, jsEvent, view) {
	 * 		$.get('/fullcalendar/test/test-form',function(data){ 	// URL Controller render
	 *			$('#modal-click').modal('show')				 		// Id of Modal click
	 *			.find('#modalContent')								// Content Id rendered
	 *			.html(data);									 
	 *		});
	 * 	}
	 * EOF;
	 * @author piter novian [ptr.nov@gmail.com]
	 */
	public $modalClick=[
		'id'=> 'modal-click',
		'headerLabel' => 'Model Click event - Header Label',
		'id_content'=>'modalClickContent',
		'modal-size'=>'modal-sm',
	];
		
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
	}

	/**
	 * Load the widget
	 * @author piter novian [ptr.nov@gmail.com]
	 */
	public function run()
	{
		echo Html::beginTag('div', $this->options) . "\n";
		echo Html::beginTag('div', ['class' => 'fc-loading', 'style' => 'display:none;']);
		echo Html::encode($this->loading);
		echo Html::endTag('div') . "\n";
		echo Html::endTag('div') . "\n";
		$this->getSelectModal();	
		
		$assets = CoreAsset::register($this->view);

		// Register the theme
		if ($this->theme === true) {
			ThemeAsset::register($this->view);
		}

		if (isset($this->options['language'])) {
			$assets->language = $this->options['language'];
		}

		/* if (isset($this->options['lang'])) 
        {
            $assets->language = $this->options['lang'];
        }    */  
		
		$assets->googleCalendar = $this->googleCalendar;
		$this->clientOptions['header'] = $this->header;

		 $this->view->registerJs(implode("\n", [
			"jQuery('#{$this->options['id']}').fullCalendar({$this->getClientOptions()});",
		]), View::POS_READY); 
	}

	/**
	 * @return string
	 * Returns an JSON array containing the fullcalendar options,
	 * all available callbacks will be wrapped in JsExpressions objects if they're set
	 * @author piter novian [ptr.nov@gmail.com]
	 */
	private function getClientOptions()
	{
		$id = $this->options['id'];
		$options['loading'] = new JsExpression("function(isLoading, view ) {
			jQuery('#{$this->options['id']}').find('.fc-loading').toggle(isLoading);
        }");
		
		if (!isset($options['select'])) {
			//MODAL SELECT FULLCALENDAR SCHEDULE
			if (!isset($this->modalSelect['id'])) {
				$this->modalSelect['id'] = 'modal-select';
			}
			if (!isset($this->modalSelect['id_content'])) {
				$this->modalSelect['id_content'] = 'modalContent';
			}
			if(!isset($this->optionsEventAdd['eventSelectUrl'])){
				$optionsEventAdd['eventSelectUrl'] = '/fullcalendar/test/test-form';
			}
						
			//input Event Select
			$options['select'] =new JsExpression("function(start,end,jsEvent,view){
					var dateTime2 = new Date(end);
					var dateTime1 = new Date(start);
					var tgl1 = moment(dateTime1).format('YYYY-MM-DD');
					var tgl2 = moment(dateTime2).subtract(1, 'days').format('YYYY-MM-DD');
					$.get('".$this->optionsEventAdd['eventSelectUrl']."',{'start':tgl1,'end':tgl2},function(data){
						$('#".$this->modalSelect['id']."').modal('show').find('#".$this->modalSelect['id_content']."').html(data);
					});
				}
			");
			
			if(!isset($this->optionsEventAdd['eventDropUrl'])){
				$this->optionsEventAdd['eventDropUrl'] = $this->eventDropUrl;
			}			
			//input Event Drop
			$options['eventDrop'] =new JsExpression("function(event, element, view){
					var child = event.parent;
					var status = event.status;

					var dateTime2 = new Date(event.end);
					var dateTime1 = new Date(event.start);
					var tgl1 = moment(dateTime1).format('YYYY-MM-DD');
					var tgl2 = moment(dateTime2).subtract(1, 'days').format('YYYY-MM-DD');

					var id = event.id;
					if(child != 0 && status != 1){
						$.get('".$this->optionsEventAdd['eventDropUrl']."',{'id':id,'start':tgl1,'end':tgl2});
					}
				}
			");	
		}
		
		// Load the events
		if(isset($this->optionsEventAdd['events'])){
			$options['events'] = $this->optionsEventAdd['events'];
		}
		if(isset($this->optionsEventAdd['resources'])){
			$options['resources'] = $this->optionsEventAdd['resources'];
		}			
		$options = array_merge($options, $this->clientOptions);

		return Json::encode($options);
	}
	
	/**
	 * MODAL SELECT FULLCALENDAR SCHEDULE
	 * Return String
	 * @author piter novian [ptr.nov@gmail.com]
	*/
	private function getSelectModal(){
		
		if (!isset($this->modalSelect['id'])) {
			$this->modalSelect['id'] = 'modal-select';
		}
		if (!isset($this->modalSelect['headerLabel'])) {
			$this->modalSelect['headerLabel'] = 'Modal Select event - Header Label';
		}
		if (!isset($this->modalSelect['id_content'])) {
			$this->modalSelect['id_content'] = 'modalContent';
		}
		if (!isset($this->modalSelect['modal-size'])) {
			$this->modalSelect['modal-size'] = 'modal-sm';
		}	
	    		
		$content = Modal::begin([
			'header' =>'<div style="float:left;margin-right:10px" class="fa fa-2x fa-calendar-plus-o"></div><div><h4 class="modal-title"> '. $this->modalSelect['headerLabel'].'</h4></div>',
			'id' => $this->modalSelect['id'],
			'size' => $this->modalSelect['modal-size'],
			'headerOptions'=>[		
                 'style'=> 'border-radius:5px; background-color: rgba(90, 171, 255, 0.7)',		
			],
			//keeps from closing modal with esc key or by clicking out of the modal.
			// user must click cancel or X to close
			 'clientOptions' => ['backdrop' => 'static', 'keyboard' => FALSE]
		]);
		//echo '<div id="modalContent"></div>';
		echo '<div id="'.$this->modalSelect['id_content'].'"></div>';
		$content =  Modal::end();
		return $content;
	}

	
	
	/**
	 * MODAL CLICK FULLCALENDAR SCHEDULE
	 * Return String
	 * @author piter novian [ptr.nov@gmail.com]
	*/
	private function getClickModal(){
		
		if (!isset($this->modalClick['id'])) {
			$this->modalClick['id'] = 'modal-select';
		}
		if (!isset($this->modalClick['headerLabel'])) {
			$this->modalClick['headerLabel'] = 'Modal Click event - Header Label';
		}
		if (!isset($this->modalClick['id_content'])) {
			$this->modalClick['id_content'] = 'modalClickContent';
		}	
		if (!isset($this->modalClick['modal-size'])) {
			$this->modalClick['modal-size'] = 'modal-sm';
		}
		$content = Modal::begin([
			'header' => $this->modalClick['headerLabel'],
			'id' => $this->modalClick['id'],
			'size' => $this->modalClick['modal-size'],
			//keeps from closing modal with esc key or by clicking out of the modal.
			// user must click cancel or X to close
			 'clientOptions' => ['backdrop' => 'static', 'keyboard' => FALSE]
		]);
		//echo '<div id="modalContent"></div>';
		echo '<div id="'.$this->modalClick['id_content'].'"></div>';
		$content =  Modal::end();
		return $content;
	}
}
