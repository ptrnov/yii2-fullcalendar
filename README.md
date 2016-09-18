# Yii2 fullcalendar component

## Installation

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

To install, either run

```
php composer.phar require --prefer-dist ptrnov/yii2-scheduler-fullcalendar "*"
```

or add

```
"ptrnov/yii2-scheduler-fullcalendar": "*"
```

to the ```require``` section of your `composer.json` file.

## Usage

See the demos/ folder for all the examples.

### Simple usage with array data
```php
	//==Create file: Controllers/TestControllers.php
	//==paste script below
	namespace app\controllers;
	use Yii;
	use yii\web\Controller;
	use yii\helpers\ArrayHelper;
	use yii\web\Response;
	use yii\widgets\ActiveForm;
	use yii\helpers\Json;
	class TestController extends Controller
	{
		public function actionIndex()
		{
				return $this->render('index');    
		}
		
		public function actionForm($start,$end)
		{
			return $this->renderAjax('form',[
				'start'=>$start,
				'end'=>$end
			]);
		}
		
		public function actionDropChild($id,$start,$end){
			echo "ID=".$id." START=".$start." EBD=".$end;
			//$model = Pilotproject::findOne(['ID'=>$id]);

			//$model->PLAN_DATE1 = $start;
			//$model->PLAN_DATE2 = $end;

		   // $model->save();
		}
		
		public function actionEventCalendarSchedule()
		{
			$aryEvent=[
					['id' => '1', 'resourceId' => 'b', 'start' => '2016-05-07T02:00:00', 'end' => '2016-05-07T07:00:00', 'title' => 'event 1'],
					['id' => '2', 'resourceId' => 'c', 'start' => '2016-05-07T05:00:00', 'end' => '2016-05-07T22:00:00', 'title' => 'event 2'],
					['id' => '3', 'resourceId' => 'd', 'start' => '2016-05-06', 'end' => '2016-05-08', 'title' => 'event 3'],
					['id' => '4', 'resourceId' => 'e', 'start' => '2016-05-07T03:00:00', 'end' => '2016-05-07T08:00:00', 'title' => 'event 4'],
					['id' => '5', 'resourceId' => 'f', 'start' => '2016-05-07T00:30:00', 'end' => '2016-05-07T02:30:00', 'title' => 'event 5'],
			];
			
			return Json::encode($aryEvent);
		}
		
		public function actionResourceCalendarSchedule()
		{
			$aryResource=[
					['id' => 'a', 'title' => 'Daily Report'],
					['id' => 'b', 'title' => 'Auditorium B', 'eventColor' => 'green'],
					['id' => 'c', 'title' => 'Auditorium C', 'eventColor' => 'orange'],
					[
						'id'       => 'd', 'title' => 'Auditorium D',
						'children' => [
							['id' => 'd1', 'title' => 'Room D1'],
							['id' => 'd2', 'title' => 'Room D2'],
						],
					],
					['id' => 'e', 'title' => 'Auditorium E'],
					['id' => 'f', 'title' => 'Auditorium F', 'eventColor' => 'red'],
					['id' => 'g', 'title' => 'Auditorium G'],
					['id' => 'h', 'title' => 'Auditorium H'],
					['id' => 'i', 'title' => 'Auditorium I'],
					['id' => 'j', 'title' => 'Auditorium J'],
					['id' => 'k', 'title' => 'Auditorium K'],
					['id' => 'l', 'title' => 'Auditorium L'],
					['id' => 'm', 'title' => 'Auditorium M'],
					['id' => 'n', 'title' => 'Auditorium N'],
					['id' => 'o', 'title' => 'Auditorium O'],
					['id' => 'p', 'title' => 'Auditorium P'],
					['id' => 'q', 'title' => 'Auditorium Q'],
					['id' => 'r', 'title' => 'Auditorium R'],
					['id' => 's', 'title' => 'Auditorium S'],
					['id' => 't', 'title' => 'Auditorium T'],
					['id' => 'u', 'title' => 'Auditorium U'],
					['id' => 'v', 'title' => 'Auditorium V'],
					['id' => 'w', 'title' => 'Auditorium W'],
					['id' => 'x', 'title' => 'Auditorium X'],
					['id' => 'y', 'title' => 'Auditorium Y'],
					['id' => 'z', 'title' => 'Auditorium Z'],
				];
			
			return Json::encode($aryResource);
		}
	
	}
	
	//==Create file: views/test/index.php
	//==paste script below	
	<?
		use yii\helpers\Html;
		use yii\helpers\Url;
		use yii\bootstrap\Modal;
		use yii\web\JsExpression;
		use ptrnov\fullcalendar\FullcalendarScheduler;

		$JSEventClick = <<<EOF
			function(calEvent, jsEvent, view) {
				alert('test');
			}
	EOF;

		$wgCalendar=FullcalendarScheduler::widget([		
			'modalSelect'=>[
				/**
				 * modalSelect for cell Select
				 * 'clientOptions' => ['selectable' => true]					//makseure set true.
				 * 'clientOptions' => ['select' => function or JsExpression] 	//makseure disable/empty. if set it, used JsExpressio to callback.			
				 * @author piter novian [ptr.nov@gmail.com]		 				//"https://github.com/ptrnov/yii2-fullcalendar".
				*/
				'id' => 'modal-select',											//set it, if used FullcalendarScheduler more the one on page.
				'id_content'=>'modalContent',									//set it, if used FullcalendarScheduler more the one on page.
				'headerLabel' => 'Model Header Label',							//your modal title,as your set.	
				'modal-size'=>'modal-lg'										//size of modal (modal-xs,modal-sm,modal-sm,modal-lg).
			],
			'header'        => [
				'left'   => 'today prev,next',
				'center' => 'title',
				'right'  => 'timelineOneDays,agendaWeek,month,listWeek',
			],
			'options'=>[
				'id'=> 'calendar_test',											//set it, if used FullcalendarScheduler more the one on page.
				'language'=>'id',
			],
			'optionsEventAdd'=>[
				'events' => Url::to(['/test/event-calendar-schedule']),			//should be set "your Controller link" 	
				'resources'=> Url::to(['/test/resource-calendar-schedule']),		//should be set "your Controller link" 
				//disable 'eventDrop' => new JsExpression($JSDropEvent),
				'eventDropUrl'=>'/test/drop-child',								//should be set "your Controller link" to get(start,end) from select. You can use model for scenario.
				'eventSelectUrl'=>'/test/form',								//should be set "your Controller link" to get(start,end) from select. You can use model for scenario			
			],				
			'clientOptions' => [
				'language'=>'id',
				'selectable' => true,
				'selectHelper' => true,
				'droppable' => true,
				'editable' => true,
				//'select' => new JsExpression($JSCode),						// don't set if used "modalSelect"
				'eventClick' => new JsExpression($JSEventClick),
				'now' => '2016-05-07',
				'firstDay' =>'0',
				'theme'=> true,
				'aspectRatio'=> 1.8,
				//'scrollTime'=> '00:00', // undo default 6am scrollTime
				'defaultView'=> 'timelineMonth',//'timelineDay',//agendaDay',
				'views'=> [
					'timelineOneDays' => [
						'type'     => 'timeline',
						'duration' => [
							'days' => 1,
						],
					], 
				
				],				
				'resourceLabelText' => 'Discriptions',
				'resourceColumns'=>[
						[
							'labelText'=> 'Parent',
							'field'=> 'title'
						],
						[
							'labelText'=> 'Subject',
							'field'=> 'title'
						],
						[
							'labelText'=> 'Occupancy',
							'field'=> 'create_at'
						]
				],
				'resources'=> Url::to(['/test/resource-calendar-schedule']),		//should be set "your Controller link" 
				'events' => Url::to(['/test/event-calendar-schedule']),				//should be set "your Controller link" 	
			],	
		
		]);	
	?>
	<?=$wgCalendar?>

```