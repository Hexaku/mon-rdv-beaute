<?php

namespace App\DataFixtures;

use App\Entity\Article;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class ArticleFixtures extends Fixture implements DependentFixtureInterface
{
    public function getDependencies()
    {
        return [ProfessionalFixtures::class];
    }

    public function load(ObjectManager $manager)
    {
        $article = new Article();

        $article->setProfessional($this->getReference('marie'))
            ->setTitle('Professionel du mois')
            ->setContent('Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse non accumsan ante. 
            Nam nec consectetur mauris. Etiam porttitor augue ipsum, sed scelerisque est fermentum porttitor. 
            Ut quis augue facilisis, aliquam felis vitae, rutrum ante. Etiam lacinia euismod lorem, 
            ut malesuada eros rhoncus efficitur. Nunc sem elit, sagittis ac accumsan non, vulputate ut tortor. 
            Maecenas auctor id nibh eu pulvinar. Nunc eu semper lorem. Vivamus nec tellus eget arcu ullamcorper mollis. 
            Mauris erat erat, lacinia ut varius et, dapibus eu turpis. Duis varius fermentum mi ac tristique. Phasellus 
            eleifend iaculis quam, sit amet mollis leo imperdiet nec. Pellentesque condimentum sapien sed orci ornare 
            vulputate. Praesent tincidunt efficitur vulputate.
            Nulla tristique tortor a lacus euismod, sed elementum arcu interdum. Aliquam vel luctus risus, nec faucibus
            ex. Mauris maximus massa eu convallis tincidunt. Integer accumsan ornare arcu, in bibendum nisl ultrices 
            sed. Vivamus iaculis rhoncus ex, vestibulum dignissim augue feugiat a. Cras vel pretium eros. Nulla non 
            nibh magna. Pellentesque viverra orci eget felis lobortis consectetur. Proin vitae tincidunt eros, vitae 
            feugiat felis. Aliquam nisi elit, vulputate a varius eu, tincidunt mollis augue. Nam vel quam quis turpis 
            sagittis egestas quis ut justo. Sed non porttitor lorem, sed condimentum purus. Nullam sollicitudin ante 
            felis. Nulla dapibus diam at erat semper maximus. ')
            ->setIsHomePage(true)
            ->setSlug('professionel-du-mois');


        $manager->persist($article);
        $manager->flush();

        $article = new Article();

        $article->setProfessional($this->getReference('thierry'))
            ->setTitle('Professionel du mois 2')
            ->setContent('Nulla tristique tortor a lacus euismod, sed elementum arcu interdum. Aliquam 
            vel luctus risus, nec faucibus
            ex. Mauris maximus massa eu convallis tincidunt. Integer accumsan ornare arcu, in bibendum nisl ultrices 
            sed. Vivamus iaculis rhoncus ex, vestibulum dignissim augue feugiat a. Cras vel pretium eros. Nulla non 
            nibh magna. Pellentesque viverra orci eget felis lobortis consectetur. Proin vitae tincidunt eros, vitae 
            feugiat felis. Aliquam nisi elit, vulputate a varius eu, tincidunt mollis augue. Nam vel quam quis turpis 
            sagittis egestas quis ut justo. Sed non porttitor lorem, sed condimentum purus. Nullam sollicitudin ante 
            felis. Nulla dapibus diam at erat semper maximus.
            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse non accumsan ante. 
            Nam nec consectetur mauris. Etiam porttitor augue ipsum, sed scelerisque est fermentum porttitor. 
            Ut quis augue facilisis, aliquam felis vitae, rutrum ante. Etiam lacinia euismod lorem, 
            ut malesuada eros rhoncus efficitur. Nunc sem elit, sagittis ac accumsan non, vulputate ut tortor. 
            Maecenas auctor id nibh eu pulvinar. Nunc eu semper lorem. Vivamus nec tellus eget arcu ullamcorper mollis. 
            Mauris erat erat, lacinia ut varius et, dapibus eu turpis. Duis varius fermentum mi ac tristique. Phasellus 
            eleifend iaculis quam, sit amet mollis leo imperdiet nec. Pellentesque condimentum sapien sed orci ornare 
            vulputate. Praesent tincidunt efficitur vulputate.')
            ->setIsHomePage(false)
            ->setSlug('professionel-du-mois-2');

        $manager->persist($article);
        $manager->flush();
    }
}
