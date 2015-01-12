<?php
/**
 * mysql pdo 驱动类
 */
require_once(RUNTIME_PATH."Core/Conf/db.php");
class Db {
    public static $obj = null; //驱动类对象实例
    public $link = null;//pdo连接对象实例
    protected $_dsn = DBHOST;
    protected $_user = DBUSER;
    protected $_pwd = DBPWD;

    public static function init() {
        if (self::$obj === null) {
            return self::$obj = new self();
        }
        return self::$obj; 
    }
    
    /**
     * 构造单例模式连接
     */
    final public function __construct($c) {
        try{
            $this->link = new PDO($this->_dsn, $this->_user,$this->_pwd);
            $this->link->exec('SET NAMES UTF8');
        }catch(PDOException $e) {
            $log = new Logs;    
            $msg = $e->getMessage().' | '.$e->getline().' | '.$e->getFile();
            $log->write($msg, 3, '', '',3);
            return $e->getMessage();
        }
    }
    
    /**
     * 禁止克隆
     */
    public function __clone(){}
    
    /**
     * 查询数据库 返回关联数组列表
     */
    public function getAll($sql, $bindData)
    {
        $sth = $this->link->prepare($sql);
        $keys = array_keys($bindData);
        foreach($keys as $k => $v) {
            $sth->bindParam(":{$v}", $bindData[$v], $this->checkParam($bindData[$v]));
        }
        $sth->execute();
        return $sth->fetchAll(constant('PDO::FETCH_ASSOC'));//二维关联数组返回
    }
    
    /**
     * 查询数据库 返回一行
     */
    public function getRow($sql,$bindData)
    {

        $sth = $this->link->prepare($sql);
      
        $keys   = array_keys($bindData);
        foreach($keys as $k => $v) {
            $sth->bindParam(":{$v}", $bindData[$v], $this->checkParam($bindData[$v]));
        }
        $sth->execute();
        return $sth->fetch(constant('PDO::FETCH_ASSOC'));//一维关联数组返回
    }
    
    /**
     * 查询数据库 返回一个值
     */
    public function getTotal($sql,$bindData)
    {
        $sth = $this->link->prepare($sql);
        $keys   = array_keys($bindData);
        foreach ($keys as $k => $v) {
            $sth->bindParam(":{$v}", $bindData[$v], $this->checkParam($bindData[$v]));
        }
        $sth->execute();
        $total = $sth->fetch(constant('PDO::FETCH_NUM'));//二维关联数组返回
        return $total[0];
    }
    
    /**
     * 处理key
     */
    public function map_keys1($value)
    {
         return "`{$value}`";
    }
    
    /**
     * 处理key
     */
    public function map_keys2($value)
    {
         return ":{$value}";
    }

    /**
     * 添加一行数据
     * 返回id
     */
    public function addRow($tableName, $bindData)
    {
        $keys = array_keys($bindData);
        $f = $keys;
        $values = array_map('self::map_keys2', $keys);
        $keys = array_map('self::map_keys1', $keys);
        $keys = join($keys,',');
        $values = join($values,',');
        $sql = "insert into {$tableName}($keys) values ($values)";
        $sth = $this->link->prepare($sql);
        foreach($f as $k => $v) {
            $sth->bindParam("{$v}", $bindData[$v], $this->checkParam($bindData[$v]));
        }
        $sth->execute();
        if ($sth->rowCount() > 0) {
            return $this->link->lastInsertId();
        }
        return false;
    }
    
    /**
     * 更新数据
     */
    public function update($sql,$bindData)
    {
        $sth = $this->link->prepare($sql);
        foreach($keys as $k => $v) {
            $value = $bindDatap[$i];
            $sth->bindParam($i, $value, $this->checkParam($value));
        }
        $sth->execute();
        return $sth->rowCount();
    }
    
    /**
     * 删除数据
     */
    public function delete($sql, $bindData)
    {
        $sth = $this->link->prepare($sql);
        $count = count($bindData);
        for ($i = 1; $i<=$count; $i++) {
            $value = $bindData[$i - 1];
            $sth->bindParam($i, $bindData[$i - 1], $this->checkParam($value));
        }
        $sth->execute();
        return $sth->rowCount();
    }
    
    
    /**
     * 检查参数类型
     * @return boolean
     */
    private function checkParam($value)
    {
        if (is_int($value)) {
            $param = PDO::PARAM_INT;
        }
        else if (is_bool($value)) {
            $param = PDO::PARAM_BOOL;
        }
        else if (is_null($value)) {
            $param = PDO::PARAM_NULL;
        }
        else if (is_string($value)) {
            $param = PDO::PARAM_STR;
        } else {
            $param = FALSE;
        }
        
        return $param;
    }
}
