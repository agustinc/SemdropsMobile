<?php

/* SemdropsSemdropsMobileBundle:Semdrops:showproperties.html.twig */
class __TwigTemplate_7d1b5cce61db97dc8d4791e22789c3a1 extends Twig_Template
{
    protected $parent;

    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->blocks = array(
            'header' => array($this, 'block_header'),
            'content' => array($this, 'block_content'),
        );
    }

    public function getParent(array $context)
    {
        if (null === $this->parent) {
            $this->parent = $this->env->loadTemplate("SemdropsSemdropsMobileBundle::baseForIPhone.html.twig");
        }

        return $this->parent;
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $context = array_merge($this->env->getGlobals(), $context);

        $this->getParent($context)->display($context, array_merge($this->blocks, $blocks));
    }

    // line 2
    public function block_header($context, array $blocks = array())
    {
        echo "Show Properties";
    }

    // line 3
    public function block_content($context, array $blocks = array())
    {
        // line 4
        echo "\tProperties of the wiki <b>";
        echo twig_escape_filter($this->env, $this->getContext($context, 'link'), "html");
        echo "</b>:
\t<br><br>
\t ";
        // line 6
        $context['a'] = 0;
        // line 7
        echo "\t ";
        $context['b'] = 0;
        // line 8
        echo "     ";
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_ensure_traversable($this->getContext($context, 'result'));
        foreach ($context['_seq'] as $context['_key'] => $context['datos']) {
            // line 9
            echo "       ";
            if (($this->getContext($context, 'b') == 0)) {
                echo " 
           ";
                // line 10
                echo twig_escape_filter($this->env, $this->getAttribute($this->getContext($context, 'result'), $this->getContext($context, 'a'), array(), "array", false), "html");
                echo ":
           <a href=\"";
                // line 11
                echo twig_escape_filter($this->env, $this->getAttribute($this->getContext($context, 'result'), ($this->getContext($context, 'a') + 1), array(), "array", false), "html");
                echo "\"> ";
                echo twig_escape_filter($this->env, $this->getAttribute($this->getContext($context, 'result'), ($this->getContext($context, 'a') + 1), array(), "array", false), "html");
                echo "</a>   <br>
          ";
                // line 12
                $context['a'] = ($this->getContext($context, 'a') + 2);
                // line 13
                echo "          ";
                $context['b'] = 1;
                // line 14
                echo "       ";
            } else {
                // line 15
                echo "            ";
                $context['b'] = 0;
                // line 16
                echo "       ";
            }
            echo "   
      
       
  
    ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['datos'], $context['_parent'], $context['loop']);
        $context = array_merge($_parent, array_intersect_key($context, $_parent));
        // line 21
        echo "<br>
  No more properties to show.    
    
    
\t
\t<input type= \"button\" onclick= \"location.href='";
        // line 26
        echo twig_escape_filter($this->env, $this->env->getExtension('routing')->getPath("addPropertyTag"), "html");
        echo "'\" value=\"Add a PropertyTag\" name=\"addCategoryButton\" class= \"resetButtonStyle white button\"/><br>
\t<input type= \"button\" onclick= \"location.href='";
        // line 27
        echo twig_escape_filter($this->env, $this->env->getExtension('routing')->getPath("homepage"), "html");
        echo "'\" value=\"Go Back to Main\" name=\"gobackButton\" class= \"resetButtonStyle white button\" />

";
    }

    public function getTemplateName()
    {
        return "SemdropsSemdropsMobileBundle:Semdrops:showproperties.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }
}
