<?php 

class Model_Core_Pager
{
	public $totalRecords = 0;
	public $recordPerPage = 2;
	public $currentPage = 0;
	public $numberOfPages = 0;
	public $start = 1;
	public $previous = 0;
	public $next = 0;
	public $end = 0;
	public $startLimit = 0;

	public function __construct()
	{
		
	}

	public function calculate()
	{
        
        if (($this->numberOfPages = ceil($this->getTotalRecords() / $this->getRecordPerPage())) == 0) {
            $this->currentPage = 0;
        };
        if ($this->getNumberOfPages() == 1 || ($this->getNumberOfPages() > 1 && $this->getCurrentPage() <= 0)) {
            $this->currentPage = 1;
        }
        if ($this->getCurrentPage() > $this->getNumberOfPages()) {
            $this->currentPage = $this->getNumberOfPages();
        }

        if (!$this->getNumberOfPages()) {
            $this->start = 0;
        }
        if ($this->getCurrentPage() == 1) {
            $this->start = 0;
        }

        $this->end = $this->getNumberOfPages();
        if ($this->getCurrentPage() == $this->getNumberOfPages()) {
            $this->end = 0;
        }

        $this->previous = $this->getCurrentPage() - 1;
        if ($this->getCurrentPage() <= 1) {
            $this->previous = 0;    
        }
        
        $this->next = $this->getCurrentPage() + 1;
        if ($this->getCurrentPage() >= $this->getNumberOfPages()) {
            $this->next = 0;
        }

        if ($this->getCurrentPage() == 0) {
            $this->setCurrentPage(1);
        }
        $this->startLimit = ($this->getCurrentPage() - 1) * $this->getRecordPerPage(); 
	}

    public function getTotalRecords()
    {
        return $this->totalRecords;
    }

    public function setTotalRecords($totalRecords)
    {
        $this->totalRecords = $totalRecords;
        return $this;
    }

    public function getRecordPerPage()
    {
        return $this->recordPerPage;
    }

    public function setRecordPerPage($recordPerPage)
    {
        $this->recordPerPage = $recordPerPage;
        return $this;
    }

    public function getCurrentPage()
    {
        return $this->currentPage;
    }

    public function setCurrentPage($currentPage)
    {
        $this->currentPage = $currentPage;
        return $this;
    }

    public function getNumberOfPages()
    {
        return $this->numberOfPages;
    }

    public function setNumberOfPages($numberOfPages)
    {
        $this->numberOfPages = $numberOfPages;
        return $this;
    }

    public function getStart()
    {
        return $this->start;
    }

    public function setStart($start)
    {
        $this->start = $start;
        return $this;
    }

    public function getPrevious()
    {
        return $this->previous;
    }

    public function setPrevious($previous)
    {
        $this->previous = $previous;
        return $this;
    }

    public function getNext()
    {
        return $this->next;
    }

    public function setNext($next)
    {
        $this->next = $next;
        return $this;
    }

    public function getEnd()
    {
        return $this->end;
    }

    public function setEnd($end)
    {
        $this->end = $end;
        return $this;
    }

    public function getStartLimit()
    {
        return $this->startLimit;
    }

    public function setStartLimit($startLimit)
    {
        $this->startLimit = $startLimit;
        return $this;
    }
}