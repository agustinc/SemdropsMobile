<?php

	namespace Semdrops\SemdropsMobileBundle\Controller;
	
	use Symfony\Component\HttpFoundation\Response;
	use Symfony\Bundle\FrameworkBundle\Controller\Controller;
	use Semdrops\SemdropsMobileBundle\Entity\Link;
        use Semdrops\SemdropsMobileBundle\Entity\CategoryForm;
	
	require 'QueryPath/QueryPath.php';
	
	class SemdropsController extends Controller {
	    
		private $BASE= "http://requiem:8080/sesame/repositories/lalala/query?";
		
		public function getParsedResultsFromQuery($strQuery) {
			$encodedQuery= http_build_query($strQuery);
			$url= $this->BASE.$encodedQuery.'&limit=100&infer=true';
			$querypath= qp($url, 'results'); //kind of "from url, get tag 'results'"
			$results= array();
			foreach ($querypath->children('result')->children('binding') as $res) {
				//from the previous tag, get its child 'result', and its child 'binding'
				$results[]= $res->text(); //from 'binding', 'results's grandchild, get its text
			}
			return $results;
		}
		
		public function getFathersFromFather($father, $results, $indentation) {
			$father= trim($father);
			$strQuery= array('queryLn' => 'SPARQL',
							'query' => "select ?o
										where {
    										<".str_replace('father#', 'soon#', $father)."> <semdrops:Subcategory> ?o
										}");
			foreach ($this->getParsedResultsFromQuery($strQuery) as $gFather) {
				$results[]= $indentation.substr($gFather, 48);
				$results= $this->getFathersFromFather($gFather, $results, '---'.$indentation);
			}
			return $results;
		}
		
		public function getFathersFromCategory($category, $results) {
			$category= trim($category);
			$strQuery= array('queryLn' => "SPARQL",
							'query' => "select ?o
										where {
    										<".str_replace('category#', 'soon#', $category)."> <semdrops:Subcategory> ?o
										}");
			foreach ($this->getParsedResultsFromQuery($strQuery) as $father) {
				$results[]= '---- '.substr($father, 48);
				$results= $this->getFathersFromFather($father, $results, '-------- ');
			}
			return $results;
		}

		public function getCategoriesAndFathersFromUri($uri) {
			$strQuery= array('queryLn' => "SPARQL",
							'query' => "select ?o 
										where {
    											<".$uri."> <rdf:Type> ?o
										}");
			$results= array();
			foreach ($this->getParsedResultsFromQuery($strQuery) as $category) {
				$results[]= '- '.substr($category, 50);
				$results= $this->getFathersFromCategory($category, $results);
			}
			return $results;
		}
		
	    	public function indexAction() {
			return $this->render('SemdropsSemdropsMobileBundle:Semdrops:index.html.twig');
	   	}
	    
	    	public function getCategoriesAction() {
			$link= new Link();
			$form= $this->get('form.factory')->createBuilder('form', $link)
						->add('uri', 'url')
						->getForm();
			return $this->render('SemdropsSemdropsMobileBundle:Semdrops:gettags.html.twig', array('form' => $form->createView()));
		}
	    		
		public function showCategoriesAction() {
			$request= $this->get('request');
			if ($request->getMethod() == 'POST') {
				$filledLink= new Link();
				$form= $this->get('form.factory')->createBuilder('form', $filledLink)
							->add('uri', 'url')
							->getForm();		
				$form->bindRequest($request); //xml to form and, somehow, to filledLink.
				if ($form->isValid()) {
					$uris_categories= array();
					$uris_categories= $this->getCategoriesAndFathersFromUri($filledLink->getURI()); //[an, array, of, strings]
					$filledLink->setCategories($uris_categories);
					return $this->render('SemdropsSemdropsMobileBundle:Semdrops:showtags.html.twig',
										array('filledLink' => $filledLink));
				}
			}
			return $this->render('SemdropsSemdropsMobileBundle:Semdrops:showtags_error.html.twig');
		}

		
                    //Para poder setear una Uri y guardar su categoria en la base de datos
                public function addCategoryAction()
                {
   		       	 $category = new CategoryForm();
  			 $form = $this->get('form.factory') -> createBuilder('form',$category)
					->add('uri','url')
					->add('category','text')
                        	        ->add('father', 'text')
					->getForm();
			return $this-> render('SemdropsSemdropsMobileBundle:Semdrops:addCategory.html.twig', array('form'=>$form->createView()));
 		}

		public function addCategoryphpAction()
	        {
   			$request= $this->get('request');
   			$aCategory = new CategoryForm();
   			$form = $this->get('form.factory') -> createBuilder('form',$aCategory)
					->add('uri','url')
 					->add('category','text')
					->getForm();
    			$form->bindRequest($request);
    			$uri = $aCategory ->getUri();
    			$category= $aCategory->getCategory();
    			$datos='<'.$uri.'> <rdf:Type> <http://semdrops.lifia.edu.ar/ns/category#'.$category.'>.';
   			$url='http://requiem:8080/openrdf-sesame/repositories/lalala/statements';
    			$estado= $this -> writeInSesameDataBase($url,$datos);
  			if ($estado == TRUE)
	          { return $this-> render('SemdropsSemdropsMobileBundle:Semdrops:mostrarcategory.html.twig', array('form'=>$aCategory));}
            else
              { return $this-> render('SemdropsSemdropsMobileBundle:Semdrops:falla.html.twig', array('form'=>$aCategory));}  
  		}
 		function writeInSesameDataBase($url,$datos)
	        {
  			$request_body =$datos;
  			$ch = curl_init($url);
        		curl_setopt($ch, CURLOPT_POSTFIELDS, $request_body);
        		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);//True
        		curl_setopt($ch, CURLOPT_HEADER, 0);//false
       			curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type: text/plain', 'charset=UTF-8'));
      		  	curl_setopt($ch, CURLOPT_POST, TRUE); 
      		  	//curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//true
     			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        		$response = curl_exec($ch);
        		curl_close($ch);
       			return $response;
 		}

		
		
	}
?>
