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

use InvalidArgumentException;
use function is_dir;

class MarkdownWikiImporter {
	public function __construct(
		protected string $sourceDirectory
	) {
		if (!is_dir($this->sourceDirectory)) throw new InvalidArgumentException("The source directory $this->sourceDirectory does not exist!");
	}

	public function getSourceDirectory(): string {
		return $this->sourceDirectory;
	}
}