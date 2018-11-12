<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;


class TestController extends Controller
{
	public function actionIndex()
	{
		// echo strtotime('2018-11-15');die();
		//查询活动
		$sql = "select * from active order by starttime desc limit 1";
		$data = Yii::$app->db->createCommand($sql)->queryOne();
        $data['_time']= $data['stoptime']-time();
          // var_dump($add);die();
		//赞和踩
		$total = $data['admire']+$data['cai'];


		
         $z = $c =0;
        if ($total !=0) {
        	$z = $data['admire']/$total*100;
        	$c = $data['cai']/$total*100;
        }

            $data['z'] = $z;
	        $data['c'] = $c;

        $arr['active'] = $data;

        //评论
        $sql = 'select * from comment join user on comment.com_user = user.openid where active_id = '.$data['id'];
        $data = Yii::$app->db->createCommand($sql)->queryAll();
        $arr['comment'] = $data;
        
        
      
		
		echo json_encode($arr);
	}

	//赞和踩
	public function actionZ(){

		$get = Yii::$app->request->get();
		// print_r($get);die;
		//判断赞或踩
		$type = $get['type'] == 'nb'? 'admire' : 'cai';

		$sql = "update active set ".$type."=".$type."+1 where id=".$get['id'];
		$reg = Yii::$app->db->createCommand($sql)->execute();

		if ($reg) {

		 $sql = "select * from active limit 1";
		 $data = Yii::$app->db->createCommand($sql)->queryOne();
		

		 $total = $data['admire']+$data['cai'];
		

	        $z = $c =0;

	        if ($total !=0) {


	        	$z = round($data['admire']/$total*100);
	        	$c = round($data['cai']/$total*100);
	        }

	        $data['z'] = $z;
	        $data['c'] = $c;
	        // print_r($data);exit;
	        echo json_encode($data);

		}

		
		// var_dump($data);die();

	}
	


   
}
