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
 * Archive routing resolver. It is a custom specification of base resolver.
 *
 * @author Beñat Espiña <benatespina@gmail.com>
 * @author Gorka Laucirica <gorka.lauzirika@gmail.com>
 * @author Jon Torrado <jontorrado@gmail.com>
 */
class ArchiveResolver extends Resolver
{
    /**
     * {@inheritdoc}
     */
    protected $types = [Resolver::TYPE_ARCHIVE];

    /**
     * {@inheritdoc}
     */
    public function resolve(RouteRegistry $routes)
    {
        $postTypes = array_filter((array)get_query_var('post_type'));

        if (count($postTypes) === 1) {
            $postType = reset($postTypes);
            $controllers = $routes->match(Resolver::TYPE_ARCHIVE, ['posttype' => $postType]);
            if (count($controllers) > 0) {
                return $controllers[0];
            }

            $controllers = $routes->match(Resolver::TYPE_ARCHIVE);
            if (count($controllers) > 0) {
                return $controllers[0];
            }
        }

        return parent::resolve($routes);
    }
}
