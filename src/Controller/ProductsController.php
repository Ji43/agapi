<?php

namespace App\Controller;

use App\Entity\Produit;
use App\Entity\SousCategorieProduit;
use App\Repository\SousCategorieProduitRepository;
use App\Service\Menu;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductsController extends AbstractController
{

    /**
     * Permet d'afficher les produits par leur sous-catégorie et par le filtre "parfumés"
     *
     * @Route("/{slug}/produits/parfume={parfume}", name="show_by_parfume")
     *
     * @param SousCategorieProduitRepository $repo
     * @param Menu $menu
     * @param $slug
     * @param $parfume
     * @return Response
     */
    public function showByParfume(SousCategorieProduitRepository $repo, Menu $menu, $slug, $parfume)
    {

        return $this->render("products/show_by_parfume.html.twig",[
            'menu' => $menu,
            'sousCategorie' => $repo->findBySlugAndParfume($slug,$parfume),
            'parfume' => $parfume
        ]);

    }

    /**
     * Permet d'afficher la liste des produits par sous-categorie
     *
     * @Route("/{slug}/produits", name="show_by_sousCategorie")
     *
     * @param SousCategorieProduit $sousCategorie
     * @param Menu $menu
     * @return Response
     */
    public function showBySousCategorie(SousCategorieProduit $sousCategorie, Menu $menu) {

        return $this->render("products/show_by_sousCategorie.html.twig",[
            'menu' => $menu,
            'sousCategorie' => $sousCategorie
        ]);

    }

    /**
     * Permet d'afficher les détails d'un produit
     *
     * @Route("/produit/{slug}", name="show_product")
     *
     * @param Menu $menu
     * @param Produit $produit
     * @return Response
     */
    public function showProduct(Menu $menu, Produit $produit) {

        return $this->render('products/show_product.html.twig',[
           'menu' => $menu,
           'produit' => $produit
        ]);
    }

}
