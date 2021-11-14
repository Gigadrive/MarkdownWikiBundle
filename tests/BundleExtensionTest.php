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

use Gigadrive\Bundle\MarkdownWikiBundle\DependencyInjection\MarkdownWikiBundleExtension;
use Gigadrive\Bundle\MarkdownWikiBundle\Service\MarkdownWikiImporter;
use Gigadrive\Bundle\MarkdownWikiBundle\Service\MarkdownWikiParser;
use JetBrains\PhpStorm\Pure;
use Matthias\SymfonyDependencyInjectionTest\PhpUnit\AbstractExtensionTestCase;

class BundleExtensionTest extends AbstractExtensionTestCase {
	/**
	 * @test
	 * @author Mehdi Baaboura <mbaaboura@gigadrivegroup.com>
	 */
	public function testServiceLoading() {
		$this->load();
		$this->assertContainerBuilderHasService("markdownwiki.parser", MarkdownWikiParser::class);
		$this->assertContainerBuilderHasService("markdownwiki.importer", MarkdownWikiImporter::class);
	}

	#[Pure] protected function getContainerExtensions(): array {
		return [new MarkdownWikiBundleExtension];
	}
}