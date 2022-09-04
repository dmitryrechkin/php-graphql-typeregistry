<?php

declare(strict_types=1);

namespace DmitryRechkin\GraphQL\TypeRegistry;

use GraphQL\Type\Definition\LeafType;
use GraphQL\Type\Definition\Type;

class TypeRegistry implements TypeRegistryInterface
{
	/**
	 * @var array<Type>
	 */
	private $types;

	/**
	 * constructor
	 */
	public function __construct()
	{
		$this->types = [];
	}

	/**
	 * adds a given type to the registry
	 *
	 * @param Type $type
	 * @return self
	 */
	public function addType(Type $type): self
	{
		$this->types[$type->name] = $this->prepareType($type);

		return $this;
	}

	/**
	 * returns a list of all registered types
	 *
	 * @return array<Type>
	 */
	public function getTypes(): array
	{
		return $this->types;
	}

	/**
	 * prepares a given type and returns it
	 *
	 * @param Type $type
	 * @return Type
	 */
	private function prepareType(Type $type): Type
	{
		if (false === ($type instanceof LeafType)) {
			return $type;
		}

		if (empty($type->config['serialize'])) {
			$type->config['serialize'] = function ($value) use ($type) {
				return $type->serialize($value);
			};
		}

		if (empty($type->config['parseLiteral'])) {
			$type->config['parseLiteral'] = function ($value) use ($type) {
				return $type->parseLiteral($value);
			};
		}

		if (empty($type->config['parseValue'])) {
			$type->config['parseValue'] = function ($value) use ($type) {
				return $type->parseValue($value);
			};
		}

		return $type;
	}
}
