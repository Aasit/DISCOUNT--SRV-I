<?php

/* dashboard.tmpl */
class __TwigTemplate_c2abf50d41460f1b4ee1f45f346ff6398ab82690cd0453c826a6d3d45f59bb7e extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 1
        $this->parent = $this->loadTemplate("base.html", "dashboard.tmpl", 1);
        $this->blocks = array(
            'title' => array($this, 'block_title'),
            'header' => array($this, 'block_header'),
            'content' => array($this, 'block_content'),
            'footer' => array($this, 'block_footer'),
            'scripts' => array($this, 'block_scripts'),
        );
    }

    protected function doGetParent(array $context)
    {
        return "base.html";
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 3
    public function block_title($context, array $blocks = array())
    {
        echo "Dashboard";
    }

    // line 5
    public function block_header($context, array $blocks = array())
    {
        echo " 
    ";
        // line 6
        $this->loadTemplate("header.tmpl", "dashboard.tmpl", 6)->display($context);
        echo " 
";
    }

    // line 9
    public function block_content($context, array $blocks = array())
    {
        // line 10
        echo "<section>
";
        // line 11
        $this->loadTemplate("menu.tmpl", "dashboard.tmpl", 11)->display($context);
        // line 12
        echo "<section id=\"content-wrapper\">  
\t\t\t<div class = \"dashboard-content\">
\t\t\t\t<div class = \"dashboard-container\">
\t\t\t\t\t<div class = \"data-panels\">
\t\t\t\t\t\t<div class=\"row state-overview\">
\t\t\t\t\t\t\t<div class=\"col-lg-3 col-sm-6 col-xs-12\">
\t\t\t\t\t\t\t\t<section class=\"panel\">
\t\t\t\t\t\t\t\t\t<div class=\"symbol terques\">
\t\t\t\t\t\t\t\t\t\t<i class=\"fa fa-info\"></i>
\t\t\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t\t\t<div class=\"value\">
\t\t\t\t\t\t\t\t\t\t<h1 class=\"count\">";
        // line 23
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context["items"]) ? $context["items"] : null), "stats", array()), "initiated", array()), "html", null, true);
        echo "</h1>
\t\t\t\t\t\t\t\t\t\t<p>Schemes Initiated</p>
\t\t\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t\t</section>
\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t<div class=\"col-lg-3 col-sm-6 col-xs-12\">
\t\t\t\t\t\t\t\t<section class=\"panel\">
\t\t\t\t\t\t\t\t<div class=\"symbol orange\">
\t\t\t\t\t\t\t\t\t\t<i class=\"fa fa-archive\"></i>
\t\t\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t\t\t<div class=\"value\">
\t\t\t\t\t\t\t\t\t\t<h1 class=\" count2\">";
        // line 34
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context["items"]) ? $context["items"] : null), "stats", array()), "pending", array()), "html", null, true);
        echo "</h1>
\t\t\t\t\t\t\t\t\t\t<p>Schemes Pending Approval</p>
\t\t\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t\t</section>
\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t<div class=\"col-lg-3 col-sm-6 col-xs-12\">
\t\t\t\t\t\t\t\t<section class=\"panel\">
\t\t\t\t\t\t\t\t\t<div class=\"symbol green\">
\t\t\t\t\t\t\t\t\t\t<i class=\"fa fa-check\"></i>
\t\t\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t\t\t<div class=\"value\">
\t\t\t\t\t\t\t\t\t\t<h1 class=\" count3\">";
        // line 45
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context["items"]) ? $context["items"] : null), "stats", array()), "active", array()), "html", null, true);
        echo "</h1>
\t\t\t\t\t\t\t\t\t\t<p>Active Schemes</p>
\t\t\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t\t</section>
\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t<div class=\"col-lg-3 col-sm-6 col-xs-12\">
\t\t\t\t\t\t\t\t<section class=\"panel\">
\t\t\t\t\t\t\t\t\t<div class=\"symbol violet\">
\t\t\t\t\t\t\t\t\t\t<i class=\"fa fa-thumbs-up\"></i>
\t\t\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t\t\t<div class=\"value\">
\t\t\t\t\t\t\t\t\t\t<h1 class=\" count4\">";
        // line 56
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context["items"]) ? $context["items"] : null), "stats", array()), "concluded", array()), "html", null, true);
        echo "</h1>
\t\t\t\t\t\t\t\t\t\t<p>Schemes Concluded</p>
\t\t\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t\t</section>
\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t</div>
\t\t\t\t\t</div>

\t\t\t\t\t<div class = \"data-graphs\">
\t\t\t\t\t\t<div class = \"row\">
\t\t\t\t\t\t\t<div class = \"col-lg-12 col-sm-12 col-xs-12 active-schemes-container\">
\t\t\t\t\t\t\t\t<div  id = \"active-scheme-content-card\" >

\t\t\t\t\t\t\t\t\t<div class = \"filter-filter\">
\t\t\t\t\t\t\t\t\t\t<div class = \"filter-slider\">
\t\t\t\t\t\t\t\t\t\t\t<div class = \"slider-title\">
\t\t\t\t\t\t\t\t\t\t\t\tPayout Estimate Till date / Forecast Amount :
\t\t\t\t\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t\t\t\t\t<div class = \"range-slider\"></div>
\t\t\t\t\t\t\t\t\t\t\t<div class = \"slider-labels\">
\t\t\t\t\t\t\t\t\t\t\t\t<span class = \"slider-label-left\">0</span>
\t\t\t\t\t\t\t\t\t\t\t\t<span class = \"slider-label-right\">100</span>
\t\t\t\t\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t\t\t\t<div class = \"filter-type filter-checkbox-group\">
\t\t\t\t\t\t\t\t\t\t\t<div class = \"filter-block-title\">
\t\t\t\t\t\t\t\t\t\t\t\tType of Scheme:
\t\t\t\t\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t\t\t\t\t<div class = \"checkbox-container first\">
\t\t\t\t\t\t\t\t\t\t\t\t<input type=\"checkbox\" name=\"inBill\"><span class = \"checkbox-label\">inBill</span>
\t\t\t\t\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t\t\t\t\t<div class = \"checkbox-container\">
\t\t\t\t\t\t\t\t\t\t\t\t<input type=\"checkbox\" name=\"monthly\"><span class = \"checkbox-label\">Monthly</span>
\t\t\t\t\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t\t\t\t\t<div class = \"checkbox-container\">
\t\t\t\t\t\t\t\t\t\t\t\t<input type=\"checkbox\" name=\"tieup\"><span class = \"checkbox-label\">Tie Up</span>
\t\t\t\t\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t\t\t\t\t<div class = \"checkbox-container\">
\t\t\t\t\t\t\t\t\t\t\t\t<input type=\"checkbox\" name=\"ppipri\"><span class = \"checkbox-label\">PPI/PRI</span>
\t\t\t\t\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t\t\t\t\t<div class = \"checkbox-container\">
\t\t\t\t\t\t\t\t\t\t\t\t<input type=\"checkbox\" name=\"atrqtr\"><span class = \"checkbox-label\">ATR/QTR</span>
\t\t\t\t\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t\t\t\t\t<div class = \"checkbox-container\">
\t\t\t\t\t\t\t\t\t\t\t\t<input type=\"checkbox\" name=\"club\"><span class = \"checkbox-label\">Club</span>
\t\t\t\t\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t\t\t\t<div class = \"filter-geography\">
\t\t\t\t\t\t\t\t\t\t\t<div class = \"filter-block-title\">
\t\t\t\t\t\t\t\t\t\t\t\tGeography:
\t\t\t\t\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t\t\t\t\t<input type = \"text\" class = \"filter-search\" placeholder = \"Search\">
\t\t\t\t\t\t\t\t\t\t</div>

\t\t\t\t\t\t\t\t\t\t<div class = \"filter-checkbox-tree\"></div>
\t\t\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t\t\t<div class = \"filter-content\">
\t\t\t\t\t\t\t\t\t\t<div class = \"col-lg-12 col-sm-12 col-xs-12 elements-container\">
\t\t\t\t\t\t\t\t\t\t\t<button class = \"button-simple filter-toggle\"><i class = \"fa fa-filter\"></i>Filter</button>
\t\t\t\t\t\t\t\t\t\t\t<span class = \"button-group\">
\t\t\t\t\t\t\t\t\t\t\t\t<button class = \"button-simple\">MTD</button>
\t\t\t\t\t\t\t\t\t\t\t\t<button class = \"button-simple\">YTD</button>
\t\t\t\t\t\t\t\t\t\t\t\t<button class = \"button-simple\">YTM</button>
\t\t\t\t\t\t\t\t\t\t\t</span>
\t\t\t\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t\t\t\t<div id = \"active-scheme-content\" class = \"col-lg-12 col-sm-12 col-xs-12\"></div>
\t\t\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t</div>

\t\t\t\t\t\t<div class = \"row\">
\t\t\t\t\t\t\t<div class = \"col-lg-12 col-sm-12 col-xs-12\">
\t\t\t\t\t\t\t\t<div  id = \"scheme-budget-utilization\" >
\t\t\t\t\t\t\t\t\t<div class = \"filter-filter\">

\t\t\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t\t\t<div class = \"filter-content\">
\t\t\t\t\t\t\t\t\t\t<div class = \"col-lg-12 col-sm-12 col-xs-12 elements-container\">
\t\t\t\t\t\t\t\t\t\t\t<button class = \"button-simple filter-toggle\"><i class = \"fa fa-filter\"></i>Filter</button>
\t\t\t\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t\t\t
\t\t\t\t\t\t\t\t\t\t";
        // line 138
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_ensure_traversable($this->getAttribute((isset($context["items"]) ? $context["items"] : null), "badges", array()));
        foreach ($context['_seq'] as $context["_key"] => $context["item"]) {
            // line 139
            echo "\t\t\t\t\t\t\t\t\t\t<div class = \"col-lg-3 col-md-6 col-sm-6 col-xs-12 panel-chart-container\">
\t\t\t\t\t\t\t\t\t\t\t<div class = \"col-lg-12 col-sm-12 col-xs-12 panel-chart\">
\t\t\t\t\t\t\t\t\t\t\t\t<div class=\"col-lg-6 col-xs-6 col-md-6 col-sm-6 text-center\">
\t\t\t\t\t\t\t\t\t\t\t\t\t<div class=\"panel-chart-text\">
\t\t\t\t\t\t\t\t\t\t\t\t\t\t<span class = \"circular-chart-title\">";
            // line 143
            echo twig_escape_filter($this->env, $this->getAttribute($context["item"], "title", array()), "html", null, true);
            echo "</span>
\t\t\t\t\t\t\t\t\t\t\t\t\t\t<span class = \"circular-chart-estimate tooltip\" tip-title=\"Payout Estimate till date\">&#8377;";
            // line 144
            echo twig_escape_filter($this->env, $this->getAttribute($context["item"], "estimate", array()), "html", null, true);
            echo "</span>
\t\t\t\t\t\t\t\t\t\t\t\t\t\t<hr class = \"circular-chart-divider\">
\t\t\t\t\t\t\t\t\t\t\t\t\t\t<span class = \"circular-chart-forecast tooltip\" tip-title=\"Payout Forecast Amount\">&#8377;";
            // line 146
            echo twig_escape_filter($this->env, $this->getAttribute($context["item"], "forcast", array()), "html", null, true);
            echo "</span>
\t\t\t\t\t\t\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t\t\t\t\t\t<div class=\"col-lg-6 col-sm-6 col-xs-6 col-md-6 text-center\">
\t\t\t\t\t\t\t\t\t\t\t\t\t<div class=\"easy-pie-chart\">
\t\t\t\t\t\t\t\t\t\t\t\t\t\t<div class=\"panel-circular-chart\" data-percent=\"35\" style=\"width: 135px; height: 135px; line-height: 135px;\"><span>";
            // line 151
            echo twig_escape_filter($this->env, $this->getAttribute($context["item"], "percent", array()), "html", null, true);
            echo "</span>%</div>
\t\t\t\t\t\t\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t\t\t\t\t</div>\t\t\t\t\t\t\t\t\t\t
\t\t\t\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t\t\t\t";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['item'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 157
        echo "\t\t\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t</div>

\t\t\t\t\t\t<div class = \"row\">
\t\t\t\t\t\t\t<div class = \"col-lg-6 col-sm-12 col-xs-12\">
\t\t\t\t\t\t\t\t<div id = \"schemes-pending-approval\">
\t\t\t\t\t\t\t\t\t<div class=\"state-panel panel-solid-default\">
\t\t\t\t\t\t\t\t\t\t<div class=\"panel-heading\">
\t\t\t\t\t\t\t\t\t\t\t<h3 class=\"panel-title\">Scheme Name 001</h3>
\t\t\t\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t\t\t\t<div class=\"panel-body\">
\t\t\t\t\t\t\t\t\t\t\t<ul class=\"line-graph titles\">
\t\t\t\t\t\t\t\t\t\t\t\t<li class=\"unit size1of3\">
\t\t\t\t\t\t\t\t\t\t\t\t\t<ul class=\"line\">
\t\t\t\t\t\t\t\t\t\t\t\t\t\tInitiated
\t\t\t\t\t\t\t\t\t\t\t\t\t</ul>
\t\t\t\t\t\t\t\t\t\t\t\t</li>
\t\t\t\t\t\t\t\t\t\t\t\t<li class=\"unit size1of3\">
\t\t\t\t\t\t\t\t\t\t\t\t\t<ul class=\"line\">
\t\t\t\t\t\t\t\t\t\t\t\t\t\tReviewed
\t\t\t\t\t\t\t\t\t\t\t\t\t</ul>
\t\t\t\t\t\t\t\t\t\t\t\t</li>
\t\t\t\t\t\t\t\t\t\t\t\t<li class=\"unit size1of3\">
\t\t\t\t\t\t\t\t\t\t\t\t\t<ul class=\"line\">
\t\t\t\t\t\t\t\t\t\t\t\t\t\tApproved
\t\t\t\t\t\t\t\t\t\t\t\t\t</ul>
\t\t\t\t\t\t\t\t\t\t\t\t</li>
\t\t\t\t\t\t\t\t\t\t\t</ul>
\t\t\t\t\t\t\t\t\t\t\t<ul class=\"line-graph\">
\t\t\t\t\t\t\t\t\t\t\t\t<li class=\"unit size1of3\">
\t\t\t\t\t\t\t\t\t\t\t\t\t<ul class=\"line\">
\t\t\t\t\t\t\t\t\t\t\t\t\t\t<li class=\"process-step processed\"></li>
\t\t\t\t\t\t\t\t\t\t\t\t\t</ul>
\t\t\t\t\t\t\t\t\t\t\t\t</li>
\t\t\t\t\t\t\t\t\t\t\t\t<li class=\"unit size1of3\">
\t\t\t\t\t\t\t\t\t\t\t\t\t<ul class=\"line\">
\t\t\t\t\t\t\t\t\t\t\t\t\t\t<li class=\"process-step processed-continuous\"></li>
\t\t\t\t\t\t\t\t\t\t\t\t\t</ul>
\t\t\t\t\t\t\t\t\t\t\t\t</li>
\t\t\t\t\t\t\t\t\t\t\t\t<li class=\"unit size1of3\">
\t\t\t\t\t\t\t\t\t\t\t\t\t<ul class=\"line\">
\t\t\t\t\t\t\t\t\t\t\t\t\t\t<li class=\"process-step inactive\"></li>
\t\t\t\t\t\t\t\t\t\t\t\t\t</ul>
\t\t\t\t\t\t\t\t\t\t\t\t</li>
\t\t\t\t\t\t\t\t\t\t\t</ul>

\t\t\t\t\t\t\t\t\t\t\t<div class = \"scheme-state-details\">
\t\t\t\t\t\t\t\t\t\t\t\t<div class=\"granular-info-box\" style=\"display: none;\">
\t\t\t\t\t\t\t\t\t\t\t\t\t<div class=\"arrow\"></div>
\t\t\t\t\t\t\t\t\t\t\t\t\t<div class=\"details-content\">
\t\t\t\t\t\t\t\t\t\t\t\t\t\t<p class=\"scheme-title\">Scheme Name 001</p>
\t\t\t\t\t\t\t\t\t\t\t\t\t\t<p class = \"notification-info\">Notification received from Mr. A</p>
\t\t\t\t\t\t\t\t\t\t\t\t\t\t<ul class=\"granular-info\">
\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t<li class=\"unit \"><span class = \"start-date-label info-label\">Start Date: </span><span class = \"start-date info-data\">10 Aug 2015</span></li>
\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t<li class=\"unit \"><span class = \"end-date-labe info-label\">End Date: </span><span class = \"end-date info-data\">20 Dec 2015</span></li>
\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t<li class=\"unit \"><span class = \"forecast-amount-label info-label\">Forecast Amount: </span><span class = \"forecast-amount info-data\">&#8377;10,000,000</span></li>
\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t<li class=\"unit \"><span class = \"initiated-label info-label\">Initiated on: </span><span class = \"initiated-date info-data\">19 Sept 2013</span></li>
\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t<li class=\"unit \"><span class = \"initiator-label info-label\">Initiated by: </span><span class = \"initiated-by info-data\">Mr. S</span></li>
\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t<li class=\"unit \"><span class = \"reviewed-label info-label\">Reviewed on: </span><span class = \"reviewed-date info-data\">21 Sept 2013</span></li>
\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t<li class=\"unit \"><span class = \"reviewer-label info-label\">Reviewed by: </span><span class = \"reviewed-by info-data\">Mr. D</span></li>
\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t<li class=\"unit \"><span class = \"status-label info-label\">Status: </span><span class = \"status info-data\">To be reviewd</span></li>

\t\t\t\t\t\t\t\t\t\t\t\t\t\t</ul>
\t\t\t\t\t\t\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t\t\t\t\t\t</div>

\t\t\t\t\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t\t\t</div>

\t\t\t\t\t\t\t\t\t<div class=\"state-panel panel-solid-default\">
\t\t\t\t\t\t\t\t\t\t<div class=\"panel-heading\">
\t\t\t\t\t\t\t\t\t\t\t<h3 class=\"panel-title\">Scheme Name 002</h3>
\t\t\t\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t\t\t\t<div class=\"panel-body\">
\t\t\t\t\t\t\t\t\t\t\t<ul class=\"line-graph titles\">
\t\t\t\t\t\t\t\t\t\t\t\t<li class=\"unit size1of3\">
\t\t\t\t\t\t\t\t\t\t\t\t\t<ul class=\"line\">
\t\t\t\t\t\t\t\t\t\t\t\t\t\tInitiated
\t\t\t\t\t\t\t\t\t\t\t\t\t</ul>
\t\t\t\t\t\t\t\t\t\t\t\t</li>
\t\t\t\t\t\t\t\t\t\t\t\t<li class=\"unit size1of3\">
\t\t\t\t\t\t\t\t\t\t\t\t\t<ul class=\"line\">
\t\t\t\t\t\t\t\t\t\t\t\t\t\tReviewed
\t\t\t\t\t\t\t\t\t\t\t\t\t</ul>
\t\t\t\t\t\t\t\t\t\t\t\t</li>
\t\t\t\t\t\t\t\t\t\t\t\t<li class=\"unit size1of3\">
\t\t\t\t\t\t\t\t\t\t\t\t\t<ul class=\"line\">
\t\t\t\t\t\t\t\t\t\t\t\t\t\tApproved
\t\t\t\t\t\t\t\t\t\t\t\t\t</ul>
\t\t\t\t\t\t\t\t\t\t\t\t</li>
\t\t\t\t\t\t\t\t\t\t\t</ul>
\t\t\t\t\t\t\t\t\t\t\t<ul class=\"line-graph\">
\t\t\t\t\t\t\t\t\t\t\t\t<li class=\"unit size1of3\">
\t\t\t\t\t\t\t\t\t\t\t\t\t<ul class=\"line\">
\t\t\t\t\t\t\t\t\t\t\t\t\t\t<li class=\"process-step processed-continuous\"></li>
\t\t\t\t\t\t\t\t\t\t\t\t\t</ul>
\t\t\t\t\t\t\t\t\t\t\t\t</li>
\t\t\t\t\t\t\t\t\t\t\t\t<li class=\"unit size1of3\">
\t\t\t\t\t\t\t\t\t\t\t\t\t<ul class=\"line\">
\t\t\t\t\t\t\t\t\t\t\t\t\t\t<li class=\"process-step inactive\"></li>
\t\t\t\t\t\t\t\t\t\t\t\t\t</ul>
\t\t\t\t\t\t\t\t\t\t\t\t</li>
\t\t\t\t\t\t\t\t\t\t\t\t<li class=\"unit size1of3\">
\t\t\t\t\t\t\t\t\t\t\t\t\t<ul class=\"line\">
\t\t\t\t\t\t\t\t\t\t\t\t\t\t<li class=\"process-step inactive\"></li>
\t\t\t\t\t\t\t\t\t\t\t\t\t</ul>
\t\t\t\t\t\t\t\t\t\t\t\t</li>
\t\t\t\t\t\t\t\t\t\t\t</ul>

\t\t\t\t\t\t\t\t\t\t\t<div class = \"scheme-state-details\">
\t\t\t\t\t\t\t\t\t\t\t\t<div class=\"granular-info-box\" style=\"display: none;\">
\t\t\t\t\t\t\t\t\t\t\t\t\t<div class=\"arrow\"></div>
\t\t\t\t\t\t\t\t\t\t\t\t\t<div class=\"details-content\">
\t\t\t\t\t\t\t\t\t\t\t\t\t\t<p class=\"scheme-title\">Scheme Name 001</p>
\t\t\t\t\t\t\t\t\t\t\t\t\t\t<p class = \"notification-info\">Notification received from Mr. A</p>
\t\t\t\t\t\t\t\t\t\t\t\t\t\t<ul class=\"granular-info\">
\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t<li class=\"unit \"><span class = \"start-date-label info-label\">Start Date: </span><span class = \"start-date info-data\">10 Aug 2015</span></li>
\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t<li class=\"unit \"><span class = \"end-date-labe info-label\">End Date: </span><span class = \"end-date info-data\">20 Dec 2015</span></li>
\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t<li class=\"unit \"><span class = \"forecast-amount-label info-label\">Forecast Amount: </span><span class = \"forecast-amount info-data\">&#8377;10,000,000</span></li>
\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t<li class=\"unit \"><span class = \"initiated-label info-label\">Initiated on: </span><span class = \"initiated-date info-data\">19 Sept 2013</span></li>
\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t<li class=\"unit \"><span class = \"initiator-label info-label\">Initiated by: </span><span class = \"initiated-by info-data\">Mr. S</span></li>
\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t<li class=\"unit \"><span class = \"reviewed-label info-label\">Reviewed on: </span><span class = \"reviewed-date info-data\">21 Sept 2013</span></li>
\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t<li class=\"unit \"><span class = \"reviewer-label info-label\">Reviewed by: </span><span class = \"reviewed-by info-data\">Mr. D</span></li>
\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t<li class=\"unit \"><span class = \"status-label info-label\">Status: </span><span class = \"status info-data\">To be reviewd</span></li>

\t\t\t\t\t\t\t\t\t\t\t\t\t\t</ul>
\t\t\t\t\t\t\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t\t\t\t\t\t</div>

\t\t\t\t\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t\t\t</div>

\t\t\t\t\t\t\t\t\t<div class=\"state-panel panel-solid-default\">
\t\t\t\t\t\t\t\t\t\t<div class=\"panel-heading\">
\t\t\t\t\t\t\t\t\t\t\t<h3 class=\"panel-title\">Scheme Name 003</h3>
\t\t\t\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t\t\t\t<div class=\"panel-body\">
\t\t\t\t\t\t\t\t\t\t\t<ul class=\"line-graph titles\">
\t\t\t\t\t\t\t\t\t\t\t\t<li class=\"unit size1of3\">
\t\t\t\t\t\t\t\t\t\t\t\t\t<ul class=\"line\">
\t\t\t\t\t\t\t\t\t\t\t\t\t\tInitiated
\t\t\t\t\t\t\t\t\t\t\t\t\t</ul>
\t\t\t\t\t\t\t\t\t\t\t\t</li>
\t\t\t\t\t\t\t\t\t\t\t\t<li class=\"unit size1of3\">
\t\t\t\t\t\t\t\t\t\t\t\t\t<ul class=\"line\">
\t\t\t\t\t\t\t\t\t\t\t\t\t\tReviewed
\t\t\t\t\t\t\t\t\t\t\t\t\t</ul>
\t\t\t\t\t\t\t\t\t\t\t\t</li>
\t\t\t\t\t\t\t\t\t\t\t\t<li class=\"unit size1of3\">
\t\t\t\t\t\t\t\t\t\t\t\t\t<ul class=\"line\">
\t\t\t\t\t\t\t\t\t\t\t\t\t\tApproved
\t\t\t\t\t\t\t\t\t\t\t\t\t</ul>
\t\t\t\t\t\t\t\t\t\t\t\t</li>
\t\t\t\t\t\t\t\t\t\t\t</ul>
\t\t\t\t\t\t\t\t\t\t\t<ul class=\"line-graph\">
\t\t\t\t\t\t\t\t\t\t\t\t<li class=\"unit size1of3\">
\t\t\t\t\t\t\t\t\t\t\t\t\t<ul class=\"line\">
\t\t\t\t\t\t\t\t\t\t\t\t\t\t<li class=\"process-step processed\"></li>
\t\t\t\t\t\t\t\t\t\t\t\t\t</ul>
\t\t\t\t\t\t\t\t\t\t\t\t</li>
\t\t\t\t\t\t\t\t\t\t\t\t<li class=\"unit size1of3\">
\t\t\t\t\t\t\t\t\t\t\t\t\t<ul class=\"line\">
\t\t\t\t\t\t\t\t\t\t\t\t\t\t<li class=\"process-step processed\"></li>
\t\t\t\t\t\t\t\t\t\t\t\t\t</ul>
\t\t\t\t\t\t\t\t\t\t\t\t</li>
\t\t\t\t\t\t\t\t\t\t\t\t<li class=\"unit size1of3\">
\t\t\t\t\t\t\t\t\t\t\t\t\t<ul class=\"line\">
\t\t\t\t\t\t\t\t\t\t\t\t\t\t<li class=\"process-step processed\"></li>
\t\t\t\t\t\t\t\t\t\t\t\t\t</ul>
\t\t\t\t\t\t\t\t\t\t\t\t</li>
\t\t\t\t\t\t\t\t\t\t\t</ul>

\t\t\t\t\t\t\t\t\t\t\t<div class = \"scheme-state-details\">
\t\t\t\t\t\t\t\t\t\t\t\t<div class=\"granular-info-box\" style=\"display: none;\">
\t\t\t\t\t\t\t\t\t\t\t\t\t<div class=\"arrow\"></div>
\t\t\t\t\t\t\t\t\t\t\t\t\t<div class=\"details-content\">
\t\t\t\t\t\t\t\t\t\t\t\t\t\t<p class=\"scheme-title\">Scheme Name 001</p>
\t\t\t\t\t\t\t\t\t\t\t\t\t\t<p class = \"notification-info\">Notification received from Mr. A</p>
\t\t\t\t\t\t\t\t\t\t\t\t\t\t<ul class=\"granular-info\">
\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t<li class=\"unit \"><span class = \"start-date-label info-label\">Start Date: </span><span class = \"start-date info-data\">10 Aug 2015</span></li>
\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t<li class=\"unit \"><span class = \"end-date-labe info-label\">End Date: </span><span class = \"end-date info-data\">20 Dec 2015</span></li>
\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t<li class=\"unit \"><span class = \"forecast-amount-label info-label\">Forecast Amount: </span><span class = \"forecast-amount info-data\">&#8377;10,000,000</span></li>
\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t<li class=\"unit \"><span class = \"initiated-label info-label\">Initiated on: </span><span class = \"initiated-date info-data\">19 Sept 2013</span></li>
\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t<li class=\"unit \"><span class = \"initiator-label info-label\">Initiated by: </span><span class = \"initiated-by info-data\">Mr. S</span></li>
\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t<li class=\"unit \"><span class = \"reviewed-label info-label\">Reviewed on: </span><span class = \"reviewed-date info-data\">21 Sept 2013</span></li>
\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t<li class=\"unit \"><span class = \"reviewer-label info-label\">Reviewed by: </span><span class = \"reviewed-by info-data\">Mr. D</span></li>
\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t<li class=\"unit \"><span class = \"status-label info-label\">Status: </span><span class = \"status info-data\">To be reviewd</span></li>

\t\t\t\t\t\t\t\t\t\t\t\t\t\t</ul>
\t\t\t\t\t\t\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t\t\t\t\t\t</div>

\t\t\t\t\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t\t\t</div>

\t\t\t\t\t\t\t\t\t<div class=\"state-panel panel-solid-default\">
\t\t\t\t\t\t\t\t\t\t<div class=\"panel-heading\">
\t\t\t\t\t\t\t\t\t\t\t<h3 class=\"panel-title\">Scheme Name 001</h3>
\t\t\t\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t\t\t\t<div class=\"panel-body\">
\t\t\t\t\t\t\t\t\t\t\t<ul class=\"line-graph titles\">
\t\t\t\t\t\t\t\t\t\t\t\t<li class=\"unit size1of3\">
\t\t\t\t\t\t\t\t\t\t\t\t\t<ul class=\"line\">
\t\t\t\t\t\t\t\t\t\t\t\t\t\tInitiated
\t\t\t\t\t\t\t\t\t\t\t\t\t</ul>
\t\t\t\t\t\t\t\t\t\t\t\t</li>
\t\t\t\t\t\t\t\t\t\t\t\t<li class=\"unit size1of3\">
\t\t\t\t\t\t\t\t\t\t\t\t\t<ul class=\"line\">
\t\t\t\t\t\t\t\t\t\t\t\t\t\tReviewed
\t\t\t\t\t\t\t\t\t\t\t\t\t</ul>
\t\t\t\t\t\t\t\t\t\t\t\t</li>
\t\t\t\t\t\t\t\t\t\t\t\t<li class=\"unit size1of3\">
\t\t\t\t\t\t\t\t\t\t\t\t\t<ul class=\"line\">
\t\t\t\t\t\t\t\t\t\t\t\t\t\tApproved
\t\t\t\t\t\t\t\t\t\t\t\t\t</ul>
\t\t\t\t\t\t\t\t\t\t\t\t</li>
\t\t\t\t\t\t\t\t\t\t\t</ul>
\t\t\t\t\t\t\t\t\t\t\t<ul class=\"line-graph\">
\t\t\t\t\t\t\t\t\t\t\t\t<li class=\"unit size1of3\">
\t\t\t\t\t\t\t\t\t\t\t\t\t<ul class=\"line\">
\t\t\t\t\t\t\t\t\t\t\t\t\t\t<li class=\"process-step processed\"></li>
\t\t\t\t\t\t\t\t\t\t\t\t\t</ul>
\t\t\t\t\t\t\t\t\t\t\t\t</li>
\t\t\t\t\t\t\t\t\t\t\t\t<li class=\"unit size1of3\">
\t\t\t\t\t\t\t\t\t\t\t\t\t<ul class=\"line\">
\t\t\t\t\t\t\t\t\t\t\t\t\t\t<li class=\"process-step processed\"></li>
\t\t\t\t\t\t\t\t\t\t\t\t\t</ul>
\t\t\t\t\t\t\t\t\t\t\t\t</li>
\t\t\t\t\t\t\t\t\t\t\t\t<li class=\"unit size1of3\">
\t\t\t\t\t\t\t\t\t\t\t\t\t<ul class=\"line\">
\t\t\t\t\t\t\t\t\t\t\t\t\t\t<li class=\"process-step processed-continuous\"></li>
\t\t\t\t\t\t\t\t\t\t\t\t\t</ul>
\t\t\t\t\t\t\t\t\t\t\t\t</li>
\t\t\t\t\t\t\t\t\t\t\t</ul>

\t\t\t\t\t\t\t\t\t\t\t<div class = \"scheme-state-details\">
\t\t\t\t\t\t\t\t\t\t\t\t<div class=\"granular-info-box\" style=\"display: none;\">
\t\t\t\t\t\t\t\t\t\t\t\t\t<div class=\"arrow\"></div>
\t\t\t\t\t\t\t\t\t\t\t\t\t<div class=\"details-content\">
\t\t\t\t\t\t\t\t\t\t\t\t\t\t<p class=\"scheme-title\">Scheme Name 001</p>
\t\t\t\t\t\t\t\t\t\t\t\t\t\t<p class = \"notification-info\">Notification received from Mr. A</p>
\t\t\t\t\t\t\t\t\t\t\t\t\t\t<ul class=\"granular-info\">
\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t<li class=\"unit \"><span class = \"start-date-label info-label\">Start Date: </span><span class = \"start-date info-data\">10 Aug 2015</span></li>
\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t<li class=\"unit \"><span class = \"end-date-labe info-label\">End Date: </span><span class = \"end-date info-data\">20 Dec 2015</span></li>
\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t<li class=\"unit \"><span class = \"forecast-amount-label info-label\">Forecast Amount: </span><span class = \"forecast-amount info-data\">&#8377;10,000,000</span></li>
\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t<li class=\"unit \"><span class = \"initiated-label info-label\">Initiated on: </span><span class = \"initiated-date info-data\">19 Sept 2013</span></li>
\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t<li class=\"unit \"><span class = \"initiator-label info-label\">Initiated by: </span><span class = \"initiated-by info-data\">Mr. S</span></li>
\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t<li class=\"unit \"><span class = \"reviewed-label info-label\">Reviewed on: </span><span class = \"reviewed-date info-data\">21 Sept 2013</span></li>
\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t<li class=\"unit \"><span class = \"reviewer-label info-label\">Reviewed by: </span><span class = \"reviewed-by info-data\">Mr. D</span></li>
\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t<li class=\"unit \"><span class = \"status-label info-label\">Status: </span><span class = \"status info-data\">To be reviewd</span></li>

\t\t\t\t\t\t\t\t\t\t\t\t\t\t</ul>
\t\t\t\t\t\t\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t\t\t\t\t\t</div>

\t\t\t\t\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t\t\t</div>

\t\t\t\t\t\t\t\t\t<div class=\"state-panel panel-solid-default\">
\t\t\t\t\t\t\t\t\t\t<div class=\"panel-heading\">
\t\t\t\t\t\t\t\t\t\t\t<h3 class=\"panel-title\">Scheme Name 001</h3>
\t\t\t\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t\t\t\t<div class=\"panel-body\">
\t\t\t\t\t\t\t\t\t\t\t<ul class=\"line-graph titles\">
\t\t\t\t\t\t\t\t\t\t\t\t<li class=\"unit size1of3\">
\t\t\t\t\t\t\t\t\t\t\t\t\t<ul class=\"line\">
\t\t\t\t\t\t\t\t\t\t\t\t\t\tInitiated
\t\t\t\t\t\t\t\t\t\t\t\t\t</ul>
\t\t\t\t\t\t\t\t\t\t\t\t</li>
\t\t\t\t\t\t\t\t\t\t\t\t<li class=\"unit size1of3\">
\t\t\t\t\t\t\t\t\t\t\t\t\t<ul class=\"line\">
\t\t\t\t\t\t\t\t\t\t\t\t\t\tReviewed
\t\t\t\t\t\t\t\t\t\t\t\t\t</ul>
\t\t\t\t\t\t\t\t\t\t\t\t</li>
\t\t\t\t\t\t\t\t\t\t\t\t<li class=\"unit size1of3\">
\t\t\t\t\t\t\t\t\t\t\t\t\t<ul class=\"line\">
\t\t\t\t\t\t\t\t\t\t\t\t\t\tApproved
\t\t\t\t\t\t\t\t\t\t\t\t\t</ul>
\t\t\t\t\t\t\t\t\t\t\t\t</li>
\t\t\t\t\t\t\t\t\t\t\t</ul>
\t\t\t\t\t\t\t\t\t\t\t<ul class=\"line-graph\">
\t\t\t\t\t\t\t\t\t\t\t\t<li class=\"unit size1of3\">
\t\t\t\t\t\t\t\t\t\t\t\t\t<ul class=\"line\">
\t\t\t\t\t\t\t\t\t\t\t\t\t\t<li class=\"process-step processed\"></li>
\t\t\t\t\t\t\t\t\t\t\t\t\t</ul>
\t\t\t\t\t\t\t\t\t\t\t\t</li>
\t\t\t\t\t\t\t\t\t\t\t\t<li class=\"unit size1of3\">
\t\t\t\t\t\t\t\t\t\t\t\t\t<ul class=\"line\">
\t\t\t\t\t\t\t\t\t\t\t\t\t\t<li class=\"process-step processed-continuous\"></li>
\t\t\t\t\t\t\t\t\t\t\t\t\t</ul>
\t\t\t\t\t\t\t\t\t\t\t\t</li>
\t\t\t\t\t\t\t\t\t\t\t\t<li class=\"unit size1of3\">
\t\t\t\t\t\t\t\t\t\t\t\t\t<ul class=\"line\">
\t\t\t\t\t\t\t\t\t\t\t\t\t\t<li class=\"process-step inactive\"></li>
\t\t\t\t\t\t\t\t\t\t\t\t\t</ul>
\t\t\t\t\t\t\t\t\t\t\t\t</li>
\t\t\t\t\t\t\t\t\t\t\t</ul>

\t\t\t\t\t\t\t\t\t\t\t<div class = \"scheme-state-details\">
\t\t\t\t\t\t\t\t\t\t\t\t<div class=\"granular-info-box\" style=\"display: none;\">
\t\t\t\t\t\t\t\t\t\t\t\t\t<div class=\"arrow\"></div>
\t\t\t\t\t\t\t\t\t\t\t\t\t<div class=\"details-content\">
\t\t\t\t\t\t\t\t\t\t\t\t\t\t<p class=\"scheme-title\">Scheme Name 001</p>
\t\t\t\t\t\t\t\t\t\t\t\t\t\t<p class = \"notification-info\">Notification received from Mr. A</p>
\t\t\t\t\t\t\t\t\t\t\t\t\t\t<ul class=\"granular-info\">
\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t<li class=\"unit \"><span class = \"start-date-label info-label\">Start Date: </span><span class = \"start-date info-data\">10 Aug 2015</span></li>
\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t<li class=\"unit \"><span class = \"end-date-labe info-label\">End Date: </span><span class = \"end-date info-data\">20 Dec 2015</span></li>
\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t<li class=\"unit \"><span class = \"forecast-amount-label info-label\">Forecast Amount: </span><span class = \"forecast-amount info-data\">&#8377;10,000,000</span></li>
\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t<li class=\"unit \"><span class = \"initiated-label info-label\">Initiated on: </span><span class = \"initiated-date info-data\">19 Sept 2013</span></li>
\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t<li class=\"unit \"><span class = \"initiator-label info-label\">Initiated by: </span><span class = \"initiated-by info-data\">Mr. S</span></li>
\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t<li class=\"unit \"><span class = \"reviewed-label info-label\">Reviewed on: </span><span class = \"reviewed-date info-data\">21 Sept 2013</span></li>
\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t<li class=\"unit \"><span class = \"reviewer-label info-label\">Reviewed by: </span><span class = \"reviewed-by info-data\">Mr. D</span></li>
\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t<li class=\"unit \"><span class = \"status-label info-label\">Status: </span><span class = \"status info-data\">To be reviewd</span></li>

\t\t\t\t\t\t\t\t\t\t\t\t\t\t</ul>
\t\t\t\t\t\t\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t\t\t\t\t\t</div>

\t\t\t\t\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t<div class = \"col-lg-6 col-sm-12 col-xs-12\">
\t\t\t\t\t\t\t\t<div id = \"concluded-schemes\">
\t\t\t\t\t\t\t\t\t";
        // line 488
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_ensure_traversable($this->getAttribute((isset($context["items"]) ? $context["items"] : null), "concludedSchemes", array()));
        foreach ($context['_seq'] as $context["_key"] => $context["itemConclued"]) {
            // line 489
            echo "\t\t\t\t\t\t\t\t\t<div class=\"state-panel panel-solid-default\">
\t\t\t\t\t\t\t\t\t\t<div class=\"panel-heading\">
\t\t\t\t\t\t\t\t\t\t\t<h3 class=\"panel-title\">";
            // line 491
            echo twig_escape_filter($this->env, $this->getAttribute($context["itemConclued"], "title", array()), "html", null, true);
            echo "</h3>
\t\t\t\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t\t\t\t<div class=\"panel-body\">
\t\t\t\t\t\t\t\t\t\t\t<ul class=\"line-graph titles\">
\t\t\t\t\t\t\t\t\t\t\t\t<li class=\"unit size1of3\">
\t\t\t\t\t\t\t\t\t\t\t\t\t<ul class=\"line\">
\t\t\t\t\t\t\t\t\t\t\t\t\t\tInitiated
\t\t\t\t\t\t\t\t\t\t\t\t\t</ul>
\t\t\t\t\t\t\t\t\t\t\t\t</li>
\t\t\t\t\t\t\t\t\t\t\t\t<li class=\"unit size1of3\">
\t\t\t\t\t\t\t\t\t\t\t\t\t<ul class=\"line\">
\t\t\t\t\t\t\t\t\t\t\t\t\t\tReviewed
\t\t\t\t\t\t\t\t\t\t\t\t\t</ul>
\t\t\t\t\t\t\t\t\t\t\t\t</li>
\t\t\t\t\t\t\t\t\t\t\t\t<li class=\"unit size1of3\">
\t\t\t\t\t\t\t\t\t\t\t\t\t<ul class=\"line\">
\t\t\t\t\t\t\t\t\t\t\t\t\t\tApproved
\t\t\t\t\t\t\t\t\t\t\t\t\t</ul>
\t\t\t\t\t\t\t\t\t\t\t\t</li>
\t\t\t\t\t\t\t\t\t\t\t</ul>
\t\t\t\t\t\t\t\t\t\t\t<ul class=\"line-graph\">
\t\t\t\t\t\t\t\t\t\t\t\t<li class=\"unit size1of3\">
\t\t\t\t\t\t\t\t\t\t\t\t\t<ul class=\"line\">
\t\t\t\t\t\t\t\t\t\t\t\t\t\t<li class=\"process-step ";
            // line 514
            if (($this->getAttribute($context["itemConclued"], "Status", array()) == "Initiated")) {
                echo "processed-continuous";
            } elseif (($this->getAttribute($context["itemConclued"], "Status", array()) == "Reviewed")) {
                echo "processed ";
            } elseif (($this->getAttribute($context["itemConclued"], "Status", array()) == "Approved")) {
                echo "processed";
            } else {
                echo "processed";
            }
            echo "\"></li>
\t\t\t\t\t\t\t\t\t\t\t\t\t</ul>
\t\t\t\t\t\t\t\t\t\t\t\t</li>
\t\t\t\t\t\t\t\t\t\t\t\t<li class=\"unit size1of3\">
\t\t\t\t\t\t\t\t\t\t\t\t\t<ul class=\"line\">
\t\t\t\t\t\t\t\t\t\t\t\t\t\t<li class=\"process-step ";
            // line 519
            if (($this->getAttribute($context["itemConclued"], "Status", array()) == "Initiated")) {
                echo "inactive";
            } elseif (($this->getAttribute($context["itemConclued"], "Status", array()) == "Reviewed")) {
                echo "processed-continuous";
            } elseif (($this->getAttribute($context["itemConclued"], "Status", array()) == "Approved")) {
                echo "processed";
            } else {
                echo "processed";
            }
            echo "\"></li>
\t\t\t\t\t\t\t\t\t\t\t\t\t</ul>
\t\t\t\t\t\t\t\t\t\t\t\t</li>
\t\t\t\t\t\t\t\t\t\t\t\t<li class=\"unit size1of3\">
\t\t\t\t\t\t\t\t\t\t\t\t\t<ul class=\"line\">
\t\t\t\t\t\t\t\t\t\t\t\t\t\t<li class=\"process-step ";
            // line 524
            if (($this->getAttribute($context["itemConclued"], "Status", array()) == "Initiated")) {
                echo "inactive";
            } elseif (($this->getAttribute($context["itemConclued"], "Status", array()) == "Reviewed")) {
                echo "inactive";
            } elseif (($this->getAttribute($context["itemConclued"], "Status", array()) == "Approved")) {
                echo "processed-continuous";
            } else {
                echo "processed";
            }
            echo "\"></li>
\t\t\t\t\t\t\t\t\t\t\t\t\t</ul>
\t\t\t\t\t\t\t\t\t\t\t\t</li>
\t\t\t\t\t\t\t\t\t\t\t</ul>

\t\t\t\t\t\t\t\t\t\t\t<div class = \"scheme-state-details\">
\t\t\t\t\t\t\t\t\t\t\t\t<div class=\"granular-info-box\" style=\"display: none;\">
\t\t\t\t\t\t\t\t\t\t\t\t\t<div class=\"arrow\"></div>
\t\t\t\t\t\t\t\t\t\t\t\t\t<div class=\"details-content\">
\t\t\t\t\t\t\t\t\t\t\t\t\t\t<p class=\"scheme-title\">";
            // line 533
            echo twig_escape_filter($this->env, $this->getAttribute($context["itemConclued"], "title", array()), "html", null, true);
            echo "</p>
\t\t\t\t\t\t\t\t\t\t\t\t\t\t<p class = \"notification-info\">";
            // line 534
            echo twig_escape_filter($this->env, $this->getAttribute($context["itemConclued"], "notification", array()), "html", null, true);
            echo "</p>
\t\t\t\t\t\t\t\t\t\t\t\t\t\t<ul class=\"granular-info\">
\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t<li class=\"unit \"><span class = \"start-date-label info-label\">Start Date: </span><span class = \"start-date info-data\">";
            // line 536
            echo twig_escape_filter($this->env, $this->getAttribute($context["itemConclued"], "startDate", array()), "html", null, true);
            echo "</span></li>
\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t<li class=\"unit \"><span class = \"end-date-labe info-label\">End Date: </span><span class = \"end-date info-data\">";
            // line 537
            echo twig_escape_filter($this->env, $this->getAttribute($context["itemConclued"], "endDate", array()), "html", null, true);
            echo "</span></li>
\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t<li class=\"unit \"><span class = \"forecast-amount-label info-label\">Forecast Amount: </span><span class = \"forecast-amount info-data\">&#8377;";
            // line 538
            echo twig_escape_filter($this->env, $this->getAttribute($context["itemConclued"], "forcast", array()), "html", null, true);
            echo "</span></li>
\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t<li class=\"unit \"><span class = \"initiated-label info-label\">Initiated on: </span><span class = \"initiated-date info-data\">";
            // line 539
            echo twig_escape_filter($this->env, $this->getAttribute($context["itemConclued"], "initiatedOn", array()), "html", null, true);
            echo "</span></li>
\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t<li class=\"unit \"><span class = \"initiator-label info-label\">Initiated by: </span><span class = \"initiated-by info-data\">";
            // line 540
            echo twig_escape_filter($this->env, $this->getAttribute($context["itemConclued"], "initiatedBy", array()), "html", null, true);
            echo "</span></li>
\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t<li class=\"unit \"><span class = \"reviewed-label info-label\">Reviewed on: </span><span class = \"reviewed-date info-data\">";
            // line 541
            echo twig_escape_filter($this->env, $this->getAttribute($context["itemConclued"], "reviewedOn", array()), "html", null, true);
            echo "</span></li>
\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t<li class=\"unit \"><span class = \"reviewer-label info-label\">Reviewed by: </span><span class = \"reviewed-by info-data\">";
            // line 542
            echo twig_escape_filter($this->env, $this->getAttribute($context["itemConclued"], "reviewedBy", array()), "html", null, true);
            echo "</span></li>
\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t<li class=\"unit \"><span class = \"status-label info-label\">Status: </span><span class = \"status info-data\">";
            // line 543
            echo twig_escape_filter($this->env, $this->getAttribute($context["itemConclued"], "Status", array()), "html", null, true);
            echo "</span></li>

\t\t\t\t\t\t\t\t\t\t\t\t\t\t</ul>
\t\t\t\t\t\t\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t\t\t\t\t\t</div>

\t\t\t\t\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t\t\t";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['itemConclued'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 553
        echo "\t\t\t\t\t\t\t\t\t\t
\t\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t</div>


\t\t\t\t\t</div>
\t\t\t\t</div>
\t\t\t</div>
\t\t\t
\t\t</div>

    </div>
 </section>
</section>
";
    }

    // line 570
    public function block_footer($context, array $blocks = array())
    {
    }

    // line 572
    public function block_scripts($context, array $blocks = array())
    {
        // line 573
        echo "    ";
        $this->displayParentBlock("scripts", $context, $blocks);
        echo "
    <!-- jqplot -->
    <script type=\"text/javascript\" src=";
        // line 575
        echo call_user_func_array($this->env->getFunction('resolvePath')->getCallable(), array("jquery.jqplot.js"));
        echo "></script>
    <script type=\"text/javascript\" src=";
        // line 576
        echo call_user_func_array($this->env->getFunction('resolvePath')->getCallable(), array("jqplot.barRenderer.min.js"));
        echo "></script>
\t<script type=\"text/javascript\" src=";
        // line 577
        echo call_user_func_array($this->env->getFunction('resolvePath')->getCallable(), array("jqplot.categoryAxisRenderer.min.js"));
        echo "></script>
\t<script type=\"text/javascript\" src=";
        // line 578
        echo call_user_func_array($this->env->getFunction('resolvePath')->getCallable(), array("jqplot.pointLabels.min.js"));
        echo "></script>
\t<script type=\"text/javascript\" src=";
        // line 579
        echo call_user_func_array($this->env->getFunction('resolvePath')->getCallable(), array("jqplot.canvasTextRenderer.min.js"));
        echo "></script>
    <script type=\"text/javascript\" src=";
        // line 580
        echo call_user_func_array($this->env->getFunction('resolvePath')->getCallable(), array("jqplot.canvasAxisLabelRenderer.min.js"));
        echo "></script>
    <script type=\"text/javascript\" src=";
        // line 581
        echo call_user_func_array($this->env->getFunction('resolvePath')->getCallable(), array("jqplot.highlighter.min.js"));
        echo "></script>
    <script type=\"text/javascript\" src=";
        // line 582
        echo call_user_func_array($this->env->getFunction('resolvePath')->getCallable(), array("jqplot.cursor.min.js"));
        echo "></script>
    <script type=\"text/javascript\" src=";
        // line 583
        echo call_user_func_array($this->env->getFunction('resolvePath')->getCallable(), array("jqplot.dateAxisRenderer.min.js"));
        echo "></script>
    <!-- External libs -->
\t<script type=\"text/javascript\" src=";
        // line 585
        echo call_user_func_array($this->env->getFunction('resolvePath')->getCallable(), array("jquery.easypiechart.min.js"));
        echo "></script>
\t<script type=\"text/javascript\" src=";
        // line 586
        echo call_user_func_array($this->env->getFunction('resolvePath')->getCallable(), array("jquery.nouislider.min.js"));
        echo "></script>
\t<!-- n5 wrappers -->
\t<script type=\"text/javascript\" src=";
        // line 588
        echo call_user_func_array($this->env->getFunction('resolvePath')->getCallable(), array("native5.ui.card.js"));
        echo "></script>
\t<script type=\"text/javascript\" src=";
        // line 589
        echo call_user_func_array($this->env->getFunction('resolvePath')->getCallable(), array("native5.ui.graph.circularChart.js"));
        echo "></script>
\t<script type=\"text/javascript\" src=";
        // line 590
        echo call_user_func_array($this->env->getFunction('resolvePath')->getCallable(), array("native5.ui.graph.bar.js"));
        echo "></script>
\t<script type=\"text/javascript\" src=";
        // line 591
        echo call_user_func_array($this->env->getFunction('resolvePath')->getCallable(), array("native5.ui.filtermenu.js"));
        echo "></script>
\t<script type=\"text/javascript\" src=";
        // line 592
        echo call_user_func_array($this->env->getFunction('resolvePath')->getCallable(), array("native5.ui.checkboxTree.js"));
        echo "></script>

\t<!-- akzo wrappers -->
\t<script type=\"text/javascript\" src=";
        // line 595
        echo call_user_func_array($this->env->getFunction('resolvePath')->getCallable(), array("akzo.ui.budgetUtilization.js"));
        echo "></script>
\t<script type=\"text/javascript\" src=";
        // line 596
        echo call_user_func_array($this->env->getFunction('resolvePath')->getCallable(), array("akzo.activeSchemes.js"));
        echo "></script>
    <script type=\"text/javascript\" src=";
        // line 597
        echo call_user_func_array($this->env->getFunction('resolvePath')->getCallable(), array("akzo_menu.js"));
        echo "></script> 
    <script type=\"text/javascript\" src=";
        // line 598
        echo call_user_func_array($this->env->getFunction('resolvePath')->getCallable(), array("dashboard.js"));
        echo "></script> 
    
";
    }

    public function getTemplateName()
    {
        return "dashboard.tmpl";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  821 => 598,  817 => 597,  813 => 596,  809 => 595,  803 => 592,  799 => 591,  795 => 590,  791 => 589,  787 => 588,  782 => 586,  778 => 585,  773 => 583,  769 => 582,  765 => 581,  761 => 580,  757 => 579,  753 => 578,  749 => 577,  745 => 576,  741 => 575,  735 => 573,  732 => 572,  727 => 570,  708 => 553,  692 => 543,  688 => 542,  684 => 541,  680 => 540,  676 => 539,  672 => 538,  668 => 537,  664 => 536,  659 => 534,  655 => 533,  635 => 524,  619 => 519,  603 => 514,  577 => 491,  573 => 489,  569 => 488,  236 => 157,  224 => 151,  216 => 146,  211 => 144,  207 => 143,  201 => 139,  197 => 138,  112 => 56,  98 => 45,  84 => 34,  70 => 23,  57 => 12,  55 => 11,  52 => 10,  49 => 9,  43 => 6,  38 => 5,  32 => 3,  11 => 1,);
    }
}
