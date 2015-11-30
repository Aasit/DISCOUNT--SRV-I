<?php

/* schemeDetails.tmpl */
class __TwigTemplate_2cbf1d05c3ef8756b65075e88b2f8617058b4a12155f6aaf896ad0ccdd71e4c8 extends Twig_Template
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
";
        // line 2
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_ensure_traversable($this->getAttribute((isset($context["items"]) ? $context["items"] : null), "schemesPendingApproval", array()));
        foreach ($context['_seq'] as $context["_key"] => $context["scheme"]) {
            // line 3
            echo "    <div class=\"state-panel panel-solid-default\">
\t\t<div class=\"panel-heading\">

\t\t\t<div class=\"scheme-minimize-button\"><i class=\"fa fa-chevron-down\"></i></div>
\t\t\t";
            // line 7
            if ((($this->getAttribute($context["scheme"], "state", array()) == $this->getAttribute($this->getAttribute((isset($context["items"]) ? $context["items"] : null), "states", array()), "staged", array())) || ($this->getAttribute($context["scheme"], "state", array()) == $this->getAttribute($this->getAttribute((isset($context["items"]) ? $context["items"] : null), "states", array()), "updateRequested", array())))) {
                // line 8
                echo "\t\t\t\t<a class=\"scheme-link-button\" href = \"template?schemeId=";
                echo twig_escape_filter($this->env, $this->getAttribute($context["scheme"], "code", array()), "html", null, true);
                echo "&rand_token=";
                echo twig_escape_filter($this->env, $this->getAttribute((isset($context["items"]) ? $context["items"] : null), "nonce", array()), "html", null, true);
                echo "\"><i class=\"fa fa-external-link\"></i></a>
\t\t\t";
            } else {
                // line 10
                echo "\t\t\t\t<a class=\"scheme-link-button\" href = \"scheme?schemeId=";
                echo twig_escape_filter($this->env, $this->getAttribute($context["scheme"], "code", array()), "html", null, true);
                echo "&rand_token=";
                echo twig_escape_filter($this->env, $this->getAttribute((isset($context["items"]) ? $context["items"] : null), "nonce", array()), "html", null, true);
                echo "\"><i class=\"fa fa-external-link\"></i></a>
\t\t\t";
            }
            // line 12
            echo "\t\t\t<h3 class=\"panel-title\">";
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
            // line 16
            if (($this->getAttribute($context["scheme"], "state", array()) == $this->getAttribute($this->getAttribute((isset($context["items"]) ? $context["items"] : null), "states", array()), "staged", array()))) {
                // line 17
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
                // line 58
                echo twig_escape_filter($this->env, $this->getAttribute($context["scheme"], "start_date", array()), "html", null, true);
                echo "</span></li>
\t\t\t\t\t\t\t\t<li class=\"unit \"><span class=\"end-date-labe info-label\">End Date: </span><span class=\"end-date info-data\">";
                // line 59
                echo twig_escape_filter($this->env, $this->getAttribute($context["scheme"], "end_date", array()), "html", null, true);
                echo "</span></li>
\t\t\t\t\t\t\t\t<li class=\"unit \"><span class=\"forecast-amount-label info-label\">Forecast Amount: </span><span class=\"forecast-amount info-data\">-</span></li>
\t\t\t\t\t\t\t\t<li class=\"unit \"><span class=\"initiated-label info-label\">Created on: </span><span class=\"initiated-date info-data\">";
                // line 61
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
            } elseif (($this->getAttribute(            // line 71
$context["scheme"], "state", array()) == $this->getAttribute($this->getAttribute((isset($context["items"]) ? $context["items"] : null), "states", array()), "updateRequested", array()))) {
                // line 72
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
                // line 113
                echo twig_escape_filter($this->env, $this->getAttribute($context["scheme"], "start_date", array()), "html", null, true);
                echo "</span></li>
\t\t\t\t\t\t\t\t<li class=\"unit \"><span class=\"end-date-labe info-label\">End Date: </span><span class=\"end-date info-data\">";
                // line 114
                echo twig_escape_filter($this->env, $this->getAttribute($context["scheme"], "end_date", array()), "html", null, true);
                echo "</span></li>
\t\t\t\t\t\t\t\t<li class=\"unit \"><span class=\"forecast-amount-label info-label\">Forecast Amount: </span><span class=\"forecast-amount info-data\">-</span></li>
\t\t\t\t\t\t\t\t<li class=\"unit \"><span class=\"initiated-label info-label\">Created on: </span><span class=\"initiated-date info-data\">";
                // line 116
                echo twig_escape_filter($this->env, $this->getAttribute($context["scheme"], "created_at", array()), "html", null, true);
                echo "</span></li>
\t\t\t\t\t\t\t\t<li class=\"unit \"><span class=\"initiator-label info-label\">Initiated by: </span><span class=\"initiated-by info-data\">";
                // line 117
                echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($context["scheme"], "initiator", array()), "name", array()), "html", null, true);
                echo "</span></li>
\t\t\t\t\t\t\t\t<li class=\"unit \"><span class=\"initiator-label info-label\">To be Updated by: </span><span class=\"initiated-by info-data\">";
                // line 118
                echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($context["scheme"], "initiator", array()), "name", array()), "html", null, true);
                echo "</span></li>
\t\t\t\t\t\t\t\t<li class=\"unit \"><span class=\"reviewer-label info-label\">To be Reviewed by: </span><span class=\"reviewed-by info-data\">";
                // line 119
                echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($context["scheme"], "reviewer", array()), "name", array()), "html", null, true);
                echo "</span></li>
\t\t\t\t\t\t\t\t<li class=\"unit \"><span class=\"reviewer-label info-label\">To be Approved by: </span><span class=\"reviewed-by info-data\">";
                // line 120
                echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($context["scheme"], "approver", array()), "name", array()), "html", null, true);
                echo "</span></li>
\t\t\t\t\t\t\t\t<li class=\"unit \"><span class=\"status-label info-label\">Status: </span><span class=\"status info-data\">Saved as a Draft</span></li>

\t\t\t\t\t\t\t</ul>
\t\t\t\t\t\t</div>
\t\t\t\t\t</div>

\t\t\t\t</div>
\t\t\t";
            } elseif (($this->getAttribute(            // line 128
$context["scheme"], "state", array()) == $this->getAttribute($this->getAttribute((isset($context["items"]) ? $context["items"] : null), "states", array()), "initiated", array()))) {
                // line 129
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
                // line 170
                echo twig_escape_filter($this->env, $this->getAttribute($context["scheme"], "start_date", array()), "html", null, true);
                echo "</span></li>
\t\t\t\t\t\t\t\t<li class=\"unit \"><span class=\"end-date-labe info-label\">End Date: </span><span class=\"end-date info-data\">";
                // line 171
                echo twig_escape_filter($this->env, $this->getAttribute($context["scheme"], "end_date", array()), "html", null, true);
                echo "</span></li>
\t\t\t\t\t\t\t\t<li class=\"unit \"><span class=\"forecast-amount-label info-label\">Forecast Amount: </span><span class=\"forecast-amount info-data\">-</span></li>
\t\t\t\t\t\t\t\t<li class=\"unit \"><span class=\"initiated-label info-label\">Created on: </span><span class=\"initiated-date info-data\">";
                // line 173
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
            } elseif (($this->getAttribute(            // line 184
$context["scheme"], "state", array()) == $this->getAttribute($this->getAttribute((isset($context["items"]) ? $context["items"] : null), "states", array()), "reviewed", array()))) {
                // line 185
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
                // line 226
                echo twig_escape_filter($this->env, $this->getAttribute($context["scheme"], "start_date", array()), "html", null, true);
                echo "</span></li>
\t\t\t\t\t\t\t\t<li class=\"unit \"><span class=\"end-date-labe info-label\">End Date: </span><span class=\"end-date info-data\">";
                // line 227
                echo twig_escape_filter($this->env, $this->getAttribute($context["scheme"], "end_date", array()), "html", null, true);
                echo "</span></li>
\t\t\t\t\t\t\t\t<li class=\"unit \"><span class=\"forecast-amount-label info-label\">Forecast Amount: </span><span class=\"forecast-amount info-data\">-</span></li>
\t\t\t\t\t\t\t\t<li class=\"unit \"><span class=\"initiated-label info-label\">Created on: </span><span class=\"initiated-date info-data\">";
                // line 229
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
            } elseif (($this->getAttribute(            // line 240
$context["scheme"], "state", array()) == $this->getAttribute($this->getAttribute((isset($context["items"]) ? $context["items"] : null), "states", array()), "approved", array()))) {
                // line 241
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
\t\t\t\t<ul class=\"line-graph\">
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
\t\t\t\t\t\t\t<li class=\"process-step processed\"></li>
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
                // line 282
                echo twig_escape_filter($this->env, $this->getAttribute($context["scheme"], "start_date", array()), "html", null, true);
                echo "</span></li>
\t\t\t\t\t\t\t\t<li class=\"unit \"><span class=\"end-date-labe info-label\">End Date: </span><span class=\"end-date info-data\">";
                // line 283
                echo twig_escape_filter($this->env, $this->getAttribute($context["scheme"], "end_date", array()), "html", null, true);
                echo "</span></li>
\t\t\t\t\t\t\t\t<li class=\"unit \"><span class=\"forecast-amount-label info-label\">Forecast Amount: </span><span class=\"forecast-amount info-data\">-</span></li>
\t\t\t\t\t\t\t\t<li class=\"unit \"><span class=\"initiated-label info-label\">Created on: </span><span class=\"initiated-date info-data\">";
                // line 285
                echo twig_escape_filter($this->env, $this->getAttribute($context["scheme"], "created_at", array()), "html", null, true);
                echo "</span></li>
\t\t\t\t\t\t\t\t<li class=\"unit \"><span class=\"initiator-label info-label\">Initiated by: </span><span class=\"initiated-by info-data\">Mr. S</span></li>
\t\t\t\t\t\t\t\t<li class=\"unit \"><span class=\"reviewed-label info-label\">Reviewed on: </span><span class=\"reviewed-date info-data\">21 Sept 2013</span></li>
\t\t\t\t\t\t\t\t<li class=\"unit \"><span class=\"reviewer-label info-label\">Reviewed by: </span><span class=\"reviewed-by info-data\">Mr. D</span></li>
\t\t\t\t\t\t\t\t<li class=\"unit \"><span class=\"status-label info-label\">Status: </span><span class=\"status info-data\">Approved</span></li>

\t\t\t\t\t\t\t</ul>
\t\t\t\t\t\t</div>
\t\t\t\t\t</div>

\t\t\t\t</div>
\t\t\t";
            }
            // line 297
            echo "
\t\t\t\t
\t\t</div>
\t</div>
";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['scheme'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 302
        echo "\t";
    }

    public function getTemplateName()
    {
        return "schemeDetails.tmpl";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  427 => 302,  417 => 297,  402 => 285,  397 => 283,  393 => 282,  350 => 241,  348 => 240,  334 => 229,  329 => 227,  325 => 226,  282 => 185,  280 => 184,  266 => 173,  261 => 171,  257 => 170,  214 => 129,  212 => 128,  201 => 120,  197 => 119,  193 => 118,  189 => 117,  185 => 116,  180 => 114,  176 => 113,  133 => 72,  131 => 71,  118 => 61,  113 => 59,  109 => 58,  66 => 17,  64 => 16,  50 => 12,  42 => 10,  34 => 8,  32 => 7,  26 => 3,  22 => 2,  19 => 1,);
    }
}
