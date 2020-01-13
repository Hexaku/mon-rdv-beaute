<?php


namespace App\DataFixtures;

use App\Entity\Professional;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use DateTime;

class ProfessionalFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $professional = new Professional();
        $professional->setPhone('0698567435')
            ->setName('Marie Dubois')
            ->setDescription('Coiffeuse')
            ->setEmail('maridubois@monsite.mail')
            ->setFilename('5df8f893904fe535997572.jpg')
            ->setPlace('8 rue de Nantes, 44000 Nantes');

        $manager->persist($professional);
        $this->addReference('marie', $professional);
        $manager->flush();

        $professional = new Professional();
        $professional->setPhone('0698567435')
            ->setName('Thierry Dupont')
            ->setDescription('Coiffeur')
            ->setEmail('thierrydupont@monsite.mail')
            ->setFilename('5df8fb52e26c4367514253.png')
            ->setPlace('20 rue de Nantes, 44000 Nantes');

        $manager->persist($professional);
        $this->addReference('thierry', $professional);
        $manager->flush();
    }
}
