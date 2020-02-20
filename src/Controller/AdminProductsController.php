<?php

namespace App\Controller;

use App\Entity\Produit;
use App\Form\ProductType;
use App\Service\PaginationAdminService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminProductsController extends AbstractController
{

    /**
     * Permet de visualiser l'ensemble des produits et d'accéder à l'ajout/modif
     *
     * @Route("/admin/products/{page<\d+>?1}", name="admin_products_index")
     */
    public function index($page, PaginationAdminService $pagination)
    {
        $pagination->setEntityClass(Produit::class)
                   ->setPage($page);

        return $this->render('admin/products/index.html.twig', [
            'pagination' => $pagination
        ]);
    }

    /**
     * Permet de créer un produit
     *
     * @Route("/admin/products/new", name="product_create")
     *
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return Response
     */

    public function create(Request $request, EntityManagerInterface $manager) {

        $produit = new Produit();
        $form = $this->createForm(ProductType::class,$produit);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $user = $this->getUser();
            $produit->setUtilisateur($user);

            $manager->persist($produit);
            $manager->flush();

            $this->addFlash(
                "success",
                "Le produit <strong>{$produit->getLibelle()}</strong> a bien été ajouté !"
            );

        }

        return $this->render('admin/products/new.html.twig',[
            'form' => $form->createView(),
            'pageTitle' => "Ajout d'un produit",
            'secondTitle' => "Ajouter un produit"
        ]);
    }

    /**
     * Permet de modifier un produit
     *
     * @Route("/admin/products/edit/{id}", name="product_edit")
     *
     * @param Produit $produit
     * @param EntityManagerInterface $manager
     * @param Request $request
     * @return Response
     */
    public function edit(Produit $produit, EntityManagerInterface $manager, Request $request) {

        $form = $this->createForm(ProductType::class,$produit);
        $productName = $produit->getLibelle();

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

            $manager->persist($produit);
            $manager->flush();

            $this->addFlash(
                "success",
                "Le produit <strong>{$productName}</strong> a bien été modifié !"
            );

            return $this->redirectToRoute("admin_products_index");
        }

        return $this->render("admin/products/new.html.twig",[
            'form' => $form->createView(),
            'pageTitle' => "Modification d'un produit",
            'secondTitle' => "Modification du produit : <i>{$productName}</i>"
        ]);

    }

    /**
     * Permet la suppression du produit
     *
     * @Route("/admin/products/delete/{id}", name="product_delete")
     *
     * @param Produit $produit
     * @param EntityManagerInterface $manager
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function delete(Produit $produit, EntityManagerInterface $manager) {

        $productName = $produit->getLibelle();
        $manager->remove($produit);
        $manager->flush();

        $this->addFlash(
            'success',
            "Le produit <strong>{$productName}</strong> a bien été supprimé !"
        );

        return $this->redirectToRoute("admin_products_index");
    }

}
