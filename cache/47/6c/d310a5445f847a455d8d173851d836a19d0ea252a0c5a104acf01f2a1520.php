<?php

/* schemesPendingApproval.tmpl */
class __TwigTemplate_476cd310a5445f847a455d8d173851d836a19d0ea252a0c5a104acf01f2a1520 extends Twig_Template
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
                } elseif (($this->getAttribute($context["scheme"], "state", array()) == $this->getAttribute($this->getAttribute((isset($context["items"]) ? $context["items"] : null), "states", array()), "updateRequested", array()))) {
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
                } elseif (($this->getAttribute($context["scheme"], "state", array()) == $this->getAttribute($this->getAttribute((isset($context["items"]) ? $context["items"] : null), "states", array()), "initiated", array()))) {
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
                } elseif (($this->getAttribute($context["scheme"], "state", array()) == $this->getAttribute($this->getAttribute((isset($context["items"]) ? $context["items"] : null), "states", array()), "reviewed", array()))) {
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
                } elseif (($this->getAttribute($context["scheme"], "state", array()) == $this->getAttribute($this->getAttribute((isset($context["items"]) ? $context["items"] : null), "states", array()), "updateRequested", array()))) {
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
                } elseif (($this->getAttribute($context["scheme"], "state", array()) == $this->getAttribute($this->getAttribute((isset($context["items"]) ? $context["items"] : null), "states", array()), "initiated", array()))) {
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
                } elseif (($this->getAttribute($context["scheme"], "state", array()) == $this->getAttribute($this->getAttribute((isset($context["items"]) ? $context["items"] : null), "states", array()), "reviewed", array()))) {
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
                } elseif (($this->getAttribute($context["scheme"], "state", array()) == $this->getAttribute($this->getAttribute((isset($context["items"]) ? $context["items"] : null), "states", array()), "updateRequested", array()))) {
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
                } elseif (($this->getAttribute($context["scheme"], "state", array()) == $this->getAttribute($this->getAttribute((isset($context["items"]) ? $context["items"] : null), "states", array()), "initiated", array()))) {
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
                } elseif (($this->getAttribute($context["scheme"], "state", array()) == $this->getAttribute($this->getAttribute((isset($context["items"]) ? $context["items"] : null), "states", array()), "reviewed", array()))) {
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
        return array (  1040 => 749,  1025 => 737,  1020 => 735,  1016 => 734,  973 => 693,  958 => 681,  953 => 679,  949 => 678,  906 => 637,  894 => 628,  890 => 627,  886 => 626,  882 => 625,  878 => 624,  873 => 622,  869 => 621,  826 => 580,  812 => 569,  807 => 567,  803 => 566,  760 => 525,  758 => 524,  745 => 520,  739 => 519,  733 => 515,  730 => 514,  726 => 513,  723 => 512,  717 => 508,  715 => 507,  711 => 505,  700 => 499,  684 => 486,  679 => 484,  675 => 483,  632 => 442,  617 => 430,  612 => 428,  608 => 427,  565 => 386,  553 => 377,  549 => 376,  545 => 375,  541 => 374,  537 => 373,  532 => 371,  528 => 370,  485 => 329,  471 => 318,  466 => 316,  462 => 315,  419 => 274,  417 => 273,  404 => 269,  398 => 268,  392 => 264,  389 => 263,  385 => 262,  382 => 261,  376 => 257,  374 => 256,  371 => 255,  360 => 249,  345 => 237,  340 => 235,  336 => 234,  293 => 193,  278 => 181,  273 => 179,  269 => 178,  226 => 137,  214 => 128,  210 => 127,  206 => 126,  202 => 125,  198 => 124,  193 => 122,  189 => 121,  146 => 80,  132 => 69,  127 => 67,  123 => 66,  80 => 25,  78 => 24,  65 => 20,  62 => 19,  54 => 17,  46 => 15,  44 => 14,  37 => 9,  34 => 8,  30 => 7,  27 => 6,  21 => 2,  19 => 1,);
    }
}
