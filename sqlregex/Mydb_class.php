<?php

	class Mydb{
		public $mysql;
		
	function __construct(){
		require_once("password.php");
	    $this->mysql=mysqli_connect($dbhost,$dbuser,$dbpassword,$dbname,$dbdk)or("数据库连接失败:".mysqli_connect_error());
	
	    /*mysql_select_db($dbname,$this->mysql)or("数据表连接失败:".mysql_error());*/
	
	    mysqli_query($this->mysql,"set names utf8");
	}
		
	function __destruct(){
		if($this->mysql){
			mysqli_close($this->mysql);
			$this->mysql=false;
			}
		}
	}
?>