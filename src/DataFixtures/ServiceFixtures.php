<?php

namespace App\DataFixtures;

use App\Entity\Service;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class ServiceFixtures extends Fixture implements DependentFixtureInterface
{
    public function getDependencies()
    {
        return [ProfessionalFixtures::class, CategoryFixtures::class];
    }

    public function load(ObjectManager $manager)
    {
        $service = new Service();

        $service->setProfessional($this->getReference('marie'))
            ->setFilename('5df92edd39d4e935506095.jpeg')
            ->setSlug('coiffure-1')
            ->setName('Coiffure 1')
            ->setDescription('Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse non accumsan ante. 
            Nam nec consectetur mauris. Etiam porttitor augue ipsum, sed scelerisque est fermentum porttitor. 
            Ut quis augue facilisis, aliquam felis vitae, rutrum ante. Etiam lacinia euismod lorem, 
            ut malesuada eros rhoncus efficitur. Nunc sem elit, sagittis ac accumsan non, vulputate ut tortor. 
            Maecenas auctor id nibh eu pulvinar. Nunc eu semper lorem. Vivamus nec tellus eget arcu ullamcorper mollis. 
            Mauris erat erat, lacinia ut varius et, dapibus eu turpis. Duis varius fermentum mi ac tristique. Phasellus 
            eleifend iaculis quam, sit amet mollis leo imperdiet nec. Pellentesque condimentum sapien sed orci ornare 
            vulputate. Praesent tincidunt efficitur vulputate.')
            ->setCategory($this->getReference('coiffure'))
            ->setDuration(60)
            ->setPrice(40)
            ->setSlogan('Lorem ipsum dolor sit amet, consectetur adipiscing elit.')
            ->setServiceType(1);

        $this->addReference('coiffure_1', $service);
        $manager->persist($service);

        $service = new Service();

        $service->setProfessional($this->getReference('marie'))
            ->setFilename('5df92edd39d4e935506095.jpeg')
            ->setSlug('coiffure-2')
            ->setName('Coiffure 2')
            ->setDescription('Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse non accumsan ante. 
            Nam nec consectetur mauris. Etiam porttitor augue ipsum, sed scelerisque est fermentum porttitor. 
            Ut quis augue facilisis, aliquam felis vitae, rutrum ante. Etiam lacinia euismod lorem.')
            ->setCategory($this->getReference('coiffure'))
            ->setDuration(30)
            ->setPrice(40)
            ->setSlogan('Lorem ipsum dolor sit amet, consectetur adipiscing elit.')
            ->setServiceType(1);

        $this->addReference('coiffure_2', $service);
        $manager->persist($service);

        $service = new Service();

        $service->setProfessional($this->getReference('thierry'))
            ->setFilename('5df92edd39d4e935506095.jpeg')
            ->setSlug('coiffure-3')
            ->setName('Coiffure 3')
            ->setDescription('Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse non accumsan ante. 
            Nam nec consectetur mauris. Etiam porttitor augue ipsum, sed scelerisque est fermentum porttitor. 
            Ut quis augue facilisis, aliquam felis vitae, rutrum ante. Etiam lacinia euismod lorem.')
            ->setCategory($this->getReference('coiffure'))
            ->setDuration(120)
            ->setPrice(40)
            ->setSlogan('Lorem ipsum dolor sit amet, consectetur adipiscing elit.')
            ->setServiceType(1);

        $this->addReference('coiffure_3', $service);
        $manager->persist($service);

        $service = new Service();

        $service->setProfessional($this->getReference('marie'))
            ->setFilename('5df92edd39d4e935506095.jpeg')
            ->setSlug('coiffure-4')
            ->setName('Coiffure 4')
            ->setDescription('Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse non accumsan ante. 
            Nam nec consectetur mauris. Etiam porttitor augue ipsum, sed scelerisque est fermentum porttitor. 
            Ut quis augue facilisis, aliquam felis vitae, rutrum ante. Etiam lacinia euismod lorem, 
            ut malesuada eros rhoncus efficitur. Nunc sem elit, sagittis ac accumsan non, vulputate ut tortor.')
            ->setCategory($this->getReference('coiffure'))
            ->setDuration(45)
            ->setPrice(75)
            ->setSlogan('Lorem ipsum dolor sit amet, consectetur adipiscing elit.')
            ->setServiceType(1);

        $this->addReference('coiffure_4', $service);
        $manager->persist($service);

        $manager->flush();
    }
}
