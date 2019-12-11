<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

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
        $user1->setEmail("user1@monsite.com");
        $user1->setRoles(['ROLE_USER']);
        $user1->setPassword($this->passwordEncoder->encodePassword(
            $user1,
            'userpassword'
        ));


        $manager->persist($user1);


        $user2 = new User();
        $user2->setEmail("user2@monsite.com");
        $user2->setRoles(['ROLE_USER']);
        $user2->setPassword($this->passwordEncoder->encodePassword(
            $user2,
            'userpassword'
        ));


        $manager->persist($user2);


        $user3 = new User();
        $user3->setEmail("user3@monsite.com");
        $user3->setRoles(['ROLE_USER']);
        $user3->setPassword($this->passwordEncoder->encodePassword(
            $user3,
            'userpassword'
        ));


        $manager->persist($user3);


        $prestataire = new User();
        $prestataire->setEmail("prestataire@monsite.com");
        $prestataire->setRoles(['ROLE_PRESTATAIRE']);
        $prestataire->setPassword($this->passwordEncoder->encodePassword(
            $prestataire,
            'prestatairepassword'
        ));


        $manager->persist($prestataire);



        $prestataire1 = new User();
        $prestataire1->setEmail("subscriberauthor2@monsite.com");
        $prestataire1->setRoles(['ROLE_PRESTATAIRE']);
        $prestataire1->setPassword($this->passwordEncoder->encodePassword(
            $prestataire1,
            'prestatairepassword'
        ));


        $manager->persist($prestataire1);


        $admin = new User();
        $admin->setEmail('admin@monsite.com');
        $admin->setRoles(['ROLE_ADMIN']);
        $admin->setPassword($this->passwordEncoder->encodePassword(
            $admin,
            'adminpassword'
        ));

        $manager->persist($admin);


        $manager->flush();
    }
}
