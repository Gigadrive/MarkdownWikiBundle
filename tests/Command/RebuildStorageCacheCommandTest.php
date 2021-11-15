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

namespace Gigadrive\Bundle\MarkdownWikiBundle\Tests\Command;

use Gigadrive\Bundle\MarkdownWikiBundle\Command\RebuildStorageCacheCommand;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Console\Tester\CommandTester;

class RebuildStorageCacheCommandTest extends KernelTestCase {
	protected RebuildStorageCacheCommand $command;

	/**
	 * @test
	 * @author Mehdi Baaboura <mbaaboura@gigadrivegroup.com>
	 */
	public function testCommand() {
		$tester = new CommandTester($this->command);

		$this->assertEquals(0, $tester->execute([]));
	}

	protected function setUp(): void {
		self::bootKernel();

		$this->command = static::getContainer()->get(RebuildStorageCacheCommand::class);
	}
}