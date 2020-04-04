<?php

namespace Tests\Feature;

use App\Actions\RetrieveLandoFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;
use TitasGailius\Terminal\Terminal;

class InsertHelperCommandTest extends TestCase
{
    private $filesystemCDCommand = 'cd storage/framework/testing/disks/project';

    /** @test */
    public function itWillFailIfUnknownProjectStructure()
    {
        $this->artisan('in')
            ->expectsOutput('Could not determine what kind of project you are tweaking')
            ->assertExitCode(0);
    }

    /** @test */
    public function itWillSilentlyFailIfLandoFileDoesNotExist()
    {
        $result = app(RetrieveLandoFile::class)();
        $this->assertTrue(empty($result));

        // Clear fake project.
        Storage::fake('project');
    }

    /** @test */
    public function itCanFindWordpressProjects()
    {
        $filesystem = Storage::fake('project');
        $filesystem->makeDirectory('wp-content');
        $filesystem->put('.lando.yml', '');

        /** @var \TitasGailius\Terminal\Response */
        $response = Terminal::run("{$this->filesystemCDCommand} && php ../../../../../tweak in");
        $this->assertStringContainsString('Project type discovered: WordPress', $response->output());

        // Clear fake project.
        Storage::fake('project');
    }

    /** @test */
    public function itCanFindDrupalVanillaProjects()
    {
        $filesystem = Storage::fake('project');
        $filesystem->makeDirectory('core');

        /** @var \TitasGailius\Terminal\Response */
        $response = Terminal::run("{$this->filesystemCDCommand} && php ../../../../../tweak in");
        $this->assertStringContainsString('Project type discovered: Drupal', $response->output());

        // Clear fake project.
        Storage::fake('project');
    }

    /** @test */
    public function itCanFindDrupalComposerProjects()
    {
        $filesystem = Storage::fake('project');
        $filesystem->makeDirectory('web/core');
        $filesystem->put('composer.json', '{"require": {"drupal/core-recommended": "^8.8"}}');

        /** @var \TitasGailius\Terminal\Response */
        $response = Terminal::run("{$this->filesystemCDCommand} && php ../../../../../tweak in");
        $this->assertStringContainsString('Project type discovered: Drupal', $response->output());

        // Clear fake project.
        Storage::fake('project');
    }
}
