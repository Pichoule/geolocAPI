<?php

use Symfony\Component\Routing\Exception\MethodNotAllowedException;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Symfony\Component\Routing\RequestContext;

/**
 * This class has been auto-generated
 * by the Symfony Routing Component.
 */
class srcDevDebugProjectContainerUrlMatcher extends Symfony\Bundle\FrameworkBundle\Routing\RedirectableUrlMatcher
{
    public function __construct(RequestContext $context)
    {
        $this->context = $context;
    }

    public function match($pathinfo)
    {
        $allow = $allowSchemes = array();
        if ($ret = $this->doMatch($pathinfo, $allow, $allowSchemes)) {
            return $ret;
        }
        if ($allow) {
            throw new MethodNotAllowedException(array_keys($allow));
        }
        if (!in_array($this->context->getMethod(), array('HEAD', 'GET'), true)) {
            // no-op
        } elseif ($allowSchemes) {
            redirect_scheme:
            $scheme = $this->context->getScheme();
            $this->context->setScheme(key($allowSchemes));
            try {
                if ($ret = $this->doMatch($pathinfo)) {
                    return $this->redirect($pathinfo, $ret['_route'], $this->context->getScheme()) + $ret;
                }
            } finally {
                $this->context->setScheme($scheme);
            }
        } elseif ('/' !== $pathinfo) {
            $pathinfo = '/' !== $pathinfo[-1] ? $pathinfo.'/' : substr($pathinfo, 0, -1);
            if ($ret = $this->doMatch($pathinfo, $allow, $allowSchemes)) {
                return $this->redirect($pathinfo, $ret['_route']) + $ret;
            }
            if ($allowSchemes) {
                goto redirect_scheme;
            }
        }

        throw new ResourceNotFoundException();
    }

    private function doMatch(string $rawPathinfo, array &$allow = array(), array &$allowSchemes = array()): ?array
    {
        $allow = $allowSchemes = array();
        $pathinfo = rawurldecode($rawPathinfo);
        $context = $this->context;
        $requestMethod = $canonicalMethod = $context->getMethod();

        if ('HEAD' === $requestMethod) {
            $canonicalMethod = 'GET';
        }

        switch ($pathinfo) {
            case '/category':
                // category
                $ret = array('_route' => 'category', '_controller' => 'App\\Controller\\CategoryController::index');
                if (!isset(($a = array('GET' => 0))[$canonicalMethod])) {
                    $allow += $a;
                    goto not_category;
                }

                return $ret;
                not_category:
                // category_create
                $ret = array('_route' => 'category_create', '_controller' => 'App\\Controller\\CategoryController::category_create');
                if (!isset(($a = array('POST' => 0))[$requestMethod])) {
                    $allow += $a;
                    goto not_category_create;
                }

                return $ret;
                not_category_create:
                break;
            case '/place':
                // place
                $ret = array('_route' => 'place', '_controller' => 'App\\Controller\\PlaceController::index');
                if (!isset(($a = array('GET' => 0))[$canonicalMethod])) {
                    $allow += $a;
                    goto not_place;
                }

                return $ret;
                not_place:
                // place_create
                $ret = array('_route' => 'place_create', '_controller' => 'App\\Controller\\PlaceController::place_create');
                if (!isset(($a = array('POST' => 0))[$requestMethod])) {
                    $allow += $a;
                    goto not_place_create;
                }

                return $ret;
                not_place_create:
                break;
            default:
                $routes = array(
                    '/user' => array(array('_route' => 'useruser_create', '_controller' => 'App\\Controller\\UserController::user_create'), null, array('POST' => 0), null),
                );

                if (!isset($routes[$pathinfo])) {
                    break;
                }
                list($ret, $requiredHost, $requiredMethods, $requiredSchemes) = $routes[$pathinfo];

                $hasRequiredScheme = !$requiredSchemes || isset($requiredSchemes[$context->getScheme()]);
                if ($requiredMethods && !isset($requiredMethods[$canonicalMethod]) && !isset($requiredMethods[$requestMethod])) {
                    if ($hasRequiredScheme) {
                        $allow += $requiredMethods;
                    }
                    break;
                }
                if (!$hasRequiredScheme) {
                    $allowSchemes += $requiredSchemes;
                    break;
                }

                return $ret;
        }

        $matchedPathinfo = $pathinfo;
        $regexList = array(
            0 => '{^(?'
                    .'|/category/([^/]++)(?'
                        .'|(*:28)'
                    .')'
                    .'|/place/(?'
                        .'|([^/]++)(*:54)'
                        .'|category/([^/]++)(*:78)'
                        .'|([^/]++)(?'
                            .'|(*:96)'
                            .'|/([^/]++)/([^/]++)(*:121)'
                        .')'
                    .')'
                    .'|/user/([^/]++)(?'
                        .'|(*:148)'
                    .')'
                .')$}sD',
        );

        foreach ($regexList as $offset => $regex) {
            while (preg_match($regex, $matchedPathinfo, $matches)) {
                switch ($m = (int) $matches['MARK']) {
                    case 28:
                        $matches = array('id' => $matches[1] ?? null);

                        // category_id
                        $ret = $this->mergeDefaults(array('_route' => 'category_id') + $matches, array('_controller' => 'App\\Controller\\CategoryController::category_id'));
                        if (!isset(($a = array('GET' => 0))[$canonicalMethod])) {
                            $allow += $a;
                            goto not_category_id;
                        }

                        return $ret;
                        not_category_id:

                        // category_update
                        $ret = $this->mergeDefaults(array('_route' => 'category_update') + $matches, array('_controller' => 'App\\Controller\\CategoryController::category_update'));
                        if (!isset(($a = array('PUT' => 0))[$requestMethod])) {
                            $allow += $a;
                            goto not_category_update;
                        }

                        return $ret;
                        not_category_update:

                        // category_delete
                        $ret = $this->mergeDefaults(array('_route' => 'category_delete') + $matches, array('_controller' => 'App\\Controller\\CategoryController::category_delete'));
                        if (!isset(($a = array('DELETE' => 0))[$requestMethod])) {
                            $allow += $a;
                            goto not_category_delete;
                        }

                        return $ret;
                        not_category_delete:

                        break;
                    case 96:
                        $matches = array('id' => $matches[1] ?? null);

                        // place_update
                        $ret = $this->mergeDefaults(array('_route' => 'place_update') + $matches, array('_controller' => 'App\\Controller\\PlaceController::place_update'));
                        if (!isset(($a = array('PUT' => 0))[$requestMethod])) {
                            $allow += $a;
                            goto not_place_update;
                        }

                        return $ret;
                        not_place_update:

                        // place_delete
                        $ret = $this->mergeDefaults(array('_route' => 'place_delete') + $matches, array('_controller' => 'App\\Controller\\PlaceController::place_delete'));
                        if (!isset(($a = array('DELETE' => 0))[$requestMethod])) {
                            $allow += $a;
                            goto not_place_delete;
                        }

                        return $ret;
                        not_place_delete:

                        break;
                    case 148:
                        $matches = array('id' => $matches[1] ?? null);

                        // useruser
                        $ret = $this->mergeDefaults(array('_route' => 'useruser') + $matches, array('_controller' => 'App\\Controller\\UserController::user_id'));
                        if (!isset(($a = array('GET' => 0))[$canonicalMethod])) {
                            $allow += $a;
                            goto not_useruser;
                        }

                        return $ret;
                        not_useruser:

                        // useruser_delete
                        $ret = $this->mergeDefaults(array('_route' => 'useruser_delete') + $matches, array('_controller' => 'App\\Controller\\UserController::user_delete'));
                        if (!isset(($a = array('DELETE' => 0))[$requestMethod])) {
                            $allow += $a;
                            goto not_useruser_delete;
                        }

                        return $ret;
                        not_useruser_delete:

                        // useruser_update
                        $ret = $this->mergeDefaults(array('_route' => 'useruser_update') + $matches, array('_controller' => 'App\\Controller\\UserController::user_update'));
                        if (!isset(($a = array('PUT' => 0))[$requestMethod])) {
                            $allow += $a;
                            goto not_useruser_update;
                        }

                        return $ret;
                        not_useruser_update:

                        break;
                    default:
                        $routes = array(
                            54 => array(array('_route' => 'place_id', '_controller' => 'App\\Controller\\PlaceController::place_id'), array('id'), array('GET' => 0), null),
                            78 => array(array('_route' => 'places_category_id', '_controller' => 'App\\Controller\\PlaceController::places_category_id'), array('id'), array('GET' => 0), null),
                            121 => array(array('_route' => 'place_in_range', '_controller' => 'App\\Controller\\PlaceController::GetPlacesInRange'), array('latitude', 'longitude', 'range'), array('GET' => 0), null),
                        );

                        list($ret, $vars, $requiredMethods, $requiredSchemes) = $routes[$m];

                        foreach ($vars as $i => $v) {
                            if (isset($matches[1 + $i])) {
                                $ret[$v] = $matches[1 + $i];
                            }
                        }

                        $hasRequiredScheme = !$requiredSchemes || isset($requiredSchemes[$context->getScheme()]);
                        if ($requiredMethods && !isset($requiredMethods[$canonicalMethod]) && !isset($requiredMethods[$requestMethod])) {
                            if ($hasRequiredScheme) {
                                $allow += $requiredMethods;
                            }
                            break;
                        }
                        if (!$hasRequiredScheme) {
                            $allowSchemes += $requiredSchemes;
                            break;
                        }

                        return $ret;
                }

                if (148 === $m) {
                    break;
                }
                $regex = substr_replace($regex, 'F', $m - $offset, 1 + strlen($m));
                $offset += strlen($m);
            }
        }
        if ('/' === $pathinfo && !$allow && !$allowSchemes) {
            throw new Symfony\Component\Routing\Exception\NoConfigurationException();
        }

        return null;
    }
}
