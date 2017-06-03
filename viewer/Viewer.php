<?php
  /**
   * Github/Bitbucket Wiki Smarty HTML Viewer
	 * 
	 * @version: 1.0.0
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
			//check if other file is called by url
			if (isset($_GET['f'])){
				$file = dirname($file) . '/' . $_GET['f'];
			}
      //check file exists
      if (!is_file($file)){
			  die('Error parsing file: ' . $file);
		  }
      
      //parse txt to html
     	//use github markdown to parse the txt file to html code
      $parser = new \cebe\markdown\GithubMarkdown();
      $txt_content = $this->load_txt($file);
  	  $html_content = $parser->parse($txt_content);
			echo 'Parsed txt content to html<br>';
      
      //get page name
      $this->current_page_name = $this->get_page_name($file);
      
      //set full html code
      $html = $this->set_html_header(); //set header
      $html .= $this->set_viewer_header();
      $html .= $this->set_viewer_content($txt_content, $html_content, $file); //set content
      $html .= $this->set_viewer_footer();
      $html_fot = $this->set_html_footer(); //set footer
      
			//set debug info
			$html .= $this->get_debug_info();
			
      return $html . $html_fot;
    }
		
		/**
     * Privated method to set the viewer header
     **/
    private function set_viewer_content($txt_content, $html_content, $filename){
			$html = '<div id="main">';
			$html .= $this->get_page_index($html_content);
			$html .= '<div id="mainHTML">' . $html_content . '</div>';
			$html .= '<div id="mainTXT"><pre>' . $txt_content . '</pre></div>';
			$html .= $this->get_all_wiki_pages($filename);
		
			echo 'Setted viewer content<br>';
			return $html . "</div>\n";
		}
    
    /**
     * Privated method to set the viewer header
     **/
    private function set_viewer_header(){
      $html = '<div id="header">'; 
      $html .= '<i id="see_allwikipages" title="See all wiki pages" class="fa fa-files-o fa-2x fa-border"></i>';
      $html .= '<i id="see_pageindex" title="See page index" class="fa fa-list-alt fa-2x fa-border"></i>';
			if ($this->debug)
	      $html .= '<i id="see_debuglog" title="See debug log" class="fa fa-stethoscope fa-2x fa-border"></i>';
      $html .= '<i id="swich_html2txt" title="Switch to txt mode" class="fa fa-file-code-o fa-2x fa-border"></i>';
      $html .= '</div>';
      
			echo 'Setted viewer header<br>';
      return $html . "\n";
    }
    
    /**
     * Privated method to set the viewer footer
     **/
    private function set_viewer_footer(){
      $html = '<div id="footer">' . $this->html_title . ' - ' . $this->current_page_name;
      $html .= ' &middot; Copyright ' . date('Y');
			
			echo 'Setted viewer footer<br>';
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
      $html .= '<script type="text/javascript" src="viewer/vendors/jquery/jquery-3.1.1.min.js"></script>' . 
				'<script type="text/javascript" src="viewer/js/viewer.js"></script>';
      
      //set css files
      $html .= '<link rel="stylesheet" type="text/css" href="viewer/css/viewer.css" />' .
				'<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">' . //font-awesome icons
				//'<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">' . //bootstrap icons
				//'<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">' . //google icons
				"\n";
      
			echo 'Setted html header<br>';
      return $html . "</head><body>\n";
    }
    
    /**
     * Privated method to set the html footer
     **/
    private function set_html_footer(){
      //set js scripts at end
      $html = '';
      
			echo 'Setted html footer<br>';
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
      
			echo 'Loaded txt content<br>';
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
      
			echo 'Getted page name<br>';
      return implode('.', $file_name);
    }
		
		/**
     * Privated method to get the list of the chaptsers in current page
     **/
    private function get_page_index($html_content){
			$html = '<div id="mainIndex">';
			$htags = $this->parse_htags_in_html_content($html_content);
			//echo serialize($htags); exit;
			if ($htags){
				$cnt = 1;
				foreach($htags as $htag){
					//var_dump($htag); exit;
					$html .= $cnt . '. ' . $htag['text'] . '<br>';
					$cnt2 = 1;
					foreach($htag['childs'] as $htag2){
						$html .= '&nbsp;&nbsp;' . $cnt . '.' . $cnt2 . '. ' . $htag2['text'] . '<br>';
						if (count($htag2['childs']) > 0){
							$cnt3 = 1;
							foreach($htag2['childs'] as $htag3){
								$html .= '&nbsp;&nbsp;&nbsp;&nbsp;' . $cnt . '.' . $cnt2 . '.' . $cnt3 . '. ' . $htag3['text'] . '<br>';
								$cnt3++;
							}
						}
						$cnt2++;
					}
					$cnt++;
				}
			} else {
				$html .= '<i>Error loading index</i>';
			}
			$html .= '</div>';
			
			echo 'Setted current page index<br>';
			return $html;
		}
		
		/**
     * Privated method to get parse the h1, h2, h3, h4 tags in the html content
     **/
    private function parse_htags_in_html_content($html_content, $search = '<h1'){
			$inipos = strpos($html_content, $search);
			if ($inipos !== false){
				$list = array();
				while($inipos !== false){
					//get tag text
					$inipos = $inipos + count($search);
					$html_content = substr($html_content, $inipos);
					$inipos = strpos($html_content, '>') + 1;
					$endpos = strpos($html_content, '</');
					$text = substr($html_content, $inipos, $endpos - $inipos);
					$html_content = substr($html_content, $endpos + 5);
					//var_dump($text); exit;
					$list[] = array('text' => $text,
						'childs' => array());
					$inipos = strpos($html_content, $search);
					$childendpos = $inipos !== false? $inipos: 99999;
					if ($search == '<h1'){
						$list[count($list) - 1]['childs'] = $this->parse_htags_in_html_content(substr($html_content, 0, $childendpos), '<h2');
					} else if ($search == '<h2'){
						$list[count($list) - 1]['childs'] = $this->parse_htags_in_html_content(substr($html_content, 0, $childendpos), '<h3');
					}
				}	
				return $list;
			}
			return false;
		}
		
		/**
     * Privated method to get the list of allt he wiki pages
     **/
    private function get_all_wiki_pages($filename){
			$dir = dirname($filename);
			echo 'All wiki pages list from dir: ' . $dir . '<br>';
			
			$html = '<div id="mainAllWikiPages">';
			if (is_dir($dir)){
				if ($gestor = opendir($dir)) {
					$flist = array();
					while (false !== ($entrada = readdir($gestor))) {
							if ($entrada == '.' || $entrada == '..' || $entrada == '.git') continue;
							$flist[] = $entrada;
					}
					closedir($gestor);
					//order list
					sort($flist);
					//print list
					foreach($flist as $f){
						$html .= '- <a href="index.php?f=' . $f . '" title="Link to ' . $f . '">' . $f . '</a><br>';
					}
				} else {
					$html .= '<i>Error loading info</i>';
				}
			}
			$html .= '</div>';
			
			echo 'Setted all wikis pages list<br>';
			return $html;
		}
		
		private function get_debug_info(){
			echo 'Getted debug info<br>';
			$debug_info = ob_get_flush();
			ob_end_clean();
			return '<div id="debug"><div id="debug_content">' .$debug_info . '</div></div>';
		}
  }