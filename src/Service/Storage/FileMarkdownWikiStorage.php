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

namespace Gigadrive\Bundle\MarkdownWikiBundle\Service\Storage;

use Gigadrive\Bundle\MarkdownWikiBundle\Model\MarkdownWikiPage;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Finder\Finder;
use Symfony\Component\HttpKernel\KernelInterface;
use function file_exists;
use function file_get_contents;
use function file_put_contents;
use function mkdir;
use function serialize;
use function str_ends_with;
use function unserialize;
use const DIRECTORY_SEPARATOR;

class FileMarkdownWikiStorage implements MarkdownWikiStorageInterface {
	public function __construct(
		protected KernelInterface $kernel,
		protected ?string         $path = null
	) {
	}

	public function store(MarkdownWikiPage $page): void {
		$this->createCacheDirectory();

		$dirPath = $this->getPath() . $page->getPath();
		if (!file_exists($dirPath)) {
			mkdir($dirPath, 0777, true);
		}

		$filePath = $dirPath . "/page.dat";

		file_put_contents($filePath, serialize($page));
	}

	public function getPath(): string {
		return $this->path ?: $this->kernel->getCacheDir() . DIRECTORY_SEPARATOR . "markdownwikibundle-cache";
	}

	public function createCacheDirectory() {
		$path = $this->getPath();

		if (!file_exists($path)) {
			mkdir($path, 0777, true);
		}
	}

	public function get(string $path): ?MarkdownWikiPage {
		$filePath = $this->getPath() . $path . (!str_ends_with($path, "/") ? "/" : "") . "page.dat";
		if (!file_exists($filePath)) return null;

		$content = @file_get_contents($filePath);
		if (!$content) return null;

		return unserialize($content);
	}

	public function all(): array {
		$pages = [];

		foreach ((new Finder())->in($this->getPath())->name("page.dat") as $file) {
			$pages[] = unserialize($file->getContents());
		}

		return $pages;
	}

	public function flush(): void {
		$this->createCacheDirectory();

		(new Filesystem)
			->remove(
				(new Finder())
					->in($this->getPath())
			);
	}
}