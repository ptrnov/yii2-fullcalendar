<?php
use kartik\helpers\Html;
//use yii\widgets\DetailView;
use kartik\grid\GridView;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\bootstrap\Modal;
use yii\widgets\Pjax;
use kartik\widgets\Spinner;
use yii\web\JsExpression;
use ptrnov\fullcalendar\FullcalendarScheduler;


$JSCode = <<<EOF
	function( start, end, jsEvent, view) {
		//alert('Event: ' + jsEvent.title);
		//alert('Coordinates: ' + jsEvent.pageX + ',' + jsEvent.pageY);
		//$.get('/widget/pilotproject/createparent',{'tgl1':tgl1,'tgl2':tgl2},function(data){
		$.get('/fullcalendar/test/test-form',function(data){
						$('#modal-select').modal('show')
						.find('#modalContent')
						.html(data);
		});
	}
EOF;

$JSEventClick = <<<EOF
	function(calEvent, jsEvent, view) {
		alert('test');
	}
EOF;

	$wgCalendar=FullcalendarScheduler::widget([
		'modalSelect'=>[
			'id'    => 'modal-select',
			'headerLabel' => 'Model Header Label',
			'id_content'=>'modalContent1'
		],
		'header'        => [
			'left'   => 'today prev,next',
			'center' => 'title',
			'right'  => 'timelineOneDays,agendaWeek,month,listWeek',
		],
		'options'=>[
			'id'=> 'calendar_test',
			'language'=>'id',
		],	
		'clientOptions' => [
			'language'=>'id',
			'selectable' => true,
			'selectHelper' => true,
			'droppable' => true,
			'editable' => true,
			'select' => new JsExpression($JSCode),
			'eventClick' => new JsExpression($JSEventClick),
			'now' => '2016-05-07',
			'firstDay' =>'0',
			'theme'=> true,
			'aspectRatio'       => 1.8,
			//'scrollTime'        => '00:00', // undo default 6am scrollTime
			'defaultView'       => 'timelineMonth',//'timelineDay',//agendaDay',
			'views'             => [
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
			'resources'         => [
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
			],
			'events'            => [
				['id' => '1', 'resourceId' => 'b', 'start' => '2016-05-07T02:00:00', 'end' => '2016-05-07T07:00:00', 'title' => 'event 1'],
				['id' => '2', 'resourceId' => 'c', 'start' => '2016-05-07T05:00:00', 'end' => '2016-05-07T22:00:00', 'title' => 'event 2'],
				['id' => '3', 'resourceId' => 'd', 'start' => '2016-05-06', 'end' => '2016-05-08', 'title' => 'event 3'],
				['id' => '4', 'resourceId' => 'e', 'start' => '2016-05-07T03:00:00', 'end' => '2016-05-07T08:00:00', 'title' => 'event 4'],
				['id' => '5', 'resourceId' => 'f', 'start' => '2016-05-07T00:30:00', 'end' => '2016-05-07T02:30:00', 'title' => 'event 5'],
			],
		],
	
	]);
	
/* 	Modal::begin([
		'headerOptions' => ['id' => 'modalHeader'],
		'id' => 'modal-select',
		// 'size' => 'modal-sm',
		//keeps from closing modal with esc key or by clicking out of the modal.
		// user must click cancel or X to close
		// 'clientOptions' => ['backdrop' => 'static', 'keyboard' => FALSE]
	]);
	echo "<div id='modalContent'></div>";
	Modal::end(); */

?>


<?php
/* $this->registerJs("		
		jQuery(document).ready(function () {
		var loading_container = jQuery('#calendar-memo .fc-loading');
		jQuery('#calendar-memo').empty().append(loading_container);
		jQuery('#calendar-memo').fullCalendar({"loading":function(isLoading, view ) {
						jQuery('#calendar-memo').find('.fc-loading').toggle(isLoading);
				}

				alert('Event: ' + calEvent.title);
				alert('Coordinates: ' + jsEvent.pageX + ',' + jsEvent.pageY);
				alert('View: ' + view.name);

				// change the border color just for fun
				$(this).css('border-color', 'red');

			}
		);
",$this::POS_READY);	
 */

?>

<?php echo $wgCalendar;?>
