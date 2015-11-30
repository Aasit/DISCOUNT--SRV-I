<?php

/* schemesPendingApproval.tmpl */
class __TwigTemplate_79e47ef2ee54b24af87a6263e2b85d3ec8537fd55bedd83cb315f5d2399c0951 extends Twig_Template
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
            echo "\t";
            if ((((($this->getAttribute($context["scheme"], "state", array()) == $this->getAttribute($this->getAttribute((isset($context["items"]) ? $context["items"] : null), "states", array()), "staged", array())) || ($this->getAttribute($context["scheme"], "state", array()) == $this->getAttribute($this->getAttribute((isset($context["items"]) ? $context["items"] : null), "states", array()), "updateRequested", array()))) || ($this->getAttribute($context["scheme"], "state", array()) == $this->getAttribute($this->getAttribute((isset($context["items"]) ? $context["items"] : null), "states", array()), "initiated", array()))) || ($this->getAttribute($context["scheme"], "state", array()) == $this->getAttribute($this->getAttribute((isset($context["items"]) ? $context["items"] : null), "states", array()), "reviewed", array())))) {
                // line 9
                echo "    <div class=\"state-panel panel-solid-default col-lg-6 col-md-6 col-sm-12 col-xs-12\">
\t\t<div class=\"panel-heading\">

\t\t\t<div class=\"scheme-minimize-button\"><i class=\"fa fa-chevron-down\"></i></div>

\t\t\t";
                // line 14
                if ((($this->getAttribute($context["scheme"], "state", array()) == $this->getAttribute($this->getAttribute((isset($context["items"]) ? $context["items"] : null), "states", array()), "staged", array())) || ($this->getAttribute($context["scheme"], "state", array()) == $this->getAttribute($this->getAttribute((isset($context["items"]) ? $context["items"] : null), "states", array()), "updateRequested", array())))) {
                    // line 15
                    echo "\t\t\t\t<a class=\"scheme-link-button\" href = \"template?schemeId=";
                    echo twig_escape_filter($this->env, $this->getAttribute($context["scheme"], "code", array()), "html", null, true);
                    echo "&rand_token=";
                    echo twig_escape_filter($this->env, $this->getAttribute((isset($context["items"]) ? $context["items"] : null), "nonce", array()), "html", null, true);
                    echo "\"><i class=\"fa fa-external-link\"></i></a>
\t\t\t";
                } else {
                    // line 17
                    echo "\t\t\t\t<a class=\"scheme-link-button\" href = \"scheme?schemeId=";
                    echo twig_escape_filter($this->env, $this->getAttribute($context["scheme"], "code", array()), "html", null, true);
                    echo "&rand_token=";
                    echo twig_escape_filter($this->env, $this->getAttribute((isset($context["items"]) ? $context["items"] : null), "nonce", array()), "html", null, true);
                    echo "\"><i class=\"fa fa-external-link\"></i></a>
\t\t\t";
                }
                // line 19
                echo "\t\t\t
\t\t\t<h3 class=\"panel-title\">";
                // line 20
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
                // line 24
                if (($this->getAttribute($context["scheme"], "state", array()) == $this->getAttribute($this->getAttribute((isset($context["items"]) ? $context["items"] : null), "states", array()), "staged", array()))) {
                    // line 25
                    echo "\t\t\t\t<ul class=\"line-graph titles\">
\t\t\t\t\t<li class=\"unit size1of3\">
\t\t\t\t\t\t<ul class=\"line\">
\t\t\t\t\t\t\tInitiated
\t\t\t\t\t\t</ul>
\t\t\t\t\t</li>
\t\t\t\t\t<li class=\"unit size1of3\">
\t\t\t\t\t\t<ul class=\"line\">
\t\t\t\t\t\t\tReviewed
\t\t\t\t\t\t</ul>
\t\t\t\t\t</li>
\t\t\t\t\t<li class=\"unit size1of3\">
\t\t\t\t\t\t<ul class=\"line\">
\t\t\t\t\t\t\tApproved
\t\t\t\t\t\t</ul>
\t\t\t\t\t</li>
\t\t\t\t</ul>
\t\t\t    <ul class=\"line-graph\">
\t\t\t\t\t<li class=\"unit size1of3\">
\t\t\t\t\t\t<ul class=\"line\">
\t\t\t\t\t\t\t<li class=\"process-step processed-continuous\"></li>
\t\t\t\t\t\t</ul>
\t\t\t\t\t</li>
\t\t\t\t\t<li class=\"unit size1of3\">
\t\t\t\t\t\t<ul class=\"line\">
\t\t\t\t\t\t\t<li class=\"process-step inactive\"></li>
\t\t\t\t\t\t</ul>
\t\t\t\t\t</li>
\t\t\t\t\t<li class=\"unit size1of3\">
\t\t\t\t\t\t<ul class=\"line\">
\t\t\t\t\t\t\t<li class=\"process-step inactive\"></li>
\t\t\t\t\t\t</ul>
\t\t\t\t\t</li>
\t\t\t\t</ul>
\t\t\t\t<div class=\"scheme-state-details\">
\t\t\t\t\t<div class=\"granular-info-box\" style=\"display: none;\">
\t\t\t\t\t\t<div class=\"arrow\"></div>
\t\t\t\t\t\t<div class=\"details-content\">
\t\t\t\t\t\t\t<!-- <p class=\"scheme-title\">Scheme Name 001</p>
\t\t\t\t\t\t\t<p class=\"notification-info\">Notification received from Mr. A</p> -->
\t\t\t\t\t\t\t<ul class=\"granular-info\">
\t\t\t\t\t\t\t\t<li class=\"unit \"><span class=\"start-date-label info-label\">Start Date: </span><span class=\"start-date info-data\">";
                    // line 66
                    echo twig_escape_filter($this->env, $this->getAttribute($context["scheme"], "start_date", array()), "html", null, true);
                    echo "</span></li>
\t\t\t\t\t\t\t\t<li class=\"unit \"><span class=\"end-date-labe info-label\">End Date: </span><span class=\"end-date info-data\">";
                    // line 67
                    echo twig_escape_filter($this->env, $this->getAttribute($context["scheme"], "end_date", array()), "html", null, true);
                    echo "</span></li>
\t\t\t\t\t\t\t\t<li class=\"unit \"><span class=\"forecast-amount-label info-label\">Forecast Amount: </span><span class=\"forecast-amount info-data\">-</span></li>
\t\t\t\t\t\t\t\t<li class=\"unit \"><span class=\"initiated-label info-label\">Created on: </span><span class=\"initiated-date info-data\">";
                    // line 69
                    echo twig_escape_filter($this->env, $this->getAttribute($context["scheme"], "created_at", array()), "html", null, true);
                    echo "</span></li>
\t\t\t\t\t\t\t\t<li class=\"unit \"><span class=\"initiator-label info-label\">To be Initiated by: </span><span class=\"initiated-by info-data\">Mr. S</span></li>
\t\t\t\t\t\t\t\t<li class=\"unit \"><span class=\"reviewer-label info-label\">To be Reviewed by: </span><span class=\"reviewed-by info-data\">Mr. D</span></li>
\t\t\t\t\t\t\t\t<li class=\"unit \"><span class=\"status-label info-label\">Status: </span><span class=\"status info-data\">Saved as a Draft</span></li>

\t\t\t\t\t\t\t</ul>
\t\t\t\t\t\t</div>
\t\t\t\t\t</div>

\t\t\t\t</div>
\t\t\t";
                } elseif (($this->getAttribute(                // line 79
$context["scheme"], "state", array()) == $this->getAttribute($this->getAttribute((isset($context["items"]) ? $context["items"] : null), "states", array()), "updateRequested", array()))) {
                    // line 80
                    echo "\t\t\t\t<ul class=\"line-graph titles\">
\t\t\t\t\t<li class=\"unit size1of3\">
\t\t\t\t\t\t<ul class=\"line\">
\t\t\t\t\t\t\tUpdate Requested
\t\t\t\t\t\t</ul>
\t\t\t\t\t</li>
\t\t\t\t\t<li class=\"unit size1of3\">
\t\t\t\t\t\t<ul class=\"line\">
\t\t\t\t\t\t\tTo Be Reviewed
\t\t\t\t\t\t</ul>
\t\t\t\t\t</li>
\t\t\t\t\t<li class=\"unit size1of3\">
\t\t\t\t\t\t<ul class=\"line\">
\t\t\t\t\t\t\tTo Be Approved
\t\t\t\t\t\t</ul>
\t\t\t\t\t</li>
\t\t\t\t</ul>
\t\t\t    <ul class=\"line-graph\">
\t\t\t\t\t<li class=\"unit size1of3\">
\t\t\t\t\t\t<ul class=\"line\">
\t\t\t\t\t\t\t<li class=\"process-step processed-continuous\"></li>
\t\t\t\t\t\t</ul>
\t\t\t\t\t</li>
\t\t\t\t\t<li class=\"unit size1of3\">
\t\t\t\t\t\t<ul class=\"line\">
\t\t\t\t\t\t\t<li class=\"process-step inactive\"></li>
\t\t\t\t\t\t</ul>
\t\t\t\t\t</li>
\t\t\t\t\t<li class=\"unit size1of3\">
\t\t\t\t\t\t<ul class=\"line\">
\t\t\t\t\t\t\t<li class=\"process-step inactive\"></li>
\t\t\t\t\t\t</ul>
\t\t\t\t\t</li>
\t\t\t\t</ul>
\t\t\t\t<div class=\"scheme-state-details\">
\t\t\t\t\t<div class=\"granular-info-box\" style=\"display: none;\">
\t\t\t\t\t\t<div class=\"arrow\"></div>
\t\t\t\t\t\t<div class=\"details-content\">
\t\t\t\t\t\t\t<!-- <p class=\"scheme-title\">Scheme Name 001</p>
\t\t\t\t\t\t\t<p class=\"notification-info\">Notification received from Mr. A</p> -->
\t\t\t\t\t\t\t<ul class=\"granular-info\">
\t\t\t\t\t\t\t\t<li class=\"unit \"><span class=\"start-date-label info-label\">Start Date: </span><span class=\"start-date info-data\">";
                    // line 121
                    echo twig_escape_filter($this->env, $this->getAttribute($context["scheme"], "start_date", array()), "html", null, true);
                    echo "</span></li>
\t\t\t\t\t\t\t\t<li class=\"unit \"><span class=\"end-date-labe info-label\">End Date: </span><span class=\"end-date info-data\">";
                    // line 122
                    echo twig_escape_filter($this->env, $this->getAttribute($context["scheme"], "end_date", array()), "html", null, true);
                    echo "</span></li>
\t\t\t\t\t\t\t\t<li class=\"unit \"><span class=\"forecast-amount-label info-label\">Forecast Amount: </span><span class=\"forecast-amount info-data\">-</span></li>
\t\t\t\t\t\t\t\t<li class=\"unit \"><span class=\"initiated-label info-label\">Created on: </span><span class=\"initiated-date info-data\">";
                    // line 124
                    echo twig_escape_filter($this->env, $this->getAttribute($context["scheme"], "created_at", array()), "html", null, true);
                    echo "</span></li>
\t\t\t\t\t\t\t\t<li class=\"unit \"><span class=\"initiator-label info-label\">Initiated by: </span><span class=\"initiated-by info-data\">";
                    // line 125
                    echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($context["scheme"], "initiator", array()), "name", array()), "html", null, true);
                    echo "</span></li>
\t\t\t\t\t\t\t\t<li class=\"unit \"><span class=\"initiator-label info-label\">To be Updated by: </span><span class=\"initiated-by info-data\">";
                    // line 126
                    echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($context["scheme"], "initiator", array()), "name", array()), "html", null, true);
                    echo "</span></li>
\t\t\t\t\t\t\t\t<li class=\"unit \"><span class=\"reviewer-label info-label\">To be Reviewed by: </span><span class=\"reviewed-by info-data\">";
                    // line 127
                    echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($context["scheme"], "reviewer", array()), "name", array()), "html", null, true);
                    echo "</span></li>
\t\t\t\t\t\t\t\t<li class=\"unit \"><span class=\"reviewer-label info-label\">To be Approved by: </span><span class=\"reviewed-by info-data\">";
                    // line 128
                    echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($context["scheme"], "approver", array()), "name", array()), "html", null, true);
                    echo "</span></li>
\t\t\t\t\t\t\t\t<li class=\"unit \"><span class=\"status-label info-label\">Status: </span><span class=\"status info-data\">Saved as a Draft</span></li>

\t\t\t\t\t\t\t</ul>
\t\t\t\t\t\t</div>
\t\t\t\t\t</div>

\t\t\t\t</div>
\t\t\t";
                } elseif (($this->getAttribute(                // line 136
$context["scheme"], "state", array()) == $this->getAttribute($this->getAttribute((isset($context["items"]) ? $context["items"] : null), "states", array()), "initiated", array()))) {
                    // line 137
                    echo "\t\t\t\t<ul class=\"line-graph titles\">
\t\t\t\t\t<li class=\"unit size1of3\">
\t\t\t\t\t\t<ul class=\"line\">
\t\t\t\t\t\t\tInitiated
\t\t\t\t\t\t</ul>
\t\t\t\t\t</li>
\t\t\t\t\t<li class=\"unit size1of3\">
\t\t\t\t\t\t<ul class=\"line\">
\t\t\t\t\t\t\tTo Be Reviewed
\t\t\t\t\t\t</ul>
\t\t\t\t\t</li>
\t\t\t\t\t<li class=\"unit size1of3\">
\t\t\t\t\t\t<ul class=\"line\">
\t\t\t\t\t\t\tTo Be Approved
\t\t\t\t\t\t</ul>
\t\t\t\t\t</li>
\t\t\t\t</ul>
\t\t\t    <ul class=\"line-graph\">
\t\t\t\t\t<li class=\"unit size1of3\">
\t\t\t\t\t\t<ul class=\"line\">
\t\t\t\t\t\t\t<li class=\"process-step processed\"></li>
\t\t\t\t\t\t</ul>
\t\t\t\t\t</li>
\t\t\t\t\t<li class=\"unit size1of3\">
\t\t\t\t\t\t<ul class=\"line\">
\t\t\t\t\t\t\t<li class=\"process-step processed-continuous\"></li>
\t\t\t\t\t\t</ul>
\t\t\t\t\t</li>
\t\t\t\t\t<li class=\"unit size1of3\">
\t\t\t\t\t\t<ul class=\"line\">
\t\t\t\t\t\t\t<li class=\"process-step inactive\"></li>
\t\t\t\t\t\t</ul>
\t\t\t\t\t</li>
\t\t\t\t</ul>
\t\t\t\t<div class=\"scheme-state-details\">
\t\t\t\t\t<div class=\"granular-info-box\" style=\"display: none;\">
\t\t\t\t\t\t<div class=\"arrow\"></div>
\t\t\t\t\t\t<div class=\"details-content\">
\t\t\t\t\t\t\t<!-- <p class=\"scheme-title\">Scheme Name 001</p>
\t\t\t\t\t\t\t<p class=\"notification-info\">Notification received from Mr. A</p> -->
\t\t\t\t\t\t\t<ul class=\"granular-info\">
\t\t\t\t\t\t\t\t<li class=\"unit \"><span class=\"start-date-label info-label\">Start Date: </span><span class=\"start-date info-data\">";
                    // line 178
                    echo twig_escape_filter($this->env, $this->getAttribute($context["scheme"], "start_date", array()), "html", null, true);
                    echo "</span></li>
\t\t\t\t\t\t\t\t<li class=\"unit \"><span class=\"end-date-labe info-label\">End Date: </span><span class=\"end-date info-data\">";
                    // line 179
                    echo twig_escape_filter($this->env, $this->getAttribute($context["scheme"], "end_date", array()), "html", null, true);
                    echo "</span></li>
\t\t\t\t\t\t\t\t<li class=\"unit \"><span class=\"forecast-amount-label info-label\">Forecast Amount: </span><span class=\"forecast-amount info-data\">-</span></li>
\t\t\t\t\t\t\t\t<li class=\"unit \"><span class=\"initiated-label info-label\">Created on: </span><span class=\"initiated-date info-data\">";
                    // line 181
                    echo twig_escape_filter($this->env, $this->getAttribute($context["scheme"], "created_at", array()), "html", null, true);
                    echo "</span></li>
\t\t\t\t\t\t\t\t<li class=\"unit \"><span class=\"initiator-label info-label\">Initiated by: </span><span class=\"initiated-by info-data\">Mr. S</span></li>
\t\t\t\t\t\t\t\t<li class=\"unit \"><span class=\"reviewed-label info-label\">Initiated on: </span><span class=\"reviewed-date info-data\">-</span></li>
\t\t\t\t\t\t\t\t<li class=\"unit \"><span class=\"reviewer-label info-label\">To be Reviewed by: </span><span class=\"reviewed-by info-data\">Mr. D</span></li>
\t\t\t\t\t\t\t\t<li class=\"unit \"><span class=\"status-label info-label\">Status: </span><span class=\"status info-data\">Initiated</span></li>

\t\t\t\t\t\t\t</ul>
\t\t\t\t\t\t</div>
\t\t\t\t\t</div>

\t\t\t\t</div>
\t\t\t";
                } elseif (($this->getAttribute(                // line 192
$context["scheme"], "state", array()) == $this->getAttribute($this->getAttribute((isset($context["items"]) ? $context["items"] : null), "states", array()), "reviewed", array()))) {
                    // line 193
                    echo "\t\t\t\t<ul class=\"line-graph titles\">
\t\t\t\t\t<li class=\"unit size1of3\">
\t\t\t\t\t\t<ul class=\"line\">
\t\t\t\t\t\t\tInitiated
\t\t\t\t\t\t</ul>
\t\t\t\t\t</li>
\t\t\t\t\t<li class=\"unit size1of3\">
\t\t\t\t\t\t<ul class=\"line\">
\t\t\t\t\t\t\tReviewed
\t\t\t\t\t\t</ul>
\t\t\t\t\t</li>
\t\t\t\t\t<li class=\"unit size1of3\">
\t\t\t\t\t\t<ul class=\"line\">
\t\t\t\t\t\t\tTo Be Approved
\t\t\t\t\t\t</ul>
\t\t\t\t\t</li>
\t\t\t\t</ul>
\t\t\t    <ul class=\"line-graph\">
\t\t\t\t\t<li class=\"unit size1of3\">
\t\t\t\t\t\t<ul class=\"line\">
\t\t\t\t\t\t\t<li class=\"process-step processed\"></li>
\t\t\t\t\t\t</ul>
\t\t\t\t\t</li>
\t\t\t\t\t<li class=\"unit size1of3\">
\t\t\t\t\t\t<ul class=\"line\">
\t\t\t\t\t\t\t<li class=\"process-step processed\"></li>
\t\t\t\t\t\t</ul>
\t\t\t\t\t</li>
\t\t\t\t\t<li class=\"unit size1of3\">
\t\t\t\t\t\t<ul class=\"line\">
\t\t\t\t\t\t\t<li class=\"process-step processed-continuous\"></li>
\t\t\t\t\t\t</ul>
\t\t\t\t\t</li>
\t\t\t\t</ul>
\t\t\t\t<div class=\"scheme-state-details\">
\t\t\t\t\t<div class=\"granular-info-box\" style=\"display: none;\">
\t\t\t\t\t\t<div class=\"arrow\"></div>
\t\t\t\t\t\t<div class=\"details-content\">
\t\t\t\t\t\t\t<!-- <p class=\"scheme-title\">Scheme Name 001</p>
\t\t\t\t\t\t\t<p class=\"notification-info\">Notification received from Mr. A</p> -->
\t\t\t\t\t\t\t<ul class=\"granular-info\">
\t\t\t\t\t\t\t\t<li class=\"unit \"><span class=\"start-date-label info-label\">Start Date: </span><span class=\"start-date info-data\">";
                    // line 234
                    echo twig_escape_filter($this->env, $this->getAttribute($context["scheme"], "start_date", array()), "html", null, true);
                    echo "</span></li>
\t\t\t\t\t\t\t\t<li class=\"unit \"><span class=\"end-date-labe info-label\">End Date: </span><span class=\"end-date info-data\">";
                    // line 235
                    echo twig_escape_filter($this->env, $this->getAttribute($context["scheme"], "end_date", array()), "html", null, true);
                    echo "</span></li>
\t\t\t\t\t\t\t\t<li class=\"unit \"><span class=\"forecast-amount-label info-label\">Forecast Amount: </span><span class=\"forecast-amount info-data\">-</span></li>
\t\t\t\t\t\t\t\t<li class=\"unit \"><span class=\"initiated-label info-label\">Created on: </span><span class=\"initiated-date info-data\">";
                    // line 237
                    echo twig_escape_filter($this->env, $this->getAttribute($context["scheme"], "created_at", array()), "html", null, true);
                    echo "</span></li>
\t\t\t\t\t\t\t\t<li class=\"unit \"><span class=\"initiator-label info-label\">Initiated by: </span><span class=\"initiated-by info-data\">Mr. S</span></li>
\t\t\t\t\t\t\t\t<li class=\"unit \"><span class=\"reviewed-label info-label\">Reviewed on: </span><span class=\"reviewed-date info-data\">21 Sept 2013</span></li>
\t\t\t\t\t\t\t\t<li class=\"unit \"><span class=\"reviewer-label info-label\">Reviewed by: </span><span class=\"reviewed-by info-data\">Mr. D</span></li>
\t\t\t\t\t\t\t\t<li class=\"unit \"><span class=\"status-label info-label\">Status: </span><span class=\"status info-data\">Reviewd</span></li>

\t\t\t\t\t\t\t</ul>
\t\t\t\t\t\t</div>
\t\t\t\t\t</div>

\t\t\t\t</div>
\t\t\t";
                }
                // line 249
                echo "
\t\t\t\t
\t\t</div>
\t</div>
\t";
            }
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['scheme'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 255
        echo "
";
        // line 256
        if ((twig_length_filter($this->env, $this->getAttribute((isset($context["items"]) ? $context["items"] : null), "toBeReviewedSchemes", array())) > 0)) {
            // line 257
            echo "    <div class = \"list-header\">
\t\tSchemes Under My Review
\t</div>
";
        }
        // line 261
        echo "
";
        // line 262
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_ensure_traversable($this->getAttribute((isset($context["items"]) ? $context["items"] : null), "toBeReviewedSchemes", array()));
        foreach ($context['_seq'] as $context["_key"] => $context["scheme"]) {
            // line 263
            echo "\t";
            if ((((($this->getAttribute($context["scheme"], "state", array()) == $this->getAttribute($this->getAttribute((isset($context["items"]) ? $context["items"] : null), "states", array()), "staged", array())) || ($this->getAttribute($context["scheme"], "state", array()) == $this->getAttribute($this->getAttribute((isset($context["items"]) ? $context["items"] : null), "states", array()), "updateRequested", array()))) || ($this->getAttribute($context["scheme"], "state", array()) == $this->getAttribute($this->getAttribute((isset($context["items"]) ? $context["items"] : null), "states", array()), "initiated", array()))) || ($this->getAttribute($context["scheme"], "state", array()) == $this->getAttribute($this->getAttribute((isset($context["items"]) ? $context["items"] : null), "states", array()), "reviewed", array())))) {
                // line 264
                echo "    <div class=\"state-panel panel-solid-default col-lg-6 col-md-6 col-sm-12 col-xs-12\">
\t\t<div class=\"panel-heading\">

\t\t\t<div class=\"scheme-minimize-button\"><i class=\"fa fa-chevron-down\"></i></div>
\t\t\t<a class=\"scheme-link-button\" href = \"scheme?schemeId=";
                // line 268
                echo twig_escape_filter($this->env, $this->getAttribute($context["scheme"], "code", array()), "html", null, true);
                echo "&rand_token=";
                echo twig_escape_filter($this->env, $this->getAttribute((isset($context["items"]) ? $context["items"] : null), "nonce", array()), "html", null, true);
                echo "\"><i class=\"fa fa-external-link\"></i></a>
\t\t\t<h3 class=\"panel-title\">";
                // line 269
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
                // line 273
                if (($this->getAttribute($context["scheme"], "state", array()) == $this->getAttribute($this->getAttribute((isset($context["items"]) ? $context["items"] : null), "states", array()), "staged", array()))) {
                    // line 274
                    echo "\t\t\t\t<ul class=\"line-graph titles\">
\t\t\t\t\t<li class=\"unit size1of3\">
\t\t\t\t\t\t<ul class=\"line\">
\t\t\t\t\t\t\tInitiated
\t\t\t\t\t\t</ul>
\t\t\t\t\t</li>
\t\t\t\t\t<li class=\"unit size1of3\">
\t\t\t\t\t\t<ul class=\"line\">
\t\t\t\t\t\t\tReviewed
\t\t\t\t\t\t</ul>
\t\t\t\t\t</li>
\t\t\t\t\t<li class=\"unit size1of3\">
\t\t\t\t\t\t<ul class=\"line\">
\t\t\t\t\t\t\tApproved
\t\t\t\t\t\t</ul>
\t\t\t\t\t</li>
\t\t\t\t</ul>
\t\t\t    <ul class=\"line-graph\">
\t\t\t\t\t<li class=\"unit size1of3\">
\t\t\t\t\t\t<ul class=\"line\">
\t\t\t\t\t\t\t<li class=\"process-step processed-continuous\"></li>
\t\t\t\t\t\t</ul>
\t\t\t\t\t</li>
\t\t\t\t\t<li class=\"unit size1of3\">
\t\t\t\t\t\t<ul class=\"line\">
\t\t\t\t\t\t\t<li class=\"process-step inactive\"></li>
\t\t\t\t\t\t</ul>
\t\t\t\t\t</li>
\t\t\t\t\t<li class=\"unit size1of3\">
\t\t\t\t\t\t<ul class=\"line\">
\t\t\t\t\t\t\t<li class=\"process-step inactive\"></li>
\t\t\t\t\t\t</ul>
\t\t\t\t\t</li>
\t\t\t\t</ul>
\t\t\t\t<div class=\"scheme-state-details\">
\t\t\t\t\t<div class=\"granular-info-box\" style=\"display: none;\">
\t\t\t\t\t\t<div class=\"arrow\"></div>
\t\t\t\t\t\t<div class=\"details-content\">
\t\t\t\t\t\t\t<!-- <p class=\"scheme-title\">Scheme Name 001</p>
\t\t\t\t\t\t\t<p class=\"notification-info\">Notification received from Mr. A</p> -->
\t\t\t\t\t\t\t<ul class=\"granular-info\">
\t\t\t\t\t\t\t\t<li class=\"unit \"><span class=\"start-date-label info-label\">Start Date: </span><span class=\"start-date info-data\">";
                    // line 315
                    echo twig_escape_filter($this->env, $this->getAttribute($context["scheme"], "start_date", array()), "html", null, true);
                    echo "</span></li>
\t\t\t\t\t\t\t\t<li class=\"unit \"><span class=\"end-date-labe info-label\">End Date: </span><span class=\"end-date info-data\">";
                    // line 316
                    echo twig_escape_filter($this->env, $this->getAttribute($context["scheme"], "end_date", array()), "html", null, true);
                    echo "</span></li>
\t\t\t\t\t\t\t\t<li class=\"unit \"><span class=\"forecast-amount-label info-label\">Forecast Amount: </span><span class=\"forecast-amount info-data\">-</span></li>
\t\t\t\t\t\t\t\t<li class=\"unit \"><span class=\"initiated-label info-label\">Created on: </span><span class=\"initiated-date info-data\">";
                    // line 318
                    echo twig_escape_filter($this->env, $this->getAttribute($context["scheme"], "created_at", array()), "html", null, true);
                    echo "</span></li>
\t\t\t\t\t\t\t\t<li class=\"unit \"><span class=\"initiator-label info-label\">To be Initiated by: </span><span class=\"initiated-by info-data\">Mr. S</span></li>
\t\t\t\t\t\t\t\t<li class=\"unit \"><span class=\"reviewer-label info-label\">To be Reviewed by: </span><span class=\"reviewed-by info-data\">Mr. D</span></li>
\t\t\t\t\t\t\t\t<li class=\"unit \"><span class=\"status-label info-label\">Status: </span><span class=\"status info-data\">Saved as a Draft</span></li>

\t\t\t\t\t\t\t</ul>
\t\t\t\t\t\t</div>
\t\t\t\t\t</div>

\t\t\t\t</div>
\t\t\t";
                } elseif (($this->getAttribute(                // line 328
$context["scheme"], "state", array()) == $this->getAttribute($this->getAttribute((isset($context["items"]) ? $context["items"] : null), "states", array()), "updateRequested", array()))) {
                    // line 329
                    echo "\t\t\t\t<ul class=\"line-graph titles\">
\t\t\t\t\t<li class=\"unit size1of3\">
\t\t\t\t\t\t<ul class=\"line\">
\t\t\t\t\t\t\tUpdate Requested
\t\t\t\t\t\t</ul>
\t\t\t\t\t</li>
\t\t\t\t\t<li class=\"unit size1of3\">
\t\t\t\t\t\t<ul class=\"line\">
\t\t\t\t\t\t\tTo Be Reviewed
\t\t\t\t\t\t</ul>
\t\t\t\t\t</li>
\t\t\t\t\t<li class=\"unit size1of3\">
\t\t\t\t\t\t<ul class=\"line\">
\t\t\t\t\t\t\tTo Be Approved
\t\t\t\t\t\t</ul>
\t\t\t\t\t</li>
\t\t\t\t</ul>
\t\t\t    <ul class=\"line-graph\">
\t\t\t\t\t<li class=\"unit size1of3\">
\t\t\t\t\t\t<ul class=\"line\">
\t\t\t\t\t\t\t<li class=\"process-step processed-continuous\"></li>
\t\t\t\t\t\t</ul>
\t\t\t\t\t</li>
\t\t\t\t\t<li class=\"unit size1of3\">
\t\t\t\t\t\t<ul class=\"line\">
\t\t\t\t\t\t\t<li class=\"process-step inactive\"></li>
\t\t\t\t\t\t</ul>
\t\t\t\t\t</li>
\t\t\t\t\t<li class=\"unit size1of3\">
\t\t\t\t\t\t<ul class=\"line\">
\t\t\t\t\t\t\t<li class=\"process-step inactive\"></li>
\t\t\t\t\t\t</ul>
\t\t\t\t\t</li>
\t\t\t\t</ul>
\t\t\t\t<div class=\"scheme-state-details\">
\t\t\t\t\t<div class=\"granular-info-box\" style=\"display: none;\">
\t\t\t\t\t\t<div class=\"arrow\"></div>
\t\t\t\t\t\t<div class=\"details-content\">
\t\t\t\t\t\t\t<!-- <p class=\"scheme-title\">Scheme Name 001</p>
\t\t\t\t\t\t\t<p class=\"notification-info\">Notification received from Mr. A</p> -->
\t\t\t\t\t\t\t<ul class=\"granular-info\">
\t\t\t\t\t\t\t\t<li class=\"unit \"><span class=\"start-date-label info-label\">Start Date: </span><span class=\"start-date info-data\">";
                    // line 370
                    echo twig_escape_filter($this->env, $this->getAttribute($context["scheme"], "start_date", array()), "html", null, true);
                    echo "</span></li>
\t\t\t\t\t\t\t\t<li class=\"unit \"><span class=\"end-date-labe info-label\">End Date: </span><span class=\"end-date info-data\">";
                    // line 371
                    echo twig_escape_filter($this->env, $this->getAttribute($context["scheme"], "end_date", array()), "html", null, true);
                    echo "</span></li>
\t\t\t\t\t\t\t\t<li class=\"unit \"><span class=\"forecast-amount-label info-label\">Forecast Amount: </span><span class=\"forecast-amount info-data\">-</span></li>
\t\t\t\t\t\t\t\t<li class=\"unit \"><span class=\"initiated-label info-label\">Created on: </span><span class=\"initiated-date info-data\">";
                    // line 373
                    echo twig_escape_filter($this->env, $this->getAttribute($context["scheme"], "created_at", array()), "html", null, true);
                    echo "</span></li>
\t\t\t\t\t\t\t\t<li class=\"unit \"><span class=\"initiator-label info-label\">Initiated by: </span><span class=\"initiated-by info-data\">";
                    // line 374
                    echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($context["scheme"], "initiator", array()), "name", array()), "html", null, true);
                    echo "</span></li>
\t\t\t\t\t\t\t\t<li class=\"unit \"><span class=\"initiator-label info-label\">To be Updated by: </span><span class=\"initiated-by info-data\">";
                    // line 375
                    echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($context["scheme"], "initiator", array()), "name", array()), "html", null, true);
                    echo "</span></li>
\t\t\t\t\t\t\t\t<li class=\"unit \"><span class=\"reviewer-label info-label\">To be Reviewed by: </span><span class=\"reviewed-by info-data\">";
                    // line 376
                    echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($context["scheme"], "reviewer", array()), "name", array()), "html", null, true);
                    echo "</span></li>
\t\t\t\t\t\t\t\t<li class=\"unit \"><span class=\"reviewer-label info-label\">To be Approved by: </span><span class=\"reviewed-by info-data\">";
                    // line 377
                    echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($context["scheme"], "approver", array()), "name", array()), "html", null, true);
                    echo "</span></li>
\t\t\t\t\t\t\t\t<li class=\"unit \"><span class=\"status-label info-label\">Status: </span><span class=\"status info-data\">Saved as a Draft</span></li>

\t\t\t\t\t\t\t</ul>
\t\t\t\t\t\t</div>
\t\t\t\t\t</div>

\t\t\t\t</div>
\t\t\t";
                } elseif (($this->getAttribute(                // line 385
$context["scheme"], "state", array()) == $this->getAttribute($this->getAttribute((isset($context["items"]) ? $context["items"] : null), "states", array()), "initiated", array()))) {
                    // line 386
                    echo "\t\t\t\t<ul class=\"line-graph titles\">
\t\t\t\t\t<li class=\"unit size1of3\">
\t\t\t\t\t\t<ul class=\"line\">
\t\t\t\t\t\t\tInitiated
\t\t\t\t\t\t</ul>
\t\t\t\t\t</li>
\t\t\t\t\t<li class=\"unit size1of3\">
\t\t\t\t\t\t<ul class=\"line\">
\t\t\t\t\t\t\tTo Be Reviewed
\t\t\t\t\t\t</ul>
\t\t\t\t\t</li>
\t\t\t\t\t<li class=\"unit size1of3\">
\t\t\t\t\t\t<ul class=\"line\">
\t\t\t\t\t\t\tTo Be Approved
\t\t\t\t\t\t</ul>
\t\t\t\t\t</li>
\t\t\t\t</ul>
\t\t\t    <ul class=\"line-graph\">
\t\t\t\t\t<li class=\"unit size1of3\">
\t\t\t\t\t\t<ul class=\"line\">
\t\t\t\t\t\t\t<li class=\"process-step processed\"></li>
\t\t\t\t\t\t</ul>
\t\t\t\t\t</li>
\t\t\t\t\t<li class=\"unit size1of3\">
\t\t\t\t\t\t<ul class=\"line\">
\t\t\t\t\t\t\t<li class=\"process-step processed-continuous\"></li>
\t\t\t\t\t\t</ul>
\t\t\t\t\t</li>
\t\t\t\t\t<li class=\"unit size1of3\">
\t\t\t\t\t\t<ul class=\"line\">
\t\t\t\t\t\t\t<li class=\"process-step inactive\"></li>
\t\t\t\t\t\t</ul>
\t\t\t\t\t</li>
\t\t\t\t</ul>
\t\t\t\t<div class=\"scheme-state-details\">
\t\t\t\t\t<div class=\"granular-info-box\" style=\"display: none;\">
\t\t\t\t\t\t<div class=\"arrow\"></div>
\t\t\t\t\t\t<div class=\"details-content\">
\t\t\t\t\t\t\t<!-- <p class=\"scheme-title\">Scheme Name 001</p>
\t\t\t\t\t\t\t<p class=\"notification-info\">Notification received from Mr. A</p> -->
\t\t\t\t\t\t\t<ul class=\"granular-info\">
\t\t\t\t\t\t\t\t<li class=\"unit \"><span class=\"start-date-label info-label\">Start Date: </span><span class=\"start-date info-data\">";
                    // line 427
                    echo twig_escape_filter($this->env, $this->getAttribute($context["scheme"], "start_date", array()), "html", null, true);
                    echo "</span></li>
\t\t\t\t\t\t\t\t<li class=\"unit \"><span class=\"end-date-labe info-label\">End Date: </span><span class=\"end-date info-data\">";
                    // line 428
                    echo twig_escape_filter($this->env, $this->getAttribute($context["scheme"], "end_date", array()), "html", null, true);
                    echo "</span></li>
\t\t\t\t\t\t\t\t<li class=\"unit \"><span class=\"forecast-amount-label info-label\">Forecast Amount: </span><span class=\"forecast-amount info-data\">-</span></li>
\t\t\t\t\t\t\t\t<li class=\"unit \"><span class=\"initiated-label info-label\">Created on: </span><span class=\"initiated-date info-data\">";
                    // line 430
                    echo twig_escape_filter($this->env, $this->getAttribute($context["scheme"], "created_at", array()), "html", null, true);
                    echo "</span></li>
\t\t\t\t\t\t\t\t<li class=\"unit \"><span class=\"initiator-label info-label\">Initiated by: </span><span class=\"initiated-by info-data\">Mr. S</span></li>
\t\t\t\t\t\t\t\t<li class=\"unit \"><span class=\"reviewed-label info-label\">Initiated on: </span><span class=\"reviewed-date info-data\">-</span></li>
\t\t\t\t\t\t\t\t<li class=\"unit \"><span class=\"reviewer-label info-label\">To be Reviewed by: </span><span class=\"reviewed-by info-data\">Mr. D</span></li>
\t\t\t\t\t\t\t\t<li class=\"unit \"><span class=\"status-label info-label\">Status: </span><span class=\"status info-data\">Initiated</span></li>

\t\t\t\t\t\t\t</ul>
\t\t\t\t\t\t</div>
\t\t\t\t\t</div>

\t\t\t\t</div>
\t\t\t";
                } elseif (($this->getAttribute(                // line 441
$context["scheme"], "state", array()) == $this->getAttribute($this->getAttribute((isset($context["items"]) ? $context["items"] : null), "states", array()), "reviewed", array()))) {
                    // line 442
                    echo "\t\t\t\t<ul class=\"line-graph titles\">
\t\t\t\t\t<li class=\"unit size1of3\">
\t\t\t\t\t\t<ul class=\"line\">
\t\t\t\t\t\t\tInitiated
\t\t\t\t\t\t</ul>
\t\t\t\t\t</li>
\t\t\t\t\t<li class=\"unit size1of3\">
\t\t\t\t\t\t<ul class=\"line\">
\t\t\t\t\t\t\tReviewed
\t\t\t\t\t\t</ul>
\t\t\t\t\t</li>
\t\t\t\t\t<li class=\"unit size1of3\">
\t\t\t\t\t\t<ul class=\"line\">
\t\t\t\t\t\t\tTo Be Approved
\t\t\t\t\t\t</ul>
\t\t\t\t\t</li>
\t\t\t\t</ul>
\t\t\t    <ul class=\"line-graph\">
\t\t\t\t\t<li class=\"unit size1of3\">
\t\t\t\t\t\t<ul class=\"line\">
\t\t\t\t\t\t\t<li class=\"process-step processed\"></li>
\t\t\t\t\t\t</ul>
\t\t\t\t\t</li>
\t\t\t\t\t<li class=\"unit size1of3\">
\t\t\t\t\t\t<ul class=\"line\">
\t\t\t\t\t\t\t<li class=\"process-step processed\"></li>
\t\t\t\t\t\t</ul>
\t\t\t\t\t</li>
\t\t\t\t\t<li class=\"unit size1of3\">
\t\t\t\t\t\t<ul class=\"line\">
\t\t\t\t\t\t\t<li class=\"process-step processed-continuous\"></li>
\t\t\t\t\t\t</ul>
\t\t\t\t\t</li>
\t\t\t\t</ul>
\t\t\t\t<div class=\"scheme-state-details\">
\t\t\t\t\t<div class=\"granular-info-box\" style=\"display: none;\">
\t\t\t\t\t\t<div class=\"arrow\"></div>
\t\t\t\t\t\t<div class=\"details-content\">
\t\t\t\t\t\t\t<!-- <p class=\"scheme-title\">Scheme Name 001</p>
\t\t\t\t\t\t\t<p class=\"notification-info\">Notification received from Mr. A</p> -->
\t\t\t\t\t\t\t<ul class=\"granular-info\">
\t\t\t\t\t\t\t\t<li class=\"unit \"><span class=\"start-date-label info-label\">Start Date: </span><span class=\"start-date info-data\">";
                    // line 483
                    echo twig_escape_filter($this->env, $this->getAttribute($context["scheme"], "start_date", array()), "html", null, true);
                    echo "</span></li>
\t\t\t\t\t\t\t\t<li class=\"unit \"><span class=\"end-date-labe info-label\">End Date: </span><span class=\"end-date info-data\">";
                    // line 484
                    echo twig_escape_filter($this->env, $this->getAttribute($context["scheme"], "end_date", array()), "html", null, true);
                    echo "</span></li>
\t\t\t\t\t\t\t\t<li class=\"unit \"><span class=\"forecast-amount-label info-label\">Forecast Amount: </span><span class=\"forecast-amount info-data\">-</span></li>
\t\t\t\t\t\t\t\t<li class=\"unit \"><span class=\"initiated-label info-label\">Created on: </span><span class=\"initiated-date info-data\">";
                    // line 486
                    echo twig_escape_filter($this->env, $this->getAttribute($context["scheme"], "created_at", array()), "html", null, true);
                    echo "</span></li>
\t\t\t\t\t\t\t\t<li class=\"unit \"><span class=\"initiator-label info-label\">Initiated by: </span><span class=\"initiated-by info-data\">Mr. S</span></li>
\t\t\t\t\t\t\t\t<li class=\"unit \"><span class=\"reviewed-label info-label\">Reviewed on: </span><span class=\"reviewed-date info-data\">21 Sept 2013</span></li>
\t\t\t\t\t\t\t\t<li class=\"unit \"><span class=\"reviewer-label info-label\">Reviewed by: </span><span class=\"reviewed-by info-data\">Mr. D</span></li>
\t\t\t\t\t\t\t\t<li class=\"unit \"><span class=\"status-label info-label\">Status: </span><span class=\"status info-data\">Reviewd</span></li>

\t\t\t\t\t\t\t</ul>
\t\t\t\t\t\t</div>
\t\t\t\t\t</div>

\t\t\t\t</div>
\t\t\t
\t\t\t";
                }
                // line 499
                echo "
\t\t\t\t
\t\t</div>
\t</div>
\t";
            }
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['scheme'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 505
        echo "

";
        // line 507
        if ((twig_length_filter($this->env, $this->getAttribute((isset($context["items"]) ? $context["items"] : null), "toBeApprovedSchemes", array())) > 0)) {
            // line 508
            echo "    <div class = \"list-header\">
\t\tSchemes Under My Approval
\t</div>
";
        }
        // line 512
        echo "\t
";
        // line 513
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_ensure_traversable($this->getAttribute((isset($context["items"]) ? $context["items"] : null), "toBeApprovedSchemes", array()));
        foreach ($context['_seq'] as $context["_key"] => $context["scheme"]) {
            // line 514
            echo "\t";
            if ((((($this->getAttribute($context["scheme"], "state", array()) == $this->getAttribute($this->getAttribute((isset($context["items"]) ? $context["items"] : null), "states", array()), "staged", array())) || ($this->getAttribute($context["scheme"], "state", array()) == $this->getAttribute($this->getAttribute((isset($context["items"]) ? $context["items"] : null), "states", array()), "updateRequested", array()))) || ($this->getAttribute($context["scheme"], "state", array()) == $this->getAttribute($this->getAttribute((isset($context["items"]) ? $context["items"] : null), "states", array()), "initiated", array()))) || ($this->getAttribute($context["scheme"], "state", array()) == $this->getAttribute($this->getAttribute((isset($context["items"]) ? $context["items"] : null), "states", array()), "reviewed", array())))) {
                // line 515
                echo "    <div class=\"state-panel panel-solid-default col-lg-6 col-md-6 col-sm-12 col-xs-12\">
\t\t<div class=\"panel-heading\">

\t\t\t<div class=\"scheme-minimize-button\"><i class=\"fa fa-chevron-down\"></i></div>
\t\t\t<a class=\"scheme-link-button\" href = \"scheme?schemeId=";
                // line 519
                echo twig_escape_filter($this->env, $this->getAttribute($context["scheme"], "code", array()), "html", null, true);
                echo "&rand_token=";
                echo twig_escape_filter($this->env, $this->getAttribute((isset($context["items"]) ? $context["items"] : null), "nonce", array()), "html", null, true);
                echo "\"><i class=\"fa fa-external-link\"></i></a>
\t\t\t<h3 class=\"panel-title\">";
                // line 520
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
                // line 524
                if (($this->getAttribute($context["scheme"], "state", array()) == $this->getAttribute($this->getAttribute((isset($context["items"]) ? $context["items"] : null), "states", array()), "staged", array()))) {
                    // line 525
                    echo "\t\t\t\t<ul class=\"line-graph titles\">
\t\t\t\t\t<li class=\"unit size1of3\">
\t\t\t\t\t\t<ul class=\"line\">
\t\t\t\t\t\t\tInitiated
\t\t\t\t\t\t</ul>
\t\t\t\t\t</li>
\t\t\t\t\t<li class=\"unit size1of3\">
\t\t\t\t\t\t<ul class=\"line\">
\t\t\t\t\t\t\tReviewed
\t\t\t\t\t\t</ul>
\t\t\t\t\t</li>
\t\t\t\t\t<li class=\"unit size1of3\">
\t\t\t\t\t\t<ul class=\"line\">
\t\t\t\t\t\t\tApproved
\t\t\t\t\t\t</ul>
\t\t\t\t\t</li>
\t\t\t\t</ul>
\t\t\t    <ul class=\"line-graph\">
\t\t\t\t\t<li class=\"unit size1of3\">
\t\t\t\t\t\t<ul class=\"line\">
\t\t\t\t\t\t\t<li class=\"process-step processed-continuous\"></li>
\t\t\t\t\t\t</ul>
\t\t\t\t\t</li>
\t\t\t\t\t<li class=\"unit size1of3\">
\t\t\t\t\t\t<ul class=\"line\">
\t\t\t\t\t\t\t<li class=\"process-step inactive\"></li>
\t\t\t\t\t\t</ul>
\t\t\t\t\t</li>
\t\t\t\t\t<li class=\"unit size1of3\">
\t\t\t\t\t\t<ul class=\"line\">
\t\t\t\t\t\t\t<li class=\"process-step inactive\"></li>
\t\t\t\t\t\t</ul>
\t\t\t\t\t</li>
\t\t\t\t</ul>
\t\t\t\t<div class=\"scheme-state-details\">
\t\t\t\t\t<div class=\"granular-info-box\" style=\"display: none;\">
\t\t\t\t\t\t<div class=\"arrow\"></div>
\t\t\t\t\t\t<div class=\"details-content\">
\t\t\t\t\t\t\t<!-- <p class=\"scheme-title\">Scheme Name 001</p>
\t\t\t\t\t\t\t<p class=\"notification-info\">Notification received from Mr. A</p> -->
\t\t\t\t\t\t\t<ul class=\"granular-info\">
\t\t\t\t\t\t\t\t<li class=\"unit \"><span class=\"start-date-label info-label\">Start Date: </span><span class=\"start-date info-data\">";
                    // line 566
                    echo twig_escape_filter($this->env, $this->getAttribute($context["scheme"], "start_date", array()), "html", null, true);
                    echo "</span></li>
\t\t\t\t\t\t\t\t<li class=\"unit \"><span class=\"end-date-labe info-label\">End Date: </span><span class=\"end-date info-data\">";
                    // line 567
                    echo twig_escape_filter($this->env, $this->getAttribute($context["scheme"], "end_date", array()), "html", null, true);
                    echo "</span></li>
\t\t\t\t\t\t\t\t<li class=\"unit \"><span class=\"forecast-amount-label info-label\">Forecast Amount: </span><span class=\"forecast-amount info-data\">-</span></li>
\t\t\t\t\t\t\t\t<li class=\"unit \"><span class=\"initiated-label info-label\">Created on: </span><span class=\"initiated-date info-data\">";
                    // line 569
                    echo twig_escape_filter($this->env, $this->getAttribute($context["scheme"], "created_at", array()), "html", null, true);
                    echo "</span></li>
\t\t\t\t\t\t\t\t<li class=\"unit \"><span class=\"initiator-label info-label\">To be Initiated by: </span><span class=\"initiated-by info-data\">Mr. S</span></li>
\t\t\t\t\t\t\t\t<li class=\"unit \"><span class=\"reviewer-label info-label\">To be Reviewed by: </span><span class=\"reviewed-by info-data\">Mr. D</span></li>
\t\t\t\t\t\t\t\t<li class=\"unit \"><span class=\"status-label info-label\">Status: </span><span class=\"status info-data\">Saved as a Draft</span></li>

\t\t\t\t\t\t\t</ul>
\t\t\t\t\t\t</div>
\t\t\t\t\t</div>

\t\t\t\t</div>
\t\t\t";
                } elseif (($this->getAttribute(                // line 579
$context["scheme"], "state", array()) == $this->getAttribute($this->getAttribute((isset($context["items"]) ? $context["items"] : null), "states", array()), "updateRequested", array()))) {
                    // line 580
                    echo "\t\t\t\t<ul class=\"line-graph titles\">
\t\t\t\t\t<li class=\"unit size1of3\">
\t\t\t\t\t\t<ul class=\"line\">
\t\t\t\t\t\t\tUpdate Requested
\t\t\t\t\t\t</ul>
\t\t\t\t\t</li>
\t\t\t\t\t<li class=\"unit size1of3\">
\t\t\t\t\t\t<ul class=\"line\">
\t\t\t\t\t\t\tTo Be Reviewed
\t\t\t\t\t\t</ul>
\t\t\t\t\t</li>
\t\t\t\t\t<li class=\"unit size1of3\">
\t\t\t\t\t\t<ul class=\"line\">
\t\t\t\t\t\t\tTo Be Approved
\t\t\t\t\t\t</ul>
\t\t\t\t\t</li>
\t\t\t\t</ul>
\t\t\t    <ul class=\"line-graph\">
\t\t\t\t\t<li class=\"unit size1of3\">
\t\t\t\t\t\t<ul class=\"line\">
\t\t\t\t\t\t\t<li class=\"process-step processed-continuous\"></li>
\t\t\t\t\t\t</ul>
\t\t\t\t\t</li>
\t\t\t\t\t<li class=\"unit size1of3\">
\t\t\t\t\t\t<ul class=\"line\">
\t\t\t\t\t\t\t<li class=\"process-step inactive\"></li>
\t\t\t\t\t\t</ul>
\t\t\t\t\t</li>
\t\t\t\t\t<li class=\"unit size1of3\">
\t\t\t\t\t\t<ul class=\"line\">
\t\t\t\t\t\t\t<li class=\"process-step inactive\"></li>
\t\t\t\t\t\t</ul>
\t\t\t\t\t</li>
\t\t\t\t</ul>
\t\t\t\t<div class=\"scheme-state-details\">
\t\t\t\t\t<div class=\"granular-info-box\" style=\"display: none;\">
\t\t\t\t\t\t<div class=\"arrow\"></div>
\t\t\t\t\t\t<div class=\"details-content\">
\t\t\t\t\t\t\t<!-- <p class=\"scheme-title\">Scheme Name 001</p>
\t\t\t\t\t\t\t<p class=\"notification-info\">Notification received from Mr. A</p> -->
\t\t\t\t\t\t\t<ul class=\"granular-info\">
\t\t\t\t\t\t\t\t<li class=\"unit \"><span class=\"start-date-label info-label\">Start Date: </span><span class=\"start-date info-data\">";
                    // line 621
                    echo twig_escape_filter($this->env, $this->getAttribute($context["scheme"], "start_date", array()), "html", null, true);
                    echo "</span></li>
\t\t\t\t\t\t\t\t<li class=\"unit \"><span class=\"end-date-labe info-label\">End Date: </span><span class=\"end-date info-data\">";
                    // line 622
                    echo twig_escape_filter($this->env, $this->getAttribute($context["scheme"], "end_date", array()), "html", null, true);
                    echo "</span></li>
\t\t\t\t\t\t\t\t<li class=\"unit \"><span class=\"forecast-amount-label info-label\">Forecast Amount: </span><span class=\"forecast-amount info-data\">-</span></li>
\t\t\t\t\t\t\t\t<li class=\"unit \"><span class=\"initiated-label info-label\">Created on: </span><span class=\"initiated-date info-data\">";
                    // line 624
                    echo twig_escape_filter($this->env, $this->getAttribute($context["scheme"], "created_at", array()), "html", null, true);
                    echo "</span></li>
\t\t\t\t\t\t\t\t<li class=\"unit \"><span class=\"initiator-label info-label\">Initiated by: </span><span class=\"initiated-by info-data\">";
                    // line 625
                    echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($context["scheme"], "initiator", array()), "name", array()), "html", null, true);
                    echo "</span></li>
\t\t\t\t\t\t\t\t<li class=\"unit \"><span class=\"initiator-label info-label\">To be Updated by: </span><span class=\"initiated-by info-data\">";
                    // line 626
                    echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($context["scheme"], "initiator", array()), "name", array()), "html", null, true);
                    echo "</span></li>
\t\t\t\t\t\t\t\t<li class=\"unit \"><span class=\"reviewer-label info-label\">To be Reviewed by: </span><span class=\"reviewed-by info-data\">";
                    // line 627
                    echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($context["scheme"], "reviewer", array()), "name", array()), "html", null, true);
                    echo "</span></li>
\t\t\t\t\t\t\t\t<li class=\"unit \"><span class=\"reviewer-label info-label\">To be Approved by: </span><span class=\"reviewed-by info-data\">";
                    // line 628
                    echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($context["scheme"], "approver", array()), "name", array()), "html", null, true);
                    echo "</span></li>
\t\t\t\t\t\t\t\t<li class=\"unit \"><span class=\"status-label info-label\">Status: </span><span class=\"status info-data\">Saved as a Draft</span></li>

\t\t\t\t\t\t\t</ul>
\t\t\t\t\t\t</div>
\t\t\t\t\t</div>

\t\t\t\t</div>
\t\t\t";
                } elseif (($this->getAttribute(                // line 636
$context["scheme"], "state", array()) == $this->getAttribute($this->getAttribute((isset($context["items"]) ? $context["items"] : null), "states", array()), "initiated", array()))) {
                    // line 637
                    echo "\t\t\t\t<ul class=\"line-graph titles\">
\t\t\t\t\t<li class=\"unit size1of3\">
\t\t\t\t\t\t<ul class=\"line\">
\t\t\t\t\t\t\tInitiated
\t\t\t\t\t\t</ul>
\t\t\t\t\t</li>
\t\t\t\t\t<li class=\"unit size1of3\">
\t\t\t\t\t\t<ul class=\"line\">
\t\t\t\t\t\t\tTo Be Reviewed
\t\t\t\t\t\t</ul>
\t\t\t\t\t</li>
\t\t\t\t\t<li class=\"unit size1of3\">
\t\t\t\t\t\t<ul class=\"line\">
\t\t\t\t\t\t\tTo Be Approved
\t\t\t\t\t\t</ul>
\t\t\t\t\t</li>
\t\t\t\t</ul>
\t\t\t    <ul class=\"line-graph\">
\t\t\t\t\t<li class=\"unit size1of3\">
\t\t\t\t\t\t<ul class=\"line\">
\t\t\t\t\t\t\t<li class=\"process-step processed\"></li>
\t\t\t\t\t\t</ul>
\t\t\t\t\t</li>
\t\t\t\t\t<li class=\"unit size1of3\">
\t\t\t\t\t\t<ul class=\"line\">
\t\t\t\t\t\t\t<li class=\"process-step processed-continuous\"></li>
\t\t\t\t\t\t</ul>
\t\t\t\t\t</li>
\t\t\t\t\t<li class=\"unit size1of3\">
\t\t\t\t\t\t<ul class=\"line\">
\t\t\t\t\t\t\t<li class=\"process-step inactive\"></li>
\t\t\t\t\t\t</ul>
\t\t\t\t\t</li>
\t\t\t\t</ul>
\t\t\t\t<div class=\"scheme-state-details\">
\t\t\t\t\t<div class=\"granular-info-box\" style=\"display: none;\">
\t\t\t\t\t\t<div class=\"arrow\"></div>
\t\t\t\t\t\t<div class=\"details-content\">
\t\t\t\t\t\t\t<!-- <p class=\"scheme-title\">Scheme Name 001</p>
\t\t\t\t\t\t\t<p class=\"notification-info\">Notification received from Mr. A</p> -->
\t\t\t\t\t\t\t<ul class=\"granular-info\">
\t\t\t\t\t\t\t\t<li class=\"unit \"><span class=\"start-date-label info-label\">Start Date: </span><span class=\"start-date info-data\">";
                    // line 678
                    echo twig_escape_filter($this->env, $this->getAttribute($context["scheme"], "start_date", array()), "html", null, true);
                    echo "</span></li>
\t\t\t\t\t\t\t\t<li class=\"unit \"><span class=\"end-date-labe info-label\">End Date: </span><span class=\"end-date info-data\">";
                    // line 679
                    echo twig_escape_filter($this->env, $this->getAttribute($context["scheme"], "end_date", array()), "html", null, true);
                    echo "</span></li>
\t\t\t\t\t\t\t\t<li class=\"unit \"><span class=\"forecast-amount-label info-label\">Forecast Amount: </span><span class=\"forecast-amount info-data\">-</span></li>
\t\t\t\t\t\t\t\t<li class=\"unit \"><span class=\"initiated-label info-label\">Created on: </span><span class=\"initiated-date info-data\">";
                    // line 681
                    echo twig_escape_filter($this->env, $this->getAttribute($context["scheme"], "created_at", array()), "html", null, true);
                    echo "</span></li>
\t\t\t\t\t\t\t\t<li class=\"unit \"><span class=\"initiator-label info-label\">Initiated by: </span><span class=\"initiated-by info-data\">Mr. S</span></li>
\t\t\t\t\t\t\t\t<li class=\"unit \"><span class=\"reviewed-label info-label\">Initiated on: </span><span class=\"reviewed-date info-data\">-</span></li>
\t\t\t\t\t\t\t\t<li class=\"unit \"><span class=\"reviewer-label info-label\">To be Reviewed by: </span><span class=\"reviewed-by info-data\">Mr. D</span></li>
\t\t\t\t\t\t\t\t<li class=\"unit \"><span class=\"status-label info-label\">Status: </span><span class=\"status info-data\">Initiated</span></li>

\t\t\t\t\t\t\t</ul>
\t\t\t\t\t\t</div>
\t\t\t\t\t</div>

\t\t\t\t</div>
\t\t\t";
                } elseif (($this->getAttribute(                // line 692
$context["scheme"], "state", array()) == $this->getAttribute($this->getAttribute((isset($context["items"]) ? $context["items"] : null), "states", array()), "reviewed", array()))) {
                    // line 693
                    echo "\t\t\t\t<ul class=\"line-graph titles\">
\t\t\t\t\t<li class=\"unit size1of3\">
\t\t\t\t\t\t<ul class=\"line\">
\t\t\t\t\t\t\tInitiated
\t\t\t\t\t\t</ul>
\t\t\t\t\t</li>
\t\t\t\t\t<li class=\"unit size1of3\">
\t\t\t\t\t\t<ul class=\"line\">
\t\t\t\t\t\t\tReviewed
\t\t\t\t\t\t</ul>
\t\t\t\t\t</li>
\t\t\t\t\t<li class=\"unit size1of3\">
\t\t\t\t\t\t<ul class=\"line\">
\t\t\t\t\t\t\tTo Be Approved
\t\t\t\t\t\t</ul>
\t\t\t\t\t</li>
\t\t\t\t</ul>
\t\t\t    <ul class=\"line-graph\">
\t\t\t\t\t<li class=\"unit size1of3\">
\t\t\t\t\t\t<ul class=\"line\">
\t\t\t\t\t\t\t<li class=\"process-step processed\"></li>
\t\t\t\t\t\t</ul>
\t\t\t\t\t</li>
\t\t\t\t\t<li class=\"unit size1of3\">
\t\t\t\t\t\t<ul class=\"line\">
\t\t\t\t\t\t\t<li class=\"process-step processed\"></li>
\t\t\t\t\t\t</ul>
\t\t\t\t\t</li>
\t\t\t\t\t<li class=\"unit size1of3\">
\t\t\t\t\t\t<ul class=\"line\">
\t\t\t\t\t\t\t<li class=\"process-step processed-continuous\"></li>
\t\t\t\t\t\t</ul>
\t\t\t\t\t</li>
\t\t\t\t</ul>
\t\t\t\t<div class=\"scheme-state-details\">
\t\t\t\t\t<div class=\"granular-info-box\" style=\"display: none;\">
\t\t\t\t\t\t<div class=\"arrow\"></div>
\t\t\t\t\t\t<div class=\"details-content\">
\t\t\t\t\t\t\t<!-- <p class=\"scheme-title\">Scheme Name 001</p>
\t\t\t\t\t\t\t<p class=\"notification-info\">Notification received from Mr. A</p> -->
\t\t\t\t\t\t\t<ul class=\"granular-info\">
\t\t\t\t\t\t\t\t<li class=\"unit \"><span class=\"start-date-label info-label\">Start Date: </span><span class=\"start-date info-data\">";
                    // line 734
                    echo twig_escape_filter($this->env, $this->getAttribute($context["scheme"], "start_date", array()), "html", null, true);
                    echo "</span></li>
\t\t\t\t\t\t\t\t<li class=\"unit \"><span class=\"end-date-labe info-label\">End Date: </span><span class=\"end-date info-data\">";
                    // line 735
                    echo twig_escape_filter($this->env, $this->getAttribute($context["scheme"], "end_date", array()), "html", null, true);
                    echo "</span></li>
\t\t\t\t\t\t\t\t<li class=\"unit \"><span class=\"forecast-amount-label info-label\">Forecast Amount: </span><span class=\"forecast-amount info-data\">-</span></li>
\t\t\t\t\t\t\t\t<li class=\"unit \"><span class=\"initiated-label info-label\">Created on: </span><span class=\"initiated-date info-data\">";
                    // line 737
                    echo twig_escape_filter($this->env, $this->getAttribute($context["scheme"], "created_at", array()), "html", null, true);
                    echo "</span></li>
\t\t\t\t\t\t\t\t<li class=\"unit \"><span class=\"initiator-label info-label\">Initiated by: </span><span class=\"initiated-by info-data\">Mr. S</span></li>
\t\t\t\t\t\t\t\t<li class=\"unit \"><span class=\"reviewed-label info-label\">Reviewed on: </span><span class=\"reviewed-date info-data\">21 Sept 2013</span></li>
\t\t\t\t\t\t\t\t<li class=\"unit \"><span class=\"reviewer-label info-label\">Reviewed by: </span><span class=\"reviewed-by info-data\">Mr. D</span></li>
\t\t\t\t\t\t\t\t<li class=\"unit \"><span class=\"status-label info-label\">Status: </span><span class=\"status info-data\">Reviewd</span></li>

\t\t\t\t\t\t\t</ul>
\t\t\t\t\t\t</div>
\t\t\t\t\t</div>

\t\t\t\t</div>
\t\t\t";
                }
                // line 749
                echo "
\t\t\t\t
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
        return "schemesPendingApproval.tmpl";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  1049 => 749,  1034 => 737,  1029 => 735,  1025 => 734,  982 => 693,  980 => 692,  966 => 681,  961 => 679,  957 => 678,  914 => 637,  912 => 636,  901 => 628,  897 => 627,  893 => 626,  889 => 625,  885 => 624,  880 => 622,  876 => 621,  833 => 580,  831 => 579,  818 => 569,  813 => 567,  809 => 566,  766 => 525,  764 => 524,  751 => 520,  745 => 519,  739 => 515,  736 => 514,  732 => 513,  729 => 512,  723 => 508,  721 => 507,  717 => 505,  706 => 499,  690 => 486,  685 => 484,  681 => 483,  638 => 442,  636 => 441,  622 => 430,  617 => 428,  613 => 427,  570 => 386,  568 => 385,  557 => 377,  553 => 376,  549 => 375,  545 => 374,  541 => 373,  536 => 371,  532 => 370,  489 => 329,  487 => 328,  474 => 318,  469 => 316,  465 => 315,  422 => 274,  420 => 273,  407 => 269,  401 => 268,  395 => 264,  392 => 263,  388 => 262,  385 => 261,  379 => 257,  377 => 256,  374 => 255,  363 => 249,  348 => 237,  343 => 235,  339 => 234,  296 => 193,  294 => 192,  280 => 181,  275 => 179,  271 => 178,  228 => 137,  226 => 136,  215 => 128,  211 => 127,  207 => 126,  203 => 125,  199 => 124,  194 => 122,  190 => 121,  147 => 80,  145 => 79,  132 => 69,  127 => 67,  123 => 66,  80 => 25,  78 => 24,  65 => 20,  62 => 19,  54 => 17,  46 => 15,  44 => 14,  37 => 9,  34 => 8,  30 => 7,  27 => 6,  21 => 2,  19 => 1,);
    }
}
