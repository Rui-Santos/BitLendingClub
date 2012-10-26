<?php

require_once('dompdf/dompdf_config.inc.php');

class App_Dompdf {
    
    /**
     *
     * @var type 
     */
    protected $_dompdf = null;
    /**
     *
     * @var type 
     */
    protected $_options = array();
    
    
    public function __construct(array $options = array())
    {
        $this->_options = $options;
        $this->_dompdf = new DOMPDF();
        
    }
    
    
    public function convert()
    {
        $this->_dompdf->load_html_file($this->_options['url']);
        $this->_dompdf->render();
        $this->_dompdf->stream($this->_options['outputFilename']);
        
    }
    
    
}