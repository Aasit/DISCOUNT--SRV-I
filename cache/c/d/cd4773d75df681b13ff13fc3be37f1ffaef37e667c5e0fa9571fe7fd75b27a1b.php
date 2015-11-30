<?php

/* menu.tmpl */
class __TwigTemplate_cd4773d75df681b13ff13fc3be37f1ffaef37e667c5e0fa9571fe7fd75b27a1b extends Twig_Template
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
        echo "<aside id=\"responsive-admin-menu\">
\t<div id=\"menu\">
\t\t\t<a href=";
        // line 3
        echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('nonce')->getCallable(), array("./dashboard")), "html", null, true);
        echo " title=\"Dashboard\"><i class=\"fa fa-tachometer\"></i><span> 
\t\t\tDashboard</span></a>
\t\t\t<a href=";
        // line 5
        echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('nonce')->getCallable(), array("./template")), "html", null, true);
        echo " title=\"Create Scheme\"><i class=\"fa fa-bullhorn\"></i><span> Create Scheme</span></a>
\t\t\t<a href=";
        // line 6
        echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('nonce')->getCallable(), array("./schemes")), "html", null, true);
        echo " title=\"Schemes\"><i class=\"fa fa-anchor\"></i><span> Schemes</span></a>
\t\t\t<a href=\"\" title=\"My Schemes\" class=\"submenu\" name=\"schemes-sub\"><i class=\"fa fa-eye\"></i><span>  
\t\t\tMy Schemes</span></a>
\t\t\t<!-- Media Sub Menu -->
\t\t\t\t<div id=\"schemes-sub\" class = \"submenu-elm\" style=\"display: none;\">
\t\t\t\t\t<a href=";
        // line 11
        echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('nonce')->getCallable(), array("./myschemes")), "html", null, true);
        echo "#activeSchemesCard title=\"Active Schemes\"><i class=\"fa fa-film\"></i><span>  
\t\t\t\t\tActive Schemes</span></a>
\t\t\t\t\t<a href=";
        // line 13
        echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('nonce')->getCallable(), array("./myschemes")), "html", null, true);
        echo "#schemesPendingApprovalCard title=\"Schemes Pending Approval\"><i class=\"fa fa-picture-o\"></i><span>  
\t\t\t\t\tSchemes Pending Approval</span></a>
\t\t\t\t\t<a href=";
        // line 15
        echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('nonce')->getCallable(), array("./myschemes")), "html", null, true);
        echo "#draftSchemesCard title=\"Draft Schemes\"><i class=\"fa fa-picture-o\"></i><span>  
\t\t\t\t\tDraft Schemes</span></a>
\t\t\t\t\t<a href=";
        // line 17
        echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('nonce')->getCallable(), array("./myschemes")), "html", null, true);
        echo "#concludedSchemesCard title=\"Concluded Schemes\"><i class=\"fa fa-picture-o\"></i><span>  
\t\t\t\t\tConcluded Schemes</span></a>
\t\t\t\t</div>

\t\t\t<a href=";
        // line 21
        echo twig_escape_filter($this->env, call_user_func_array($this->env->getFilter('nonce')->getCallable(), array("./simulation")), "html", null, true);
        echo " title=\"Simulate Schemes\"><i class=\"fa fa-globe\"></i><span>  
\t\t\tSimulate Schemes</span></a>
\t\t\t<a href=\"\" title=\"Events\"><i class=\"fa fa-ticket\"></i><span>  
\t\t\tEvents</span></a>

\t\t\t<a href=\"\" class=\"submenu\" name=\"other-sub\" title=\"Other Contents\"><i class=\"fa fa-random\"></i><span> 
\t\t\tOther Contents</span></a>
\t\t\t<!-- Other Contents Sub Menu -->
\t\t\t\t<div id=\"other-sub\" class = \"submenu-elm\">
\t\t\t\t\t<a href=\"\" title=\"Forms\"><i class=\"fa fa-female\"></i><span>  
\t\t\t\t\tForms</span></a>
\t\t\t\t\t<a href=\"\" title=\"Mail Lists\"><i class=\"fa fa-male\"></i><span>  
\t\t\t\t\tMail Lists</span></a>
\t\t\t\t\t<a href=\"\" title=\"Maps\"><i class=\"fa fa-plane\"></i><span>  
\t\t\t\t\tMaps</span></a>
\t\t\t\t</div>
\t\t\t<!-- Other Contents Sub Menu -->
\t\t\t<a href=\"\" title=\"Admin Tools\"><i class=\"fa fa-gear\"></i><span>  
\t\t\tAdmin Tools</span></a>
\t</div>
</aside>

";
    }

    public function getTemplateName()
    {
        return "menu.tmpl";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  62 => 21,  55 => 17,  50 => 15,  45 => 13,  40 => 11,  32 => 6,  28 => 5,  23 => 3,  19 => 1,);
    }
}
