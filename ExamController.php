<?php

namespace api\controllers;

use Yii;
use yii\web\Controller;
// use common\libs\PHPExcel;
header("content-type:text/html;charset=utf-8");

/**
 * 
 */
class ExamController extends Controller
{
	public $enableCsrfValidation = false;
	public function actionIndexs()
	{
		$dir = '../upload/excel.xls';
		// $reg = move_uploaded_file($_FILES['excel']['tmp_name'], $dir);
		$title = YII::$app->request->post('title');
		
		require(__DIR__.'/../../common/libs/PHPExcel.php');
		$objPHPExcel = \PHPExcel_IOFactory::load($dir);
		//当前面试题
		$sheetData = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
		unset($sheetData[1]);
		$type = array_flip(Yii::$app->params['type']);
		$score = Yii::$app->params['score'];
		foreach ($sheetData as $k => $val)
		 {
			$array = Array(
				'title'=>$val['C'],
				'month'=>'10',
				'unit'=>$title,
				'type'=>$type[$val['B']],
				'score'=>$score[$type[$val['B']]],

				'add_time'=>time()

			);
			$data = Yii::$app->db->createCommand()->insert('test',$array)->execute();
			
			$id = Yii::$app->db->getLastInsertID();
		
}
	}
}