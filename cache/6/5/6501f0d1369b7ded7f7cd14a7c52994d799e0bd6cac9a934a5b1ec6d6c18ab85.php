<?php

/* emails/basicSchemeDetails.tmpl */
class __TwigTemplate_6501f0d1369b7ded7f7cd14a7c52994d799e0bd6cac9a934a5b1ec6d6c18ab85 extends Twig_Template
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
        echo "Scheme Highlights:
------------------
Name: ";
        // line 3
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context["items"]) ? $context["items"] : null), "scheme", array()), "name", array()), "html", null, true);
        echo "
Start Date: ";
        // line 4
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context["items"]) ? $context["items"] : null), "scheme", array()), "start_date", array()), "html", null, true);
        echo "
End Date: ";
        // line 5
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context["items"]) ? $context["items"] : null), "scheme", array()), "end_date", array()), "html", null, true);
        echo "
Created on: ";
        // line 6
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context["items"]) ? $context["items"] : null), "scheme", array()), "created_at", array()), "html", null, true);
        echo "
Status: ";
        // line 7
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["items"]) ? $context["items"] : null), "status", array()), "html", null, true);
        echo "

";
        // line 9
        if ( !twig_test_empty($this->getAttribute((isset($context["items"]) ? $context["items"] : null), "comment", array()))) {
            // line 10
            echo "Submission Comments:
--------------------
";
            // line 12
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context["items"]) ? $context["items"] : null), "comment", array()), "html", null, true);
            echo "
";
        }
    }

    public function getTemplateName()
    {
        return "emails/basicSchemeDetails.tmpl";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  50 => 12,  46 => 10,  44 => 9,  39 => 7,  35 => 6,  31 => 5,  27 => 4,  23 => 3,  19 => 1,);
    }
}
