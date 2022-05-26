<?php

namespace App\DataFixtures;

use App\Entity\Program;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class ProgramFixtures extends Fixture implements DependentFixtureInterface
{
    public const PROGRAMS = [
        ['id' => 0,
        'title' => 'Les mystères de l\'amour',
        'synopsis' => 'La suite d\'helene et les garçons',
        'category' => 'category_Comedie'],
        ['id' => 1,
        'title' => 'Plus belle la vie',
        'synopsis' => 'des aventures de marseillais',
        'category' => 'category_Aventure'],
        ['id' => 2,
        'title' => 'Extra Zigda',
        'synopsis' => 'Une extra terrestre devient fille au pair',
        'category' => 'category_Comedie'],
        ['id' => 3,
        'title' => 'Premiers baisers',
        'synopsis' => 'La vie de Justine Girard tout au long de ses années lycée',
        'category' => 'category_Comedie'],
        ['id' => 4,
        'title' => 'Les filles d\'à côté',
        'synopsis' => 'Les mésaventures de cinq trentenaires et voisins de paliers dans un immeuble',
        'category' => 'category_Comedie'],
    ];

    public function load(ObjectManager $manager): void
    {
        foreach(self::PROGRAMS as $programItems) {
            $program = new Program();
            $program->setTitle($programItems['title']);
            $program->setSynopsis($programItems['synopsis']);
            $program->setCategory($this->getReference($programItems['category']));
            $manager->persist($program);
            $this->addReference('program_' . $programItems['id'], $program);
            
        }

        $manager->flush();
        
    }

    public function getDependencies()
    {
        return [
          CategoryFixtures::class,
        ];
    }

}