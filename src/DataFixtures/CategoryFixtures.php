<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class CategoryFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $category = new  Category();

        $category->setName('Coiffure')
            ->setSlug('coiffure')
            ->setFilename('5e217337174ed958691177.png');

        $this->addReference('coiffure', $category);
        $manager->persist($category);

        $category = new  Category();

        $category->setName('Massage')
            ->setSlug('massage')
            ->setFilename('5e217337174ed958691177.png');

        $this->addReference('massage', $category);
        $manager->persist($category);

        $category = new  Category();

        $category->setName('Esthétique')
            ->setSlug('esthetique')
            ->setFilename('5e217337174ed958691177.png');

        $this->addReference('esthetique', $category);
        $manager->persist($category);

        $manager->flush();
    }
}
