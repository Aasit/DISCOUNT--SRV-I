<?php

/* base.html */
class __TwigTemplate_7d877d5b15614eed94b15287757d666d126f5340b09fda12481411c76757a815 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
            'head' => array($this, 'block_head'),
            'title' => array($this, 'block_title'),
            'header' => array($this, 'block_header'),
            'content' => array($this, 'block_content'),
            'footer' => array($this, 'block_footer'),
            'scripts' => array($this, 'block_scripts'),
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        echo "<!DOCTYPE HTML>

<!--[if IE 9]><html class=\"no-js lt-ie10\"> <![endif]-->
<!--[if gt IE 8]><!--> <html class=\"no-js\"> <!--<![endif]-->
<html>
    <head>
    ";
        // line 7
        $this->displayBlock('head', $context, $blocks);
        // line 17
        echo "    </head>

    <body itemscope itemtype=\"http://schema.org/WebPage\">
        <!-- Dashboard Header -->
        ";
        // line 21
        $this->displayBlock('header', $context, $blocks);
        // line 24
        echo "        <!-- Dashboard Header -->
        <!-- Dashboard Body -->           
            <div class = \"body-div\">
            ";
        // line 27
        $this->displayBlock('content', $context, $blocks);
        // line 30
        echo "            </div>
        <!-- Dashboard Body -->

        <!-- Dashboard Footer -->
        ";
        // line 34
        $this->displayBlock('footer', $context, $blocks);
        // line 37
        echo "        
        <!-- Dashboard Footer -->


        ";
        // line 41
        $this->displayBlock('scripts', $context, $blocks);
        // line 50
        echo "        
    </body>
</html>
";
    }

    // line 7
    public function block_head($context, array $blocks = array())
    {
        // line 8
        echo "        <meta charset=\"utf-8\">
        <title>Akzo | Discounts and Incentives | ";
        // line 9
        $this->displayBlock('title', $context, $blocks);
        echo "</title>
        <meta name=\"viewport\" content=\"width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0\">
        <link rel=\"icon\" href=\"./favicon.ico\" type=\"image/x-icon\" />
        <link rel=\"stylesheet\" href=";
        // line 12
        echo call_user_func_array($this->env->getFunction('resolvePath')->getCallable(), array("main.css"));
        echo ">
        <link href='http://fonts.googleapis.com/css?family=Lato:300,400' rel='stylesheet' type='text/css'>

        <script type=\"text/javascript\" src=";
        // line 15
        echo call_user_func_array($this->env->getFunction('resolvePath')->getCallable(), array("modernizr.custom.77812.js"));
        echo "></script>
    ";
    }

    // line 9
    public function block_title($context, array $blocks = array())
    {
    }

    // line 21
    public function block_header($context, array $blocks = array())
    {
        // line 22
        echo "            
        ";
    }

    // line 27
    public function block_content($context, array $blocks = array())
    {
        // line 28
        echo "
            ";
    }

    // line 34
    public function block_footer($context, array $blocks = array())
    {
        // line 35
        echo "            
        ";
    }

    // line 41
    public function block_scripts($context, array $blocks = array())
    {
        // line 42
        echo "            <script type=\"text/javascript\" src=";
        echo call_user_func_array($this->env->getFunction('resolvePath')->getCallable(), array("jquery-2.1.0.min.js"));
        echo "></script>
            <script type=\"text/javascript\" src=";
        // line 43
        echo call_user_func_array($this->env->getFunction('resolvePath')->getCallable(), array("native5.core.js"));
        echo "></script>
            <script type=\"text/javascript\" src=";
        // line 44
        echo call_user_func_array($this->env->getFunction('resolvePath')->getCallable(), array("native5.core.analytics.js"));
        echo "></script>
            <script type=\"text/javascript\" src=";
        // line 45
        echo call_user_func_array($this->env->getFunction('resolvePath')->getCallable(), array("invokeService.js"));
        echo "></script>
            <script type=\"text/javascript\" src=";
        // line 46
        echo call_user_func_array($this->env->getFunction('resolvePath')->getCallable(), array("form.js"));
        echo "></script>
            <script type=\"text/javascript\" src=";
        // line 47
        echo call_user_func_array($this->env->getFunction('resolvePath')->getCallable(), array("native5.ui.dropdown.js"));
        echo "></script>
            <script type=\"text/javascript\" src=";
        // line 48
        echo call_user_func_array($this->env->getFunction('resolvePath')->getCallable(), array("app.js"));
        echo "></script>
        ";
    }

    public function getTemplateName()
    {
        return "base.html";
    }

    public function getDebugInfo()
    {
        return array (  154 => 48,  150 => 47,  146 => 46,  142 => 45,  138 => 44,  134 => 43,  129 => 42,  126 => 41,  121 => 35,  118 => 34,  113 => 28,  110 => 27,  105 => 22,  102 => 21,  97 => 9,  91 => 15,  85 => 12,  79 => 9,  76 => 8,  73 => 7,  66 => 50,  64 => 41,  58 => 37,  56 => 34,  50 => 30,  48 => 27,  43 => 24,  41 => 21,  35 => 17,  33 => 7,  25 => 1,);
    }
}
