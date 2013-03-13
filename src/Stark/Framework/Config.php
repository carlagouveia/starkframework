<?php

namespace Stark\Framework;

class Config
{
    protected $data;

    public function __construct($file)
    {
        if (!file_exists($file)) {
            die("Please, create the config.ini file.");
        }

        $this->data = parse_ini_file($file, true);
    }

    public function get($section, $option)
    {
        if (!array_key_exists($section, $this->data)) {
            return false;
        }

        if (!array_key_exists($option, $this->data[$section])) {
            return false;
        }

        return $this->data[$section][$option];
    }

    public function import(&$container)
    {
        foreach ($this->data as $section => $items) {
            foreach ($items as $key => $value) {
                $parameter = sprintf('%s.%s', $section, $key);
                $container->setParameter($parameter, $value);
            }
        }
    }
}