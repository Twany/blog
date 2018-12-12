<?php

/*数据库访问类*/
class Db{
	
	function __construct(){
		$this->db_list = array(
			//'default' => array('dsn'=>'mysql:host=blog.com;dbname=php','username'=>'root','password'=>'root'),
			'default' => array('dsn'=>'mysql:host=127.0.0.1;dbname=php','username'=>'root','password'=>'root'),
			//'test' => array('dsn'=>'mysql:host=blog.com;dbname=test','username'=>'root','password'=>'root')
		);		
		
		$this->pdo_list = [];
	}
	
	public function init_pdo($db){
		if(isset($this->pdo_list[$db]) && $this->pdo_list[$db]){
			
		}
		$this->pdo = new PDO($this->db_list[$db]['dsn'],$this->db_list[$db]['username'],$this->db_list[$db]['password']);
		
		$this->pdo_list[$db] = $this->pdo;
		//PDO异常模式处理
		$this->pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);			
	}
	
	
	/*指定表名*/
	//$table 为表名，$db为数据库名称
	public function table($table,$db = 'default'){
		
		$this->init_pdo($db);	
		
		$this->table = $table;		
		$this->field = '*';
		$this->where = [];
		$this->order = '';
		$this->limit = 0;
		return $this;
	}
	
	/*指定查询字段*/
	public function field($field){
		$this->field = $field;
		return $this;
	}
	
	/*指定查询条件*/
	public function where($where){
		$this->where = $where;
		return $this;
	}
	
	/*指定排序*/
	public function order($order = " ORDER BY id DESC"){
		$this->order = $order;
		return $this;
	}
	
	/*指定查询数量*/
	public function limit($limit){
		$this->limit = $limit;
		return $this;
	}
	
	/*查询一条记录*/
	public function item(){
		$sql = $this->_build_sql('select');
		$sql .=" LIMIT 1";
		$stmt = $this->pdo->prepare($sql);
		
		//$stmt->bindValue(':id',1);------用一个bindValue函数绑定来实现这个功能
		
		$this->bindValue($stmt);
		$stmt->execute();
		$item = $stmt->fetchAll(PDO::FETCH_ASSOC);
	
		return $item;
	}
	
	
	private function bindValue($stmt,$data=null){
		
		if($this->where && is_array($this->where)){
			foreach($this->where as $key=>$value){
				
				//$value = is_string($value) ? "'".$value."'":$value;
				$stmt->bindValue(':'.$key,$value);
			}
			
		}
		
	/*	if($data){
			//data数据的绑定
			foreach($data as $k => $val){
				$val = is_string($val) ? "'".$val."'" : $val;
				echo $k.$val.'<br>';
				
				$stmt->bindValue(':'.$k,$val);				
				
			}
		}*/
		
	}
	
	/*查询多条记录*/
	public function lists(){
		$sql = $this->_build_sql('select');
		$stmt = $this->pdo->prepare($sql);
		$this->bindValue($stmt);
		$stmt->execute();
		$lists = $stmt->fetchAll(PDO::FETCH_ASSOC);
		return $lists;
	}
	
	/*查询总数*/
	public function counts(){
		
		$sql = $this->_build_sql('counts');
		$stmt = $this->pdo->prepare($sql);
		$this->bindValue($stmt);
		$stmt->execute();
		$total = $stmt->fetchColumn(0);
		return $total;
	}
	
	/*分页*/
	public function pages($page=1,$pageSize=2,$path = 'http://127.0.0.1/Blog/index.php'){
		/*SELECT * FROM admin WHERE ` LIMIT 0,10*/
		//路径path
		//注意此处路径，西门老师写的是index，那样会直接跳转到博客主页，这样才能显示正常的测试页
		//$path = 'http://blog.com/lib/text.php';
		//$path = 'http://39.107.127.186/Blog/index.php';
		//$path = 'http://127.0.0.1/Blog/index.php';
		$this->limit = ($page-1)*$pageSize.','.$pageSize;
		$total = $this->counts();
		$data = $this->lists();
		$_pages = $this->subPages($page,$pageSize,$total,$path);
		return array('total'=>$total,'data'=>$data,'pages'=>$_pages);
		
	}
	
	private function subPages($cur_page,$pageSize,$total,$path){
		$html = '';
		//分页数
		$pageCount = ceil($total/$pageSize);
		if($pageCount == 1){
			return $html;
		}
		
		//$path问题
		$symbol = '?';

		
		//首页
		if($cur_page > 1){
			$html = "<li><a href='{$path}{$symbol}page=1'><span>首页</span></a><li>";			
		}
		
		//首页与尾页
		
		$end = $pageCount;
		
		for($i=1;$i<=$end;$i++){
			$html .= "<li><a href='{$path}{$symbol}page={$i}'><span>{$i}</span></a><li>";	
		}
		
		if($cur_page<$end){
			$html .="<li><a href='{$path}{$symbol}page={$end}'><span>尾页</span></a><li>";	
		}
		
		return '<ul class="pagination">'.$html.'</ul>';
		
	}
	
	/*插入记录*/
	public function insert($data){
		$sql = $this->_build_sql('insert',$data);
		$stmt = $this->pdo->prepare($sql);
		$this->bindValue($stmt,$data);
		return $stmt->execute();
	}
	
	/*更新记录*/
	public function update($data){
		$sql = $this->_build_sql('update',$data);
		$stmt = $this->pdo->prepare($sql);
		$this->bindValue($stmt,$data);
		//exit($sql);
		return $stmt->execute();
	}
	
	/*删除记录*/
	public function delete(){
		$sql = $this->_build_sql('delete');
		$stmt = $this->pdo->prepare($sql);
		$this->bindValue($stmt);
		//exit($sql);
		return $stmt->execute();
	}
	
	
	/*构造SQL语句*/
	private function _build_sql($type,$data = null){
		
		/*查询*/
		if($type == 'select'){
		$sql = "SELECT {$this->field} FROM {$this->table}";
		
			if($this->where){
			$sql .=$this->_build_where_sql();
				
		}
		if($this->order){
			$sql .=" order by {$this->order}";
			
		}
		
		if($this->limit){
			$sql .=" LIMIT {$this->limit}";
		}
		}
		
		/*插入*/
		if($type == 'insert'){
			$sql = '';
			$sql .=$this->_build_insert_sql($data);
		}
		
		/*更新*/
		if($type == 'update'){
			$sql = '';
			$sql .=$this->_build_update_sql($data);
		}
		
		/*删除*/
		if($type == 'delete'){
			$sql = '';
			$sql .=$this->_build_delete_sql($data);
		}
		
		/*总条数*/
		if($type == 'counts'){
			$sql = '';
			$sql .=$this->_build_counts_sql();
		}
		
		return $sql;
	}
	
	
	/*构造_build_where_sql*/
	private function _build_where_sql(){
		$sql ='';
		$where = '';
		foreach($this->where as $key => $value){
			$where .=" and `".$key.'`=:'.$key;

		}
		$where = ltrim($where,' and');
		$sql .= ($where ? " WHERE ".$where : '');
		return $sql;
	}
	
	/*构造_build_insert_sql*/
	private function _build_insert_sql($data){
		/*例：INSERT INTO Persons (id, name) VALUES (42, 'Yyk')*/
		$sql = "INSERT INTO {$this->table}";
		$fields = $values = [];
		foreach($data as $key => $value){
			$fields[] = '`'.$key.'`';
			$values[] = is_string($value) ? "'".$value."'" : $value; 
		}
		$sql .='('.implode(',',$fields).') VALUES ('.implode(',',$values).')';
		return $sql;
	}
	
	/*构造_build_update_sql*/
	private function _build_update_sql($data){
		/*UPDATE admin SET id=2,name = 'yyyy' WHERE id = '15' */
		$sql = "UPDATE {$this->table} SET ";
		$update = [];
		$where = $this->_build_where_sql();
		foreach($data as $key => $value){
			if(is_string($value)){
				$update .= ",`{$key}`='{$value}'";
			}else{
				@$update .= ",`{$key}`={$value}";
			}
		}
		$update = ltrim($update,'Array , ');
		
		$sql .=$update.$where;
	
		return $sql;
	}
	
	/*构造_build_delete_sql*/
	private function _build_delete_sql($data){
		/*DELETE FROM admin WHERE name = 'Yyk' */
		$sql = "DELETE FROM {$this->table}";
		$where = $this->_build_where_sql();
		$sql .=$where;
		return $sql;
	}
	
	/*构造_build_count_sql*/
	private function _build_counts_sql(){
		/*"SELECT count({$field}) FROM admin WHERE id>5"*/
		$where = $this->_build_where_sql();
		$sql = "SELECT count({$this->field}) FROM {$this->table} {$where}";
		return $sql;
	}
}


/*  借鉴
								PDO的封装. 
  我认为最主要的是,如何把一条sql语句用php语言组合拼装起来,比如sql语句中对字段两侧的符号'`'的处理,以及当value值是否是字符串类型时进行判断,是字符串时,必须在左右两侧添加单引号;当组装where或insert语句时,对传入array数组的进行foreach循环遍历拆分以及组装到sql语句中;又例如当组装update中set后面 value的sql语句时,末尾会多出个',',我们就要用php函数:rtrim对右边多余的一个','进行移除;构造insert语句时,我们需要用到implode函数,把数组中的元素组合成字符串类型;
  其次是函数的链式调用;当对一些方法操作时,没有传入值时,我们要给其进行赋默认值,比如进行limit方法时,如果不传入参数,就将其limit的后面的参数设置为0,这就相当于查询所有的数据;执行order方法时,没有填写参数时,将设置为空,让数据库自行进行排序.
  接着是分页查询的一个计算LIMIT后面参数的一个小小的算法,要清楚的了解到LIMIT (参数1,参数2),参数1和参数2,分别代表什么意思.(索引从几开始,要获取的数据条数)*/
