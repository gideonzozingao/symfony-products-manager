<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Product;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $product = new Product();
        $product->setName("Product Three");
        $product->setDescription("This is the third Product");

        $manager->persist($product);


        $product = new Product();
        $product->setName("Product Foure");
        $product->setDescription("This is the fourth Product");

        $manager->persist($product);

        $manager->flush();
    }
}
