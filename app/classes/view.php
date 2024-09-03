<?php

	/*
	* View-specific wrapper.
	* Limits the accessible scope available to templates.
	*/
	include_once ROOT_PATH.'/vendor/autoload.php';
	//use Twig\Environment;
	//use Twig\Loader\FilesystemLoader;

	class View {

	    /*
	    * Template being rendered.
	    */
	    protected $template = "";
	    protected $loader;
	    /*
	    * Initialize a new view context.
	    */
	    public function __construct($template) {

	    	$this->loader = new \Twig\Loader\FilesystemLoader($_SERVER['DOCUMENT_ROOT'].'/templates');
			$this->loader->addPath($_SERVER['DOCUMENT_ROOT'].'/layouts/dynamic', 'dynamic');
		    $this->loader->addPath($_SERVER['DOCUMENT_ROOT'].'/layouts/sections', 'sections');
			$this->loader->addPath($_SERVER['DOCUMENT_ROOT'].'/layouts/static', 'static');
		    $this->loader->addPath($_SERVER['DOCUMENT_ROOT'].'/libs/js', 'js');
		    $this->loader->addPath($_SERVER['DOCUMENT_ROOT'].'/libs/js/particles', 'particles');
		    $this->loader->addPath($_SERVER['DOCUMENT_ROOT'].'/libs/css', 'css');
			$this->template = $template;

	    }

	    /*
	    * Safely escape/encode the provided data.
	    */
	    private function check() {
	    	$path = $this->template ? $_SERVER['DOCUMENT_ROOT'].'/templates/'.$this->template.'.twig' : $_SERVER['DOCUMENT_ROOT'].'/templates/main.twig';
	        if ( !file_exists( $path ) ) return false;
            else return true;
	    }

	    public function render(array $data = null, $slug = null) {

		    	if (!$this->check()) {
		    		header('HTTP/1.0 404 Not Found');
		  			echo 'Error 404 :-(<br>';
		  			echo 'The requested path "'.$this->template.'" was not found!';
		    	}
		    	else {
		    		$view = $this->template ? $this->template.'.twig' : 'main.twig';
					$twig = new \Twig\Environment($this->loader);
					$twig = new \Twig\Environment($this->loader, [
					    //'cache' => 'cache',
						'debug' => true
					]);

					$page_js = $this->template ? $this->template : 'main';
					if(file_exists('libs/js/pages/'.$page_js.'.js')){
						$page_js = '/libs/js/pages/'.$page_js.'.js';
						$twig->addGlobal('page_js', $page_js );
					}

					//$twig->addGlobal('root_path', $_SERVER['DOCUMENT_ROOT']);
					$twig->addGlobal('path', $this->template );
					$twig->addGlobal('session', $_SESSION);
					$twig->addGlobal('baselocale', BASELOCALE);
					$twig->addGlobal('home_url', HOME_URL);
					$twig->addGlobal('change_site_url', CHANGE_SITE_URL);
					$twig->addGlobal('product_slug', $slug);
					$twig->addExtension(new \Twig\Extension\DebugExtension());

					if ($data) echo $twig->render($view, $data);
					else echo $twig->render($view);//, ['page_title' => 'SIMPLICITY']);
					// echo $this->template;
		    	}
	    }

			public function html(array $data = null) {

		    	if (!$this->check()) {
		    		header('HTTP/1.0 404 Not Found');
		  			echo 'Error 404 :-(<br>';
		  			echo 'The requested path "'.$this->template.'" was not found!';
		    	}
		    	else {
		    		$view = $this->template ? $this->template.'.twig' : 'main.twig';
					$twig = new \Twig\Environment($this->loader);
					//$twig = new \Twig\Environment($this->loader, [
					//     'cache' => 'cache',
					//]);
					$twig->addGlobal('path', $this->template );
					$twig->addGlobal('session', $_SESSION);
					$twig->addGlobal('baselocale', BASELOCALE);

					if ($data) return $twig->render($view, $data);
					else return $twig->render($view);//, ['page_title' => 'SIMPLICITY']);
					// echo $this->template;
		    	}
	    }
	}

?>
