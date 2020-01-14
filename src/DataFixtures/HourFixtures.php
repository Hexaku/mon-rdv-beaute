<?php


namespace App\DataFixtures;

use App\DataFixtures\ProfessionalFixtures;
use App\Entity\BusinessHour;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use DateTime;

class HourFixtures extends Fixture implements DependentFixtureInterface
{
    public function getDependencies()
    {
        return [ProfessionalFixtures::class];
    }

    public function load(ObjectManager $manager)
    {
        $hour = new BusinessHour();

        $hour->setProfessional($this->getReference('marie'))
            ->setDay(1)
            ->setOpenTime(new DateTime('08:00:00'))
            ->setCloseTime(new DateTime('12:00:00'));

        $manager->persist($hour);

        $hour = new BusinessHour();

        $hour->setProfessional($this->getReference('marie'))
            ->setDay(2)
            ->setOpenTime(new DateTime('14:00:00'))
            ->setCloseTime(new DateTime('20:00:00'));

        $manager->persist($hour);

        $hour = new BusinessHour();

        $hour->setProfessional($this->getReference('marie'))
            ->setDay(3)
            ->setOpenTime(new DateTime('08:00:00'))
            ->setCloseTime(new DateTime('12:00:00'));

        $manager->persist($hour);

        $hour = new BusinessHour();

        $hour->setProfessional($this->getReference('marie'))
            ->setDay(3)
            ->setOpenTime(new DateTime('14:00:00'))
            ->setCloseTime(new DateTime('20:00:00'));

        $manager->persist($hour);

        $hour = new BusinessHour();

        $hour->setProfessional($this->getReference('thierry'))
            ->setDay(5)
            ->setOpenTime(new DateTime('14:00:00'))
            ->setCloseTime(new DateTime('20:00:00'));

        $manager->persist($hour);

        $hour = new BusinessHour();

        $hour->setProfessional($this->getReference('thierry'))
            ->setDay(6)
            ->setOpenTime(new DateTime('08:00:00'))
            ->setCloseTime(new DateTime('12:00:00'));

        $manager->persist($hour);

        $hour = new BusinessHour();

        $hour->setProfessional($this->getReference('thierry'))
            ->setDay(6)
            ->setOpenTime(new DateTime('14:00:00'))
            ->setCloseTime(new DateTime('20:00:00'));

        $manager->persist($hour);

        $hour = new BusinessHour();

        $hour->setProfessional($this->getReference('thierry'))
            ->setDay(7)
            ->setOpenTime(new DateTime('14:00:00'))
            ->setCloseTime(new DateTime('20:00:00'));

        $manager->persist($hour);
        $manager->flush();
    }
}
