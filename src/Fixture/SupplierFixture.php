<?php

declare(strict_types=1);

namespace App\Fixture;

use App\Entity\Supplier;
use Faker\Generator;
use Doctrine\Common\Persistence\ObjectManager;
use Sylius\Bundle\FixturesBundle\Fixture\AbstractFixture;
use Sylius\Bundle\FixturesBundle\Fixture\FixtureInterface;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Sylius\Component\Resource\Factory\FactoryInterface;
use Doctrine\ORM\EntityManagerInterface;

final class SupplierFixture extends AbstractFixture implements FixtureInterface
{
    /** @var FactoryInterface */
    private $supplierFactory;

    /** @var EntityManagerInterface */          // objectmanager need to change to entitymanager interface.
    private $supplierManager;

    /** @var Generator */
    private $generator;

    public function __construct(FactoryInterface $supplierFactory, EntityManagerInterface $supplierManager, Generator $generator)
    {
        $this->supplierFactory = $supplierFactory;
        $this->supplierManager = $supplierManager;
        $this->generator = $generator;

    }

    public function load(array $options): void 
    {
        for ($i = 0; $i < $options['count']; $i++) {
            /** @var SupplierInterface $supplier */
            $supplier = $this->supplierFactory->createNew();
            $supplier->setEmail($this->generator->companyEmail);
            $supplier->setName($this->generator->company);
            $this->supplierManager->persist($supplier);

        }

        $this->supplierManager->flush();

    }

    public function getName(): string 
    {
        return 'supplier';
    }

    protected function configureOptionsNode(ArrayNodeDefinition $optionsNode): void
    {
        $optionsNode
            ->children()
            ->integerNode('count')
            ;

    }

}