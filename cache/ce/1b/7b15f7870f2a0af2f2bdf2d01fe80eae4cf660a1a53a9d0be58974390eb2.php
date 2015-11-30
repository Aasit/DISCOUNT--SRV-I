<?php

/* mySchemes.tmpl */
class __TwigTemplate_ce1b7b15f7870f2a0af2f2bdf2d01fe80eae4cf660a1a53a9d0be58974390eb2 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 1
        try {
            $this->parent = $this->env->loadTemplate("base.html");
        } catch (Twig_Error_Loader $e) {
            $e->setTemplateFile($this->getTemplateName());
            $e->setTemplateLine(1);

            throw $e;
        }

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
        $this->env->loadTemplate("header.tmpl")->display($context);
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
        $this->env->loadTemplate("menu.tmpl")->display($context);
        // line 12
        echo "\t<section id=\"content-wrapper\">  
\t\t\t\t<div class = \"dashboard-content\">
\t\t\t\t\t<div class = \"dashboard-container\">
\t\t\t\t\t\t<div class = \"row\">
\t\t\t\t\t\t\t<div class = \"col-lg-12 col-sm-12 col-xs-12\">
\t\t\t\t\t\t\t\t<div id = \"active-schemes\">
\t\t\t\t\t\t\t\t\t";
        // line 18
        $this->env->loadTemplate("activeSchemes.tmpl")->display($context);
        // line 19
        echo "\t\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t<div class = \"col-lg-12 col-sm-12 col-xs-12\">
\t\t\t\t\t\t\t\t<div id = \"schemes-pending-approval\">
\t\t\t\t\t\t\t\t\t";
        // line 23
        $this->env->loadTemplate("schemesPendingApproval.tmpl")->display($context);
        // line 24
        echo "\t\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t<div class = \"col-lg-12 col-sm-12 col-xs-12\">
\t\t\t\t\t\t\t\t<div id = \"draft-schemes\">
\t\t\t\t\t\t\t\t\t";
        // line 28
        $this->env->loadTemplate("draftSchemes.tmpl")->display($context);
        // line 29
        echo "\t\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t<div class = \"col-lg-12 col-sm-12 col-xs-12\">
\t\t\t\t\t\t\t\t<div id = \"concluded-schemes\">
\t\t\t\t\t\t\t\t\t";
        // line 33
        $this->env->loadTemplate("concludedSchemes.tmpl")->display($context);
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
        return array (  137 => 55,  133 => 54,  127 => 51,  121 => 49,  118 => 48,  113 => 46,  99 => 34,  97 => 33,  91 => 29,  89 => 28,  83 => 24,  81 => 23,  75 => 19,  73 => 18,  65 => 12,  63 => 11,  60 => 10,  57 => 9,  51 => 6,  46 => 5,  40 => 3,  11 => 1,);
    }
}
