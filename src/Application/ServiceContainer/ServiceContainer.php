<?php

namespace Application\ServiceContainer;

use Application\Config\Config;
use Application\Exception\InternalApplicationException;
use Application\Exception\ServiceNotFoundException;
use Twig_Environment;
use Twig_Loader_Filesystem;

class ServiceContainer
{
    const CLASS_KEY = 'class';
    const ARGUMENTS_KEY = 'arguments';
    const CALL_KEY = 'call';

    /** @var array */
    private $services;

    public function __construct(Config $config)
    {
        $this->initialize($config);
    }

    public function get(string $name)
    {
        if (!$this->exist($name)) {
            throw new ServiceNotFoundException(sprintf("Service with name '%s' not found.", $name));
        }
        return $this->services[$name];
    }

    private function initialize(Config $config)
    {
        $this->buildTwig($config->get('template_dir'), $config->get('cache_dir'));

        $servicesRaw = $this->loadJsonServices($config->get('services_path'));

        foreach ($servicesRaw as $serviceName => $serviceData) {
            $this->services[$serviceName] = $this->buildService($serviceName, $servicesRaw);
        }
    }

    private function buildService(string $serviceName, array $servicesRaw)
    {
        $service = $servicesRaw[$serviceName];
        $class = new \ReflectionClass($service[self::CLASS_KEY]);
        $argumentList = $service[self::ARGUMENTS_KEY] ?? [];

        foreach ($argumentList as $serviceName) {
            if ($this->exist($serviceName)) {
                $arguments[] = $this->get($serviceName);
            } else {
                $arguments[] = $this->buildService($serviceName, $servicesRaw);
            }
        }
        $instance = $class->newInstanceArgs($arguments ?? []);
        if (isset($service[self::CALL_KEY])) {
            $callData = $service[self::CALL_KEY];
            foreach ($callData as $methodData) {
                $methodName = $methodData['method'];
                $methodArgs = array_map(function (string $serviceName) {
                    return $this->get($serviceName);
                }, $methodData['arguments'] ?? []);

                $method = $class->getMethod($methodName);
                $method->invokeArgs($instance, $methodArgs);
            }
        }
        return $instance;
    }

    private function loadJsonServices(string $serviceFilePath): array
    {
        $jsonServicesContent = file_get_contents($serviceFilePath);

        if (!$jsonServicesContent) {
            throw new InternalApplicationException("Error in process parsing config.");
        }
        $services = json_decode($jsonServicesContent, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new InternalApplicationException(json_last_error_msg());
        }

        return $services;
    }

    private function exist(string $name): bool
    {
        return isset($this->services[$name]);
    }

    private function buildTwig(string $templateDir, string $cacheDir)
    {
        $twigLoader = new Twig_Loader_Filesystem(__DIR__ . '/../../../' . $templateDir);
        $twig = new Twig_Environment($twigLoader, ['cache' => __DIR__ . '/../../../' . $cacheDir]);
        $this->services['twig'] = $twig;
    }
}