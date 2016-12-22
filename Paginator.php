<?php

/**
 * Created by The-Di-Lab
 * Email: thedilab@gmail.com
 * Website: www.the-di-lab.com
 * Version: 1.0
 */

/**
 * Modified and Painstakingly Corrected by
 * User: Angela Adams
 * Date: 12/22/2016
 */

class Paginator {
    public $itemsPerPage;
    public $range;
    public $currentPage;
    public $total;
    public $textNav;
    private $_navigation;
    private $_link;
    private $_pageNumHtml;
    private $_itemHtml;
    /**
     * Constructor
     */
    public function __construct()
    {
        //set default values
        $this->itemsPerPage = 2;
        $this->range        = 2;
        $this->currentPage  = 1;
        $this->total		= 0;
        $this->textNav 		= true;
        $this->itemSelect   = array(5,25,50,100,'All');
        //private values
        $this->_navigation  = array(
            'next'=>'&raquo;',
            'pre' =>'&laquo;',
            'ipp' =>'Item per page'
        );
        $this->_link 		 = filter_var($_SERVER['PHP_SELF'], FILTER_SANITIZE_STRING);
        $this->_pageNumHtml  = '';
        $this->_itemHtml 	 = '';
    }

    /**
     * paginate main function
     *
     * @author              The-Di-Lab <thedilab@gmail.com>
     * @access              public
     * @return              type
     */
    public function paginate()
    {
        //get current page
        if(isset($_GET['current'])){
            $this->currentPage  = $_GET['current'];
        }
        //get item per page
        if(isset($_GET['item'])){
            $this->itemsPerPage = $_GET['item'];
        }
        //get page numbers
        $this->_pageNumHtml = $this->_getPageNumbers();
        //get item per page select box
        $this->_itemHtml	= $this->_getItemSelect();
    }

    /**
     * return pagination numbers in a format of UL list
     *
     * @author              The-Di-Lab <thedilab@gmail.com>
     * @access              public
     * @param               type $parameter
     * @return              string
     */
    public function pageNumbers()
    {
        if(empty($this->_pageNumHtml)){
            exit('Please call function paginate() first.');
        }
        return $this->_pageNumHtml;
    }

    /**
     * return jump menu in a format of select box
     *
     * @author              The-Di-Lab <thedilab@gmail.com>
     * @access              public
     * @return              string
     */
    public function itemsPerPage()
    {
        if(empty($this->_itemHtml)){
            exit('Please call function paginate() first.');
        }
        return $this->_itemHtml;
    }

    /**
     * return page numbers html formats
     *
     * @author              The-Di-Lab <thedilab@gmail.com>
     * @access              public
     * @return              string
     */
    private function  _getPageNumbers()
    {
        $html  = '<div class="row">
                    <div class="col-md-4 col-md-offset-4">
                        <nav aria-label="Page navigation">
                            <ul class="pagination">';
        //previous link button
        if($this->textNav&&($this->currentPage>1)){
            $html .=  '<li><a href="'.$this->_link .'?current='.($this->currentPage-1).'"';
            $html .=  ' aria-label="Previous">'.$this->_navigation['pre'].'</a></li>';
        }
        //do ranged pagination only in the middle
        $max_pages = $this->total / $this->itemsPerPage;
        if ($max_pages <= 1) { // Only 1 page of results
            $start = 1;
            $end = 1;
        } else if ($this->currentPage < $max_pages) {
            $start = ($this->currentPage <= $this->range)?1:($this->currentPage - $this->range);
            $end   = ($max_pages - $this->currentPage >= $this->range)?($this->currentPage+$this->range): $max_pages;
        } else { // Final page
            $start   = ($this->currentPage - $this->range);
            if ($start <= 0) $start = 1;
            $end     = $max_pages;
        }

        //loop through page numbers
        for($i = $start; $i <= $end; $i++){
            $html .=  '<li><a href="'.$this->_link .'?current='.$i.'"';
            if($i==$this->currentPage) {
                $html .= "class='current' style='color:black;'";
                $html .= '>' . $i . '</a></li>';
            } else {
                $html .= '>' . $i . '</a></li>';
            }
        }
        //next link button
        if($this->textNav&&($this->currentPage< $max_pages)){
            $html .=  '<li><a href="'.$this->_link .'?current='.($this->currentPage+1).'"';
            $html .=  ' aria-label="Next">'.$this->_navigation['next'].'</a></li>';
        }
        $html .= '</ul>
                </nav>
              </div>
            </div>';
        echo $html;
        return $html;
    }

    /**
     * return item select box
     *
     * @author              The-Di-Lab <thedilab@gmail.com>
     * @access              public
     * @return              string
     */
    private function  _getItemSelect()
    {
        $items = '';
        $ippArray = $this->itemSelect;
        foreach($ippArray as $ippOpt){
            $items .= ($ippOpt == $this->itemsPerPage) ? "<option selected value=\"$ippOpt\">$ippOpt</option>\n":"<option value=\"$ippOpt\">$ippOpt</option>\n";
        }
        return "<span class=\"paginate\">".$this->_navigation['ipp']."</span>
	    	<select class=\"paginate\" onchange=\"window.location='$this->_link?current=1&item='+this[this.selectedIndex].value;return false\">$items</select>\n";
    }
}