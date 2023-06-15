<?php
namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Products;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class CategoryFixtures extends BaseFixtures
{
    public function loadData(ObjectManager $manager): void
    {
        $this->faker = Factory::create();
        $this->createMany(Category::class, 10, function (Category $category) use ($manager)
        {

            $category
                ->setName($this->faker->words(2, true))
                ->setText($this->faker->words(2, true));
            if ($this->faker->boolean(90)) {
                $category->setPublishedAt(new \DateTimeImmutable(sprintf('-%d days', rand(0, 50))));
            }
            if ($this->faker->boolean(30)) {
                $category->setCategory($category);
            }


            for($i = 1; $i < $this->faker->numberBetween(7, 50); $i++){
                $products = (new Products())
                    ->setName($this->faker->words(2, true))
                    ->setCategory($category)
                    ->setImg($this->faker->imageUrl(210, 210, 'Notebook', true))
                    ->setPublishedAt(new \DateTimeImmutable(sprintf('-%d days', rand(0, 50))))
                    ->setDescription($this->faker->words(2, true))
                    ->setPrice($this->faker->numberBetween(300, 9000));
                $manager->persist($products);
            }

        });
    }
}
