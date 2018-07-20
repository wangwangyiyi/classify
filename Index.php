<?php
namespace app\index\controller;
use think\Controller;
use app\admin\model\Indexnav as indexNavModel;
use think\Db;


/**
* 
*/
class Index extends Controller
{
	
	function index()
	{	
		// 取值
		static $indexNavModel = array();
		$indexNavModel = db('catename')->select();  
 		print_r($this->getChildren($indexNavModel));

 	}
 	// 树形数组排序
 	function getChildren($indexNavModel,$pid=0)
 	{
 		 $arr = array();
        foreach ($indexNavModel as $key => $value) {
            if ($value['catename_p_id'] == $pid) {
                $value['children'] = $this->getChildren($indexNavModel, $value['id']);
                $arr[] = $value;
            }
        }
        return $arr;
	}
	   
	// 分类排序
	public function gettree()
 	{
		$indexNavModel = new indexNavModel();
 		$result = $indexNavModel->select();
 		return $this->sort($result);
	}
 	public function sort($result,$pid=0,$level=0)
 	{
 		static $arr = array();
 		foreach ($result as $k => $v) {
 			if($v['catename_p_id'] == $pid)
 			{
 				$arr[] = $v;
 				
 				$this->sort($result,$v['id'],$level+1);
 			}
 		}
 		return $arr;
 	}
}