<?php
namespace Solution1CBitrix\Blanks;

class EmptyBlank
{
    /** @var static|null Объект класса */
    protected static $instance = null;


    /**
     * Создает и возвращает объект класса
     * @param array ...$argument
     * @return static
     */
    public static function getInstance(...$argument)
    {
        if(static::$instance === null)
        {
            static::$instance = new static(...$argument);
        }

        return static::$instance;
    }

    public static function reset()
    {
        static::$instance = null;
    }

    protected function __construct(...$argument)
    {

    }

    protected function __wakeup()
    {
    }

    protected function __clone()
    {
    }
}
