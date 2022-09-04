<?php

declare(strict_types=1);

namespace DmitryRechkin\Tests\Unit\GraphQL\TypeRegistry;

use DmitryRechkin\GraphQL\TypeRegistry\TypeRegistry;
use GraphQL\Type\Definition\BooleanType;
use GraphQL\Type\Definition\EnumType;
use PHPUnit\Framework\TestCase;

class TypeRegistryTest extends TestCase
{
	/**
	 * @return void
	 */
	public function testAddTypeReturnsSelf(): void
	{
		$typeRegistry = new TypeRegistry();
		$this->assertSame($typeRegistry, $typeRegistry->addType(new BooleanType()));
	}

	/**
	 * @return void
	 */
	public function testAddTypeAddsSameTypeOnlyOnce(): void
	{
		$typeRegistry = new TypeRegistry();
		$typeRegistry->addType(new BooleanType());
		$typeRegistry->addType(new BooleanType());

		$this->assertSame(1, count($typeRegistry->getTypes()));
	}

	/**
	 * @return void
	 */
	public function testGetTypesReturnsAllPreviouslyAddedTypes(): void
	{
		$booleanType = new BooleanType();
		$enumType = new EnumType(['name' => 'blah']);

		$types = [
			$booleanType->name => $booleanType,
			$enumType->name => $enumType,
		];

		$typeRegistry = new TypeRegistry();
		foreach ($types as $type) {
			$typeRegistry->addType($type);
		}

		$outputTypes = $typeRegistry->getTypes();
		foreach ($outputTypes as $name => $outputType) {
			$this->assertInstanceOf(get_class($types[$name]), $outputType);
		}
	}
}
