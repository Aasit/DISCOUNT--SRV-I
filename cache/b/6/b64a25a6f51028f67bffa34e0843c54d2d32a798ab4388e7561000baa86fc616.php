<?php

/* mySchemes.tmpl */
class __TwigTemplate_b64a25a6f51028f67bffa34e0843c54d2d32a798ab4388e7561000baa86fc616 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 1
        $this->parent = $this->loadTemplate("base.html", "mySchemes.tmpl", 1);
        $this->blocks = array(
            'title' => array($this, 'block_title'),
            'header' => array($this, 'block_header'),
            'content' => array($this, 'block_content'),
            'footer' => array($this, 'block_footer'),
            'scripts' => array($this, 'block_scripts'),
        );
    }

    protected function doGetParent(array $context)
    {
        return "base.html";
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 3
    public function block_title($context, array $blocks = array())
    {
        echo "Dashboard";
    }

    // line 5
    public function block_header($context, array $blocks = array())
    {
        echo " 
    ";
        // line 6
        $this->loadTemplate("header.tmpl", "mySchemes.tmpl", 6)->display($context);
        echo " 
";
    }

    // line 9
    public function block_content($context, array $blocks = array())
    {
        // line 10
        echo "<section>
\t";
        // line 11
        $this->loadTemplate("menu.tmpl", "mySchemes.tmpl", 11)->display($context);
        // line 12
        echo "\t<section id=\"content-wrapper\">  
\t\t\t\t<div class = \"dashboard-content\">
\t\t\t\t\t<div class = \"dashboard-container\">
\t\t\t\t\t\t<div class = \"row\">
\t\t\t\t\t\t\t<div class = \"col-lg-12 col-sm-12 col-xs-12\">
\t\t\t\t\t\t\t\t<div id = \"active-schemes\">
\t\t\t\t\t\t\t\t\t";
        // line 18
        $this->loadTemplate("activeSchemes.tmpl", "mySchemes.tmpl", 18)->display($context);
        // line 19
        echo "\t\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t<div class = \"col-lg-12 col-sm-12 col-xs-12\">
\t\t\t\t\t\t\t\t<div id = \"schemes-pending-approval\">
\t\t\t\t\t\t\t\t\t";
        // line 23
        $this->loadTemplate("schemesPendingApproval.tmpl", "mySchemes.tmpl", 23)->display($context);
        // line 24
        echo "\t\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t<div class = \"col-lg-12 col-sm-12 col-xs-12\">
\t\t\t\t\t\t\t\t<div id = \"draft-schemes\">
\t\t\t\t\t\t\t\t\t";
        // line 28
        $this->loadTemplate("draftSchemes.tmpl", "mySchemes.tmpl", 28)->display($context);
        // line 29
        echo "\t\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t<div class = \"col-lg-12 col-sm-12 col-xs-12\">
\t\t\t\t\t\t\t\t<div id = \"concluded-schemes\">
\t\t\t\t\t\t\t\t\t";
        // line 33
        $this->loadTemplate("concludedSchemes.tmpl", "mySchemes.tmpl", 33)->display($context);
        // line 34
        echo "\t\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t
\t\t\t\t\t\t</div>
\t\t\t\t\t</div>
\t\t\t\t</div>
\t\t\t</div>
\t    </div>
\t</section>
</section>
";
    }

    // line 46
    public function block_footer($context, array $blocks = array())
    {
    }

    // line 48
    public function block_scripts($context, array $blocks = array())
    {
        // line 49
        echo "    ";
        $this->displayParentBlock("scripts", $context, $blocks);
        echo "
\t<!-- n5 wrappers -->
\t<script type=\"text/javascript\" src=";
        // line 51
        echo call_user_func_array($this->env->getFunction('resolvePath')->getCallable(), array("native5.ui.card.js"));
        echo "></script>

\t<!-- akzo wrappers -->
    <script type=\"text/javascript\" src=";
        // line 54
        echo call_user_func_array($this->env->getFunction('resolvePath')->getCallable(), array("akzo_menu.js"));
        echo "></script> 
    <script type=\"text/javascript\" src=";
        // line 55
        echo call_user_func_array($this->env->getFunction('resolvePath')->getCallable(), array("my_schemes.js"));
        echo "></script> 
    
";
    }

    public function getTemplateName()
    {
        return "mySchemes.tmpl";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  129 => 55,  125 => 54,  119 => 51,  113 => 49,  110 => 48,  105 => 46,  91 => 34,  89 => 33,  83 => 29,  81 => 28,  75 => 24,  73 => 23,  67 => 19,  65 => 18,  57 => 12,  55 => 11,  52 => 10,  49 => 9,  43 => 6,  38 => 5,  32 => 3,  11 => 1,);
    }
}
