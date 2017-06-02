<?php
  /**
   * Github/Bitbucket Wiki Smarty HTML Viewer
   **/
  class Viewer {
    
    //initilize properties
    private $debug = false;
    private $html_title = 'WuiWui Wiki';
    private $current_page_name = 'Home';
    
    //class constructor
    public function __construct($debug = false){
      //set debug mode
      if (defined('DEBUG')){
        $this->debug = DEBUG;
      } else {
        $this->debug = $debug;
      }
      if ($this->debug){
        echo 'Loading Viewer...<br>';
      }
    }
    
    /**
     *  Public method to parse the file and return the html code to print
     **/
    public function parse_file($file){
      //check file exists
      if (!is_file($file)){
			  die('Error parsing file: ' . $file);
		  }
      
      //parse txt to html
     	//use github markdown to parse the txt file to html code
      $parser = new \cebe\markdown\GithubMarkdown();
      $txt_content = $this->load_txt($file);
  	  $html_content = $parser->parse($txt_content);
      
      //get page name
      $this->current_page_name = $this->get_page_name($file);
      
      //set full html code
      $html = $this->set_html_header(); //set header
      $html .= $this->set_viewer_header();
      $html .= $html_content; //set content
      $html .= $this->set_viewer_footer();
      $html .= $this->set_html_footer(); //set footer
      
      return $html;
    }
    
    /**
     * Privated method to set the viewer header
     **/
    private function set_viewer_header(){
      $html = '<div id="header">'; 
      $html .= '<a id="see_allwikipages" title="See all wiki pages">SeeAllWikiPages</a>';
      $html .= '<a id="see_pageindex" title="See page index">SeePageIndex</a>';
      $html .= '<a id="see_debuglog" title="See debug log">SeeDebugLog</a>';
      $html .= '<a id="swich_html2txt" title="Switch to txt mode">SwitchHTML2txt</a>';
      $html .= '</div>';
      
      return $html . "\n" . '<div id="main">';
    }
    
    /**
     * Privated method to set the viewer footer
     **/
    private function set_viewer_footer(){
      $html = '</div>' . "\n";
      $html .= '<div id="footer">' . $this->html_title . ' - ' . $this->current_page_name;
      $html .= ' &middot; Copyright 2017';
      return $html . '</div>';
    }
    
    /**
     * Privated method to set the html header
     **/
    private function set_html_header(){
      //set start html tags, metas and title
      $html = '<!DOCTYPE html><html lang="en"><head>' . "\n" . 
            '<meta charset="utf-8"><meta name="viewport" content="width=device-width">' . "\n" .
            '<title>' . $this->html_title . ' - ' . $this->current_page_name . '</title>' . "\n";
      
      //set js files
      $html .= '';
      
      //set css files
      $html .= '<link rel="stylesheet" type="text/css" href="viewer/css/viewer.css" />' . "\n";
      
      return $html . "</head><body>\n";
    }
    
    /**
     * Privated method to set the html footer
     **/
    private function set_html_footer(){
      //set js scripts at end
      $html = '';
      
      return "\n</body></html>";
    }
    
    /**
     * Privated method to load the txt content from de given file
     **/
    private function load_txt($file){
      //check file exists
      if (!is_file($file)){
			  die('Error reading file: ' . $file);
		  }
      
		  return file_get_contents($file);
    }
    
    /**
     * Privated method to get the page name of the file that is going to be printed
     **/
    private function get_page_name($filename){
      //check filename is not empty
      if (empty($filename)){
			  die('Error geting file name, empty value: ' . $filename);
		  }
      
      //get the last string value after the "/"
      $file_name = explode('/', $filename);
      $file_name = $file_name[count($file_name) - 1];
      
      //take out the last .**
      $file_name = explode('.', $file_name);
      unset($file_name[count($file_name) - 1]);
      
      return implode('.', $file_name);
    }
  }