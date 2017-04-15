<?php

namespace Application\Config;

use Application\Exception\InternalApplicationException;

class Config
{
    private $config;

    public function __construct(string $configPath)
    {
        $this->config = $this->loadJsonConfig($configPath);
    }

    private function loadJsonConfig(string $configPath): array
    {
        $jsonConfigContent = file_get_contents($configPath);

        if (!$jsonConfigContent) {
            throw new InternalApplicationException("Error in process parsing config");
        }
        $config = json_decode($jsonConfigContent, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new InternalApplicationException(json_last_error_msg());
        }
        foreach ($config as $key => $value) {
            if (is_array($value)) {
                throw new InternalApplicationException("Config should have only scalar values.");
            }
        }

        return $config;
    }

    public function get(string $key)
    {
        if (!isset($this->config[$key])) {
            throw new InternalApplicationException(sprintf("Config with key '%s not found.", $key));
        }

        return $this->config[$key];
    }
}