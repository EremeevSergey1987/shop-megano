<?php

namespace App\Twig;

use Symfony\Component\Asset\PackageInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Twig\Extension\RuntimeExtensionInterface;

class AppUploadedAsset implements RuntimeExtensionInterface
{

    private ParameterBagInterface $parameterBag;
    private PackageInterface $package;

    public function __construct(ParameterBagInterface $parameterBag, PackageInterface $package)
    {
        $this->parameterBag = $parameterBag;
        $this->package = $package;
    }

    public function asset(string $config, string $path){
        return $this->package->getUrl($this->parameterBag->get($config) . '/' . $path);

    }

}