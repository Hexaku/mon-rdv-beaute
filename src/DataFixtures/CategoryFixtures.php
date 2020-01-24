<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class CategoryFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $category = new Category();

        $category->setName('Coiffure')
            ->setSlug('coiffure')
            ->setFilename('');

        $this->addReference('coiffure', $category);
        $manager->persist($category);

        $category = new Category();

        $category->setName('Massage')
            ->setSlug('massage')
            ->setFilename('');

        $this->addReference('massage', $category);
        $manager->persist($category);

        $category = new Category();

        $category->setName('Esthétique')
            ->setSlug('esthetique')
            ->setFilename('');

        $this->addReference('esthetique', $category);
        $manager->persist($category);

        $manager->flush();
    }
}
