<?php

	require __DIR__ .'/../../vendor/autoload.php';

  class TemplateEditor {

    private $conn;
		//private $table_name;

    public function __construct($db)//, $table_name)
    {
        $this->conn = $db;
        //$this->table_name = $table_name;
    }

		private function getPartials($twigTemplateName){

      $loader = new \Twig\Loader\FilesystemLoader($_SERVER['DOCUMENT_ROOT'].'/templates');
      $loader->addPath($_SERVER['DOCUMENT_ROOT'].'/layouts/dynamic', 'dynamic');
      $loader->addPath($_SERVER['DOCUMENT_ROOT'].'/layouts/sections', 'sections');
      $loader->addPath($_SERVER['DOCUMENT_ROOT'].'/layouts/static', 'static');
      $loader->addPath($_SERVER['DOCUMENT_ROOT'].'/libs/js', 'js');
      $loader->addPath($_SERVER['DOCUMENT_ROOT'].'/libs/js/particles', 'particles');
      $loader->addPath($_SERVER['DOCUMENT_ROOT'].'/libs/css', 'css');

      $twig = new \Twig\Environment($loader);

      $source = $twig->getLoader()->getSourceContext($twigTemplateName.'.twig');

      $tokens = $twig->tokenize($source);
      //return $source;

      $parsed = $twig->parse($tokens);
      $collected = $this->collectIncludes($parsed);

      //return $parsed;
      return $collected;

    }

		public function getStaticPartials($twigTemplateName){
      $collected = $this->getPartials($twigTemplateName);
      $result = [];
      foreach ($collected as $c) {
        if (preg_match('/@static\/(.*?).twig/', $c, $match) == 1) {
          array_push($result, $match[1]);
        }
      }
      return $result;
    }

    public function getDynamicPartials($twigTemplateName){
      $collected = $this->getPartials($twigTemplateName);
      $result = [];
      foreach ($collected as $c) {
        if (preg_match('/@dynamic\/(.*?).twig/', $c, $match) == 1) {
            array_push($result, $match[1]);
        }
      }
      return $result;
    }

    public function getSectionsPartials($twigTemplateName){
      $collected = $this->getPartials($twigTemplateName);
      $result = [];
      // echo "<pre>";
      // var_dump($collected);
      // echo "</pre>";
      foreach ($collected as $c) {
        if (preg_match('/@sections\/(.*?).twig/', $c, $match) == 1) {
            array_push($result, $match[1]);
        }
      }
      return $result;
    }

    public function getDefaultHead($twigHeaderName)
    {
      $loader = new \Twig\Loader\FilesystemLoader($_SERVER['DOCUMENT_ROOT'].'/layouts');

        $twig = new \Twig\Environment($loader);
        $source = $twig->getLoader()->getSourceContext($twigHeaderName.'.twig');
        $tokens = $twig->tokenize($source);
        $parsed = $twig->parse($tokens);
        $collected = [];
        $this->collectNodes($parsed, $collected);

        return array_keys($collected);
    }

    public function getDefaultBody($twigTemplateName)
    {
      $loader = new \Twig\Loader\FilesystemLoader($_SERVER['DOCUMENT_ROOT'].'/templates');
			$loader->addPath($_SERVER['DOCUMENT_ROOT'].'/layouts/dynamic', 'dynamic');
			$loader->addPath($_SERVER['DOCUMENT_ROOT'].'/layouts/global', 'global');
			$loader->addPath($_SERVER['DOCUMENT_ROOT'].'/layouts/sections', 'sections');
			$loader->addPath($_SERVER['DOCUMENT_ROOT'].'/layouts/static', 'static');
			$loader->addPath($_SERVER['DOCUMENT_ROOT'].'/libs/js', 'js');
			$loader->addPath($_SERVER['DOCUMENT_ROOT'].'/libs/js/particles', 'particles');
			$loader->addPath($_SERVER['DOCUMENT_ROOT'].'/libs/css', 'css');

      $twig = new \Twig\Environment($loader);
      $source = $twig->getLoader()->getSourceContext($twigTemplateName.'.twig');
      $tokens = $twig->tokenize($source);
      $parsed = $twig->parse($tokens);
      $collected = [];
      $this->collectNodes($parsed, $collected);

      return array_keys($collected);
    }
    
    public function getSectionBody($twigTemplateName){
			$loader = new \Twig\Loader\FilesystemLoader($_SERVER['DOCUMENT_ROOT'].'/layouts/sections');

			$twig = new \Twig\Environment($loader);
			$source = $twig->getLoader()->getSourceContext($twigTemplateName.'.twig');
			$tokens = $twig->tokenize($source);
			$parsed = $twig->parse($tokens);
			$collected = [];
			$this->collectNodes($parsed, $collected);

			return array_keys($collected);
		}

    public function getDefaultFooter(){
      $loader = new \Twig\Loader\FilesystemLoader($_SERVER['DOCUMENT_ROOT'].'/layouts');

      $twig = new \Twig\Environment($loader);
      $source = $twig->getLoader()->getSourceContext('footer.twig');
      $tokens = $twig->tokenize($source);
      $parsed = $twig->parse($tokens);
      $collected = [];
      $this->collectNodes($parsed, $collected);

      return array_keys($collected);
    }

    private function collectNodes($nodes, array &$collected) {
      foreach ($nodes as $node) {
        $childNodes = $node->getIterator()->getArrayCopy();
        if (!empty($childNodes)) {
          $this->collectNodes($childNodes, $collected); // recursion
        } elseif ($node instanceof \Twig_Node_Expression_Name) {
          $name = $node->getAttribute('name');
          $collected[$name] = $node; // ensure unique values
        }
      }
    }

		private function collectIncludes($nodes): array {
      $variables = [];
      foreach ($nodes as $node) {
        if ($node instanceof \Twig_Node && $nodes instanceof \Twig_Node_Expression_Function) {
          $value = $node->getNode(0)->getAttribute('value');
          if (!empty($value) && is_string($value)) {
            $variables[$value] = $value;
            //array_push($variables, $value);
          }
          //var_dump($node->getNode(0));
        } elseif ($node instanceof \Twig_Node) {
          $variables += $this->collectIncludes($node);
        }
      }
      return $variables;
    }

		public function getStaticBlockBody($twigTemplateName) {
      $loader = new \Twig\Loader\FilesystemLoader($_SERVER['DOCUMENT_ROOT'].'/layouts/static');

      $twig = new \Twig\Environment($loader);
      $source = $twig->getLoader()->getSourceContext($twigTemplateName.'.twig');
      $tokens = $twig->tokenize($source);
      $parsed = $twig->parse($tokens);
      $collected = [];
      $this->collectNodes($parsed, $collected);

      return array_keys($collected);
    }

		public function getDynamicBlock($twigTemplateName) {
      $loader = new \Twig\Loader\FilesystemLoader($_SERVER['DOCUMENT_ROOT'].'/layouts/dynamic');

      $twig = new \Twig\Environment($loader);
      $source = $twig->getLoader()->getSourceContext($twigTemplateName.'.twig');
      $tokens = $twig->tokenize($source);
      $parsed = $twig->parse($tokens);
      $collected = [];
      $this->collectNodes($parsed, $collected);

      return array_keys($collected);
    }

    public function getGlobalBlock($twigTemplateName) {
      $loader = new \Twig\Loader\FilesystemLoader($_SERVER['DOCUMENT_ROOT'].'/layouts/global');
  
      $twig = new \Twig\Environment($loader);
      $source = $twig->getLoader()->getSourceContext($twigTemplateName.'.twig');
      $tokens = $twig->tokenize($source);
      $parsed = $twig->parse($tokens);
      $collected = [];
      $this->collectNodes($parsed, $collected);

      return array_keys($collected);
    }

  }
?>