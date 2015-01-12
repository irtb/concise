<?php
require_once(RUNTIME_PATH."/Core/Conf/db.php");
class Db {
    public static $obj = null;  
    public $link = null;        

    protected $_dsn = DBHOST;
    protected $_user = DBUSER;
    protected $_pwd = DBPWD;
    
    /**
     * 构造单例模式连接
     * 在整个PHP脚本运行中 只构建一次 实至名归 单利模式
     */
    public static function init() {
        if (self::$obj === null) {
            return self::$obj = new self();
        }
        return self::$obj;
    }
    /**
     * 构造函数 初始化完成后返回一个Pdo连接对象
     * 设置基本参数 开始实例化连接对象 设置防止SQL注入的基本参数
     */
    final public function __construct($c) {
        try {
            $option = array(
                constant('PDO::MYSQL_ATTR_INIT_COMMAND') => 'set names utf8'
            );
            $this->link = new PDO($this->_dsn, $this->_user, $this->_pwd, $option);
            $this->link->setAttribute(constant('PDO::ATTR_EMULATE_PREPARES') , false);
            $this->link->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->link->setAttribute(PDO::ATTR_ORACLE_NULLS, PDO::NULL_TO_STRING); 
            $this->link->setAttribute(PDO::ATTR_STRINGIFY_FETCHES, true); 
            $this->link->exec('set names utf8');
        } catch(PDOException $e) {
            $log = new Logs;    
            $log->write($e, 3, '', '',2);
            die("db error!");
        }
    }
    // 禁止克隆
    public function __clone() {}
    // 查询全部
    public function getAll($sql, $bindData = array()) {
        $sth = $this->link->prepare($sql);
        if (!empty($bindData)) {
            $sth->execute($bindData);
        } else {
            $sth->execute();
        }
        $res = $sth->fetchAll(constant('PDO::FETCH_ASSOC'));
        $sth = null;
        return $res;
    }
    // 查询单行
    public function getRow($sql, $bindData = array()) {
        $sth = $this->link->prepare($sql);
        if (!empty($bindData)) {
            $sth->execute($bindData);
        } else {
            $sth->execute();
        }
        $res = $sth->fetch(constant('PDO::FETCH_ASSOC'));
        $sth = null;
        return $res;
    }
    // 查询字段
    public function getColumn($sql, $fieldIndex = 0, $rowIndex = 1, $bindData = array()) {
        $sth = $this->link->prepare($sql);
        if (!empty($bindData)) {
            $sth->execute($bindData);
        } else {
            $sth->execute();
        }
        for ($i = 0; $i < $rowIndex; $i++) {
            $res = $sth->fetchColumn($fieldIndex);
            
        }
        $sth = null;
        return $res;
    }
    // 查询条数
    public function getTotal($sql, $bindData = array()) {
        $sth = $this->link->prepare($sql);
        if (!empty($bindData)) {
            $sth->execute($bindData);
        } else {
            $sth->execute();
        }
        $total = $sth->fetchColumn(); //返回统计计数
        $sth = null;
        return $total;
    }
    // 处理字段
    private function processField($value) {
        return "`{$value}`";
    }
    // 绑定占位符
    private function processOccupy($value) {
        return ":{$value}";
    }
    // 添加一行
    public function addRow($tableName, $bindData) {
        $keys = array_keys($bindData);
        $occupys = join(array_map('self::processOccupy', $keys) , ',');
        $fields = join(array_map('self::processField', $keys) , ',');
        $sql = "insert into `{$tableName}`($fields) values ($occupys)";
        $sth = $this->link->prepare($sql);
        foreach ($keys as $k => $v) {
            $sth->bindParam(":{$v}", $bindData[$v], $this->checkParam($bindData[$v]));
        }
        $sth->execute();
        if ($sth->rowCount() > 0) {
            $lastId = $this->link->lastInsertId();
            $sth = null;
            return $lastId;
        }
        $sth = null;
        return 0;
    }
    // 全部添加
    public function addAll($tableName, $data) {
        $rowsCount = count($data);
        $fieldCount = count($data[0]);
        $val = rtrim(str_repeat('?,', $fieldCount) , ',');
        $keys = join(array_map('self::processField', array_keys($data[0])) , ',');
        $bindData = array();
        $values = "";
        for ($i = 0; $i < $rowsCount; $i++) {
            $bindData = array_merge($bindData, array_values($data[$i]));
            unset($data[$i]);
            $values.= "({$val}),";
        }
        $values = rtrim($values, ',');
        $sql = "insert into `{$tableName}`($keys) values $values";
        $sth = $this->link->prepare($sql);
        $sth->execute($bindData);
        $lastId = $this->link->lastInsertId();
        $sth = null;
        return $lastId;
    }
    // 批量添加
    public function addAllTest($tableName, $data) {
        $rowsCount = count($data);
        $fieldCount = count($data[0]);
        $values = rtrim(str_repeat('?,', $fieldCount) , ',');
        $keys = join(array_map('self::processField', array_keys($data[0])) , ',');
        $sql = "insert into `{$tableName}`($keys) values ($values)";
        $sth = $this->link->prepare($sql);
        $lastIdArray = array();
        for ($i = 0; $i < $rowsCount; $i++) {
            $sth->execute(array_values($data[$i]));
            $lastIdArray[] = $this->link->lastInsertId();
        }
        unset($data);
        $sth = null;
        return $lastIdArray;
    }
    //  更新
    public function update($sql, $bindData = array()) {
        $sth = $this->link->prepare($sql);
        if (!empty($bindData)) {
            $sth->execute($bindData);
        } else {
            $sth->execute();
        }
        $res = $sth->rowCount();
        $sth = null;
        return $res;
    }
    // 删除
    public function delete($sql, $bindData = array()) {
        $sth = $this->link->prepare($sql);
        if (!empty($bindData)) {
            $sth->execute($bindData);
        } else {
            $sth->execute();
        }
        $res = $sth->rowCount();
        $sth = null;
        return $res;
    }
    /**
     * 设置表名称方法 将会要求设置表名称
     */
    public function tableName($tableName = array()) {
        if (!empty($tableName)) {
            $this->data['tablename'] = $tableName;
        }
        return $this;
    }
    /**
     * 设置字段
     */
    public function field($field = array()) {
        if (!empty($field)) {
            $this->data['field'] = $field;
        }
        return $this;
    }
    /**
     * 关联表
     */
    public function join($join) {
        if (!empty($join)) {
            $this->data['join'] = $join;
        }
        return $this;
    }
    /**
     * 设置条件where
     */
    public function where($where = array()) {
        if (!empty($where)) {
            $this->data['where'] = $where;
        }
        return $this;
    }
    /**
     * 设置分组group
     */
    public function group($group = array()) {
        if (!empty($group)) {
            $this->data['group'] = $group;
        }
        return $this;
    }
    /**
     * 设置limit
     */
    public function limit($limit = array()) {
        if (!empty($limit)) {
            $this->data['limit'] = $limit;
        }
        return $this;
    }
    /**
     * 设置order by
     */
    public function orderby($orderby = array()) {
        if (!empty($orderby)) {
            $this->data['orderby'] = $orderby;
        }
        return $this;
    }
    /**
     * 绑定索引数据 使用问号占位符符号的形式
     */
    public function bindIndexData($data = array()) {
        if (!empty($data)) {
            $this->data['bind_index_data'] = $data;
        }
        return $this;
    }
    /**
     * 绑定关联键值对名称的数据
     */
    public function bindKeyData($data = array()) {
        if (!empty($data)) {
            $this->data['bind_key_data'] = $data;
        }
        return $this;
    }
    /**
     * 处理字段
     * @param type $value
     */
    private function processAlias($value, $a) {
        return "$a.`$value`";
    }
    /**
     * 格式化sql
     * @return string
     */
    private function formatSql() {
        $sql = "select ";
        if (!empty($this->data['field'])) {
            $t1 = array();
            foreach ($this->data['field'] as $k => $v) {
                $t2 = array();
                $count = count($v);
                for ($i = 0; $i < $count; $i++) {
                    $t2[] = $k;
                }
                $t1 = array_merge($t1, array_map('self::processAlias', $v, $t2));
            }
            $sql.= join(',', $t1);
        } else {
            $sql.= "*";
        }
        if (isset($this->data['tablename'][0])) {
            $sql.= ' from ' . $this->data['tablename'][0] . ' ' . $this->data['tablename'][1];
        }
        if (!empty($this->data['join'])) {
            $sql.= ' ' . join(' ', $this->data['join']);
        }
        if (!empty($this->data['where'])) {
            $t3 = array();
            foreach ($this->data['where'] as $k => $v) {
                if (in_array('or', $v)) {
                    foreach ($v as $k1 => $v1) {
                        if ($v1 == 'or') {
                            unset($v[$k1]);
                        }
                    }
                    $t3[] = '(' . join(' or ', $v) . ')';
                } else {
                    $t3[] = join(' and ', $v);
                }
            }
            $sql.= ' where ' . join(' and ', $t3);
        }
        if (!empty($this->data['orderby'])) {
            $sql.= " order by " . $this->data['orderby'];
        }
        if (!empty($this->data['limit'])) {
            $sql.= ' limit ' . $this->data['limit'] . ' ';
        } else {
            $sql.= ' limit 30 ';
        }
        return $sql;
    }
    /**
     * 查询
     */
    public function selectAll($exec = 0) {
        $sql = $this->formatSql();
        if (!$exec) {
            echo "预处理sql语句:" . $sql;
            exit;
        } else {
            $sth = $this->link->prepare($sql);
            if (!empty($this->data['bind_index_data'])) {
                $sth->execute($this->data['bind_index_data']);
            } else if (!empty($this->data['bind_key_data'])) {
                $sth->execute($this->data['bind_key_data']);
            } else {
                $sth->execute();
            }
            $res = $sth->fetchAll(constant('PDO::FETCH_ASSOC'));
            $sth = null;
            print_r($res);
        }
    }
    /**
     * 查询
     */
    public function selectRow($exec = 0) {
        $sql = $this->formatSql();
        $sql = preg_replace('/limit[\S\s]*/', 'limit 1', $sql);
        if (!$exec) {
            echo "预处理sql语句:" . $sql;
        } else {
            $sth = $this->link->prepare($sql);
            if (!empty($this->data['bind_index_data'])) {
                $sth->execute($this->data['bind_index_data']);
            } else if (!empty($this->data['bind_key_data'])) {
                $sth->execute($this->data['bind_key_data']);
            } else {
                $sth->execute();
            }
            $res = $sth->fetch(constant('PDO::FETCH_ASSOC'));
            $sth = null;
            print_r($res);
        }
    }
    // 统计数量
    public function count($field = "") {
        $sql = $this->formatSql();
        $prtt = '/select[\s\S]*from/i';
        if (!$field) {
            $sql = preg_replace($prtt, 'select count(*) from', $sql);
        } else {
            $sql = preg_replace($prtt, "select count({$field}) from", $sql);
        }
        if (!empty($this->data['bind_index_data'])) {
            return $this->getTotal($sql, $this->data['bind_index_data']);
        } else if (!empty($this->data['bind_key_data'])) {
            return $this->getTotal($sql, $this->data['bind_key_data']);
        } else {
            return $this->getTotal($sql);
        }
    }
    /**
     * 检查参数类型
     * @return boolean
     */
    private function checkParam($value) {
        if (is_int($value)) {
            $param = PDO::PARAM_INT;
        } else if (is_bool($value)) {
            $param = PDO::PARAM_BOOL;
        } else if (is_null($value)) {
            $param = PDO::PARAM_NULL;
        } else if (is_string($value)) {
            $param = PDO::PARAM_STR;
        } else {
            $param = FALSE;
        }
        return $param;
    }
}