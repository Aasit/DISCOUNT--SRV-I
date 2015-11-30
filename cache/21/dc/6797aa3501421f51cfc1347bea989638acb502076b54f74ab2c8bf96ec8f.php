<?php

/* copy_schemesPendingApproval.tmpl */
class __TwigTemplate_21dc6797aa3501421f51cfc1347bea989638acb502076b54f74ab2c8bf96ec8f extends Twig_Template
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
\t\tInitiated Schemes
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
            echo "    <div class=\"state-panel panel-solid-default no-margin\">
\t\t<a href=\"template?schemeId=";
            // line 9
            echo twig_escape_filter($this->env, $this->getAttribute($context["scheme"], "code", array()), "html", null, true);
            echo "&rand_token=";
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context["items"]) ? $context["items"] : null), "nonce", array()), "html", null, true);
            echo "&cpy=true\">
\t\t\t<div class=\"panel-heading\">
\t\t\t\t<h3 class=\"panel-title\">";
            // line 11
            echo twig_escape_filter($this->env, $this->getAttribute($context["scheme"], "name", array()), "html", null, true);
            echo " ";
            if ( !twig_test_empty($this->getAttribute($context["scheme"], "uid", array()))) {
                echo "(";
                echo twig_escape_filter($this->env, $this->getAttribute($context["scheme"], "uid", array()), "html", null, true);
                echo ")";
            }
            echo "</h3>
\t\t\t</div>
\t\t</a>
\t</div>
";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['scheme'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 16
        echo "
";
        // line 17
        if ((twig_length_filter($this->env, $this->getAttribute((isset($context["items"]) ? $context["items"] : null), "toBeReviewedSchemes", array())) > 0)) {
            // line 18
            echo "    <div class = \"list-header\">
\t\tTo Be Approved Schemes
\t</div>
";
        }
        // line 22
        echo "
";
        // line 23
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_ensure_traversable($this->getAttribute((isset($context["items"]) ? $context["items"] : null), "toBeReviewedSchemes", array()));
        foreach ($context['_seq'] as $context["_key"] => $context["scheme"]) {
            // line 24
            echo "    <div class=\"state-panel panel-solid-default no-margin\">
    \t<a href=\"template?schemeId=";
            // line 25
            echo twig_escape_filter($this->env, $this->getAttribute($context["scheme"], "code", array()), "html", null, true);
            echo "&rand_token=";
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context["items"]) ? $context["items"] : null), "nonce", array()), "html", null, true);
            echo "&cpy=true\">
\t\t\t<div class=\"panel-heading\">
\t\t\t\t<h3 class=\"panel-title\">";
            // line 27
            echo twig_escape_filter($this->env, $this->getAttribute($context["scheme"], "name", array()), "html", null, true);
            echo " ";
            if ( !twig_test_empty($this->getAttribute($context["scheme"], "uid", array()))) {
                echo "(";
                echo twig_escape_filter($this->env, $this->getAttribute($context["scheme"], "uid", array()), "html", null, true);
                echo ")";
            }
            echo "</h3>
\t\t\t</div>\t
\t\t</a>\t\t\t
\t</div>
";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['scheme'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 32
        echo "

";
        // line 34
        if ((twig_length_filter($this->env, $this->getAttribute((isset($context["items"]) ? $context["items"] : null), "toBeApprovedSchemes", array())) > 0)) {
            // line 35
            echo "    <div class = \"list-header\">
\t\tTo Be Reviewed Schemes
\t</div>
";
        }
        // line 39
        echo "\t
";
        // line 40
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_ensure_traversable($this->getAttribute((isset($context["items"]) ? $context["items"] : null), "toBeApprovedSchemes", array()));
        foreach ($context['_seq'] as $context["_key"] => $context["scheme"]) {
            // line 41
            echo "    <div class=\"state-panel panel-solid-default no-margin\">
    \t<a href=\"template?schemeId=";
            // line 42
            echo twig_escape_filter($this->env, $this->getAttribute($context["scheme"], "code", array()), "html", null, true);
            echo "&rand_token=";
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context["items"]) ? $context["items"] : null), "nonce", array()), "html", null, true);
            echo "&cpy=true\">
\t\t\t<div class=\"panel-heading\">
\t\t\t\t<h3 class=\"panel-title\">";
            // line 44
            echo twig_escape_filter($this->env, $this->getAttribute($context["scheme"], "name", array()), "html", null, true);
            echo " ";
            if ( !twig_test_empty($this->getAttribute($context["scheme"], "uid", array()))) {
                echo "(";
                echo twig_escape_filter($this->env, $this->getAttribute($context["scheme"], "uid", array()), "html", null, true);
                echo ")";
            }
            echo "</h3>
\t\t\t</div>
\t\t</a>

\t</div>
";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['scheme'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
    }

    public function getTemplateName()
    {
        return "copy_schemesPendingApproval.tmpl";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  135 => 44,  128 => 42,  125 => 41,  121 => 40,  118 => 39,  112 => 35,  110 => 34,  106 => 32,  89 => 27,  82 => 25,  79 => 24,  75 => 23,  72 => 22,  66 => 18,  64 => 17,  61 => 16,  44 => 11,  37 => 9,  34 => 8,  30 => 7,  27 => 6,  21 => 2,  19 => 1,);
    }
}
