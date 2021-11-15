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

/**
 * Interface MarkdownWikiStorageInterface
 *
 * An interface to implement a method of storing wiki pages.
 *
 * @author Mehdi Baaboura <mbaaboura@gigadrivegroup.com>
 * @package Gigadrive\Bundle\MarkdownWikiBundle\Service\Storage
 */
interface MarkdownWikiStorageInterface {
	/**
	 * Stores a wiki page.
	 *
	 * @param MarkdownWikiPage $page
	 * @author Mehdi Baaboura <mbaaboura@gigadrivegroup.com>
	 */
	public function store(MarkdownWikiPage $page): void;

	/**
	 * Gets a wiki page by its path.
	 *
	 * @param string $path
	 * @return MarkdownWikiPage|null
	 * @author Mehdi Baaboura <mbaaboura@gigadrivegroup.com>
	 */
	public function get(string $path): ?MarkdownWikiPage;

	/**
	 * Gets an array with all existing pages.
	 *
	 * @return MarkdownWikiPage[]
	 * @author Mehdi Baaboura <mbaaboura@gigadrivegroup.com>
	 */
	public function all(): array;

	/**
	 * Flushes all stored wiki pages.
	 *
	 * @author Mehdi Baaboura <mbaaboura@gigadrivegroup.com>
	 */
	public function flush(): void;
}