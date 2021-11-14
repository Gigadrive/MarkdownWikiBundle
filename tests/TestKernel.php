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

namespace Gigadrive\Bundle\MarkdownWikiBundle\Tests;

use Exception;
use Gigadrive\Bundle\MarkdownWikiBundle\MarkdownWikiBundle;
use Symfony\Bundle\FrameworkBundle\FrameworkBundle;
use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Kernel;

class TestKernel extends Kernel {
	use MicroKernelTrait;

	public function registerBundles(): iterable {
		yield new FrameworkBundle;
		yield new MarkdownWikiBundle;
	}

	/**
	 * @throws Exception
	 */
	protected function configureContainer(ContainerBuilder $container, LoaderInterface $loader): void {
		$loader->load(__DIR__ . "/Fixtures/Resources/config/**/*.{php,xml,yaml,yml}", "glob");
	}
}