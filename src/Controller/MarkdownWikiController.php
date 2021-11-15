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

namespace Gigadrive\Bundle\MarkdownWikiBundle\Controller;

use Gigadrive\Bundle\MarkdownWikiBundle\Service\Storage\MarkdownWikiStorageInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use function is_null;
use function str_starts_with;

/**
 * Represents a controller used for serving pages.
 *
 * This controller is not routed by default. You may use it in
 * your project, but it mainly serves as an example
 * for using this bundle.
 *
 * @package Gigadrive\Bundle\MarkdownWikiBundle\Controller
 * @author Mehdi Baaboura <mbaaboura@gigadrivegroup.com>
 */
class MarkdownWikiController extends AbstractController {
	public function __construct(
		protected MarkdownWikiStorageInterface $storage,
	) {
	}

	public function indexAction(string $path, Request $request): Response {
		if (!str_starts_with($path, "/")) $path = "/" . $path;

		$page = $this->storage->get($path);
		if (is_null($page)) throw $this->createNotFoundException("Page with path $path not found.");

		$locale = $request->getLocale() ?: "en";
		$fallbackLocale = $this->getParameter("kernel.default_locale") ?: "en";

		$title = $page->getTitle()[$locale] ?? $page->getTitle()[$fallbackLocale] ?? "";
		$description = $page->getDescription()[$locale] ?? $page->getDescription()[$fallbackLocale] ?? "";
		$content = $page->getContent()[$locale] ?? $page->getContent()[$fallbackLocale] ?? "";

		return $this->render("@MarkdownWiki/page.html.twig", [
			"title" => $title,
			"description" => $description,
			"content" => $content
		]);
	}
}