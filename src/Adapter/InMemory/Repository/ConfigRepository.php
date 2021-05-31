<?php

namespace App\Adapter\InMemory\Repository;

use App\Entity\Config;
use App\Form\ConfigType;
use App\Gateway\ConfigGateway;

/**
 * Class ConfigRepository
 * @package App\Adapter\InMemory\Repository
 */
class ConfigRepository implements ConfigGateway
{
    /**
     * @var array
     */
    public array $config = [];

    /**
     * ConfigRepository constructor.
     */
    public function __construct()
    {
        $config_array = [
            ['name' => 'app_logo','value' => ""],
            ['name' => 'app_name','value' => "optigas"],
            ['name' => 'app_description','value' => "description :)"],
            ['name' => 'app_address','value' => ""],
            ['name' => 'app_cp','value' => 11060],
            ['name' => 'app_city','value' => "Yaounde"],
            ['name' => 'app_tel','value' => "(+237)233 42 99 72"],
            ['name' => 'app_gsm','value' => "(+237)675 14 85 38"],
            ['name' => 'app_email','value' => "contact@optigas.com"],
            ['name' => 'app_website','value' => "http://www.optigas.com"],
            ['name' => 'app_map_lat','value' => 237],
            ['name' => 'app_map_lng','value' => 237],
            ['name' => 'app_lang','value' => "fr"],
            ['name' => 'rows_per_page','value' => 50],
            ['name' => 'app_css','value' => "/* css */"],
            ['name' => 'allow_registration','value' => "on"],
        ];
        $i = 1;
        foreach ($config_array as $c) {
            $config = new Config();
            $config->setTheKey($c['name'])->setTheValue($c['value']);

            $reflectionClass = new \ReflectionClass($config);
            $reflectionProperty = $reflectionClass->getProperty("id");
            $reflectionProperty->setAccessible(true);
            $reflectionProperty->setValue($config, $i);

            $this->config[$i++] = $config;
        }
    }

    /**
     * @param int $id
     * @return Config|null
     */
    public function findOneById(int $id): ?Config
    {
        if (!array_key_exists($id, $this->config)) {
            //throw new Exception("Notice: Undefined offset: ".$id);
            return null;
        }
        return $this->config[$id];
    }

    /**
     * @return Config[]|null
     */
    public function findAll(): ?array
    {
        return $this->config;
    }

    /**
     * @param Config $config
     */
    public function create(Config $config): void
    {
    }

    public function delete(Config $config): void
    {
    }

    /**
     * @return string
     */
    public function getTypeClass(): string
    {
        return ConfigType::class;
    }

    /**
     * @param $key
     * @param $value
     * @return int
     */
    public function updateBy($key, $value): int
    {
        return 1;
    }

    /**
     * @param Config $config
     */
    public function update(Config $config): void
    {
    }
}
