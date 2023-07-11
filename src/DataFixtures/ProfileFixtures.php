<?php

namespace App\DataFixtures;

use App\Entity\Profile;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class ProfileFixtures extends Fixture implements DependentFixtureInterface
{
    private function getData(): array
    {
        return [
            ['Consultant front end / vue js / react js', 'Sol que dentelees moi caractere concierge age. Ravins ans venait propos bottes fer triste furent. Nul des sein fut asie robe eue. Ah miserable gachettes du bourreaux le. Ai je ramassa groupes extreme la dociles. Depenser arbustes poternes fumantes blanches sa or la ou actrices.', 2],
            ['Développeur node js / angular', 'Etriers jet couleur non capotes pendant epouses violets. Ca soixante cornette ai exaltait. Pile des chez dut mais agit nid hein vlan. Ton arriverent indulgence vin vie electrique vieillards. Ans nid ici arrivons lupanars vin regiment persuada. Coups je de armes crise te ou. Attendu montent or malheur battant tu il ne. Ah un closes clairs ruches. Ne en touffe jambes gaiete courbe veilla.', 2],
            ['Developpeur fullstack react / android / angular / java / nodejs', 'Redoublait clairieres revolution en un. Pile gens tout voit jeu ils uns. Un doit avez la tant tete peur. Cathedrale oh me il lumineuses petitement gourmettes le. Mes oui egorger laissez fin roulent. Morceaux soixante du poitrine et propager laissons. Ete vive est que rues cela seul sans mur pose.', 3],
            ['Consultant chef de projet cybersécurité', 'Elue ange roc ete mort pale fort toi. Fit ange ils ifs fond ils mats. Somptueux repousser entourage inassouvi direction nos ici ces sol gachettes. Mur dit ont des cris aime loin soir avez. La poussiere flamboyer troupeaux va hesitante. Chez aime robe dur vie cree paix seul.', 3],
        ];
    }

    public function getDependencies()
    {
        return [UserFixtures::class];
    }

    public function load(ObjectManager $manager): void
    {
        foreach ($this->getData() as [$title, $description, $user_id]) {
            $user = $manager->getRepository(User::class)->find($user_id);

            $profile = new Profile();
            $profile->setTitle($title);
            $profile->setDescription($description);
            $profile->setUser($user);

            $manager->persist($profile);
        }

        $manager->flush();
    }
}