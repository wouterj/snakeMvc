<?php
namespace snakeMvc\Framework\Config\Parser;

/**
 * The abstract class for parsers
 *
 * @author Wouter J
 * @package snakeMvc
 * @subpackage Config\Parser
 */
abstract class AbstractParser
{
	/**
	 * The content of the parsed file
	 *
	 * @var string
	 */
	protected $file;

	/**
	 * Set the filename
	 *
	 * @param string $fileName The content of the parsing file
	 */
	public function __construct( $file )
	{
		$this->file = $file;
	}

	abstract function parse();
}
