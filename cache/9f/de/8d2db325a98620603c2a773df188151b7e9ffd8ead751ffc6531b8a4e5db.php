<?php

/* copy_draftSchemes.tmpl */
class __TwigTemplate_9fde8d2db325a98620603c2a773df188151b7e9ffd8ead751ffc6531b8a4e5db extends Twig_Template
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
            echo "    <div class=\"state-panel panel-solid-default no-margin\">
    \t<a href=\"template?schemeId=";
            // line 3
            echo twig_escape_filter($this->env, $this->getAttribute($context["scheme"], "code", array()), "html", null, true);
            echo "&rand_token=";
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context["items"]) ? $context["items"] : null), "nonce", array()), "html", null, true);
            echo "&cpy=true\">
\t\t\t<div class=\"panel-heading\">
\t\t\t\t<h3 class=\"panel-title\">";
            // line 5
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
    }

    public function getTemplateName()
    {
        return "copy_draftSchemes.tmpl";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  33 => 5,  26 => 3,  23 => 2,  19 => 1,);
    }
}
