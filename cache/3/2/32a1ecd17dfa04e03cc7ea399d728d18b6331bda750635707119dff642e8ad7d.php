<?php

/* draftSchemes.tmpl */
class __TwigTemplate_32a1ecd17dfa04e03cc7ea399d728d18b6331bda750635707119dff642e8ad7d extends Twig_Template
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
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_ensure_traversable($this->getAttribute((isset($context["items"]) ? $context["items"] : null), "draftSchemes", array()));
        foreach ($context['_seq'] as $context["_key"] => $context["scheme"]) {
            // line 2
            echo "    <div class=\"state-panel panel-solid-default col-lg-6 col-md-6 col-sm-12 col-xs-12\">
\t\t<div class=\"panel-heading\">

\t\t\t<!-- <div class=\"scheme-minimize-button\"><i class=\"fa fa-chevron-down\"></i></div> -->
\t\t\t<a class=\"scheme-link-button\" href = \"template?schemeId=";
            // line 6
            echo twig_escape_filter($this->env, $this->getAttribute($context["scheme"], "code", array()), "html", null, true);
            echo "&rand_token=";
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context["items"]) ? $context["items"] : null), "nonce", array()), "html", null, true);
            echo "\"><i class=\"fa fa-external-link\"></i></a>
\t\t\t<h3 class=\"panel-title\">";
            // line 7
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
\t\t\t
\t\t\t";
            // line 11
            if (($this->getAttribute($context["scheme"], "state", array()) == $this->getAttribute($this->getAttribute((isset($context["items"]) ? $context["items"] : null), "states", array()), "staged", array()))) {
                // line 12
                echo "\t\t\t\t<div class=\"scheme-state-details\">
\t\t\t\t\t<div class=\"granular-info-box\">
\t\t\t\t\t\t<div class=\"arrow\"></div>
\t\t\t\t\t\t<div class=\"details-content\">
\t\t\t\t\t\t\t<!-- <p class=\"scheme-title\">Scheme Name 001</p>
\t\t\t\t\t\t\t<p class=\"notification-info\">Notification received from Mr. A</p> -->
\t\t\t\t\t\t\t<ul class=\"granular-info\">
\t\t\t\t\t\t\t\t<li class=\"unit \"><span class=\"start-date-label info-label\">Start Date: </span><span class=\"start-date info-data\">";
                // line 19
                echo twig_escape_filter($this->env, $this->getAttribute($context["scheme"], "start_date", array()), "html", null, true);
                echo "</span></li>
\t\t\t\t\t\t\t\t<li class=\"unit \"><span class=\"end-date-labe info-label\">End Date: </span><span class=\"end-date info-data\">";
                // line 20
                echo twig_escape_filter($this->env, $this->getAttribute($context["scheme"], "end_date", array()), "html", null, true);
                echo "</span></li>
\t\t\t\t\t\t\t\t<li class=\"unit \"><span class=\"forecast-amount-label info-label\">Forecast Amount: </span><span class=\"forecast-amount info-data\">-</span></li>
\t\t\t\t\t\t\t\t<li class=\"unit \"><span class=\"initiated-label info-label\">Created on: </span><span class=\"initiated-date info-data\">";
                // line 22
                echo twig_escape_filter($this->env, $this->getAttribute($context["scheme"], "created_at", array()), "html", null, true);
                echo "</span></li>
\t\t\t\t\t\t\t\t<li class=\"unit \"><span class=\"initiator-label info-label\">Initiated by: </span><span class=\"initiated-by info-data\">";
                // line 23
                echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($context["scheme"], "initiator", array()), "name", array()), "html", null, true);
                echo "</span></li>
\t\t\t\t\t\t\t\t<li class=\"unit \"><span class=\"initiator-label info-label\">To be Updated by: </span><span class=\"initiated-by info-data\">";
                // line 24
                echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($context["scheme"], "initiator", array()), "name", array()), "html", null, true);
                echo "</span></li>
\t\t\t\t\t\t\t\t<li class=\"unit \"><span class=\"reviewer-label info-label\">To be Reviewed by: </span><span class=\"reviewed-by info-data\">";
                // line 25
                echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($context["scheme"], "reviewer", array()), "name", array()), "html", null, true);
                echo "</span></li>
\t\t\t\t\t\t\t\t<li class=\"unit \"><span class=\"reviewer-label info-label\">To be Approved by: </span><span class=\"reviewed-by info-data\">";
                // line 26
                echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($context["scheme"], "approver", array()), "name", array()), "html", null, true);
                echo "</span></li>

\t\t\t\t\t\t\t</ul>
\t\t\t\t\t\t</div>
\t\t\t\t\t</div>

\t\t\t\t</div>
\t\t\t";
            } elseif (($this->getAttribute(            // line 33
$context["scheme"], "state", array()) == $this->getAttribute($this->getAttribute((isset($context["items"]) ? $context["items"] : null), "states", array()), "updateRequested", array()))) {
                // line 34
                echo "\t\t\t\t
\t\t\t\t<div class=\"scheme-state-details\">
\t\t\t\t\t<div class=\"granular-info-box\">
\t\t\t\t\t\t<div class=\"arrow\"></div>
\t\t\t\t\t\t<div class=\"details-content\">
\t\t\t\t\t\t\t<!-- <p class=\"scheme-title\">Scheme Name 001</p>
\t\t\t\t\t\t\t<p class=\"notification-info\">Notification received from Mr. A</p> -->
\t\t\t\t\t\t\t<ul class=\"granular-info\">
\t\t\t\t\t\t\t\t<li class=\"unit \"><span class=\"start-date-label info-label\">Start Date: </span><span class=\"start-date info-data\">";
                // line 42
                echo twig_escape_filter($this->env, $this->getAttribute($context["scheme"], "start_date", array()), "html", null, true);
                echo "</span></li>
\t\t\t\t\t\t\t\t<li class=\"unit \"><span class=\"end-date-labe info-label\">End Date: </span><span class=\"end-date info-data\">";
                // line 43
                echo twig_escape_filter($this->env, $this->getAttribute($context["scheme"], "end_date", array()), "html", null, true);
                echo "</span></li>
\t\t\t\t\t\t\t\t<li class=\"unit \"><span class=\"forecast-amount-label info-label\">Forecast Amount: </span><span class=\"forecast-amount info-data\">-</span></li>
\t\t\t\t\t\t\t\t<li class=\"unit \"><span class=\"initiated-label info-label\">Created on: </span><span class=\"initiated-date info-data\">";
                // line 45
                echo twig_escape_filter($this->env, $this->getAttribute($context["scheme"], "created_at", array()), "html", null, true);
                echo "</span></li>
\t\t\t\t\t\t\t\t<li class=\"unit \"><span class=\"initiator-label info-label\">Initiated by: </span><span class=\"initiated-by info-data\">";
                // line 46
                echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($context["scheme"], "initiator", array()), "name", array()), "html", null, true);
                echo "</span></li>
\t\t\t\t\t\t\t\t<li class=\"unit \"><span class=\"initiator-label info-label\">To be Updated by: </span><span class=\"initiated-by info-data\">";
                // line 47
                echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($context["scheme"], "initiator", array()), "name", array()), "html", null, true);
                echo "</span></li>
\t\t\t\t\t\t\t\t<li class=\"unit \"><span class=\"reviewer-label info-label\">To be Reviewed by: </span><span class=\"reviewed-by info-data\">";
                // line 48
                echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($context["scheme"], "reviewer", array()), "name", array()), "html", null, true);
                echo "</span></li>
\t\t\t\t\t\t\t\t<li class=\"unit \"><span class=\"reviewer-label info-label\">To be Approved by: </span><span class=\"reviewed-by info-data\">";
                // line 49
                echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($context["scheme"], "approver", array()), "name", array()), "html", null, true);
                echo "</span></li>

\t\t\t\t\t\t\t</ul>
\t\t\t\t\t\t</div>
\t\t\t\t\t</div>

\t\t\t\t</div>
\t\t\t
\t\t\t";
            }
            // line 58
            echo "
\t\t\t\t
\t\t</div>
\t</div>
";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['scheme'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
    }

    public function getTemplateName()
    {
        return "draftSchemes.tmpl";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  143 => 58,  131 => 49,  127 => 48,  123 => 47,  119 => 46,  115 => 45,  110 => 43,  106 => 42,  96 => 34,  94 => 33,  84 => 26,  80 => 25,  76 => 24,  72 => 23,  68 => 22,  63 => 20,  59 => 19,  50 => 12,  48 => 11,  35 => 7,  29 => 6,  23 => 2,  19 => 1,);
    }
}
