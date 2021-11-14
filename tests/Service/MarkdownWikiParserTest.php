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

use Gigadrive\Bundle\MarkdownWikiBundle\Service\MarkdownWikiParser;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class MarkdownWikiParserTest extends KernelTestCase {
	protected MarkdownWikiParser $parser;

	/**
	 * @test
	 * @author Mehdi Baaboura <mbaaboura@gigadrivegroup.com>
	 */
	public function testHeadlines() {
		$this->assertEquals("<h1>This is a test.</h1>", $this->parser->parse("# This is a test."));
		$this->assertEquals("<h2>This is a test.</h2>", $this->parser->parse("## This is a test."));
		$this->assertEquals("<h3>This is a test.</h3>", $this->parser->parse("### This is a test."));
		$this->assertEquals("<h4>This is a test.</h4>", $this->parser->parse("#### This is a test."));
		$this->assertEquals("<h5>This is a test.</h5>", $this->parser->parse("##### This is a test."));
		$this->assertEquals("<h6>This is a test.</h6>", $this->parser->parse("###### This is a test."));
	}

	/**
	 * @test
	 * @author Mehdi Baaboura <mbaaboura@gigadrivegroup.com>
	 */
	public function testParagraph() {
		$this->assertEquals("<p>This is a test.</p>", $this->parser->parse("This is a test."));
	}

	/**
	 * @test
	 * @author Mehdi Baaboura <mbaaboura@gigadrivegroup.com>
	 */
	public function testBold() {
		$this->assertEquals("<p><strong>This is a test.</strong></p>", $this->parser->parse("**This is a test.**"));
	}

	/**
	 * @test
	 * @author Mehdi Baaboura <mbaaboura@gigadrivegroup.com>
	 */
	public function testItalic() {
		$this->assertEquals("<p><em>This is a test.</em></p>", $this->parser->parse("*This is a test.*"));
		$this->assertEquals("<p><em>This is a test.</em></p>", $this->parser->parse("_This is a test._"));
	}

	/**
	 * @test
	 * @author Mehdi Baaboura <mbaaboura@gigadrivegroup.com>
	 */
	public function testStrikethrough() {
		$this->assertEquals("<p><del>This is a test.</del></p>", $this->parser->parse("~~This is a test.~~"));
	}

	/**
	 * @test
	 * @author Mehdi Baaboura <mbaaboura@gigadrivegroup.com>
	 */
	public function testOrderedList() {
		$this->assertEquals("<ol>\n<li>First Item</li>\n<li>Second Item</li>\n<li>Third Item</li>\n</ol>", $this->parser->parse("1. First Item\n2. Second Item\n3. Third Item"));
	}

	/**
	 * @test
	 * @author Mehdi Baaboura <mbaaboura@gigadrivegroup.com>
	 */
	public function testUnorderedList() {
		$this->assertEquals("<ul>\n<li>First Item</li>\n<li>Second Item</li>\n<li>Third Item</li>\n</ul>", $this->parser->parse("- First Item\n- Second Item\n- Third Item"));
		$this->assertEquals("<ul>\n<li>First Item</li>\n<li>Second Item</li>\n<li>Third Item</li>\n</ul>", $this->parser->parse("* First Item\n* Second Item\n* Third Item"));
		$this->assertEquals("<ul>\n<li>First Item</li>\n<li>Second Item</li>\n<li>Third Item</li>\n</ul>", $this->parser->parse("+ First Item\n+ Second Item\n+ Third Item"));
	}

	/**
	 * @test
	 * @author Mehdi Baaboura <mbaaboura@gigadrivegroup.com>
	 */
	public function testBlockquote() {
		$this->assertEquals("<blockquote>\n<p>This is a test.</p>\n</blockquote>", $this->parser->parse("> This is a test."));
	}

	/**
	 * @test
	 * @author Mehdi Baaboura <mbaaboura@gigadrivegroup.com>
	 */
	public function testInlineCode() {
		$this->assertEquals("<p><code>This is a test.</code></p>", $this->parser->parse("`This is a test.`"));
	}

	/**
	 * @test
	 * @author Mehdi Baaboura <mbaaboura@gigadrivegroup.com>
	 */
	public function testHorizontalRule() {
		$this->assertEquals("<hr />", $this->parser->parse("---"));
	}

	/**
	 * @test
	 * @author Mehdi Baaboura <mbaaboura@gigadrivegroup.com>
	 */
	public function testLink() {
		$this->assertEquals('<p><a href="https://github.com">This is a test.</a></p>', $this->parser->parse("[This is a test.](https://github.com)"));
	}

	/**
	 * @test
	 * @author Mehdi Baaboura <mbaaboura@gigadrivegroup.com>
	 */
	public function testImage() {
		$this->assertEquals('<p><img src="source" alt="This is a test." /></p>', $this->parser->parse("![This is a test.](source)"));
	}

	/**
	 * @test
	 * @author Mehdi Baaboura <mbaaboura@gigadrivegroup.com>
	 */
	public function testCodeBlock() {
		$this->assertEquals("<pre><code>This is a test.</code></pre>", $this->parser->parse("```\nThis is a test.\n```"));
	}

	protected function setUp(): void {
		self::bootKernel();

		$this->parser = static::getContainer()->get("markdownwiki.parser");
	}
}