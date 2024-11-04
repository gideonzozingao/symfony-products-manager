<?php

namespace App\Controller;

use App\Entity\Product;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\ProductRepository;
use App\Form\ProductType;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;

class ProductController extends AbstractController
{
    #[Route('/products', name: 'product_index')]
    public function index(ProductRepository $repository): Response
    {
        $products = $repository->findAll();

        return $this->render('product/index.html.twig', [
            'products' => $products,
        ]);
    }

    #[Route('/products/{id<\d+>}', name: 'product_show')]
    public function show($id, ProductRepository $repository): Response
    {
        $product = $repository->find($id);
        if ($product === null) {
            throw $this->createNotFoundException('Product is not found');
        }
        return $this->render('product/show.html.twig', [
            'product' => $product
        ]);
    }
    #[Route('/products/new', name: 'product_new')]
    public function new(Request $request, EntityManagerInterface $manager): Response
    {
        $product = new Product;
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($product);
            $manager->flush();
            return $this->redirectToRoute('product_show', ['id' => $product->getId()]);
        }
        return $this->render('product/new.html.twig', [
            'form' => $form
        ]);
    }

    #[Route('/products/{id<\d+>}/edit', name: 'product_edit')]
    public function edit(Product $product, Request $request, EntityManagerInterface $manager): Response
    {

        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $manager->flush();
            return $this->redirectToRoute('product_show', ['id' => $product->getId()]);
        }
        return $this->render('product/edit.html.twig', [
            'form' => $form
        ]);
    }

    #[Route('/products/{id<\d+>}/delete', name: 'product_delete')]
    public function delete(Request $request, Product $product, EntityManagerInterface $manager): Response
    {
        if ($request->isMethod('POST')) {
            $manager->remove($product);
            // $manager->persist();
            $manager->flush();
            return $this->redirectToRoute('product_index');
        }
        return $this->render('product/delete.html.twig', ['id' => $product->getId()]);
    }
}
