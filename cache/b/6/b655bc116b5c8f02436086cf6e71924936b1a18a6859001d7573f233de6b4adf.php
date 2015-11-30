<?php

/* header.tmpl */
class __TwigTemplate_b655bc116b5c8f02436086cf6e71924936b1a18a6859001d7573f233de6b4adf extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        echo "<header>
    <div class=\"header-main-block header-main-block-shrink\">
        <span class = \"menu-toggle-container\">
            <i class=\"fa fa-bars menu-toggle trigger\" id = \"trigger\"></i>            
        </span>
        <div class=\"header-inner-block\">
            <h1>Akzo | Discounts</h1>
            
        </div>
        <nav class = \"header-navbar\">
            <div class = \"header-right-button \" id = \"header-settings\">
                <i class=\"fa fa-wrench header-right-button-icon\"></i>
                <span class = \"header-right-button-text\">
                    Settings
                </span> 
            </div>
            <div class = \"header-right-button \" id = \"header-notifications\">
                <i class=\"fa fa-bell-o header-right-button-icon\"></i>
                <span class = \"header-right-button-text\">
                    Notifications
                </span> 
            </div>
            <div class = \"header-right-button\" id = \"header-profile\">
                <i class=\"fa fa-user header-right-button-icon\"></i>
                <span class = \"header-right-button-text\">
                    Profile
                </span> 
            </div>
        </nav>
    </div>
           
</header>
";
    }

    public function getTemplateName()
    {
        return "header.tmpl";
    }

    public function getDebugInfo()
    {
        return array (  19 => 1,);
    }
}
