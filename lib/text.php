<?php

require_once $_SERVER['DOCUMENT_ROOT'].'/lib/Db.php';

$db = new Db();

//插入
//$res = $db->table('html5css')->insert(array('title'=>'test','content'=>'test'));
//print_r($res);

/*排序*/
/*echo '<pre>';
$res = $db->table('cate')->order('id desc')->lists('*');
print_r($res);*/

/*删除*/
//$res = $db->table('admin')->where(array('id'=>2,'QQ'=>11))->delete();
//print_r($res);

/*更新*/
//$res = $db->table('admin')->where(array('id'=>64))->delete(array('name'=>111,'QQ'=>111,'password'=>111));

//$res1 = $db->table('admin')->where(array('id'=>65))->update(array('name'=>222,'QQ'=>222,'password'=>222));
/*查询总条数*/
//$res1 = $db->table('admin')->counts('*');

/*分页*/
//echo '<pre>';
//$page = isset($_GET['page'])?$_GET['page']:1;
//$res2 = $db1->table('admin')->pages($page,2);
//print_r($res2);
//print_r($res1);

/*不同数据库查询*/
/*$res1 = $db1->table('admin')->where(array('id'=>1))->lists();
$res2 = $db1->table('admin')->where(array('id'=>1))->lists();
$res3 = $db1->table('std','test')->where(array('id'=>1))->lists();
print_r($res1);
echo '<hr>';
print_r($res2);
echo '<hr>';
print_r($res3);*/


//$a['default']=null;/*no,no*/
//$a['default']=false;/*yes,no*/
$a['default']=[];/*yes,no*/
if(isset($a['default']) || $a['default']){
	echo 'yes';
}else{
	echo 'no';
}


