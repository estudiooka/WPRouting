<?php

/*
 * This file is part of the WPRouting library.
 *
 * Copyright (c) 2015 LIN3S <info@lin3s.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace LIN3S\WPRouting\Resolvers;

use LIN3S\WPRouting\RouteRegistry;

/**
 * Page routing resolver. It is a custom specification of base resolver.
 *
 * @author Beñat Espiña <benatespina@gmail.com>
 * @author Gorka Laucirica <gorka.lauzirika@gmail.com>
 */
class PageResolver extends Resolver
{
    /**
     * {@inheritdoc}
     */
    protected $types = ['page'];

    /**
     * {@inheritdoc}
     */
    public function resolve(RouteRegistry $routes)
    {
        $template = get_page_template_slug();

        if ($template) {
            $controllers = $routes->getByTemplate($template);
            if (count($controllers) > 0) {
                return $controllers[0];
            }
        }

        $pagename = get_query_var('pagename');
        if ($pagename) {
            $controllers = $routes->getByTypeAndSlug('page', $pagename);
            if (count($controllers) > 0) {
                return $controllers[0];
            }
        }

        $id = get_queried_object_id();
        if ($id) {
            $controllers = $routes->getByTypeAndId('page', $id);
            if (count($controllers) > 0) {
                return $controllers[0];
            }
        }

        return parent::resolve($routes);
    }
}
