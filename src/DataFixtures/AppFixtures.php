<?php

namespace App\DataFixtures;

use App\Entity\CategorieProduit;
use App\Entity\Produit;
use App\Entity\SousCategorieProduit;
use App\Entity\Utilisateur;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');

        // Tableau des catégories et sous catégories

        $categSousCateg = [
            'Thés' => ["Thés noirs", "Thés blancs", "Thés verts", "Oolong", "Pu-erh"],
            'Plantes' => ["Tisanes", "Carcadets", "Roiboos", "Matés du Brésil", "Autres plantes"],
            'Boites et sachets' => ["Boites métals", "Sachets emballés", "Boites cristal"],
            'Coffrets et accessoires' => ["Théières", "Coffrets cadeaux", "Bols, tasses et autres", "Boites à thé", "Accessoires"],
            'Gourmandises' => ["Chocolats", "Cafés", "Confitures", "Patisseries"],
            'Nouveautés' => []
        ];

        //gestion des utilisateurs

        $utilisateurs = [];

        for ($i= 0; $i < 5; $i++) {
            $utilisateur = new Utilisateur();

            $utilisateur->setNomUtilisateur($faker->userName)
                        ->setHash($this->encoder->encodePassword($utilisateur,'password'))
                        ->setNom($faker->lastName)
                        ->setPrenom($faker->firstName);

            $manager->persist($utilisateur);

            $utilisateurs [] = $utilisateur;
        }



        foreach ($categSousCateg as $categorie => $sousCategorie) {

            //Gestion des categories

            $uneCategorie = new CategorieProduit();
            $uneCategorie->setLibelle($categorie)
                ->setImageCouverture($faker->imageUrl(1920, 548))
                ->setCourteIntroduction($faker->sentence(15))
                ->setCourteDescription($faker->paragraph(1));
            $manager->persist($uneCategorie);


            // Gestion des sous-catégories

            foreach ($sousCategorie as $libelleSousCateg) {

                $uneSousCategorie = new SousCategorieProduit();
                $uneSousCategorie->setLibelle($libelleSousCateg)
                    ->setHasNatureParfume(
                        $uneCategorie->getLibelle() === "Thés" ? true : false
                    )
                    ->setImageCouverture($faker->imageUrl(1920, 548))
                    ->setCourteDescription($faker->sentence(20))
                    ->setCourteIntroduction($faker->paragraph(1))
                    ->setCategorieProduit($uneCategorie);

                $manager->persist($uneSousCategorie);


                //Gestion des produits

                for ($i = 1; $i <= 10; $i++) {
                    $unProduit = new Produit();
                    $unProduit->setLibelle($faker->sentence(4))
                        ->setDescription($faker->paragraph(10))
                        ->setPrix(mt_rand(5, 50))
                        ->setOrigine($faker->sentence(1))
                        ->setImage($faker->imageUrl(870, 1029))
                        ->setUtilisateur($utilisateurs[mt_rand(0,count($utilisateurs)-1)]);
                    $uneSousCategorie->GetHasNatureParfume() ? $unProduit->setParfume(mt_rand(0, 1)) : $unProduit->setParfume(null);
                    $unProduit->setSousCategorieProduit($uneSousCategorie);
                    $manager->persist($unProduit);
                }

            }

        }
        $manager->flush();

    }
}
