<?php


namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class CategoryFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $category = new  Category();

        $category->setName('Coiffure')
            ->setSlug('coiffure');

        $this->addReference('coiffure', $category);
        $manager->persist($category);

        $category = new  Category();

        $category->setName('Massage')
            ->setSlug('massage');

        $this->addReference('massage', $category);
        $manager->persist($category);

        $category = new  Category();

        $category->setName('Esthétique')
            ->setSlug('esthetique');

        $this->addReference('esthetique', $category);
        $manager->persist($category);

        $manager->flush();
    }
}
