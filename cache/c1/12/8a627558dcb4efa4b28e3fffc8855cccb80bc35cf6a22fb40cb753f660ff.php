<?php

/* simulation.tmpl */
class __TwigTemplate_c1128a627558dcb4efa4b28e3fffc8855cccb80bc35cf6a22fb40cb753f660ff extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 1
        try {
            $this->parent = $this->env->loadTemplate("base.html");
        } catch (Twig_Error_Loader $e) {
            $e->setTemplateFile($this->getTemplateName());
            $e->setTemplateLine(1);

            throw $e;
        }

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
        echo "Create Scheme";
    }

    // line 5
    public function block_header($context, array $blocks = array())
    {
        echo " 
    ";
        // line 6
        $this->env->loadTemplate("header.tmpl")->display($context);
        echo " 
";
    }

    // line 9
    public function block_content($context, array $blocks = array())
    {
        // line 10
        echo "    <div class = \"body-template\">
        <!--Menu-->
        ";
        // line 12
        $this->env->loadTemplate("menu.tmpl")->display($context);
        // line 13
        echo "        <section id=\"content-wrapper\">  
            <div class = \"dashboard-content simulation-content\" align = \"center\">
            </div>
            <div class = \"sales-data\" align = \"center\">
            </div>  
            <div class = \"simulation-result\" align = \"center\">
            </div>            

        </section>
    </div>

    <script type=\"text/html\" id = \"simulation-template\">
        <% _.each(groups, function(group) { %>
            <div class = \"simulation-group\" data-number = \"<%=group.number%>\">
                <div class = \"group-header\">
                    <button class = \"button-simple button-right remove-group\">Remove Group</button>
                    <div class = \"group-title\"><%= group.name %></div>
                </div>

                <select class='simulation-select' multiple='multiple'>
                    ";
        // line 33
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_ensure_traversable($this->getAttribute((isset($context["items"]) ? $context["items"] : null), "draftSchemes", array()));
        foreach ($context['_seq'] as $context["_key"] => $context["item"]) {
            // line 34
            echo "                        <option value='";
            echo twig_escape_filter($this->env, $this->getAttribute($context["item"], "code", array()), "html", null, true);
            echo "'   <% if (group.value.indexOf(\"";
            echo twig_escape_filter($this->env, $this->getAttribute($context["item"], "code", array()), "html", null, true);
            echo "\") >= 0 ) { %>selected <% } %> >";
            echo twig_escape_filter($this->env, $this->getAttribute($context["item"], "name", array()), "html", null, true);
            echo " (";
            echo twig_escape_filter($this->env, $this->getAttribute($context["item"], "uid", array()), "html", null, true);
            echo ")</option> 
                    ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['item'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 35
        echo "                   
                </select>
            </div>
        <% }); %>
        <div class = \"button-group\" align = \"left\">
            <button class = \"button-simple\" id='add_group'>Add Group</button>
            <button class = \"button-simple\" id='simulate'>Simulate Selection</button>
            <div class = \"actual-container\">
                <input type=\"checkbox\" id = \"actual-data-checkbox\" name=\"actual\" >
                <span>Use Actual data to simulate</span>
            </div>
        </div>
        
    </script>

    <script type=\"text/html\" id = \"salesdata-template\">
        <div class = \"group-header\">
            <div class=\"n5-card n5-card-blue  col-lg-12 col-sm-12\" style = \"padding: 0; background: #fff\">
                <div class=\"n5-card-header\">
                    <h2>
                        <span>
                            <i class=\"fa fa-list-alt\"></i>
                        </span>
                        <span class=\"n5-card-title\">Sales Data</span>
                    </h2>
                    <div class=\"n5-card-icon\"><span class=\"n5-card-toggleIcon fa fa-chevron-up\"></span></div>
                </div>
                <div class=\"n5-card-content\">
                    <div class = \"result-content-wrapper col-lg-6 col-md-6 col-sm-12 col-xs-12 results-detail\" >
                        <div class = \"results-panel\">
                            <div class = \"result-list-header\">YTD Status (Till previous month)</div>
                            <div class = \"result-list-elm\"><span class = \"result-list-title\">Value Sales YTD(Lacs): </span><%= salesdata.ytdPrevMonth.val %></div>
                            <% if(salesdata.typeLength == 1) { %>
                            <div class = \"result-list-elm\"><span class = \"result-list-title\">Budget %: </span><%= salesdata.ytdPrevMonth.budgetpercentage.total %>%</div>
                            <div class = \"result-list-elm\"><span class = \"result-list-title\">Budget Available: </span><%= salesdata.ytdPrevMonth.budgetavailable.total %></div>
                            <% } else { %>
                                <% if(salesdata.types.monthly == true) { %>
                                    <div class = \"result-list-elm\"><span class = \"result-list-title\">Budget %(Monthly): </span><%= salesdata.ytdPrevMonth.budgetpercentage.monthly %>%</div>
                                    <div class = \"result-list-elm\"><span class = \"result-list-title\">Budget Available(Monthly): </span><%= salesdata.ytdPrevMonth.budgetavailable.monthly %></div>
                                <% }%>
                                <% if(salesdata.types.atrqtr == true) { %>
                                    <div class = \"result-list-elm\"><span class = \"result-list-title\">Budget %(ATR/QTR): </span><%= salesdata.ytdPrevMonth.budgetpercentage.atrqtr %>%</div>
                                    <div class = \"result-list-elm\"><span class = \"result-list-title\">Budget Available(ATR/QTR): </span><%= salesdata.ytdPrevMonth.budgetavailable.atrqtr %></div>
                                <% }%>
                                <% if(salesdata.types.custom == true) { %>
                                    <div class = \"result-list-elm\"><span class = \"result-list-title\">Budget %(Custom): </span><%= salesdata.ytdPrevMonth.budgetpercentage.custom %>%</div>
                                    <div class = \"result-list-elm\"><span class = \"result-list-title\">Budget Available(Custom): </span><%= salesdata.ytdPrevMonth.budgetavailable.custom %></div>
                                <% }%>
                            <% } %>
                            
                            <div class = \"result-list-elm\"><span class = \"result-list-title\">Actual Spend YTD: </span>--</div>
                            <div class = \"result-list-elm\"><span class = \"result-list-title\">Variance: </span>--</div>
                            <div class = \"result-list-elm\"><span class = \"result-list-title\">% Variance: </span>--</div>
                        </div>
                    </div>

                    <div class = \"result-content-wrapper col-lg-6 col-md-6 col-sm-12 col-xs-12 results-detail\" >
                        <div class = \"results-panel\">
                            <div class = \"result-list-header\">Current month</div>
                            <div class = \"result-list-elm\"><span class = \"result-list-title\">Value Sales YTD(Lacs): </span><%= salesdata.ytdCurrMonth.val %></div>
                            <% if(salesdata.typeLength == 1) { %>
                            <div class = \"result-list-elm\"><span class = \"result-list-title\">Budget %: </span><%= salesdata.ytdCurrMonth.budgetpercentage.total %>%</div>
                            <div class = \"result-list-elm\"><span class = \"result-list-title\">Budget Available: </span><%= salesdata.ytdCurrMonth.budgetavailable.total %></div>
                            <% } else { %>
                                <% if(salesdata.types.monthly == true) { %>
                                    <div class = \"result-list-elm\"><span class = \"result-list-title\">Budget %(Monthly): </span><%= salesdata.ytdCurrMonth.budgetpercentage.monthly %>%</div>
                                    <div class = \"result-list-elm\"><span class = \"result-list-title\">Budget Available(Monthly): </span><%= salesdata.ytdCurrMonth.budgetavailable.monthly %></div>
                                <% }%>
                                <% if(salesdata.types.atrqtr == true) { %>
                                    <div class = \"result-list-elm\"><span class = \"result-list-title\">Budget %(ATR/QTR): </span><%= salesdata.ytdCurrMonth.budgetpercentage.atrqtr %>%</div>
                                    <div class = \"result-list-elm\"><span class = \"result-list-title\">Budget Available(ATR/QTR): </span><%= salesdata.ytdCurrMonth.budgetavailable.atrqtr %></div>
                                <% }%>
                                <% if(salesdata.types.custom == true) { %>
                                    <div class = \"result-list-elm\"><span class = \"result-list-title\">Budget %(Custom): </span><%= salesdata.ytdCurrMonth.budgetpercentage.custom %>%</div>
                                    <div class = \"result-list-elm\"><span class = \"result-list-title\">Budget Available(Custom): </span><%= salesdata.ytdCurrMonth.budgetavailable.custom %></div>
                                <% }%>
                            <% } %>
                            
                            <div class = \"result-list-elm\"><span class = \"result-list-title\">Actual Spend YTD: </span>--</div>
                            <div class = \"result-list-elm\"><span class = \"result-list-title\">Variance: </span>--</div>
                            <div class = \"result-list-elm\"><span class = \"result-list-title\">% Variance: </span>--</div>
                        </div>
                    </div>

                    <div class = \"result-content-wrapper col-lg-6 col-md-6 col-sm-12 col-xs-12 results-detail\" >
                        <div class = \"results-panel\">
                            <div class = \"result-list-header\">YTD Status (Including Current month)</div>
                            <div class = \"result-list-elm\"><span class = \"result-list-title\">Value Sales YTD(Lacs): </span><%= salesdata.ytdOvr.val %></div>
                            <% if(salesdata.typeLength == 1) { %>
                            <div class = \"result-list-elm\"><span class = \"result-list-title\">Budget %: </span><%= salesdata.ytdOvr.budgetpercentage.total %>%</div>
                            <div class = \"result-list-elm\"><span class = \"result-list-title\">Budget Available: </span><%= salesdata.ytdOvr.budgetavailable.total %></div>
                            <% } else { %>
                                <% if(salesdata.types.monthly == true) { %>
                                    <div class = \"result-list-elm\"><span class = \"result-list-title\">Budget %(Monthly): </span><%= salesdata.ytdOvr.budgetpercentage.monthly %>%</div>
                                    <div class = \"result-list-elm\"><span class = \"result-list-title\">Budget Available(Monthly): </span><%= salesdata.ytdOvr.budgetavailable.monthly %></div>
                                <% }%>
                                <% if(salesdata.types.atrqtr == true) { %>
                                    <div class = \"result-list-elm\"><span class = \"result-list-title\">Budget %(ATR/QTR): </span><%= salesdata.ytdOvr.budgetpercentage.atrqtr %>%</div>
                                    <div class = \"result-list-elm\"><span class = \"result-list-title\">Budget Available(ATR/QTR): </span><%= salesdata.ytdOvr.budgetavailable.atrqtr %></div>
                                <% }%>
                                <% if(salesdata.types.custom == true) { %>
                                    <div class = \"result-list-elm\"><span class = \"result-list-title\">Budget %(Custom): </span><%= salesdata.ytdOvr.budgetpercentage.custom %>%</div>
                                    <div class = \"result-list-elm\"><span class = \"result-list-title\">Budget Available(Custom): </span><%= salesdata.ytdOvr.budgetavailable.custom %></div>
                                <% }%>
                            <% } %>
                            
                            <div class = \"result-list-elm\"><span class = \"result-list-title\">Actual Spend YTD: </span>--</div>
                            <div class = \"result-list-elm\"><span class = \"result-list-title\">Variance: </span>--</div>
                            <div class = \"result-list-elm\"><span class = \"result-list-title\">% Variance: </span>--</div>
                        </div>
                    </div>

                    <div class = \"result-content-wrapper col-lg-6 col-md-6 col-sm-12 col-xs-12 results-detail\" >
                        <div class = \"results-panel\">
                            <div class = \"result-list-header\">Budget Percentage Splits</div>
                            <div class = \"result-list-elm\"><span class = \"result-list-title\">Total Budget %: </span><%= salesdata.percentage.total %>%</div>
                            <div class = \"result-list-elm\"><span class = \"result-list-title\">Club Spend %: </span><%= salesdata.percentage.club %>%</div>
                            <div class = \"result-list-elm\"><span class = \"result-list-title\">ATR + QTR Spend %: </span><%= salesdata.percentage.atrqtr %>%</div>
                            <div class = \"result-list-elm\"><span class = \"result-list-title\">Monthly Spend %: </span><%= salesdata.percentage.monthly %>%</div>
                        </div>
                    </div>


                </div>
            </div>
        </div>
    </script>

    <script type=\"text/html\" id = \"result-template\">
        <% _.each(results, function(result, i) { %>
            <div class = \"group-header\" >
            <div class=\"n5-card n5-card-blue  col-lg-12 col-sm-12\" style = \"padding: 0; background: #fff\">
                <div class=\"n5-card-header\">
                    <h2>
                        <span>
                            <i class=\"fa fa-list-alt\"></i>
                        </span>
                        <span class=\"n5-card-title\"><%= result.schemeName %></span>
                    </h2>
                    <div class=\"n5-card-icon\"><span class=\"n5-card-toggleIcon fa fa-chevron-up\"></span></div>
                </div>
                <div class=\"n5-card-content\">
                    <div class = \"result-content-wrapper col-lg-6 col-sm-12 results-detail\" data-name = \"<%= result.schemeName %>\" data-index = \"resultElement<%= i %>\">
                        <div class = \"results-panel\">
                            <div class = \"result-list-elm\"><span class = \"result-list-title\">Status: </span><%= result.status %></div>
                            <div class = \"result-list-elm\"><span class = \"result-list-title\">Dealers: </span><%= result.dealers %></div>
                            <% _.each(result.inbill, function(template, i) { %>
                                <div class = \"result-list-elm\"><span class = \"result-list-title\">Inbill( <%= i %> ): </span><%= template.";
        // line 182
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["items"]) ? $context["items"] : null), "WITHOUT_QC", array()), "html", null, true);
        echo " %></div>
                            <% }); %>
                            <% _.each(result.ppi, function(template, i) { %>
                                <% if(template.";
        // line 185
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["items"]) ? $context["items"] : null), "WITHOUT_QC", array()), "html", null, true);
        echo " ) { %>
                                    <div class = \"result-list-elm\"><span class = \"result-list-title\">PPI( <%= i %> ): </span><%= template.";
        // line 186
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["items"]) ? $context["items"] : null), "WITHOUT_QC", array()), "html", null, true);
        echo " %></div>
                                <% }%>
                                <% if(template.";
        // line 188
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["items"]) ? $context["items"] : null), "WITH_QC", array()), "html", null, true);
        echo " ) { %>
                                    <div class = \"result-list-elm\"><span class = \"result-list-title\">PPI with QC( <%= i %> ): </span><%= template.";
        // line 189
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["items"]) ? $context["items"] : null), "WITH_QC", array()), "html", null, true);
        echo " %></div>
                                <% }%>

                            <% }); %>
                            <% _.each(result.pri, function(template, i) { %>
                                <% if(template.";
        // line 194
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["items"]) ? $context["items"] : null), "WITHOUT_QC", array()), "html", null, true);
        echo " ) { %>
                                    <div class = \"result-list-elm\"><span class = \"result-list-title\">PRI( <%= i %> ): </span><%= template.";
        // line 195
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["items"]) ? $context["items"] : null), "WITHOUT_QC", array()), "html", null, true);
        echo " %></div>
                                <% }%>
                                <% if(template.";
        // line 197
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["items"]) ? $context["items"] : null), "WITH_QC", array()), "html", null, true);
        echo " ) { %>
                                    <div class = \"result-list-elm\"><span class = \"result-list-title\">PRI with QC( <%= i %> ): </span><%= template.";
        // line 198
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["items"]) ? $context["items"] : null), "WITH_QC", array()), "html", null, true);
        echo " %></div>
                                <% }%>
                            <% }); %>
                            <% _.each(result.slab, function(template, i) { %>
                                <% if(template.";
        // line 202
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["items"]) ? $context["items"] : null), "WITHOUT_QC", array()), "html", null, true);
        echo " ) { %>
                                    <div class = \"result-list-elm\"><span class = \"result-list-title\">Slab( <%= i %> ): </span><%= template.";
        // line 203
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["items"]) ? $context["items"] : null), "WITHOUT_QC", array()), "html", null, true);
        echo " %></div>
                                <% }%>
                                <% if(template.";
        // line 205
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["items"]) ? $context["items"] : null), "WITH_QC", array()), "html", null, true);
        echo " ) { %>
                                    <div class = \"result-list-elm\"><span class = \"result-list-title\">Slab with QC( <%= i %> ): </span><%= template.";
        // line 206
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["items"]) ? $context["items"] : null), "WITH_QC", array()), "html", null, true);
        echo " %></div>
                                <% }%>
                            <% }); %>
                            <% _.each(result.slabV2, function(template, i) { %>
                                <% if(template.";
        // line 210
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["items"]) ? $context["items"] : null), "WITHOUT_QC", array()), "html", null, true);
        echo " ) { %>
                                    <div class = \"result-list-elm\"><span class = \"result-list-title\">Slab( <%= i %> ): </span><%= template.";
        // line 211
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["items"]) ? $context["items"] : null), "WITHOUT_QC", array()), "html", null, true);
        echo " %></div>
                                <% }%>
                                <% if(template.";
        // line 213
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["items"]) ? $context["items"] : null), "WITH_QC", array()), "html", null, true);
        echo " ) { %>
                                    <div class = \"result-list-elm\"><span class = \"result-list-title\">Slab with QC( <%= i %> ): </span><%= template.";
        // line 214
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["items"]) ? $context["items"] : null), "WITH_QC", array()), "html", null, true);
        echo " %></div>
                                <% }%>
                            <% }); %>
                        </div>
                    </div>

                    <div class = \"result-content-wrapper col-lg-6 col-sm-12\" >
                        <div class = \"results-panel\">
                            <div class = \"result-list-elm\"><span class = \"result-list-title\">Scheme Start Date: </span><%= result.startDate %></div>
                            <div class = \"result-list-elm\"><span class = \"result-list-title\">Scheme End Date: </span><%= result.endDate %></div>
                            <div class = \"result-list-elm\"><span class = \"result-list-title\">Scheme Created On: </span><%= result.createdOn %></div>
                            <div class = \"result-list-elm\"><span class = \"result-list-title\">To be Initiated By: </span><%= result.initiatedBy %></div>
                            <div class = \"result-list-elm\"><span class = \"result-list-title\">To be Updated By: </span><%= result.updatedBy %></div>
                            <div class = \"result-list-elm\"><span class = \"result-list-title\">To be Reviewed By: </span><%= result.reviewedBy %></div>
                            <div class = \"result-list-elm\"><span class = \"result-list-title\">To be Approved By: </span><%= result.approvedBy %></div>
                        </div>
                    </div>
                    <div class = \"result-content-wrapper col-lg-6 col-sm-12 dealer-search-container\" >
                        <input type = \"text\" class = \"dealer-search-input\" placeholder = \"Search Dealers\" >
                        <a href = \"simulation/simulationDump?code=<%=result.code%>&uid=<%=result.uid%>&actuals=<%=result.actuals%>&rand_token=";
        // line 233
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["items"]) ? $context["items"] : null), "nonce", array()), "html", null, true);
        echo "\"><button class = \"button-simple dealer-data-btn\" data-code = \"<%= result.code %>\" data-uid = \"<%= result.uid %>\">Download Dealer Data</button></a>
                    </div>
                    <div class = \"result-content-wrapper col-lg-12 col-sm-12 \" >
                        <div class = \"row dealer-result-container\"></div>
                    </div>
                </div>
            </div>
            </div>

        <% }); %>
    </script>
    <script type=\"text/html\" id = \"dealer-template\">
        <div class = \"col-lg-6 col-md-6 col-sm-12 col-xs-12\">
            <div class = \"results-panel\" style = \"background: #fff\">
                <div class = \"list-header\">Details</div>
                <div class = \"result-list-elm\"><span class = \"result-list-title\">Name: </span><%= dealer.name + \" (\" + dealer.code +\")\" %></div>
                <div class = \"result-list-elm\"><span class = \"result-list-title\">Credit Code: </span><%= dealer.credit_code %></div>
                <div class = \"result-list-elm\"><span class = \"result-list-title\">Address line 1: </span><%= dealer.address_street %></div>
                <div class = \"result-list-elm\"><span class = \"result-list-title\">Address line 2: </span><%= dealer.address_part2 %></div>
                <div class = \"result-list-elm\"><span class = \"result-list-title\">City: </span><%= dealer.address_city %></div>
                <div class = \"result-list-elm\"><span class = \"result-list-title\">Postal Code: </span><%= dealer.address_postal_code %></div>
                <div class = \"result-list-elm\"><span class = \"result-list-title\">Phone: </span><%= dealer.mobileno %></div>
            </div>
        </div>
        <div class = \"col-lg-6 col-md-6 col-sm-12 col-xs-12\">
            <div class = \"results-panel\" style = \"background: #fff\">
                <div class = \"list-header\">Attributes</div>
                <div class = \"result-list-elm\"><span class = \"result-list-title\">Segmentation:</span><%= dealer.segmentation %></div>
                <div class = \"result-list-elm\"><span class = \"result-list-title\">CSS Type:</span><%= dealer.css_type %></div>
                <div class = \"result-list-elm\"><span class = \"result-list-title\">Dealer Type:</span><%= dealer.dealer_type %></div>
                <div class = \"result-list-elm\"><span class = \"result-list-title\">Town Tier:</span><%= dealer.town_tier %></div>
                <div class = \"result-list-elm\"><span class = \"result-list-title\">Tie Up Type:</span><%= dealer.tieup_type %></div>
                <div class = \"result-list-elm\"><span class = \"result-list-title\">CSS Date:</span><%= dealer.css_date %></div>
                <div class = \"result-list-elm\"><span class = \"result-list-title\">Segment:</span><%= dealer.segment %></div>
                <div class = \"result-list-elm\"><span class = \"result-list-title\">Attribute 5:</span><%= dealer.attr5 %></div>
                <div class = \"result-list-elm\"><span class = \"result-list-title\">Attribute 9:</span><%= dealer.attr9 %></div>
            </div>
        </div>
    </script>

    <div id=\"n5-dealer-popup\" class=\"n5-popup\" style = \"display: none\">
        <div class=\"n5-template-popup-header\">
            <i class=\"modal_close fa fa-times-circle-o fa-lg\"></i>
        </div>
        <div class = \"row\" id = \"dealer-description\">
            
        </div>
    </div>

";
    }

    // line 284
    public function block_footer($context, array $blocks = array())
    {
    }

    // line 286
    public function block_scripts($context, array $blocks = array())
    {
        // line 287
        echo "    ";
        $this->displayParentBlock("scripts", $context, $blocks);
        echo "
    <script type=\"text/javascript\">
    window.simStatus = {
            \"ready\": \"";
        // line 290
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context["items"]) ? $context["items"] : null), "simStatus", array()), "ready", array()), "html", null, true);
        echo "\",
            \"partial\": \"";
        // line 291
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context["items"]) ? $context["items"] : null), "simStatus", array()), "partial", array()), "html", null, true);
        echo "\",
            \"locked\": \"";
        // line 292
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context["items"]) ? $context["items"] : null), "simStatus", array()), "locked", array()), "html", null, true);
        echo "\",
            \"not_started\": \"";
        // line 293
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context["items"]) ? $context["items"] : null), "simStatus", array()), "not_started", array()), "html", null, true);
        echo "\",
            \"just_started\": \"";
        // line 294
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context["items"]) ? $context["items"] : null), "simStatus", array()), "just_started", array()), "html", null, true);
        echo "\"
        };
    </script>
    <script type=\"text/javascript\" src=";
        // line 297
        echo call_user_func_array($this->env->getFunction('resolvePath')->getCallable(), array("akzo_menu.js"));
        echo "></script>
    <script type=\"text/javascript\" src=";
        // line 298
        echo call_user_func_array($this->env->getFunction('resolvePath')->getCallable(), array("native5.ui.modal.js"));
        echo "></script>
    <script type=\"text/javascript\" src=";
        // line 299
        echo call_user_func_array($this->env->getFunction('resolvePath')->getCallable(), array("autocomplete.js"));
        echo "></script>
    <script type=\"text/javascript\" src=";
        // line 300
        echo call_user_func_array($this->env->getFunction('resolvePath')->getCallable(), array("jquery.multi-select.js"));
        echo "></script>
    <script type=\"text/javascript\" src=";
        // line 301
        echo call_user_func_array($this->env->getFunction('resolvePath')->getCallable(), array("underscore.min.js"));
        echo "></script>
    <script type=\"text/javascript\" src=";
        // line 302
        echo call_user_func_array($this->env->getFunction('resolvePath')->getCallable(), array("backbone.min.js"));
        echo "></script>
    <script type=\"text/javascript\" src=";
        // line 303
        echo call_user_func_array($this->env->getFunction('resolvePath')->getCallable(), array("native5.ui.loader.js"));
        echo "></script>
    <script type=\"text/javascript\" src=";
        // line 304
        echo call_user_func_array($this->env->getFunction('resolvePath')->getCallable(), array("native5.notifications.js"));
        echo "></script>
    <script type=\"text/javascript\" src=";
        // line 305
        echo call_user_func_array($this->env->getFunction('resolvePath')->getCallable(), array("simulation.js"));
        echo "></script>
";
    }

    public function getTemplateName()
    {
        return "simulation.tmpl";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  481 => 305,  477 => 304,  473 => 303,  469 => 302,  465 => 301,  461 => 300,  457 => 299,  453 => 298,  449 => 297,  443 => 294,  439 => 293,  435 => 292,  431 => 291,  427 => 290,  420 => 287,  417 => 286,  412 => 284,  358 => 233,  336 => 214,  332 => 213,  327 => 211,  323 => 210,  316 => 206,  312 => 205,  307 => 203,  303 => 202,  296 => 198,  292 => 197,  287 => 195,  283 => 194,  275 => 189,  271 => 188,  266 => 186,  262 => 185,  256 => 182,  107 => 35,  92 => 34,  88 => 33,  66 => 13,  64 => 12,  60 => 10,  57 => 9,  51 => 6,  46 => 5,  40 => 3,  11 => 1,);
    }
}
