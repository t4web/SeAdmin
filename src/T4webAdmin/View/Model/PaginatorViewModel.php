<?php

namespace T4webAdmin\View\Model;

use Zend\Paginator\Paginator;
use Zend\Paginator\Adapter\NullFill;
use T4webFilter\Filter;
use T4webDomainInterface\Infrastructure\RepositoryInterface;

class PaginatorViewModel extends BaseViewModel
{
    /**
     * @var Filter
     */
    private $filter;

    /**
     * @var RepositoryInterface
     */
    private $finder;

    /**
     * @var Paginator
     */
    private $paginator;

    /**
     * @var string
     */
    private $queryString;

    /**
     * ListFilterViewModel constructor.
     * @param Filter $filter
     */
    public function __construct(Filter $filter, RepositoryInterface $finder)
    {
        $this->filter = $filter;
        $this->finder = $finder;
    }

    /**
     * @return void
     */
    public function initialize()
    {
        $filterValues = $this->filter->prepare();
        $criteria = $this->finder->createCriteria($filterValues);
        $countAll = $this->finder->count($criteria);

        $this->queryString = http_build_query($filterValues);

        $this->paginator = new Paginator(new NullFill($countAll));
        $this->paginator->setCurrentPageNumber(1);
        $this->paginator->setDefaultItemCountPerPage(20);
        $this->paginator->setPageRange(5);
    }

    /**
     * @return bool
     */
    public function isPrevBtnActive()
    {
        return $this->paginator->getPages()->first != $this->paginator->getPages()->current;
    }

    /**
     * @return bool
     */
    public function isNextBtnActive()
    {
        return $this->paginator->getPages()->last != $this->paginator->getPages()->current;
    }

    /**
     * @return array
     */
    public function getPagesInRange()
    {
        return $this->paginator->getPages()->pagesInRange;
    }

    /**
     * @param $page int
     * @return bool
     */
    public function isCurrentPage($page)
    {
        return $this->paginator->getPages()->current == $page;
    }

    /**
     * @param $page int
     * @return string
     */
    public function getUrlForPage($page)
    {
        if ($this->isCurrentPage($page)) {
            return '#';
        }

        return '?' . $this->queryString . '&page=' . $page;
    }

    /**
     * @return bool
     */
    public function canRenderLastPageBtn()
    {
        return $this->paginator->getPages()->last > $this->paginator->getPages()->lastPageInRange;
    }

    /**
     * @return int
     */
    public function getLastPage()
    {
        return $this->paginator->getPages()->last;
    }

    /**
     * @return int
     */
    public function getNextPage()
    {
        return $this->paginator->getPages()->current + 1;
    }

    /**
     * @return int
     */
    public function getPrevPage()
    {
        return $this->paginator->getPages()->current - 1;
    }
}