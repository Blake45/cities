<?php
/**
 * Created by PhpStorm.
 * User: Thibaut
 * Date: 10/10/2017
 * Time: 15:01
 */

namespace CitiesBundle\Services;


class Pagination
{

    private $page;
    private $nbPages;
    private $route;
    private $paramsRoute;
    private $query;

    public function build($page, $nbPages, $route, $paramsRoute, $query)
    {
        $this->page = $page;
        $this->nbPages = $nbPages;
        $this->route = $route;
        $this->paramsRoute = $paramsRoute;
        $this->query = $query;

        return $this;
    }

    private function getQueryString($aQuery)
    {
        $query = "";
        foreach($aQuery as $param => $value) {
            if ($value === reset($aQuery)) {
                $query .= "?";
            }
            $query .= $param."=".$value;
            if ($value !== end($aQuery)) {
                $query .= "&";
            }
        }
        return $query;
    }

    public function getPagination()
    {
        return array(
            'page' => $this->page,
            'nbPages' => $this->nbPages,
            'route' => $this->route,
            'paramsRoute' => $this->paramsRoute,
            'query' => $this->getQueryString($this->query)
        );
    }
}