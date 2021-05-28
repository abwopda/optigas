<?php

namespace App\DataFixtures;

use App\Entity\Config;
use App\Entity\Contact;
use App\Entity\Employee;
use App\Entity\Pos;
use App\Entity\Product;
use App\Entity\ProductFamily;
use App\Entity\Pump;
use App\Entity\Tank;
use App\Entity\TypeProduct;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\ConfigPasswordEncoderInterface;

/**
 * Class ConfigFixtures
 * @package App\DataFixtures
 */
class ConfigFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $config_array = [
            ['name' => 'app_logo','value' => ""],
            ['name' => 'app_name','value' => ""],
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
        foreach ($config_array as $c) {
            $config = new Config();
            $config->setTheKey($c['name'])->setTheValue($c['value']);
            $manager->persist($config);
        }

        $manager->flush();
    }
}
