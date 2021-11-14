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

namespace Gigadrive\Bundle\MarkdownWikiBundle\Tests\Service;

use Gigadrive\Bundle\MarkdownWikiBundle\Service\MarkdownWikiStorageService;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class MarkdownWikiStorageServiceTest extends KernelTestCase {
	protected MarkdownWikiStorageService $storageService;

	/**
	 * @test
	 * @author Mehdi Baaboura <mbaaboura@gigadrivegroup.com>
	 */
	public function testRebuildStorageCache() {
		$this->assertNull($this->storageService->rebuildStorageCache());
	}

	protected function setUp(): void {
		self::bootKernel();

		$this->storageService = static::getContainer()->get("markdownwiki.storageservice");
	}
}