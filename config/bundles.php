<?php

return [
    Symfony\Bundle\FrameworkBundle\FrameworkBundle::class => ['all' => true],
    Sensio\Bundle\FrameworkExtraBundle\SensioFrameworkExtraBundle::class => ['all' => true],
    Symfony\Bundle\TwigBundle\TwigBundle::class => ['all' => true],
    Symfony\Bundle\WebProfilerBundle\WebProfilerBundle::class => ['dev' => true, 'test' => true, 'system' => true],
    Symfony\Bundle\MonologBundle\MonologBundle::class => ['all' => true],
    Symfony\Bundle\DebugBundle\DebugBundle::class => ['dev' => true, 'test' => true],
    Symfony\Bundle\MakerBundle\MakerBundle::class => ['dev' => true, 'system' => true],
    Doctrine\Bundle\DoctrineBundle\DoctrineBundle::class => ['system' => true, 'prod' => true],
    Doctrine\Bundle\MigrationsBundle\DoctrineMigrationsBundle::class => ['system' => true, 'prod' => true],
    Symfony\Bundle\SecurityBundle\SecurityBundle::class => ['all' => true],
    Twig\Extra\TwigExtraBundle\TwigExtraBundle::class => ['all' => true],
    DAMA\DoctrineTestBundle\DAMADoctrineTestBundle::class => ['system' => true],
    Doctrine\Bundle\FixturesBundle\DoctrineFixturesBundle::class => ['system' => true],
    FOS\JsRoutingBundle\FOSJsRoutingBundle::class => ['all' => true],
];
