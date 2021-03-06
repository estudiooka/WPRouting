<?php

/*
 * This file is part of the WPRouting library.
 *
 * Copyright (c) 2015-2016 LIN3S <info@lin3s.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace LIN3S\WPRouting\Resolvers;

use LIN3S\WPRouting\RouteRegistry;

/**
 * Base routing resolver. This class contains a default implementation
 * of resolve method, it is used to resolve the simple use cases.
 *
 * @author Beñat Espiña <benatespina@gmail.com>
 * @author Gorka Laucirica <gorka.lauzirika@gmail.com>
 * @author Jon Torrado <jontorrado@gmail.com>
 */
abstract class Resolver
{
    const TYPE_INDEX = 'index';
    const TYPE_EMBED = 'embed';
    const TYPE_404 = 404;
    const TYPE_SEARCH = 'search';
    const TYPE_FRONT = 'front';
    const TYPE_HOME = 'home';
    const TYPE_POST_ARCHIVE = 'post_archive';
    const TYPE_TAXONOMY = 'taxonomy';
    const TYPE_ATTACHMENT = 'attachment';
    const TYPE_SINGLE = 'single';
    const TYPE_PAGE = 'page';
    const TYPE_SINGULAR = 'singular';
    const TYPE_CATEGORY = 'category';
    const TYPE_TAG = 'tag';
    const TYPE_AUTHOR = 'author';
    const TYPE_DATE = 'date';
    const TYPE_ARCHIVE = 'archive';
    const TYPE_PAGED = 'paged';

    /**
     * Array which contains the different types to match with WordPress's template loader.
     *
     * @var array
     */
    protected $types = [];

    /**
     * Resolves it's types with a proper controller.
     *
     * @param \LIN3S\WPRouting\RouteRegistry $routes The route registry
     *
     * @return array|string
     */
    public function resolve(RouteRegistry $routes)
    {
        foreach ($this->types as $type) {
            $controllers = $routes->match($type);

            if (count($controllers) > 0) {
                return $controllers[0];
            }
        }

        return $routes->match(self::TYPE_404)[0];
    }
}
