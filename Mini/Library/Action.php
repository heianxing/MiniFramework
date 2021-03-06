<?php
// +------------------------------------------------------------
// | Mini Framework
// +------------------------------------------------------------
// | Source: https://github.com/jasonweicn/MiniFramework
// +------------------------------------------------------------
// | Author: Jason.wei <jasonwei06@hotmail.com>
// +------------------------------------------------------------

abstract class Action
{
    /**
     * View实例
     * 
     * @var View
     */
    protected $view;
    
    /**
     * Params实例
     * 
     * @var Params
     */
    protected $params;
    
    /**
     * 构造
     * 
     * @param string $controller
     * @param string $action
     * @return Action
     */
    function __construct()
    {
        $this->view = new View();
        $this->params = Params::getInstance();
        if (method_exists($this, '_init')) {
            $this->_init();
        }
    }
    
    /**
     * 向View传入变量
     * 
     * @param mixed $variable
     * @param mixed $value
     */
    protected function assign($variable, $value)
    {
        $this->view->assign($variable, $value);
    }
}