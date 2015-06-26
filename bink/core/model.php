<?php
namespace Bink;
class Model {
/**
     * @Purpose:
     * Logger对象
     * @Type: Logger
     */
    private static $instance = null;


    /**
     * @Purpose:
     * 定义系统日志级别
     * @Type: int
     */
    const EMERG = 0;
    const ALERT = 1;
    const CRIT = 2;
    const ERR = 3;
    const WARN = 4;
    const NOTICE = 5;
    const INFO = 6;
    const DEBUG = 7;

    /**
     * @Purpose:
     * 日志级别对应的名字
     * @Type array
     */
    protected $priorities = array(
        self::EMERG => 'EMERG',
        self::ALERT => 'ALERT',
        self::CRIT => 'CRIT',
        self::ERR => 'ERR',
        self::WARN => 'WARN',
        self::NOTICE => 'NOTICE',
        self::INFO => 'INFO',
        self::DEBUG => 'DEBUG',
        );

    /**
     * @Purpose:
     * 日志级别对应writer handler
     * @Type array
     */
    protected $writers = array();

    /**
     * @Purpose:
     * 日志级别对应文件路径
     * @Type array
     */
    protected $log_paths = array();

    /**
     * @Purpose:
     * 日志内容
     * @Type: array
     */
    private $log_contents = array();

    /**
     * @Purpose:
     * 析构函数
     * @Method Name: __destruct
     */
    public function __destruct()
    {
        foreach ($this->log_contents as $log_key => $log_value) {
            $this->flush($log_key);
        }
    }

    /**
     * @Purpose:
     * 返回Logger对象
     * @Method Name: getInstance
     *
     * @Return: Logger
     */
    public static function getInstance()
    {
        return new Model;
    }

    /**
     * @Purpose:
     * 写日志
     * @Method Name: log
     *
     * @Param: int $priority 日志级别
     * @Param: string $message 日志内容
     *
     * @Return: $this
     */
    private function log($priority, $message)
    {
        if (!array_key_exists($priority, $this->log_contents)) 
        {
            $this->log_contents[$priority] = array();
            $this->log_contents[$priority]['count'] = 0;
            $this->log_contents[$priority]['content'] = '';
        }
        $this->log_contents[$priority]['count']++;
        $this->log_contents[$priority]['content'] = $this->log_contents[$priority]['content'] .
            date('Y-m-d H:i:s') . "\t" . $message . PHP_EOL;

        if ($this->log_contents[$priority]['count'] > 10) {
            $this->flush($priority);
        }

        return $this;
    }


    /**
     * @Purpose:
     * 日志输出文件
     * @Method Name: flushOne
     *
     * @Param: int $priority 日志级别
     *
     */
    private function flush($priority)
    {
        if ($priority != null) {
            if (array_key_exists($priority, $this->log_contents)) {
                $_log_path = LOG_PATH . $this->priorities[$priority];
                if (!is_dir($_log_path)) {
                    mkdir($_log_path, 0777, true);
                }
                $_log_path = $_log_path . DIRECTORY_SEPARATOR . date('Y-m-d_H') . '.log';
                $_write = @fopen($_log_path, 'a', false);
                if (!empty($_write)) {
                    $_content = $this->log_contents[$priority]['content'];
                    $this->log_contents[$priority]['content'] = '';
                    $this->log_contents[$priority]['count'] = 0;
                    @fwrite($_write, $_content);
                    @fclose($_write);
                }
            }
        }
    }


    /**
     * @Purpose:
     * 记录 emerg 日志
     * @Method Name: emerg
     * 
     * @Param string $message
     * 
     * @Return $this
     */
    public function emerg($message)
    {
        return $this->log(self::EMERG, $message);
    }

    /**
     * @Purpose:
     * 记录 alert 日志
     * @Method Name: alert
     * 
     * @param string $message
     * 
     * @return $this
     */
    public function alert($message)
    {
        return $this->log(self::ALERT, $message);
    }


    /**
     * @Purpose:
     * 记录 crit 日志
     * @Method Name: crit
     * 
     * @param string $message
     * 
     * @return $this
     */
    public function crit($message)
    {
        return $this->log(self::CRIT, $message);
    }

    /**
     * @Purpose:
     * 记录 err 日志
     * @Method Name: error
     * 
     * @param string $message
     * 
     * @return $this
     */
    public function error($message)
    {
        return $this->log(self::ERR, $message);
    }

    /**
     * @Purpose:
     * 记录 warn 日志
     * @Method Name: warn
     * 
     * @param string $message
     * 
     * @return $this
     */
    public function warn($message)
    {
        return $this->log(self::WARN, $message);
    }

    /**
     * @Purpose:
     * 记录 notice 日志
     * @Method Name: notice
     * 
     * @param string $message
     * 
     * @return $this
     */
    public function notice($message)
    {
        return $this->log(self::NOTICE, $message);
    }

    /**
     * @Purpose:
     * 记录 info 日志
     * @Method Name: info
     * 
     * @param string $message
     * 
     * @return $this
     */
    public function info($message)
    {
        return $this->log(self::INFO, $message);
    }

    /**
     * @Purpose:
     * 记录 debug 日志
     * @Method Name: debug
     * 
     * @param string $message
     * 
     * @return $this
     */
    public function debug($message)
    {
        return $this->log(self::DEBUG, $message);
    }
}
