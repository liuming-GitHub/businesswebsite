<?php
// 数据库连接类
class ConnDB{
    var $dbtype;
    var $host;
    var $user;
    var $pwd;
    var $dbname;
    // 构造方法
    function ConnDB($dbtype, $host, $user, $pwd, $dbname){
        $this->dbtype = $dbtype;
        $this->host = $host;
        $this->user = $user;
        $this->pwd = $pwd;
        $this->dbname = $dbname; 
    }
    // 实现数据库的连接并返回连接对象
    function GetConnId(){
        if($this->dbtype == "mysql" || $this->dbtype == "mssql"){
            $dsn = "$this->dbtype:host=$this->host;dbname=$this->dbname";
        }else{
            $dsn ="$this->dbtype:dbname=$this->dbname";
        }
        try{
            $conn = new PDO($dsn, $this->user, $this->pwd);
            // 初始化一个PDO对象，就是创建了数据库连接对象$pdo
            $conn->query("set name utf8");
            return $conn;            
        }catch(PDOException $e){
            die("Error!:".$e->getMessage()."<br/>")
        }
    }
}

// 数据库管理类
class AdminDB{
    function ExecSQL($sqlstr, $conn){
        $sqltype = strtolower(substr(trim($sql), 0, 6));
        $rs = $conn->prepare($sqlstr);
        $rs->execute();
        if ($sqltype=="select"){
            $array=$rs->fetchAll(PDO::FETCH_ASSOC);
            if(count($array)==0 || $rs==false){
                return false;
            }
            else {
                return $array;
            }
        }else if($sqltype=="update" || $sqltype == "insert" || $sqltype == "delete"){
            if($rs) 
                return true;
            else
                return false;
        }
    }
}

// 分页类
class SepPage{
    var $rs;
    var $pagesize;
    var $nowpage;
    var $array;
    var $conn;
    var $sqlstr;
    function ShowData($sqlstr, $conn, $pagesize, $nowpage){
        if(!isset($nowpage) || $nowpage==""){
            $this->nowpage=1;
        }else{
            $this->nowpage=$nowpage;
        } 
        $this->pagesize=$pagesize;
        $this->conn=$conn;
        $this->sqlstr=$sqlstr;
        $this->rs=$this->conn->PageExecute($this->sqlstr, $this->pagesize, $this->nowpage);
        @this->array=$this->rs->GetRows();
        if(count($this->array)==0 || $this->rs==false)
            return false;
        else
            return $this->array;
    }

    function ShowPage($contentname, $utits, $anothersearchstr, $anothersearchstrs, $class){
        $allrs=$this->conn->Execute($this->sqlstr); 
        $record=count($allrs->GetRows());
        $pagecount=ceil($record/$this->pagesize);
        $str.=$contentname."&nbsp;".$record."&nbsp;".$utits."&nbsp; 每页 &nbsp;".$this->pagesize."&nbsp;".$utits."&nbsp;第&nbsp;".this->rs->AbsolutePage()."&nbsp;页/共&nbsp;".$pagecount."&nbsp;页";
        $str.="&nbsp;&nbsp;&nbsp;&nbsp;";
        if($this->rs->AtFirstPage())
            $str.="<a href=".$_SERVER['PHP_SELF']."?page=1&parameter1=".$anothersearchstr."&parameter2=".$anothersearchstr." class=".$class.">首页</a>";
        else
            $str.="<font color='#555555'>首页</font>";
        $str.="&nbsp";
        if($this->rs->AtFirstPage())
            $str.="<a href=".$_SERVER['PHP_SELF']."?page=".($this->rs->AbsolutePage()-1)"&parameter1=".$anothersearchstr."&parameter2=".$anothersearchstr." class=".$class.">上一页</a>";
        else
            $str.="<font color='#555555'>上一页</font>";
        $str.="&nbsp";
        if($this->rs->AtLastPage())
            $str.="<a href=".$_SERVER['PHP_SELF']."?page=".($this->rs->AbsolutePage()+1)"&parameter1=".$anothersearchstr."&parameter2=".$anothersearchstr." class=".$class.">下一页</a>";
        else
            $str.="<font color='#555555'>下一页</font>";
        $str.="&nbsp"; 
        if($this->rs->AtLastPage())
            $str.="<a href=".$_SERVER['PHP_SELF']."?page=".$pagecount)"&parameter1=".$anothersearchstr."&parameter2=".$anothersearchstr." class=".$class.">尾页</a>";
        else
            $str.="<font color='#555555'>尾页</font>";
        if(count($this->array)==0||$this->rs==false)
            return "";
        else
            return $str;
    }
}
?>
