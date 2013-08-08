<?php namespace JasonNZ\LaravelGrunt;

use \Mockery as m;
use \JasonNZ\LaravelGrunt\Bower\Bowerfile;
use \JasonNZ\LaravelGrunt\Bower\BowerGenerator;

class BowerGeneratorTest extends  \PHPUnit_Framework_TestCase {

	public function setUp()
	{
		// Mock the filesystem, config and bowerfile
		$this->config = m::mock('Illuminate\Config\Repository');
		$this->bowerfile = m::mock('JasonNZ\LaravelGrunt\Bower\Bowerfile');
		$this->filesystem = m::mock('Illuminate\Filesystem\Filesystem');

		// Create a new GruntGenerator
		$this->generator = new BowerGenerator($this->filesystem, $this->bowerfile, $this->config);
	}

	public function tearDown()
	{
		m::close();
	}

	public function testCreatesVendorFolder()
	{
		$this->config->shouldReceive('get')->andReturn('foo');
		$this->filesystem->shouldReceive('exists')->andReturn(false);
		$this->filesystem->shouldReceive('makeDirectory')->with('foo', 0777, true)->once();

		$this->generator->createVendorFolder('foo');
	}

	public function testNotCreateVendorFolderIfExists()
	{
		$this->config->shouldReceive('get')->andReturn('foo');
		$this->filesystem->shouldReceive('exists')->andReturn(true);
		$this->filesystem->shouldReceive('makeDirectory')->never();

		$this->generator->createVendorFolder('foo');
	}

	public function testCreateBowerFile()
	{
		$this->bowerfile->shouldReceive('createBowerJsonFile')->once()->andReturn('foo');
		$this->generator->createBowerJsonFile(array());
	}

	public function testCreateBowerrcFile()
	{
		$this->bowerfile->shouldReceive('createBowerRcFile')->once()->andReturn('foo');
		$this->generator->createBowerRcFile(array());
	}

	public function testFilesExistReturnTrueIfExist()
	{
		$this->filesystem->shouldReceive('exists')->twice()->andReturn(false);
		$this->config->shouldReceive('get')->twice()->andReturn('foo');
		$this->generator->filesExist();
	}

	public function testFileExistReturnFalseIfNotExist()
	{
		$this->filesystem->shouldReceive('exists')->once()->andReturn(true);
		$this->config->shouldReceive('get')->once()->andReturn('foo');
		$this->generator->filesExist();
	}

}