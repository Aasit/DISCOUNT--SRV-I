<?php

/* emails/scheme.initiated.initiator.tmpl */
class __TwigTemplate_f1eeab829ed722b8cb15bc9967f8017a79ecf4bc92f83382903293e84930f7df extends Twig_Template
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
        echo "
Dear ";
        // line 2
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["items"]) ? $context["items"] : null), "initiatorName", array()), "html", null, true);
        echo ",

A new scheme was submitted at ";
        // line 4
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context["items"]) ? $context["items"] : null), "scheme", array()), "created_at", array()), "html", null, true);
        echo " by you for review by ";
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["items"]) ? $context["items"] : null), "reviewerName", array()), "html", null, true);
        echo " ( ";
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["items"]) ? $context["items"] : null), "reviewerCode", array()), "html", null, true);
        echo " ) & subsequent approval by ";
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["items"]) ? $context["items"] : null), "approverName", array()), "html", null, true);
        echo " ( ";
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["items"]) ? $context["items"] : null), "approverCode", array()), "html", null, true);
        echo " ). You may login into the Discounts Management Application to view the review / approval status under the \"Schemes Pending Approval\" section on your Dashboard.

You will be notified as and when any action has been performed on this scheme.

";
        // line 8
        $this->loadTemplate("emails/basicSchemeDetails.tmpl", "emails/scheme.initiated.initiator.tmpl", 8)->display($context);
        // line 9
        echo "
Regards,
Discounts Management Portal Administrator
";
        // line 12
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["items"]) ? $context["items"] : null), "url", array()), "html", null, true);
        echo "

";
    }

    public function getTemplateName()
    {
        return "emails/scheme.initiated.initiator.tmpl";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  49 => 12,  44 => 9,  42 => 8,  27 => 4,  22 => 2,  19 => 1,);
    }
}
