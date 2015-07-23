<?php

/*
 * This file is part of the WPRouting library.
 *
 * Copyright (c) 2015 LIN3S <info@lin3s.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace LIN3S\WPRouting;

use LIN3S\WPRouting\Resolvers\ArchiveResolver;
use LIN3S\WPRouting\Resolvers\CategoryResolver;
use LIN3S\WPRouting\Resolvers\DateResolver;
use LIN3S\WPRouting\Resolvers\FrontResolver;
use LIN3S\WPRouting\Resolvers\HomeResolver;
use LIN3S\WPRouting\Resolvers\Interfaces\ResolverInterface;
use LIN3S\WPRouting\Resolvers\NotFoundResolver;
use LIN3S\WPRouting\Resolvers\PageResolver;
use LIN3S\WPRouting\Resolvers\Resolver;
use LIN3S\WPRouting\Resolvers\SearchResolver;
use LIN3S\WPRouting\Resolvers\SingleResolver;
use LIN3S\WPRouting\Resolvers\TaxonomyResolver;

/**
 * Kernel class of the routing system. It registers all the resolvers
 * and it calls the correct controller resolving the type.
 *
 * @author Beñat Espiña <benatespina@gmail.com>
 * @author Gorka Laucirica <gorka.lauzirika@gmail.com>
 */
class Router
{
    /**
     * Array which contains the different resolvers of routing.
     *
     * @var array
     */
    protected $resolvers;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->resolvers = [
            '404'      => new NotFoundResolver(),
            'search'   => new SearchResolver(),
            'front'    => new FrontResolver(),
            'home'     => new HomeResolver(),
            'taxonomy' => new TaxonomyResolver(),
            'single'   => new SingleResolver(),
            'date'     => new DateResolver(),
            'page'     => new PageResolver(),
            'category' => new CategoryResolver(),
            'archive'  => new ArchiveResolver(),
            'index'    => new Resolver()
        ];
    }

    /**
     * Resolves the routes calling the proper controller.
     *
     * @return mixed
     */
    public function resolve()
    {
        $resolver = $this->resolver();
        $result = $this->resolvers[$resolver]->resolve(RouteRegistry::create());

        return $this->call($result['controller']);
    }

    /**
     * Based on Wordpress's internal template loader, gets the proper resolver
     * checking all the use cases returning always the index if does not match with any option.
     *
     * @return string
     */
    private function resolver()
    {
        if (is_404()                    && $resolver = ResolverInterface::TYPE_404) :
        elseif (is_search()             && $resolver = ResolverInterface::TYPE_SEARCH) :
        elseif (is_front_page()         && $resolver = ResolverInterface::TYPE_FRONT) :
        elseif (is_home()               && $resolver = ResolverInterface::TYPE_HOME) :
        elseif (is_post_type_archive()  && $resolver = ResolverInterface::TYPE_ARCHIVE) :
        elseif (is_tax()                && $resolver = ResolverInterface::TYPE_TAXONOMY) :
        elseif (is_attachment()         && $resolver = get_attachment_template()) :
            remove_filter('the_content', 'prepend_attachment');
        elseif (is_single()             && $resolver = ResolverInterface::TYPE_SINGLE) :
        elseif (is_page()               && $resolver = ResolverInterface::TYPE_PAGE) :
        elseif (is_category()           && $resolver = ResolverInterface::TYPE_CATEGORY) :
        elseif (is_tag()                && $resolver = get_tag_template()) :
        elseif (is_author()             && $resolver = get_author_template()) :
        elseif (is_date()               && $resolver = ResolverInterface::TYPE_DATE) :
        elseif (is_archive()            && $resolver = ResolverInterface::TYPE_ARCHIVE) :
        elseif (is_comments_popup()     && $resolver = get_comments_popup_template()) :
        elseif (is_paged()              && $resolver = get_paged_template()) :
        else :
            $resolver = ResolverInterface::TYPE_INDEX;
        endif;

        return $resolver;
    }

    /**
     * Calls to the controller's action given. It supports static or non-static calls.
     *
     * @param string $controller The fully qualified namespace controller and its action 
     *
     * @return mixed
     */
    private function call($controller)
    {
        list($controller, $method) = explode('::', $controller);
        $reflectionClass = new \ReflectionClass($controller);
        $reflectionMethod = $reflectionClass->getMethod($method);

        if (false === $reflectionMethod->isStatic()) {
            $controller = new $controller();

            return $controller->$method();
        }

        return $controller::$method();
    }
}
