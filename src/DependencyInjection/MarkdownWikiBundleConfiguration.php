<?php
/*
 * Copyright (C) 2021 - All rights reserved.
 * https://gigadrivegroup.com
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program. If not, see <https://gnu.org/licenses/>
 */

namespace Gigadrive\Bundle\MarkdownWikiBundle\DependencyInjection;

use JetBrains\PhpStorm\Pure;
use Symfony\Component\Config\Definition\Builder\NodeBuilder;
use Symfony\Component\Config\Definition\Builder\NodeDefinition;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class MarkdownWikiBundleConfiguration implements ConfigurationInterface {
	protected NodeBuilder $builder;

	#[Pure] public function __construct() {
		$this->builder = new NodeBuilder;
	}

	public function getConfigTreeBuilder(): TreeBuilder {
		$treeBuilder = new TreeBuilder("markdown_wiki_bundle", "array", $this->builder);
		$root = $treeBuilder->getRootNode();

		$root
			->addDefaultsIfNotSet()
			->children()
			->append($this->createSourceDirectoryNode())
			->append($this->createSafeModeNode());

		return $treeBuilder;
	}

	protected function createSourceDirectoryNode(): NodeDefinition {
		return $this->builder
			->scalarNode("source_directory")
			->info("The path to the directory holding the source markdown files.")
			->defaultValue("%kernel.project_dir%/wiki/");
	}

	protected function createSafeModeNode(): NodeDefinition {
		return $this->builder
			->booleanNode("use_safe_mode")
			->info("Whether to use parse down safe mode.")
			->defaultValue(false);
	}
}