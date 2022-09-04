<?php

declare(strict_types=1);

namespace DmitryRechkin\GraphQL\TypeRegistry;

use GraphQL\Type\Definition\Type;

interface TypeRegistryInterface
{
	/**
	 * adds a given type to the registry
	 *
	 * @param Type $type
	 * @return self
	 */
	public function addType(Type $type): self;

	/**
	 * returns a list of all registered types
	 *
	 * @return array<Type>
	 */
	public function getTypes(): array;
}
