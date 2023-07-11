<?php

namespace App\DataFixtures;

use App\Entity\Mission;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class MissionFixtures extends Fixture implements DependentFixtureInterface
{
    private function getData(): array
    {
        return [
            ['Ingénieur infrastructures virtualisation', 'Ah pourquoi loquaces je galopade habitent fanfares. Amour peine la arret qu. Retreci cheveux non ils nos prenons horizon ton entiere legende. Quitta mes reelle moment patrie moi son cahots des ordure. Artilleurs revolution me frisottent maintenant bouquetins au je. Dentelees car parlaient citadelle vin ils gachettes que capitaine. Quand houle aux peu calme que. Debouche oh je aisselle courages fenetres. ', 2],
            ['Dév. net / reactjs', 'Son toi ans air jeta pour fois dela paix. Bleuissent maintenant survivants eux souffrance eau air est. Fin pas nul sanglees traverse exaltait prudence pressait. Dessus intime bourse sa he dirait tuiles au il jeunes. Puits calme somme bondi sa sante sa nuits ah. Plaine la tenter jusque un on leguer en. Une courent les par nul beffroi conflit hideuse briques obtenue.', 2],
            ['Expert dba postgresql', 'Sur casernes eut pic criaient couvrent defoncat heureuse. Bon oeil aux mats tuer chez poil peur. Saut poil il fils un nous je eu idee. Si mais haut oh ah quoi loin. Crepitent demeurent perimetre sa xv cartouche convertir he culbutent. Cercle qu valoir ca bruits le ca. Oeufs feu dit sorte rente trois ecole mur moins.', 3],
            ['Product owner', 'Je rangs voyez il eu voila ii. Pu prenaient crepitent qu fusillade. Sont sol sur eau chez afin deja pour crie. Ses ils haut sons rire. Esprit tempes les vin jusque galons heures roc trotte. On suffisait le abondance la lanternes qu. Havresac bravoure ah activite ouvriers la.', 3],
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

            $mission = new Mission();
            $mission->setTitle($title);
            $mission->setDescription($description);
            $mission->setUser($user);

            $manager->persist($mission);
        }

        $manager->flush();
    }
}