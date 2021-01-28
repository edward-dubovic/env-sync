<?php

namespace Tests\Native;

use Helldar\Support\Exceptions\DirectoryNotFoundException;
use Tests\Cases\NativeTestCase;

final class ConfigurableTest extends NativeTestCase
{
    protected $fixture_expected = 'expected-config';

    public function testContent()
    {
        $service = $this->service();

        $service->path($this->path);
        $service->filename($this->filename);

        $this->assertStringEqualsFile($this->expected(), $service->content());
    }

    public function testStoring()
    {
        $service = $this->service();

        $service->path($this->path);
        $service->filename($this->filename);

        $service->store();

        $path = $this->path . '/' . $this->filename;

        $this->assertFileExists($path);
        $this->assertFileEquals($this->expected(), $path);
    }

    public function testCustomPathFailed()
    {
        $this->expectException(DirectoryNotFoundException::class);

        $this->service()->path('foo/bar/baz');
    }

    protected function serviceConfig(): ?array
    {
        return $this->config();
    }
}
