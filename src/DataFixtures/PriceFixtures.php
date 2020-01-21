<?php

namespace App\DataFixtures;

use App\Entity\ServicePrices;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class PriceFixtures extends Fixture implements DependentFixtureInterface
{
    public function getDependencies()
    {
        return [ServiceFixtures::class];
    }

    public function load(ObjectManager $manager)
    {
        $price = new ServicePrices();
        $price->setPrice(50)
            ->setName('Cheveux court')
            ->setService($this->getReference('coiffure_1'));

        $manager->persist($price);

        $price = new ServicePrices();
        $price->setPrice(60)
            ->setName('Cheveux long')
            ->setService($this->getReference('coiffure_1'));

        $manager->persist($price);
        $manager->flush();
    }
}
