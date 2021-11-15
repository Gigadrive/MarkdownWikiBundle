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

namespace Gigadrive\Bundle\MarkdownWikiBundle\Service;

use Gigadrive\Bundle\MarkdownWikiBundle\Model\MarkdownWikiPage;
use InvalidArgumentException;
use Psr\Log\LoggerInterface;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Yaml\Yaml;
use function is_dir;
use function is_empty;
use function is_null;
use function str_ends_with;
use function str_replace;
use function strlen;
use function substr;

class MarkdownWikiImporter {
	public function __construct(
		protected string             $sourceDirectory,
		protected MarkdownWikiParser $parser,
		protected LoggerInterface    $logger
	) {
		if (!is_dir($this->sourceDirectory)) throw new InvalidArgumentException("The source directory $this->sourceDirectory does not exist!");
	}

	/**
	 * @return MarkdownWikiPage[]
	 * @author Mehdi Baaboura <mbaaboura@gigadrivegroup.com>
	 */
	public function crawl(): array {
		$pages = [];

		// read root page
		$page = $this->readFilesInDirectory($this->sourceDirectory);
		if (!is_null($page)) $pages[] = $page;

		$finder = new Finder;

		$finder
			->ignoreVCS(true)
			->followLinks()
			->in($this->sourceDirectory)
			->directories();

		if (!$finder->hasResults()) {
			if (count($pages) === 0) {
				$this->logger->warning("MarkdownWikiBundle's source directory does not contain any notable files.");
			}

			return $pages;
		}

		foreach ($finder as $dir) {
			$page = $this->readFilesInDirectory($dir->getRealPath());
			if (is_null($page)) continue;

			$pages[] = $page;
		}

		return $pages;
	}

	protected function readFilesInDirectory(string $path): ?MarkdownWikiPage {
		$finder = (new Finder())
			->in($path)
			->name(["*.md", "*.yaml", "*.yml"])
			->files()
			->depth("== 0")
			->ignoreVCS(true);

		if (count($finder) < 2) {
			$this->logger->info("Directory $path does not contain all necessary files.");
			return null;
		}

		$title = [];
		$description = [];
		$pagePath = "/" . $this->stripPathPrefix($path);
		$content = [];

		foreach ($finder as $file) {
			if (str_ends_with($file->getFilename(), ".md")) {
				$language = $file->getFilenameWithoutExtension();
				if ($language === "content") $language = "en"; // backwards compatibility

				$content[$language] = $this->parser
					->setSafeMode(true)
					->text($file->getContents());
			} else {
				$language = $file->getFilenameWithoutExtension();
				if ($language === "meta") $language = "en"; // backwards compatibility

				$meta = Yaml::parse($file->getContents());

				if (!isset($meta["title"]) || !isset($meta["description"])) {
					$this->logger->warning("Meta file in directory $path is invalid.");
					return null;
				}

				$title[$language] = $meta["title"];
				$description[$language] = $meta["description"];
			}
		}

		if (is_empty($title) || is_empty($pagePath) || is_empty($content)) {
			$this->logger->warning("Directory values in $path are invalid.");
			return null;
		}

		return new MarkdownWikiPage($title, $description, $pagePath, $content);
	}

	protected function stripPathPrefix($path): string {
		return str_replace("\\", "/", substr($path, strlen($this->sourceDirectory)));
	}

	public function getSourceDirectory(): string {
		return $this->sourceDirectory;
	}
}