<?php

/* activeSchemes.tmpl */
class __TwigTemplate_5ee2b9e1ccd68f5aa589920d9f607c81f667630ca89618cd3d5c07e28de55624 extends Twig_Template
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
        if ((twig_length_filter($this->env, $this->getAttribute((isset($context["items"]) ? $context["items"] : null), "initiatedSchemes", array())) > 0)) {
            // line 2
            echo "    <div class = \"list-header\">
\t\tSchemes Initiated By Me
\t</div>
";
        }
        // line 6
        echo "\t
";
        // line 7
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_ensure_traversable($this->getAttribute((isset($context["items"]) ? $context["items"] : null), "initiatedSchemes", array()));
        foreach ($context['_seq'] as $context["_key"] => $context["scheme"]) {
            // line 8
            echo "
\t";
            // line 9
            if (($this->getAttribute($context["scheme"], "state", array()) == $this->getAttribute($this->getAttribute((isset($context["items"]) ? $context["items"] : null), "states", array()), "approved", array()))) {
                // line 10
                echo "    <div class=\"state-panel panel-solid-default col-lg-6 col-md-6 col-sm-12 col-xs-12\">
\t\t<div class=\"panel-heading\">
\t\t\t<a class=\"scheme-link-button\" href = \"scheme?schemeId=";
                // line 12
                echo twig_escape_filter($this->env, $this->getAttribute($context["scheme"], "code", array()), "html", null, true);
                echo "&rand_token=";
                echo twig_escape_filter($this->env, $this->getAttribute((isset($context["items"]) ? $context["items"] : null), "nonce", array()), "html", null, true);
                echo "\"><i class=\"fa fa-external-link\"></i></a>
\t\t\t
\t\t\t<h3 class=\"panel-title\">";
                // line 14
                echo twig_escape_filter($this->env, $this->getAttribute($context["scheme"], "name", array()), "html", null, true);
                echo " ";
                if ( !twig_test_empty($this->getAttribute($context["scheme"], "uid", array()))) {
                    echo "(";
                    echo twig_escape_filter($this->env, $this->getAttribute($context["scheme"], "uid", array()), "html", null, true);
                    echo ")";
                }
                echo "</h3>
\t\t</div>
\t\t<div class=\"panel-body\">
\t\t\t<div class=\"scheme-state-details\">
\t\t\t\t<div class=\"granular-info-box\">
\t\t\t\t\t<div class=\"arrow\"></div>
\t\t\t\t\t<div class=\"details-content\">
\t\t\t\t\t\t<!-- <p class=\"scheme-title\">Scheme Name 001</p>
\t\t\t\t\t\t<p class=\"notification-info\">Notification received from Mr. A</p> -->
\t\t\t\t\t\t<ul class=\"granular-info\">
\t\t\t\t\t\t\t<li class=\"unit \"><span class=\"start-date-label info-label\">Start Date: </span><span class=\"start-date info-data\">";
                // line 24
                echo twig_escape_filter($this->env, $this->getAttribute($context["scheme"], "start_date", array()), "html", null, true);
                echo "</span></li>
\t\t\t\t\t\t\t<li class=\"unit \"><span class=\"end-date-labe info-label\">End Date: </span><span class=\"end-date info-data\">";
                // line 25
                echo twig_escape_filter($this->env, $this->getAttribute($context["scheme"], "end_date", array()), "html", null, true);
                echo "</span></li>
\t\t\t\t\t\t\t<li class=\"unit \"><span class=\"forecast-amount-label info-label\">Forecast Amount: </span><span class=\"forecast-amount info-data\">-</span></li>
\t\t\t\t\t\t\t<li class=\"unit \"><span class=\"initiated-label info-label\">Created on: </span><span class=\"initiated-date info-data\">";
                // line 27
                echo twig_escape_filter($this->env, $this->getAttribute($context["scheme"], "created_at", array()), "html", null, true);
                echo "</span></li>
\t\t\t\t\t\t\t<li class=\"unit \"><span class=\"initiator-label info-label\">Initiated by: </span><span class=\"initiated-by info-data\">";
                // line 28
                echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($context["scheme"], "initiator", array()), "name", array()), "html", null, true);
                echo "</span></li>
\t\t\t\t\t\t\t<li class=\"unit \"><span class=\"initiator-label info-label\">To be Updated by: </span><span class=\"initiated-by info-data\">";
                // line 29
                echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($context["scheme"], "initiator", array()), "name", array()), "html", null, true);
                echo "</span></li>
\t\t\t\t\t\t\t<li class=\"unit \"><span class=\"reviewer-label info-label\">To be Reviewed by: </span><span class=\"reviewed-by info-data\">";
                // line 30
                echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($context["scheme"], "reviewer", array()), "name", array()), "html", null, true);
                echo "</span></li>
\t\t\t\t\t\t\t<li class=\"unit \"><span class=\"reviewer-label info-label\">To be Approved by: </span><span class=\"reviewed-by info-data\">";
                // line 31
                echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($context["scheme"], "approver", array()), "name", array()), "html", null, true);
                echo "</span></li>

\t\t\t\t\t\t</ul>
\t\t\t\t\t</div>
\t\t\t\t</div>

\t\t\t</div>\t
\t\t</div>
\t</div>
\t";
            }
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['scheme'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 42
        echo "
";
        // line 43
        if ((twig_length_filter($this->env, $this->getAttribute((isset($context["items"]) ? $context["items"] : null), "toBeReviewedSchemes", array())) > 0)) {
            // line 44
            echo "    <div class = \"list-header\">
\t\tSchemes Under My Review
\t</div>
";
        }
        // line 48
        echo "
";
        // line 49
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_ensure_traversable($this->getAttribute((isset($context["items"]) ? $context["items"] : null), "toBeReviewedSchemes", array()));
        foreach ($context['_seq'] as $context["_key"] => $context["scheme"]) {
            // line 50
            echo "\t";
            if (($this->getAttribute($context["scheme"], "state", array()) == $this->getAttribute($this->getAttribute((isset($context["items"]) ? $context["items"] : null), "states", array()), "approved", array()))) {
                // line 51
                echo "    <div class=\"state-panel panel-solid-default col-lg-6 col-md-6 col-sm-12 col-xs-12\">
\t\t<div class=\"panel-heading\">

\t\t\t<a class=\"scheme-link-button\" href = \"scheme?schemeId=";
                // line 54
                echo twig_escape_filter($this->env, $this->getAttribute($context["scheme"], "code", array()), "html", null, true);
                echo "&rand_token=";
                echo twig_escape_filter($this->env, $this->getAttribute((isset($context["items"]) ? $context["items"] : null), "nonce", array()), "html", null, true);
                echo "\"><i class=\"fa fa-external-link\"></i></a>
\t\t\t<h3 class=\"panel-title\">";
                // line 55
                echo twig_escape_filter($this->env, $this->getAttribute($context["scheme"], "name", array()), "html", null, true);
                echo " ";
                if ( !twig_test_empty($this->getAttribute($context["scheme"], "uid", array()))) {
                    echo "(";
                    echo twig_escape_filter($this->env, $this->getAttribute($context["scheme"], "uid", array()), "html", null, true);
                    echo ")";
                }
                echo "</h3>
\t\t</div>
\t\t<div class=\"panel-body\">
\t\t\t<div class=\"scheme-state-details\">
\t\t\t\t<div class=\"granular-info-box\">
\t\t\t\t\t<div class=\"arrow\"></div>
\t\t\t\t\t<div class=\"details-content\">
\t\t\t\t\t\t<!-- <p class=\"scheme-title\">Scheme Name 001</p>
\t\t\t\t\t\t<p class=\"notification-info\">Notification received from Mr. A</p> -->
\t\t\t\t\t\t<ul class=\"granular-info\">
\t\t\t\t\t\t\t<li class=\"unit \"><span class=\"start-date-label info-label\">Start Date: </span><span class=\"start-date info-data\">";
                // line 65
                echo twig_escape_filter($this->env, $this->getAttribute($context["scheme"], "start_date", array()), "html", null, true);
                echo "</span></li>
\t\t\t\t\t\t\t<li class=\"unit \"><span class=\"end-date-labe info-label\">End Date: </span><span class=\"end-date info-data\">";
                // line 66
                echo twig_escape_filter($this->env, $this->getAttribute($context["scheme"], "end_date", array()), "html", null, true);
                echo "</span></li>
\t\t\t\t\t\t\t<li class=\"unit \"><span class=\"forecast-amount-label info-label\">Forecast Amount: </span><span class=\"forecast-amount info-data\">-</span></li>
\t\t\t\t\t\t\t<li class=\"unit \"><span class=\"initiated-label info-label\">Created on: </span><span class=\"initiated-date info-data\">";
                // line 68
                echo twig_escape_filter($this->env, $this->getAttribute($context["scheme"], "created_at", array()), "html", null, true);
                echo "</span></li>
\t\t\t\t\t\t\t<li class=\"unit \"><span class=\"initiator-label info-label\">Initiated by: </span><span class=\"initiated-by info-data\">";
                // line 69
                echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($context["scheme"], "initiator", array()), "name", array()), "html", null, true);
                echo "</span></li>
\t\t\t\t\t\t\t<li class=\"unit \"><span class=\"initiator-label info-label\">To be Updated by: </span><span class=\"initiated-by info-data\">";
                // line 70
                echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($context["scheme"], "initiator", array()), "name", array()), "html", null, true);
                echo "</span></li>
\t\t\t\t\t\t\t<li class=\"unit \"><span class=\"reviewer-label info-label\">To be Reviewed by: </span><span class=\"reviewed-by info-data\">";
                // line 71
                echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($context["scheme"], "reviewer", array()), "name", array()), "html", null, true);
                echo "</span></li>
\t\t\t\t\t\t\t<li class=\"unit \"><span class=\"reviewer-label info-label\">To be Approved by: </span><span class=\"reviewed-by info-data\">";
                // line 72
                echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($context["scheme"], "approver", array()), "name", array()), "html", null, true);
                echo "</span></li>

\t\t\t\t\t\t</ul>
\t\t\t\t\t</div>
\t\t\t\t</div>

\t\t\t</div>\t\t\t\t\t
\t\t</div>
\t</div>
\t";
            }
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['scheme'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 83
        echo "

";
        // line 85
        if ((twig_length_filter($this->env, $this->getAttribute((isset($context["items"]) ? $context["items"] : null), "toBeApprovedSchemes", array())) > 0)) {
            // line 86
            echo "    <div class = \"list-header\">
\t\tSchemes Under My Approval
\t</div>
";
        }
        // line 90
        echo "\t
";
        // line 91
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_ensure_traversable($this->getAttribute((isset($context["items"]) ? $context["items"] : null), "toBeApprovedSchemes", array()));
        foreach ($context['_seq'] as $context["_key"] => $context["scheme"]) {
            // line 92
            echo "\t";
            if (($this->getAttribute($context["scheme"], "state", array()) == $this->getAttribute($this->getAttribute((isset($context["items"]) ? $context["items"] : null), "states", array()), "approved", array()))) {
                // line 93
                echo "    <div class=\"state-panel panel-solid-default col-lg-6 col-md-6 col-sm-12 col-xs-12\">
\t\t<div class=\"panel-heading\">

\t\t\t<a class=\"scheme-link-button\" href = \"scheme?schemeId=";
                // line 96
                echo twig_escape_filter($this->env, $this->getAttribute($context["scheme"], "code", array()), "html", null, true);
                echo "&rand_token=";
                echo twig_escape_filter($this->env, $this->getAttribute((isset($context["items"]) ? $context["items"] : null), "nonce", array()), "html", null, true);
                echo "\"><i class=\"fa fa-external-link\"></i></a>
\t\t\t<h3 class=\"panel-title\">";
                // line 97
                echo twig_escape_filter($this->env, $this->getAttribute($context["scheme"], "name", array()), "html", null, true);
                echo " ";
                if ( !twig_test_empty($this->getAttribute($context["scheme"], "uid", array()))) {
                    echo "(";
                    echo twig_escape_filter($this->env, $this->getAttribute($context["scheme"], "uid", array()), "html", null, true);
                    echo ")";
                }
                echo "</h3>
\t\t</div>
\t\t<div class=\"panel-body\">
\t\t\t<div class=\"scheme-state-details\">
\t\t\t\t<div class=\"granular-info-box\">
\t\t\t\t\t<div class=\"arrow\"></div>
\t\t\t\t\t<div class=\"details-content\">
\t\t\t\t\t\t<!-- <p class=\"scheme-title\">Scheme Name 001</p>
\t\t\t\t\t\t<p class=\"notification-info\">Notification received from Mr. A</p> -->
\t\t\t\t\t\t<ul class=\"granular-info\">
\t\t\t\t\t\t\t<li class=\"unit \"><span class=\"start-date-label info-label\">Start Date: </span><span class=\"start-date info-data\">";
                // line 107
                echo twig_escape_filter($this->env, $this->getAttribute($context["scheme"], "start_date", array()), "html", null, true);
                echo "</span></li>
\t\t\t\t\t\t\t<li class=\"unit \"><span class=\"end-date-labe info-label\">End Date: </span><span class=\"end-date info-data\">";
                // line 108
                echo twig_escape_filter($this->env, $this->getAttribute($context["scheme"], "end_date", array()), "html", null, true);
                echo "</span></li>
\t\t\t\t\t\t\t<li class=\"unit \"><span class=\"forecast-amount-label info-label\">Forecast Amount: </span><span class=\"forecast-amount info-data\">-</span></li>
\t\t\t\t\t\t\t<li class=\"unit \"><span class=\"initiated-label info-label\">Created on: </span><span class=\"initiated-date info-data\">";
                // line 110
                echo twig_escape_filter($this->env, $this->getAttribute($context["scheme"], "created_at", array()), "html", null, true);
                echo "</span></li>
\t\t\t\t\t\t\t<li class=\"unit \"><span class=\"initiator-label info-label\">Initiated by: </span><span class=\"initiated-by info-data\">";
                // line 111
                echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($context["scheme"], "initiator", array()), "name", array()), "html", null, true);
                echo "</span></li>
\t\t\t\t\t\t\t<li class=\"unit \"><span class=\"initiator-label info-label\">To be Updated by: </span><span class=\"initiated-by info-data\">";
                // line 112
                echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($context["scheme"], "initiator", array()), "name", array()), "html", null, true);
                echo "</span></li>
\t\t\t\t\t\t\t<li class=\"unit \"><span class=\"reviewer-label info-label\">To be Reviewed by: </span><span class=\"reviewed-by info-data\">";
                // line 113
                echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($context["scheme"], "reviewer", array()), "name", array()), "html", null, true);
                echo "</span></li>
\t\t\t\t\t\t\t<li class=\"unit \"><span class=\"reviewer-label info-label\">To be Approved by: </span><span class=\"reviewed-by info-data\">";
                // line 114
                echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($context["scheme"], "approver", array()), "name", array()), "html", null, true);
                echo "</span></li>

\t\t\t\t\t\t</ul>
\t\t\t\t\t</div>
\t\t\t\t</div>

\t\t\t</div>\t
\t\t</div>
\t</div>
\t";
            }
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['scheme'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
    }

    public function getTemplateName()
    {
        return "activeSchemes.tmpl";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  281 => 114,  277 => 113,  273 => 112,  269 => 111,  265 => 110,  260 => 108,  256 => 107,  237 => 97,  231 => 96,  226 => 93,  223 => 92,  219 => 91,  216 => 90,  210 => 86,  208 => 85,  204 => 83,  187 => 72,  183 => 71,  179 => 70,  175 => 69,  171 => 68,  166 => 66,  162 => 65,  143 => 55,  137 => 54,  132 => 51,  129 => 50,  125 => 49,  122 => 48,  116 => 44,  114 => 43,  111 => 42,  94 => 31,  90 => 30,  86 => 29,  82 => 28,  78 => 27,  73 => 25,  69 => 24,  50 => 14,  43 => 12,  39 => 10,  37 => 9,  34 => 8,  30 => 7,  27 => 6,  21 => 2,  19 => 1,);
    }
}
