<?php

namespace Application;

class Application
{
    const CONFIG_PATH = __DIR__ . '';

    /*
     * @var array
     */
    private $config;

    public function __construct(string $configPath = '')
    {
        $configPath ? $this->loadJsonConfig($configPath) : $this->loadJsonConfig(self::CONFIG_PATH);
    }

    private function loadJsonConfig(string $configPath)
    {
        $jsonConfigContent = file_get_contents($configPath);
        if (!$jsonConfigContent) {
            throw new \Exception("Error in process parsing config");
        }
        $config = json_decode($jsonConfigContent, true);
        if (json_last_error_msg() !== JSON_ERROR_NONE){
            throw new \Exception(json_last_error_msg());
        }
        $this->config = $config;
    }
}