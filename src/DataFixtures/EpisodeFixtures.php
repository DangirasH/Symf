<?php

namespace App\DataFixtures;

use App\Service\Slugify;
use App\Entity\Episode;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Faker\Factory;
use Doctrine\Persistence\ObjectManager;

class EpisodeFixtures extends Fixture implements DependentFixtureInterface
{
    public function __construct(private Slugify $slugify)
    {
    }

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        for ($i = 0; $i < count(ProgramFixtures::PROGRAMS); $i++) {
            $program = $this->getReference('program_' . $i);
            $numSeasons = count($program->getSeasons());
            for ($y = 0; $y < $numSeasons; $y++) {
                $maxEpisodes = rand(13, 20);
                for ($z = 0; $z < $maxEpisodes; $z++) {
                    
                    $episode = new Episode();
                    $episode->setTitle($faker->sentence());
                    $slug = $this->slugify->generate($episode->getTitle(4, true));
                    $episode->setSlug($slug);
                    //Ce Faker va nous permettre d'alimenter l'instance de Season que l'on souhaite ajouter en base
                    $episode->setNumber($z + 1);
                    $episode->setSynopsis($faker->paragraphs(3, true));
                    $episode->setSeason($this->getReference('season_' . $i . '_' . $y));
                    $manager->persist($episode);
                }
            }
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        // Tu retournes ici toutes les classes de fixtures dont ProgramFixtures dépend
        return [
            SeasonFixtures::class,
            ProgramFixtures::class,
        ];
    }
}
