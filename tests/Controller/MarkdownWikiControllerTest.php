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

namespace Gigadrive\Bundle\MarkdownWikiBundle\Tests\Controller;

use Gigadrive\Bundle\MarkdownWikiBundle\Service\MarkdownWikiStorageService;
use Gigadrive\Bundle\MarkdownWikiBundle\Service\Storage\MarkdownWikiStorageInterface;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;
use function getrandmax;
use function rand;

class MarkdownWikiControllerTest extends WebTestCase {
	protected KernelBrowser $client;
	protected MarkdownWikiStorageInterface $storage;
	protected MarkdownWikiStorageService $storageService;

	/**
	 * @test
	 * @author Mehdi Baaboura <mbaaboura@gigadrivegroup.com>
	 */
	public function testExistingPages() {
		$this->storageService->rebuildStorageCache(); // ensure pages are loaded

		foreach ($this->storage->all() as $page) {
			$path = $page->getPath();
			if ($path === "/") $path = "";

			$this->client->request("GET", "/wiki" . $path);
			$this->assertResponseIsSuccessful();
			$this->assertSelectorTextContains("h1", $page->getTitle()["en"]);
			$this->assertSelectorTextContains("p.lead", $page->getDescription()["en"]);
		}
	}

	/**
	 * @test
	 * @author Mehdi Baaboura <mbaaboura@gigadrivegroup.com>
	 */
	public function testFakePage() {
		$this->client->request("GET", "/wiki/" . rand(0, getrandmax()));
		$this->assertResponseStatusCodeSame(Response::HTTP_NOT_FOUND);
	}

	protected function setUp(): void {
		$this->client = static::createClient();
		$this->storage = static::getContainer()->get("markdownwiki.storage");
		$this->storageService = static::getContainer()->get("markdownwiki.storageservice");
	}
}