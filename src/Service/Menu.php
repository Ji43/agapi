<?php

namespace App\Service;

use App\Entity\CategorieProduit;
use Doctrine\ORM\EntityManagerInterface;
use Twig\Environment;

class Menu {
    private $manager;
    private $twig;
    private $entityClass= CategorieProduit::class;

    public function __construct(Environment $twig, EntityManagerInterface $manager)
    {
        $this->manager = $manager;
        $this->twig = $twig;
    }

    public function setEntityClass(string $entityClass) : self {
        $this->entityClass = $entityClass;
        return $this;
    }

    public function getEntityClass(): string {
        return $this->entityClass;
    }

    public function render() {
        $this->twig->display('partials/header.html.twig',[
            'categories' => $this->manager->getRepository($this->entityClass)->findAll()
            ]);
    }
}

?>