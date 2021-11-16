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

use Exception;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

class MarkdownWikiBundleExtension extends Extension {
	/**
	 * @throws Exception
	 */
	public function load(array $configs, ContainerBuilder $container) {
		$loader = new YamlFileLoader(
			$container,
			new FileLocator(__DIR__ . "/../Resources/config")
		);

		foreach (["services.yaml"] as $configFile) {
			$loader->load($configFile);
		}

		$config = $this->processConfiguration(
			new MarkdownWikiBundleConfiguration(),
			$configs
		);

		$this->addImporterDefinitionArguments($container, $config);

		$this->addAnnotatedClassesToCompile([]);
	}

	protected function addImporterDefinitionArguments(ContainerBuilder $container, array $config) {
		$definition = $container->getDefinition("markdownwiki.importer");
		$definition->setArgument("\$sourceDirectory", $config["source_directory"]);
		$definition->setArgument("\$useSafeMode", $config["use_safe_mode"]);
		$definition->setArgument("\$markupEscaped", $config["markup_escaped"]);
	}
}