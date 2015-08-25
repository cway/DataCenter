<?php

/***************************************************************************
 *
 * Copyright (c) 2013 Baidu.com, Inc. All Rights Reserved
 *
**************************************************************************/

/**
 * @file Logger.php
 *
 * @author caowei
 * @date 2015-08-21 00:50:00
 * @brief 日志类
 *
 */
class DWDData_Logger
{

	/**
     * log params data
     * @var array
     */
	private $_logParams =  array();
    
    /**
     * Valid PHP date() format string for log timestamps
     * @var string
     */
    private $dateFormat = 'Y-m-d G:i:s.u';

    /**
     * file log type
     * @var integer
     */
    static private $_fileLog    = 3;

    /**
     * Path to the log file
     * @var string
     */
    static private $_logFilePath = '/Users/cway/Workspace/DataCenter/logs/DWDData_Center.log.';

    private static $arrInstance  = array();
    public static $current_instance;

    // 获取指定App的log对象，默认为当前App
    /**
     * 
     * @return DWDData_Log
     * */
    public static function getInstance($app = null,$logType=null)
    {
        if(empty($app))
        {
            $app = 'DWDData';
        }

        if(empty(self::$arrInstance[$app]))
        {  
            self::$arrInstance[$app] = new DWDData_Logger();
        }

        return self::$arrInstance[$app];
    }

	/**
	 * [addNotice 添加日志字段]
	 * @param [type] $logKey   [日志字段]
	 * @param [type] $logValue [打印值]
	 */
	public function addNotice($logKey, $logValue)
	{
		$this->_logParams[$logKey] = $logValue;
	}
	
    /**
     * [notice 打印一般日志]
     * @return [type] [description]
     */
	public function notice()
	{
	 	error_log( self::formatMessage(), self::fileLog, self::logFilePath . date('YmdH') );
	}

    /**
     * [error 打印错误日志]
     * @return [type] [description]
     */
	public function error($message, $code)
	{
        $logContent   = PHP_EOL . "error_code[$code]\n" . "$message" . PHP_EOL;
	 	error_log( $logContent, self::$_fileLog, self::$_logFilePath . 'err.' . date('YmdH') );
	}

    /**
     * [trace 打印调试日志]
     * @return [type] [description]
     */
    public function trace($message)
    {
        error_log( $message, self::$_fileLog, self::$_logFilePath . 'debug.' . date('YmdH') );
    }

	/**
     * Formats the message for logging.
     *
     * @param  string $level   The Log Level of the message
     * @param  string $message The message to log
     * @param  array  $context The context
     * @return string
     */
    private function formatMessage()
    {
    	$formatMessage      = PHP_EOL;
        foreach ( $this->_logParams as $key => $value) 
        {
        	$logkey         = '';
        	$logValue       = '';

        	if( is_string( $key ) )
        	{
        		$logkey     = self::indent($value);
        	}
        	else
        	{
        		$logkey     = self::indent(self::contextToString($value));
        	}

        	if( empty( $value ) )
        	{
        	}
        	else if( is_string( $value ) )
        	{
        		$logValue   = self::indent($value);
        	}
        	else
        	{
        		$logValue   = self::indent(self::contextToString($value));
        	}

        	$formatMessage .= $logkey . '[' .$logValue . ']';
        }

        return "[{$this->getTimestamp()}] {$formatMessage}".PHP_EOL;
    }

    /**
     * Gets the correctly formatted Date/Time for the log entry.
     * 
     * PHP DateTime is dump, and you have to resort to trickery to get microseconds
     * to work correctly, so here it is.
     * 
     * @return string
     */
    static private function getTimestamp()
    {
        $originalTime = microtime(true);
        $micro        = sprintf("%06d", ($originalTime - floor($originalTime)) * 1000000);
        $date         = new DateTime(date('Y-m-d H:i:s.'.$micro, $originalTime));
        return $date->format($this->dateFormat);
    }

    /**
     * Takes the given context and coverts it to a string.
     * 
     * @param  array $context The Context
     * @return string
     */
    static private function contextToString($context)
    {
        $export      = '';
        foreach ($context as $key => $value) {
            $export .= "{$key}: ";
            $export .= preg_replace(array(
                '/=>\s+([a-zA-Z])/im',
                '/array\(\s+\)/im',
                '/^  |\G  /m',
            ), array(
                '=> $1',
                'array()',
                '    ',
            ), str_replace('array (', 'array(', var_export($value, true)));
            $export .= PHP_EOL;
        }
        return str_replace(array('\\\\', '\\\''), array('\\', '\''), rtrim($export));
    }

    /**
     * Indents the given string with the given indent.
     * 
     * @param  string $string The string to indent
     * @param  string $indent What to use as the indent.
     * @return string
     */
    static private function indent($string, $indent = '    ')
    {
        return $indent.str_replace("\n", "\n".$indent, $string);
    }
}