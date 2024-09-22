<?php

namespace Anil\ErdGenerator\Tests;

use Anil\ErdGenerator\ModelFinder;
use Anil\ErdGenerator\Tests\Models\Avatar;
use Anil\ErdGenerator\Tests\Models\Comment;
use Anil\ErdGenerator\Tests\Models\Post;
use Anil\ErdGenerator\Tests\Models\User;

class FindModelsFromConfigTest extends TestCase
{

    /** @test */
    public function it_can_find_class_names_from_directory()
    {
        $finder = new ModelFinder(app()->make('files'));

        $classNames = $finder->getModelsInDirectory(__DIR__ . "/Models");

        $this->assertCount(4, $classNames);

        $this->assertSame(
            [Avatar::class, Comment::class, Post::class, User::class],
            $classNames->values()->all()
        );
    }

    /** @test */
    public function it_will_ignore_a_model_if_it_is_excluded_on_config()
    {
        $this->app['config']->set('erd-generator.ignore', [
            Avatar::class,
            User::class => [
                'posts'
            ]
        ]);

        $finder = new ModelFinder(app()->make('files'));

        $classNames = $finder->getModelsInDirectory(__DIR__ . "/Models");

        $this->assertCount(3, $classNames);
        $this->assertEquals(
            [Comment::class, Post::class, User::class],
            $classNames->values()->all()
        );
    }

    /** @test */
    public function it_will_only_return_models_in_whitelist_if_present()
    {
        $this->app['config']->set('erd-generator.whitelist', [
            Avatar::class,
        ]);

        $finder = new ModelFinder(app()->make('files'));

        $classNames = $finder->getModelsInDirectory(__DIR__ . "/Models");

        $this->assertCount(1, $classNames);
        $this->assertEquals(
            [Avatar::class],
            $classNames->values()->all()
        );
    }
}
