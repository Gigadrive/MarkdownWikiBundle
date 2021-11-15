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

namespace Gigadrive\Bundle\MarkdownWikiBundle\Command;

use Gigadrive\Bundle\MarkdownWikiBundle\Service\MarkdownWikiStorageService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class RebuildStorageCacheCommand extends Command {
	protected static $defaultName = "wiki:rebuild-storage-cache";

	public function __construct(
		protected MarkdownWikiStorageService $storageService
	) {
		parent::__construct();
	}

	protected function configure() {
		$this
			->setDescription("Rebuilds the storage cache for the markdown wiki.")
			->setHelp("Rebuilds the storage cache for the markdown wiki.");
	}

	protected function execute(InputInterface $input, OutputInterface $output): int {
		$this->storageService->rebuildStorageCache();

		$output->writeln("The cache has been rebuilt.");

		return 0;
	}
}