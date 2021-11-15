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

namespace Gigadrive\Bundle\MarkdownWikiBundle\Model;

class MarkdownWikiPage {
	public function __construct(
		protected array  $title,
		protected array  $description,
		protected string $path,
		protected array  $content,
		protected array  $customAttributes
	) {
	}

	public function getTitle(): array {
		return $this->title;
	}

	public function getDescription(): array {
		return $this->description;
	}

	public function getPath(): string {
		return $this->path;
	}

	public function getContent(): array {
		return $this->content;
	}

	public function getCustomAttributes(): array {
		return $this->customAttributes;
	}
}