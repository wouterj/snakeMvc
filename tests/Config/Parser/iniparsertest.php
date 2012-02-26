<?php

namespace snakeMvc\Tests\Config\Parser;
use snakeMvc\Framework\Config\Parser\IniParser;

require_once __DIR__.'\..\..\..\lib\Config\Parser\IniParser.php';

class IniParserTest extends \PHPUnit_Framework_TestCase
{
	public function testNormalIniSyntax()
	{
		$iniStr = <<<EOT
[foo_settings]
foo = bar
bar = foo
EOT;
		$parser = new IniParser($iniStr);

		$this->assertEquals('bar', $parser->parse()->foo_settings['foo']);
		$this->assertEquals('foo', $parser->parse()->foo_settings['bar']);
	}

	public function testIniSyntaxWithCustomParser()
	{
		$iniStr = <<<EOT
[foo_settings]
database.user = foo
database.pass = bar
foo = bar
EOT;
		$parser = new IniParser($iniStr);

		$this->assertEquals('foo', $parser->parse()->foo_settings['database']['user']);
		$this->assertEquals('bar', $parser->parse()->foo_settings['database']['pass']);
	}

	public function testSnakeIniSyntax()
	{
		$iniStr = <<<EOT
[foo_settings]
database = "{
  user : foo,
  pass : bar
}"
EOT;
		$parser = new IniParser($iniStr);

		$this->assertEquals('foo', $parser->parse()->foo_settings['database']['pass']);
	}
}
