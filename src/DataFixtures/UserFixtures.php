<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use DateTime;

class UserFixtures extends Fixture
{
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager)
    {
        $user = new User();

        $user->setPassword($this->passwordEncoder->encodePassword(
            $user,
            'the_new_password'
        ));

        $user1 = new User();
        $user1->setEmail("user1@monsite.com")
            ->setRoles(['ROLE_USER'])
            ->setPassword($this->passwordEncoder->encodePassword(
                $user1,
                'userpassword'
            ))
            ->setFirstname('Marie')
            ->setLastname('Dupont')
            ->setBirthdate(new DateTime('15-06-1960'))
            ->setPhone('0123456789')
            ->setIsValidated(true)
            ->setAdress("1 rue Chaptal")
            ->setCity("Nantes");

        $manager->persist($user1);

        $user2 = new User();
        $user2->setEmail("user2@monsite.com")
            ->setRoles(['ROLE_USER'])
            ->setPassword($this->passwordEncoder->encodePassword(
                $user2,
                'userpassword'
            ))
            ->setFirstname('Thierry')
            ->setLastname('Dubois')
            ->setBirthdate(new DateTime('15-09-1960'))
            ->setPhone('0123456789')
            ->setIsValidated(true)
            ->setAdress("5 rue Lambray")
            ->setCity("Carquefou");

        $manager->persist($user2);

        $prestataire = new User();
        $prestataire->setEmail("prestataire@monsite.com")
            ->setRoles(['ROLE_PRESTATAIRE'])
            ->setPassword($this->passwordEncoder->encodePassword(
                $prestataire,
                'prestatairepassword'
            ))
            ->setFirstname('Azerty')
            ->setLastname('Ytreza')
            ->setBirthdate(new DateTime('15-06-1960'))
            ->setPhone('0917836524')
            ->setIsValidated(true)
            ->setAdress("14 rue des Louars")
            ->setCity("Nantes");

        $manager->persist($prestataire);

        $prestataire1 = new User();
        $prestataire1->setEmail("subscriberauthor2@monsite.com")
            ->setRoles(['ROLE_PRESTATAIRE'])
            ->setPassword($this->passwordEncoder->encodePassword(
                $prestataire1,
                'prestatairepassword'
            ))
            ->setFirstname('Poiuyt')
            ->setLastname('Tyuiop')
            ->setBirthdate(new DateTime('15-06-1960'))
            ->setPhone('0634253647')
            ->setIsValidated(true)
            ->setAdress("4bis quai François Mitterand")
            ->setCity("Nantes");


        $manager->persist($prestataire1);

        $admin = new User();
        $admin->setEmail('admin@monsite.com')
            ->setRoles(['ROLE_ADMIN'])
            ->setPassword($this->passwordEncoder->encodePassword(
                $admin,
                'adminpassword'
            ))
            ->setFirstname('Admin')
            ->setLastname('admin')
            ->setBirthdate(new DateTime('15-06-1960'))
            ->setPhone('0735465833')
            ->setIsValidated(true)
            ->setAdress("8 rue Graslin")
            ->setCity("Nantes");

        $manager->persist($admin);


        $manager->flush();
    }
}
