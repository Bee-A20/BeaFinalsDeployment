<?php

namespace App\DataFixtures;

use App\Entity\Products;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ProductsFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $products = [
            [
                'name' => 'Ballpoint Pen',
                'price' => '35',
                'description' => 'Smooth-writing ballpoint pen ideal for everyday notes and schoolwork.',
                'stock' => 180,
                'image' => 'Shop/Ballpoint_Pen.jpg',
            ],
            [
                'name' => 'Gel Pen',
                'price' => '120',
                'description' => 'Vibrant gel ink pen for crisp lines and comfortable writing.',
                'stock' => 95,
                'image' => 'Shop/Gel_Pen.png',
            ],
            [
                'name' => 'Composition Notebook',
                'price' => '110',
                'description' => 'Durable composition notebook with a classic cover and lined pages.',
                'stock' => 65,
                'image' => 'Shop/Composition_Notebook.jpg',
            ],
            [
                'name' => 'Highlighter Set (3 colors)',
                'price' => '99',
                'description' => 'Bright, quick-dry highlighters perfect for studying and note-taking.',
                'stock' => 70,
                'image' => 'Shop/Highlighter_Set_3_colors.jpg',
            ],
            [
                'name' => 'Mechanical Pencil',
                'price' => '89',
                'description' => 'Precision mechanical pencil with a soft grip for comfortable drawing and drafting.',
                'stock' => 120,
                'image' => 'Shop/Mechanical_Pencil.jpg',
            ],
            [
                'name' => 'Spiral Notebook',
                'price' => '150',
                'description' => 'Spiral notebook with high-quality paper for lecture notes and planning.',
                'stock' => 80,
                'image' => 'Shop/Spiral_Notebook.jpg',
            ],
        ];

        foreach ($products as $item) {
            $this->createProduct($manager, $item);
        }

        $manager->flush();
    }

    private function createProduct(ObjectManager $manager, array $item): void
    {
        $repository = $manager->getRepository(Products::class);
        if ($repository->findOneBy(['name' => $item['name']])) {
            return;
        }

        $product = new Products();
        $product->setName($item['name']);
        $product->setPrice($item['price']);
        $product->setDescription($item['description']);
        $product->setStock($item['stock']);
        $product->setImage($item['image']);
        $manager->persist($product);
    }
}
