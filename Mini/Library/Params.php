<?php
// +------------------------------------------------------------
// | Mini Framework
// +------------------------------------------------------------
// | Source: https://github.com/jasonweicn/MiniFramework
// +------------------------------------------------------------
// | Author: Jason.wei <jasonwei06@hotmail.com>
// +------------------------------------------------------------

class Params
{
    /**
     * Params Instance
     * 
     * @var Params
     */
    protected static $_instance;
    
    /**
     * 参数数组
     * 
     * @var array
     */
    public $_params;
    
    /**
     * POST数组
     * 
     * @var array
     */
    public $_post;
    
    /**
     * GET数组
     * 
     * @var array
     */
    public $_get;
    
    /**
     * 获取实例
     * 
     */
    public static function getInstance()
    {
        if (self::$_instance === null) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }
    
    /**
     * 构造
     * 
     */
    protected function __construct()
    {
        if (!empty($_GET)) {
            foreach ($_GET as $key => $val) {
                if (is_array($val)) {
                    $this->_get[$key] = $this->getArray($val);
                } else {
                    if (is_int($val)) {
                        $this->_get[$key] = $this->getInt($val);
                    } else {
                        $this->_get[$key] = $this->getStr($val);
                    }
                }
            }
        }
        
        if (!empty($_POST)) {
            foreach ($_POST as $key => $val) {
                if (is_array($val)) {
                    $this->_post[$key] = $this->getArray($val);
                } else {
                    if (is_int($val)) {
                        $this->_post[$key] = $this->getInt($val);
                    } else {
                        $this->_post[$key] = $this->getStr($val);
                    }
                }
            }
        }
    }
    
    /**
     * 获得一个整型变量
     * @param unknown $number
     * @return int
     */
    private function getInt($number)
    {
        return intval($number);
    }
    
    /**
     * 获得一个字符型变量
     * @param unknown $string
     * @return string
     */
    private function getStr($string)
    {
        if (!get_magic_quotes_gpc()) {
            $string = addslashes($string);
        }
        return $string;
    }
    
    /**
     * 递归方式过滤数组
     * 
     * @param array $array
     * @return array
     */
    private function getArray($array) {
        foreach ($array as $key => $val) {
            if (is_array($val)) {
                $array[$key] = $this->getArray($val);
            } else {
                if (is_int($val)) {
                    $array[$key] = $this->getInt($val);
                } else {
                    $array[$key] = $this->getStr($val);
                }
            }
        }
        return $array;
    }
    
    /**
     * checkInject 检测传入的字符串是否含有引起SQL注入的字符
     * 
     * @param string $string
     * @return bool
     */
    public function checkInject($string)
    {
        return eregi('select|insert|update|delete|\/\*|\*|\.\.\/|\.\/|union|into|load_file|outfile', $string);
    }
    
    /**
     * 存入参数数组
     * @param array $params
     */
    public function setParams(array $params)
    {
        $this->_params = $this->_params + (array)$params;
        
        foreach ($params as $key => $value) {
            if ($value === null) {
                unset($this->_params[$key]);
            }
        }
        return;
    }
    
    /**
     * 取出参数数组
     * @return array:
     */
    public function getParams()
    {
        return $this->_params;
    }
    
    /**
     * 存入一个参数
     * @param string $key
     * @param unknown $value
     */
    public function setParam($key, $value)
    {
        $key = (string)$key;
        
        if (($value === null) && isset($this->_params[$key])) {
            unset($this->_params[$key]);
        } elseif ($value !== null) {
            $this->_params[$key] = $value;
        }
        return;
    }
    
    /**
     * 取出一个参数
     * @param string $key
     * @return $value
     */
    public function getParam($key)
    {
        $value = null;
        $key = (string)$key;
        if (isset($this->_params[$key])) {
            $value = $this->_params[$key];
        }
        
        return $value;
    }
}