<?php

namespace Momenoor\FormBuilder;

use Illuminate\Support\ServiceProvider;
use Collective\Html\FormBuilder as LaravelForm;
use Collective\Html\HtmlBuilder as LaravelHtml;
use Illuminate\Foundation\AliasLoader;
use InvalidArgumentException;
use Momenoor\FormBuilder\FormBuilder;
use Momenoor\FormBuilder\FormHelper;

class FormBuilderServiceProvider extends ServiceProvider
{
    protected const HTML_ABSTRACT = 'html';
    protected const FORM_ABSTRACT = 'form';
    protected const BUILDER_ABSTRACT = 'laravel-form-builder';
    protected const HELPER_ABSTRACT = 'laravel-form-helper';
    public function boot()
    {
        $form = $this->app['form'];

        $form->macro('customLabel', function($name, $value, $options = [], $escape_html = true) use ($form) {
            if (isset($options['for']) && $for = $options['for']) {
                unset($options['for']);
                return $form->label($for, $value, $options, $escape_html);
            }

            return $form->label($name, $value, $options, $escape_html);
        });

        $this->loadViewsFrom(__DIR__ . '/views', 'form-builder');
        $this->loadTranslationsFrom(__DIR__ . '/lang', 'form-builder');

        $this->publishes([__DIR__ . '/config/config.php' => config_path('form-builder.php')]);
        $this->publishes([__DIR__ . '/views' => base_path('resources/views/vendor/form-builder')], 'views');

        $this->mergeConfigFrom(__DIR__ . '/config/config.php', 'form-builder');
        $this->registerCloudinaryConfig();
    }

    public function register()
    {
        $this->commands(\Momenoor\FormBuilder\Console\FormMakeCommand::class);

        $this->registerHtmlIfNeeded();
        $this->registerFormIfHeeded();

        $this->mergeConfigFrom(__DIR__ . '/config/config.php', 'laravel-form-builder');

        $this->registerFormHelper();

        $this->app->singleton('laravel-form-builder', function ($app) {
            return new FormBuilder($app, $app['laravel-form-helper'], $app['events']);
        });

        $this->commands(\Momenoor\FormBuilder\Console\FormMakeCommand::class);

        $this->alias();
    }

    protected function registerFormBuilder()
    {
        $abstract = static::BUILDER_ABSTRACT;

        $formBuilderClass = $this->getFormBuilderClass();

        $this->app->singleton($abstract, function ($app) use ($formBuilderClass) {
            $formBuilder = new $formBuilderClass($app, $app[static::HELPER_ABSTRACT], $app['events']);
            $formBuilder->setFormClass($this->getPlainFormClass());
            return $formBuilder;
        });

        $this->app->alias($abstract, $formBuilderClass);
        if ($formBuilderClass != FormBuilder::class) {
            $this->app->alias($abstract, FormBuilder::class);
        }

        $this->app->afterResolving(Form::class, function ($object, $app) use ($abstract) {
            $request = $app->make('request');

            if (in_array(ValidatesWhenResolved::class, class_uses($object), true) && $request->method() !== 'GET') {
                $form = $app->make($abstract)->setDependenciesAndOptions($object);
                $form->buildForm();
                $form->redirectIfNotValid();
            }
        });
    }

    protected function registerFormHelper()
    {
        $abstract = static::HELPER_ABSTRACT;
        $this->app->singleton($abstract, function ($app) {
            $config = $app['config']->get('form-builder');
            return new FormHelper($app['view'], $app['translator'], $config);
        });

        $this->app->alias($abstract, FormHelper::class);
    }

    public function provides()
    {
        return ['laravel-form-builder'];
    }

    private function registerHtmlIfNeeded()
    {
        if (!$this->app->offsetExists('html')) {
            $this->app->singleton('html', function ($app) {
                return new LaravelHtml($app['url'], $app['view']);
            });

            $this->registerAliasIfNotExists('Html', \Collective\Html\HtmlFacade::class);
        }
    }

    private function registerFormIfHeeded()
    {
        if (!$this->app->offsetExists('form')) {
            $this->app->singleton('form', function ($app) {
                $form = new LaravelForm($app['html'], $app['url'], $app['view'], $app['session.store']->token());
                return $form->setSessionStore($app['session.store']);
            });

            $this->registerAliasIfNotExists('Form', \Collective\Html\FormFacade::class);
        }
    }

    private function alias()
    {
        $this->registerAliasIfNotExists('FormBuilder', Facades\FormBuilder::class);
        $this->registerAliasIfNotExists('Request', \Illuminate\Support\Facades\Request::class);
        $this->registerAliasIfNotExists('Route', \Illuminate\Support\Facades\Route::class);
        $this->registerAliasIfNotExists('File', \Illuminate\Support\Facades\File::class);
        $this->registerAliasIfNotExists('Redirect', \Illuminate\Support\Facades\Redirect::class);
    }

    private function registerAliasIfNotExists($alias, $class)
    {
        if (!array_key_exists($alias, AliasLoader::getInstance()->getAliases())) {
            AliasLoader::getInstance()->alias($alias, $class);
        }
    }

    protected function registerCloudinaryConfig()
    {
        if (config('form-builder.cloudinary.enabled', false)) {
            \Cloudinary::config([
                'cloud_name' => config('form-builder.cloudinary.cloud_name'),
                'api_key' => config('form-builder.cloudinary.api_key'),
                'api_secret' => config('form-builder.cloudinary.api_secret'),
            ]);
        }
    }
    protected function getPlainFormClass()
    {
        return $this->app['config']->get('laravel-form-builder.plain_form_class', Form::class);
    }

    /**
     * @return class-string
     */
    protected function getFormBuilderClass()
    {
        $expectedClass = FormBuilder::class;
        $defaultClass = FormBuilder::class;

        $class = $this->app['config']->get('laravel-form-builder.form_builder_class', $defaultClass);

        if (!class_exists($class)) {
            throw new InvalidArgumentException("Class {$class} does not exist");
        }

        if ($class !== $expectedClass && !is_subclass_of($class, $expectedClass)) {
            throw new InvalidArgumentException("Class {$class} must extend " . $expectedClass);
        }

        return $class;
    }

    /**
     * @return class-string
     */
    protected function getFormHelperClass()
    {
        $expectedClass = FormHelper::class;
        $defaultClass = FormHelper::class;

        $class = $this->app['config']->get('laravel-form-builder.form_helper_class', $defaultClass);

        if (!class_exists($class)) {
            throw new InvalidArgumentException("Class {$class} does not exist");
        }

        if ($class !== $expectedClass && !is_subclass_of($class, $expectedClass)) {
            throw new InvalidArgumentException("Class {$class} must extend " . $expectedClass);
        }

        return $class;
    }
}
