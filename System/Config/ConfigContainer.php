<?php
namespace SPHERE\System\Config;

/**
 * Class ConfigContainer
 * @package SPHERE\System\Config
 */
class ConfigContainer
{
    /** @var null|ConfigContainer|mixed $Value */
    private $Value = null;

    /**
     * ConfigContainer constructor.
     * @param string|array $Content
     */
    public function __construct($Content)
    {
        if (is_array($Content)) {
            array_walk($Content, function (&$Value) {
                $Value = new ConfigContainer($Value);
            });
        }
        $this->Value = $Content;
    }

    /**
     * @param string $Key
     * @return null|ConfigContainer|mixed
     */
    public function getValue($Key)
    {
        if (isset($this->Value[$Key])) {
            return $this->Value[$Key];
        }
        return null;
    }

    /**
     * @return string
     * @throws \Exception
     */
    public function __toString()
    {
        if (is_array($this->Value) || $this->Value instanceof ConfigContainer) {
            return json_encode($this->Value);
        } else {
            return $this->Value;
        }
    }
}
