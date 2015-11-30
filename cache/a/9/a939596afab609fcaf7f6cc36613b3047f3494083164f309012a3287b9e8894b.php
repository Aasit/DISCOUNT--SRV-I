<?php

/* template.tmpl */
class __TwigTemplate_a939596afab609fcaf7f6cc36613b3047f3494083164f309012a3287b9e8894b extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 1
        $this->parent = $this->loadTemplate("base.html", "template.tmpl", 1);
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
        $this->loadTemplate("header.tmpl", "template.tmpl", 6)->display($context);
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
        $this->loadTemplate("menu.tmpl", "template.tmpl", 12)->display($context);
        // line 13
        echo "        <div id=\"modelDetails\" style=\"display: none;\" data-model=\"";
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["items"]) ? $context["items"] : null), "schemeData", array()), "html", null, true);
        echo "\" data-state = \"";
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["items"]) ? $context["items"] : null), "state", array()), "html", null, true);
        echo "\" data-id = \"";
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["items"]) ? $context["items"] : null), "schemeCode", array()), "html", null, true);
        echo "\" data-user = \"";
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["items"]) ? $context["items"] : null), "userType", array()), "html", null, true);
        echo "\"></div>
        <section id=\"content-wrapper\">
            <div>
                <a id=\"schemePDF1\" class=\"button-simple pull-right margin-bottom-20 ";
        // line 16
        if (($this->getAttribute((isset($context["items"]) ? $context["items"] : null), "schemeCode", array()) == false)) {
            echo " disabled ";
        }
        echo "\" ";
        if ($this->getAttribute((isset($context["items"]) ? $context["items"] : null), "schemeCode", array())) {
            echo " href=\"scheme/generatePDF?schemeId=";
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context["items"]) ? $context["items"] : null), "schemeCode", array()), "html", null, true);
            echo "&rand_token=";
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context["items"]) ? $context["items"] : null), "nonce", array()), "html", null, true);
            echo "\" ";
        }
        echo ">PDF</a>
            </div>
            
            <div class=\"dashboard-content\">
                <div class=\"margin-bottom-20\">
                    ";
        // line 21
        if ( !twig_test_empty($this->getAttribute((isset($context["items"]) ? $context["items"] : null), "transitions", array()))) {
            // line 22
            echo "                    <button class=\"button-simple n5-template-rfloat\" id=\"show-transitions\">Show Transitions</button>
                    ";
        }
        // line 24
        echo "                    <button class=\"button-simple\" id=\"scheme-from-existing\">Copy Existing Scheme</button>
                </div>
                <div id=\"scheme-details\"></div>
                <div id = \"dealer-attributes\"></div>
                
                <div id=\"qualifying-conditions\">
                    <div class = \"qc-satisfy-container\">
                        <span class=\"n5-ui-qc-right-btn\">
                            <div class=\"n5-radio-toolbar\">
                                <input type=\"radio\" name=\"satisfyAll\" id = \"radio_qca\" class = \"satisfyAll\" value=\"Satisfy All\" checked>
                                <label for=\"radio_qca\">Satisfy All</label>
                                <input type=\"radio\" name=\"satisfyAll\" id = \"radio_qco\" class = \"satisfyOne\" value=\"Satisfy Any One\">
                                <label for=\"radio_qco\">Satisfy Any One</label> 
                            </div>
                        </span>
                    </div>
                    <div id = \"n5-qc-list\">

                    </div>
                    <div  id=\"n5-add-Q-conditions\" align=\"center\">  
                        <button class=\"qc-add-condition button-simple\">Add Qualifying Condition</button>
                    </div>\t
                </div>

                <div id=\"n5-ui-template-add-temp-qc\" style=\"margin-bottom:20px;\">
                    ";
        // line 49
        if ((($this->getAttribute((isset($context["items"]) ? $context["items"] : null), "userType", array()) == "initiator") && (($this->getAttribute((isset($context["items"]) ? $context["items"] : null), "state", array()) == $this->getAttribute($this->getAttribute((isset($context["items"]) ? $context["items"] : null), "defaultStates", array()), "staged", array())) || ($this->getAttribute((isset($context["items"]) ? $context["items"] : null), "state", array()) == $this->getAttribute($this->getAttribute((isset($context["items"]) ? $context["items"] : null), "defaultStates", array()), "updateRequested", array()))))) {
            // line 50
            echo "                        <div class=\"page-footer page-buttons\" style = \"display: none;\">
                            <button id=\"checkTemplateData\" class=\"page-scheme-submit\">Submit</button>
                            <button id=\"updateTemplateData\" class=\"page-scheme-submit\">Update</button>
                            <button id=\"sendTemplateData\" class=\"page-scheme-submit\">Send</button>
                        </div>
                    ";
        } elseif ((($this->getAttribute(        // line 55
(isset($context["items"]) ? $context["items"] : null), "userType", array()) == "reviewer") && ($this->getAttribute((isset($context["items"]) ? $context["items"] : null), "state", array()) == $this->getAttribute($this->getAttribute((isset($context["items"]) ? $context["items"] : null), "defaultStates", array()), "initiated", array())))) {
            // line 56
            echo "                        <div class=\"page-footer page-buttons\" style = \"display: none;\">
                            <button id=\"checkTemplateData\" class=\"page-scheme-submit\">Submit</button>
                            <button id=\"updateTemplateData\" class=\"page-scheme-submit\">Update</button>
                            <button id=\"sendTemplateData\" class=\"page-scheme-submit\">Send</button>
                        </div>
                    ";
        } elseif ((($this->getAttribute(        // line 61
(isset($context["items"]) ? $context["items"] : null), "userType", array()) == "approver") && ($this->getAttribute((isset($context["items"]) ? $context["items"] : null), "state", array()) == $this->getAttribute($this->getAttribute((isset($context["items"]) ? $context["items"] : null), "defaultStates", array()), "reviewed", array())))) {
            // line 62
            echo "                        <div class=\"page-footer page-buttons\" style = \"display: none;\">
                            <button id=\"checkTemplateData\" class=\"page-scheme-submit\">Submit</button>
                            <button id=\"updateTemplateData\" class=\"page-scheme-submit\">Update</button>
                            <button id=\"sendTemplateData\" class=\"page-scheme-submit\">Send</button>
                        </div>
                    ";
        } elseif (($this->getAttribute(        // line 67
(isset($context["items"]) ? $context["items"] : null), "userType", array()) == "creator")) {
            // line 68
            echo "                        <div class=\"page-footer page-buttons\" style = \"display: none;\">
                            <button id=\"checkTemplateData\" class=\"page-scheme-submit\">Submit</button>
                            <button id=\"updateTemplateData\" class=\"page-scheme-submit\">Update</button>
                            <button id=\"sendTemplateData\" class=\"page-scheme-submit\">Send</button>
                        </div>
                    ";
        }
        // line 74
        echo "                </div>

                <div class=\"n5-popup\" style=\"display: none\" id=\"n5-template-popup\">
                    <div class=\"n5-template-popup-header\">
                        <i class=\"modal_close fa fa-times-circle-o fa-lg\"></i>
                    </div>
                    <div class=\"row\">
                        <div class=\"col-md-12\" style=\"margin-top: 20px;\">
                            <div class=\"col-md-2\">
                                <button id=\"n5-ui-template-modal-inBill\" class=\"button-simple col-md-10\">inBill</button>
                            </div>
                            <div class=\"col-md-2\">
                                <button id=\"n5-ui-template-modal-ppi\" class=\"button-simple col-md-10\">PPI</button>
                            </div>
                            <div class=\"col-md-2\">
                                <button id=\"n5-ui-template-modal-pri\" class=\"button-simple col-md-10\">PRI</button>
                            </div>
                            <div class=\"col-md-2\">
                                <button id=\"n5-ui-template-modal-slab\" class=\"button-simple col-md-10\">SLAB</button>
                            </div>
                            <div class=\"col-md-2\">
                                <button id=\"n5-ui-template-modal-newSlab\" class=\"button-simple col-md-10\">NEWSLAB</button>
                            </div>
                            <div class=\"col-md-2\">
                                <button id=\"n5-ui-template-modal-newPpi\" class=\"button-simple col-md-10\">NEWPPI</button>
                            </div>
                            <div class=\"col-md-2\" style=\"margin-top: 10px;\">
                                <button id=\"n5-ui-template-modal-slabv3\" class=\"button-simple col-md-10\">SLABV3</button>
                            </div>
                        </div>
                    </div>
                    <div class=\"row\">
                        <div class=\"col-md-4\" style=\"margin-top: 20px;\">
                            <button id=\"copyTemplate\" class=\"button-simple col-md-12\">Copy Template</button>
                        </div>
                        <div class=\"col-md-8 template-list\" style=\"margin-top: 20px;\">
                            <select class=\"col-md-4 copy-template-select select-dropdown n5-ui-sc-label-sub\" id=\"listTemplate\">
                                <option>Select Template ..</option>
                            </select>

                            <select class=\"col-md-4 copy-template-select select-dropdown n5-ui-sc-label-sub\" id=\"copiesTemplate\">
                                <option>1</option>
                                <option>2</option>
                                <option>3</option>
                                <option>4</option>
                                <option>5</option>
                                <option>6</option>
                                <option>7</option>
                                <option>8</option>
                                <option>9</option>
                                <option>10</option>
                            </select>

                            <button id=\"copyTemplateAction\" class=\"button-simple col-md-2 col-md-offset-1\">Copy</button>
                        </div>
                    </div>
                </div>

                <div id=\"n5-scheme-popup\" class=\"n5-popup\" style = \"display: none\">
                    <div class=\"n5-template-popup-header\">
                        <i class=\"modal_close fa fa-times-circle-o fa-lg\"></i>
                    </div>
                    <div class = \"row\">
                        <div class = \"col-lg-6 col-sm-12 col-xs-12\">
                            <div id = \"active-schemes\" style = \"max-height: 250px\">
                                ";
        // line 139
        $this->loadTemplate("copy_activeSchemes.tmpl", "template.tmpl", 139)->display($context);
        // line 140
        echo "                            </div>
                            <div id = \"draft-schemes\" style = \"max-height: 250px\">
                                ";
        // line 142
        $this->loadTemplate("copy_draftSchemes.tmpl", "template.tmpl", 142)->display($context);
        // line 143
        echo "                            </div>
                        </div>
                        <div class = \"col-lg-6 col-sm-12 col-xs-12\">
                            <div id = \"schemes-pending-approval\" style = \"max-height: 250px\">
                                ";
        // line 147
        $this->loadTemplate("copy_schemesPendingApproval.tmpl", "template.tmpl", 147)->display($context);
        // line 148
        echo "                            </div>
                        </div>
                    </div>
                </div>

                <div id=\"n5-slab-qc-popup\" class = \"n5-popup\" style = \"display: none\">
                    <div id=\"n5-template-popup-header\">
                        <i class=\"modal_close fa fa-times-circle-o fa-lg\"></i>
                    </div>
                    <div class = \"row\">
                        <div class = \"col-lg-12 col-sm-12 col-xs-12\" id = \"slab-qc-container\">
                            
                        </div>

                        <button class = \"button-simple button-right\" id = \"add-qc-inslab\">Add Qualifying Condition</button>
                        <button class = \"button-simple button-right\" id = \"add-qc-inslab-done\" style = \"margin-right: 10px\" >Done</button>
                        <button class = \"button-simple button-right\" style = \"margin-right: 10px\" id = \"remove-qc-slab\">Delete</button>
                        
                    </div>
                </div>

                <div id=\"n5-timeline-popup\" class=\"n5-popup\" style = \"display: none\">
                    <div class=\"n5-template-popup-header\">
                        <i class=\"modal_close fa fa-times-circle-o fa-lg\"></i>
                    </div>
                    <div class = \"row\">
                        <div class = \"col-lg-12 col-sm-12 col-xs-12 timeline-container\">
                            <ul class=\"cbp_tmtimeline\">
                                ";
        // line 176
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_ensure_traversable($this->getAttribute((isset($context["items"]) ? $context["items"] : null), "transitions", array()));
        $context['loop'] = array(
          'parent' => $context['_parent'],
          'index0' => 0,
          'index'  => 1,
          'first'  => true,
        );
        if (is_array($context['_seq']) || (is_object($context['_seq']) && $context['_seq'] instanceof Countable)) {
            $length = count($context['_seq']);
            $context['loop']['revindex0'] = $length - 1;
            $context['loop']['revindex'] = $length;
            $context['loop']['length'] = $length;
            $context['loop']['last'] = 1 === $length;
        }
        foreach ($context['_seq'] as $context["_key"] => $context["item"]) {
            // line 177
            echo "                                ";
            if ($this->getAttribute($context["loop"], "last", array())) {
                // line 178
                echo "                                    <li>
                                        <time class=\"cbp_tmtime\" datetime=\"2013-04-10 18:30\">
                                        <span>";
                // line 180
                echo twig_escape_filter($this->env, $this->getAttribute($context["item"], "date", array()), "html", null, true);
                echo "</span> <span>";
                echo twig_escape_filter($this->env, $this->getAttribute($context["item"], "time", array()), "html", null, true);
                echo "</span></time>
                                        <div class=\"cbp_tmicon tooltip\" tip-title = \"";
                // line 181
                echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($this->getAttribute((isset($context["items"]) ? $context["items"] : null), "stateNamesMap", array()), $this->getAttribute($context["item"], "before_state", array()), array(), "array"), "title", array()), "html", null, true);
                echo "\"><i class = \"fa fa-";
                echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($this->getAttribute((isset($context["items"]) ? $context["items"] : null), "stateNamesMap", array()), $this->getAttribute($context["item"], "before_state", array()), array(), "array"), "icon", array()), "html", null, true);
                echo "\"></i></div>
                                        <div class=\"cbp_tmlabel\">
                                            <h2>";
                // line 183
                echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($this->getAttribute((isset($context["items"]) ? $context["items"] : null), "transitionNamesMap", array()), $this->getAttribute($context["item"], "type", array()), array(), "array"), "name", array()), "html", null, true);
                echo "</h2>
                                            <p>";
                // line 184
                echo twig_escape_filter($this->env, $this->getAttribute($context["item"], "comments", array()), "html", null, true);
                echo "</p>
                                        </div>
                                        <div class=\"cbp_tmicon last tooltip\" tip-title = \"";
                // line 186
                echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($this->getAttribute((isset($context["items"]) ? $context["items"] : null), "stateNamesMap", array()), $this->getAttribute($context["item"], "after_state", array()), array(), "array"), "title", array()), "html", null, true);
                echo "\"><i class = \"fa fa-";
                echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($this->getAttribute((isset($context["items"]) ? $context["items"] : null), "stateNamesMap", array()), $this->getAttribute($context["item"], "after_state", array()), array(), "array"), "icon", array()), "html", null, true);
                echo "\"></i></div>
                                    </li>
                                ";
            } else {
                // line 189
                echo "                                    <li>
                                        <time class=\"cbp_tmtime\" datetime=\"2013-04-10 18:30\">
                                        <span>";
                // line 191
                echo twig_escape_filter($this->env, $this->getAttribute($context["item"], "date", array()), "html", null, true);
                echo "</span> <span>";
                echo twig_escape_filter($this->env, $this->getAttribute($context["item"], "time", array()), "html", null, true);
                echo "</span></time>
                                        <div class=\"cbp_tmicon tooltip\" tip-title = \"";
                // line 192
                echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($this->getAttribute((isset($context["items"]) ? $context["items"] : null), "stateNamesMap", array()), $this->getAttribute($context["item"], "before_state", array()), array(), "array"), "title", array()), "html", null, true);
                echo "\"><i class = \"fa fa-";
                echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($this->getAttribute((isset($context["items"]) ? $context["items"] : null), "stateNamesMap", array()), $this->getAttribute($context["item"], "before_state", array()), array(), "array"), "icon", array()), "html", null, true);
                echo "\"></i></div>
                                        <div class=\"cbp_tmlabel\">
                                            <h2>";
                // line 194
                echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($this->getAttribute((isset($context["items"]) ? $context["items"] : null), "transitionNamesMap", array()), $this->getAttribute($context["item"], "type", array()), array(), "array"), "name", array()), "html", null, true);
                echo "</h2>
                                            <p>";
                // line 195
                echo twig_escape_filter($this->env, $this->getAttribute($context["item"], "comments", array()), "html", null, true);
                echo "</p>
                                        </div>
                                    </li>
                                ";
            }
            // line 199
            echo "                                ";
            ++$context['loop']['index0'];
            ++$context['loop']['index'];
            $context['loop']['first'] = false;
            if (isset($context['loop']['length'])) {
                --$context['loop']['revindex0'];
                --$context['loop']['revindex'];
                $context['loop']['last'] = 0 === $context['loop']['revindex0'];
            }
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['item'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 200
        echo "                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Product Exclusion Modal -->
                <div id=\"n5-product-select-popup\" class=\"n5-popup\" style = \"display: none; top: 50px;\">
                    <div class=\"n5-template-popup-header\">
                        <i class=\"modal_close fa fa-times-circle-o fa-lg\"></i>
                    </div>
                    <div class = \"row\">
                        <div class = \"col-lg-12 col-md-12 col-sm-12 col-xs-12\">
                            <div>Select Items</div>
                            <input type=\"text\" id=\"selectInclude\" />
                        </div>
                        <!-- <div class = \"col-lg-6 col-md-6 col-sm-12 col-xs-12\">
                            <div>Excluded Products</div>
                            <input type=\"text\" id=\"selectExclude\" />
                        </div> -->
                    </div>
                    <div class = \"row\">
                        <div class = \"col-lg-12 col-md-12 col-sm-12 col-xs-12\" style=\"margin-top: 10px;\">
                            <div class=\"col-md-8\" style=\"padding: 0 !important;\">
                                Result
                                <button class = \"highlight-button product-manipulate-all\">Include All</button>
                                <button class = \"highlight-button product-manipulate-all\">Exclude All</button>
                            </div>
                            <div id=\"selectResult\" class=\"col-md-8 prod-exclusion-ul\"></div>
                        </div>
                    </div>
                    <div class=\"row\">
                        <div class=\"col-md-12\">
                            <button class=\"btn col-md-2 col-md-offset-9\" id=\"prodExclusionSubmit\">Submit</button>
                        </div>
                    </div>
                </div>
                <!-- Product Exlusion Modal -->

                <div class=\"comment-popup\" id=\"n5-comment-popup\" style=\"display: none;\">
                    <div class=\"n5-template-popup-header\">
                        <i class=\"modal_close fa fa-times-circle-o fa-lg\"></i>
                    </div>
                    <div class=\"row\">
                        <textarea placeholder=\"Comment\" id=\"n5-comment-box\"></textarea>
                    </div>
                    <div class=\"row\">
                        <button class=\"btn btn-primary pull-right\" id=\"n5-comment-submit\">Submit</button>
                    </div>
                </div>

                <script type = \"text/template\" id = \"schemeHeader\">
                    <span class=\"n5-ui-sc-col col-lg-4 col-md-6 col-sm-12 col-xs-12\" tip-title=\"Cannot be Empty\">
                        <label class=\"n5-ui-sc-label\" for=\"templateno\">Scheme Name</label>
                        <input class=\"n5-template-box scheme-name\" placeholder=\"Enter Scheme Name\" type=\"text\" value = \"<%= schemeHeader.name %>\"/>
                        <!-- <div class=\"n5-template-sd-temno-label\" name=\"templateno\">XYZVVN</div> -->
                    </span>

                    <span class=\"n5-ui-sc-col col-lg-4 col-md-6 col-sm-12 col-xs-12\">
                        <label for=\"segment\" class=\"n5-ui-sc-label\">Segment</label>
                        <span  id=\"n5-segment-type\" name=\"segment\">
                            <select multiple class = \"n5-segment-select\">
                                ";
        // line 261
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_ensure_traversable($this->getAttribute((isset($context["items"]) ? $context["items"] : null), "segmentTypes", array()));
        foreach ($context['_seq'] as $context["_key"] => $context["item"]) {
            // line 262
            echo "                                    <option value=\"";
            echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($context["item"], "attr", array()), "value", array()), "html", null, true);
            echo "\" <% if(schemeHeader.segment){ if (schemeHeader.segment.indexOf(\"";
            echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($context["item"], "attr", array()), "value", array()), "html", null, true);
            echo "\") >= 0) { %>selected<% }} %> >";
            echo twig_escape_filter($this->env, $this->getAttribute($context["item"], "textStr", array()), "html", null, true);
            echo "</option>
                                ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['item'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 264
        echo "                            </select>
                        </span>
                    </span>

                    <span class=\"n5-ui-sc-col col-lg-4 col-md-6 col-sm-12 col-xs-12\">
                        <label for=\"first_name\" class=\"n5-ui-sc-label\">Scheme Type</label>
                        <span id=\"n5-scheme-type\">
                            <select class = \"n5-schemetype-select\" >
                                ";
        // line 272
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_ensure_traversable($this->getAttribute((isset($context["items"]) ? $context["items"] : null), "schemeTypes", array()));
        foreach ($context['_seq'] as $context["_key"] => $context["item"]) {
            // line 273
            echo "                                    <option value=\"";
            echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($context["item"], "attr", array()), "value", array()), "html", null, true);
            echo "\" <% if (\"";
            echo twig_escape_filter($this->env, $this->getAttribute($context["item"], "textStr", array()), "html", null, true);
            echo "\" == schemeHeader.type) { %>selected<% } %> >";
            echo twig_escape_filter($this->env, $this->getAttribute($context["item"], "textStr", array()), "html", null, true);
            echo "</option>
                                ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['item'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 275
        echo "                            </select>
                        </span>
                    </span>

                    <span class=\"n5-ui-sc-col col-lg-4 col-md-6 col-sm-12 col-xs-12\" tip-title = \"Cannot be Empty\">
                        <label for=\"first_name\" class=\"n5-ui-sc-label\">Sales Geography</label>
                        <span  id=\"n5-sales-geography\" >
                            <button class=\"n5-template-box geography-select\">Select Geography</button>
                        </span>
                    </span>

                    <span class=\"n5-ui-sc-col col-lg-4 col-md-6 col-sm-12 col-xs-12\">
                        <label for=\"first_name\" class=\"n5-ui-sc-label\">Sales Period</label>
                        <div class=\"input-prepend input-group\">
                            <span class=\"add-on input-group-addon\">
                                <i class=\"glyphicon glyphicon-calendar fa fa-calendar\"></i>
                            </span>
                            <input type=\"text\" name=\"sales-period\" id=\"sales-period\" class=\"form-control\" placeholder = \"Select Sales Period\" readonly /> 
                        </div>      
                    </span>

                    <span class=\"n5-ui-sc-col col-lg-4 col-md-6 col-sm-12 col-xs-12\">
                        <label for=\"first_name\" class=\"n5-ui-sc-label\">Dealers Attribute</label>
                        <span  id=\"n5-dealers-attribute\">
                            <Button class = \"dealer-attr-button n5-template-box\"> Update Dealer Attributes</Button>
                        </span>
                    </span>

                    <span class = \"n5-ui-sc-col-sp-cor col-lg-6 col-md-8 col-sm-12 col-xs-12\">
                        <label for=\"termsConditions\" class=\"n5-ui-sc-label\">Terms and Conditions</label>
                        <textarea class = \"input-terms-conditions\" ><% if (typeof schemeHeader.terms !== \"undefined\"){ %><%= schemeHeader.terms%><%}%></textarea>    
                    </span>

                    <div id=\"n5-dealer-attr-popup\" class = \"n5-popup n5-dealer-attr\" style = \"display: none\">
                        <div id=\"n5-template-popup-header\">
                            <i class=\"modal_close fa fa-times-circle-o fa-lg\"></i>
                        </div>
                        <div class = \"row\">
                            
                            ";
        // line 314
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_ensure_traversable($this->getAttribute((isset($context["items"]) ? $context["items"] : null), "dealerTypes", array()));
        foreach ($context['_seq'] as $context["_key"] => $context["attribute"]) {
            // line 315
            echo "                                <div class = \"col-lg-4 col-md-4 col-sm-6 col-xs-12\">
                                    <div class = \"dealertype-select-container\">
                                        <div class = \"dealertype-select-title\"> ";
            // line 317
            echo twig_escape_filter($this->env, $this->getAttribute($context["attribute"], "name", array()), "html", null, true);
            echo " </div>
                                        <div class = \"dealertype-select-content\" data-value = \"";
            // line 318
            echo twig_escape_filter($this->env, $this->getAttribute($context["attribute"], "value", array()), "html", null, true);
            echo "\">
                                            ";
            // line 319
            $context['_parent'] = (array) $context;
            $context['_seq'] = twig_ensure_traversable($this->getAttribute($context["attribute"], "children", array()));
            foreach ($context['_seq'] as $context["_key"] => $context["val"]) {
                // line 320
                echo "                                                <div class = \"dealertype-value-container\" data-value = \"";
                echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($context["val"], "attr", array()), "value", array()), "html", null, true);
                echo "\">
                                                    <button class = \"highlight-button dealertype-include-button tooltip noleft
                                                    <% if(schemeHeader.dealerAttributes){
                                                        if (_.findWhere(
                                                            schemeHeader.dealerAttributes, 
                                                            {\"id\": \"";
                // line 325
                echo twig_escape_filter($this->env, $this->getAttribute($context["attribute"], "value", array()), "html", null, true);
                echo "\"+\"";
                echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($context["val"], "attr", array()), "value", array()), "html", null, true);
                echo "\"+\"false\"})
                                                        ) { %>selected<% }} %> \" tip-title = \"Include\"><i class = \"fa fa-plus\"></i></button>

                                                    <button class = \"highlight-button dealertype-exclude-button tooltip noleft
                                                    <% if(schemeHeader.dealerAttributes){
                                                        if (_.findWhere(
                                                            schemeHeader.dealerAttributes, 
                                                            {\"id\": \"";
                // line 332
                echo twig_escape_filter($this->env, $this->getAttribute($context["attribute"], "value", array()), "html", null, true);
                echo "\"+\"";
                echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($context["val"], "attr", array()), "value", array()), "html", null, true);
                echo "\"+\"true\"})
                                                        ) { %>selected<% }} %> \" tip-title = \"Exclude\"><i class = \"fa fa-minus\"></i></button>
                                                    <div class = \"dealertype-value\" >";
                // line 334
                echo twig_escape_filter($this->env, $this->getAttribute($context["val"], "textStr", array()), "html", null, true);
                echo "</div>
                                                </div>
                                            ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['val'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 337
            echo "                                        </div>
                                    </div>
                                </div>
                            ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['attribute'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 341
        echo "                            
                        </div>
                    </div>

                </script>

                ";
        // line 347
        $this->loadTemplate("ppiTemplate.tmpl", "template.tmpl", 347)->display($context);
        // line 348
        echo "
                ";
        // line 349
        $this->loadTemplate("newPpiTemplate.tmpl", "template.tmpl", 349)->display($context);
        // line 350
        echo "
                ";
        // line 351
        $this->loadTemplate("slabTemplate.tmpl", "template.tmpl", 351)->display($context);
        // line 352
        echo "
                ";
        // line 353
        $this->loadTemplate("slabV3Template.tmpl", "template.tmpl", 353)->display($context);
        // line 354
        echo "
                ";
        // line 355
        $this->loadTemplate("priTemplate.tmpl", "template.tmpl", 355)->display($context);
        // line 356
        echo "
                ";
        // line 357
        $this->loadTemplate("inBillTemplate.tmpl", "template.tmpl", 357)->display($context);
        // line 358
        echo "
                ";
        // line 359
        $this->loadTemplate("newSlabTemplate.tmpl", "template.tmpl", 359)->display($context);
        // line 360
        echo "
                <script type = \"text/template\" id=\"n5-ui-template-qualCond-template\">
                    <div class=\"n5-template-qc-conditions\">
                        <div class=\"n5-ui-qc-btn-par-close\">
                            <i class=\"n5-tempate-close-condition fa fa-times-circle-o pull-right\">
                            </i>
                        </div>
                        <div class=\"n5-template-qc-conditions-row\">
                            <span class=\"n5-template-qc-conditions-col\" >
                                <select class = \"n5-qctype-select\" >
                                    ";
        // line 370
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_ensure_traversable($this->getAttribute((isset($context["items"]) ? $context["items"] : null), "qcBasevalue", array()));
        foreach ($context['_seq'] as $context["_key"] => $context["item"]) {
            // line 371
            echo "                                        <option value=\"";
            echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($context["item"], "attr", array()), "value", array()), "html", null, true);
            echo "\" <% if(typeof name !== \"undefined\" && typeof type !== \"undefined\"){ if (\"";
            echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($context["item"], "attr", array()), "value", array()), "html", null, true);
            echo "\".toUpperCase() == name + \" \" + type) { %>selected<% }} %>>";
            echo twig_escape_filter($this->env, $this->getAttribute($context["item"], "textStr", array()), "html", null, true);
            echo "</option>
                                    ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['item'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 373
        echo "                                </select>
                            </span>
                            <span class=\"n5-template-qc-conditions-col\">
                                <select class = \"n5-operator-select\">
                                    ";
        // line 377
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_ensure_traversable($this->getAttribute((isset($context["items"]) ? $context["items"] : null), "qcOperator", array()));
        foreach ($context['_seq'] as $context["_key"] => $context["item"]) {
            // line 378
            echo "                                        <option value=\"";
            echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($context["item"], "attr", array()), "value", array()), "html", null, true);
            echo "\" <% if(typeof op !== \"undefined\"){ if (\"";
            echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($context["item"], "attr", array()), "value", array()), "html", null, true);
            echo "\" == op) { %>selected<% }} %> >";
            echo twig_escape_filter($this->env, $this->getAttribute($context["item"], "textStr", array()), "html", null, true);
            echo "</option>
                                    ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['item'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 380
        echo "                                </select>
                            </span>
                            <span class = \"n5-input-value-container\">
                                <span class=\"n5-template-qc-conditions-col\" tip-title = \"Value should be a Number\" >
                                    <input class=\"qc-template-box n5-ui-qc-input-value\" placeholder=\"Value\" type=\"text\" value = <% if (typeof val !== \"undefined\"){ %>\"<%= val %>\" <% } %> />
                                </span>
                            </span>
                            <span class = \"n5-input-datepicker-container\">
                                <span class=\"n5-template-qc-conditions-col\">
                                        <span class=\"add-on input-group-addon\">
                                            <i class=\"glyphicon glyphicon-calendar fa fa-calendar\"></i>
                                        </span>
                                        <input type=\"text\" name=\"sales-period\" class=\"qc-template-box n5-ui-qc-input-datepicker\" readonly placeholder = \"Select Period\" /> 
                                </span>
                                <span class=\"n5-template-qc-conditions-col\" tip-title=\"Cannot be Empty\">
                                    <span class=\"n5-qc-multi-check\">
                                        <button class = \"qc-template-box input-product-select qc-product-select\">Update Products</button>
                                    </span>
                                </span>
                            </span>
                            <span class=\"n5-template-qc-conditions-col\" >
                                <span id=\"n5-add-percentage1\" tip-title = \"Should lie in 1~100\">
                                    <input class=\"qc-template-box n5-ui-qc-input-payout\" placeholder=\"Payout Percentage %\" type=\"text\" value = <% if (typeof payoutCondition !== \"undefined\"){ %>\"<%= payoutCondition %>\" <% } %> />

                                </span>
                            </span>
                            <div class = \"n5-template-qc-segment-checkbox\">

                            </div>
                        </div>
                    </div>

                </script>
            </div>
        </section>
    </div>

";
    }

    // line 419
    public function block_footer($context, array $blocks = array())
    {
    }

    // line 421
    public function block_scripts($context, array $blocks = array())
    {
        // line 422
        echo "    ";
        $this->displayParentBlock("scripts", $context, $blocks);
        echo "

    <!-- External libs -->
    <script type=\"text/javascript\" src=";
        // line 425
        echo call_user_func_array($this->env->getFunction('resolvePath')->getCallable(), array("moment.min.js"));
        echo "></script>
    <script type=\"text/javascript\" src=";
        // line 426
        echo call_user_func_array($this->env->getFunction('resolvePath')->getCallable(), array("daterangepicker.js"));
        echo "></script>
    <script type=\"text/javascript\" src=";
        // line 427
        echo call_user_func_array($this->env->getFunction('resolvePath')->getCallable(), array("native5.select2.js"));
        echo "></script>
    <script type=\"text/javascript\" src=";
        // line 428
        echo call_user_func_array($this->env->getFunction('resolvePath')->getCallable(), array("underscore.min.js"));
        echo "></script>
    <script type=\"text/javascript\" src=";
        // line 429
        echo call_user_func_array($this->env->getFunction('resolvePath')->getCallable(), array("backbone.min.js"));
        echo "></script>
    <!-- n5 wrappers -->
    <script type=\"text/javascript\" src=";
        // line 431
        echo call_user_func_array($this->env->getFunction('resolvePath')->getCallable(), array("native5.ui.card.js"));
        echo "></script>
    <script type=\"text/javascript\" src=";
        // line 432
        echo call_user_func_array($this->env->getFunction('resolvePath')->getCallable(), array("native5.ui.modal.js"));
        echo "></script>
    <script type=\"text/javascript\" src=";
        // line 433
        echo call_user_func_array($this->env->getFunction('resolvePath')->getCallable(), array("native5.ui.tab.js"));
        echo "></script>
    <script type=\"text/javascript\" src=";
        // line 434
        echo call_user_func_array($this->env->getFunction('resolvePath')->getCallable(), array("native5.ui.table.js"));
        echo "></script>
    <script type=\"text/javascript\" src=";
        // line 435
        echo call_user_func_array($this->env->getFunction('resolvePath')->getCallable(), array("native5.ui.select.js"));
        echo "></script>
    <script type=\"text/javascript\" src=";
        // line 436
        echo call_user_func_array($this->env->getFunction('resolvePath')->getCallable(), array("native5.ui.loader.js"));
        echo "></script>
    <script type=\"text/javascript\" src=";
        // line 437
        echo call_user_func_array($this->env->getFunction('resolvePath')->getCallable(), array("native5.notifications.js"));
        echo "></script>
    <!-- akzo wrappers -->
    <script type=\"text/javascript\" src=";
        // line 439
        echo call_user_func_array($this->env->getFunction('resolvePath')->getCallable(), array("akzo.ui.select.multiple.js"));
        echo "></script>
    <script type=\"text/javascript\" src=";
        // line 440
        echo call_user_func_array($this->env->getFunction('resolvePath')->getCallable(), array("akzo.ui.exclusionSelect.js"));
        echo "></script>
    <script type=\"text/javascript\" src=";
        // line 441
        echo call_user_func_array($this->env->getFunction('resolvePath')->getCallable(), array("akzo.ui.ppiTemplate.js"));
        echo "></script>
    <script type=\"text/javascript\" src=";
        // line 442
        echo call_user_func_array($this->env->getFunction('resolvePath')->getCallable(), array("akzo.ui.newPpiTemplate.js"));
        echo "></script>
    <script type=\"text/javascript\" src=";
        // line 443
        echo call_user_func_array($this->env->getFunction('resolvePath')->getCallable(), array("akzo.ui.inBillTemplate.js"));
        echo "></script>
    <script type=\"text/javascript\" src=";
        // line 444
        echo call_user_func_array($this->env->getFunction('resolvePath')->getCallable(), array("akzo.ui.newSlabTemplate.js"));
        echo "></script>
    <script type=\"text/javascript\" src=";
        // line 445
        echo call_user_func_array($this->env->getFunction('resolvePath')->getCallable(), array("akzo.ui.priTemplate.js"));
        echo "></script>
    <script type=\"text/javascript\" src=";
        // line 446
        echo call_user_func_array($this->env->getFunction('resolvePath')->getCallable(), array("akzo.ui.slabTemplate.js"));
        echo "></script>
    <script type=\"text/javascript\" src=";
        // line 447
        echo call_user_func_array($this->env->getFunction('resolvePath')->getCallable(), array("akzo.ui.slabV3Template.js"));
        echo "></script>
    <script type=\"text/javascript\" src=";
        // line 448
        echo call_user_func_array($this->env->getFunction('resolvePath')->getCallable(), array("akzo_menu.js"));
        echo "></script>
    <script type=\"text/javascript\">
        window.defaultStates = {
            \"staged\": \"";
        // line 451
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context["items"]) ? $context["items"] : null), "defaultStates", array()), "staged", array()), "html", null, true);
        echo "\",
            \"initiated\": \"";
        // line 452
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context["items"]) ? $context["items"] : null), "defaultStates", array()), "initiated", array()), "html", null, true);
        echo "\",
            \"updateRequested\": \"";
        // line 453
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context["items"]) ? $context["items"] : null), "defaultStates", array()), "updateRequested", array()), "html", null, true);
        echo "\",
            \"reviewed\": \"";
        // line 454
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context["items"]) ? $context["items"] : null), "defaultStates", array()), "reviewed", array()), "html", null, true);
        echo "\",
            \"approved\": \"";
        // line 455
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context["items"]) ? $context["items"] : null), "defaultStates", array()), "approved", array()), "html", null, true);
        echo "\"
        };
    </script>


    <script type=\"text/javascript\" src=";
        // line 460
        echo call_user_func_array($this->env->getFunction('resolvePath')->getCallable(), array("models_default.js"));
        echo "></script>
    <script type=\"text/javascript\" src=";
        // line 461
        echo call_user_func_array($this->env->getFunction('resolvePath')->getCallable(), array("model.schemeDetail.js"));
        echo "></script>
    <script type=\"text/javascript\" src=";
        // line 462
        echo call_user_func_array($this->env->getFunction('resolvePath')->getCallable(), array("model.qualifyingCondition.js"));
        echo "></script>
    <script type=\"text/javascript\" src=";
        // line 463
        echo call_user_func_array($this->env->getFunction('resolvePath')->getCallable(), array("model.qualifyingConditions.js"));
        echo "></script>
    <script type=\"text/javascript\" src=";
        // line 464
        echo call_user_func_array($this->env->getFunction('resolvePath')->getCallable(), array("model.templateModel.js"));
        echo "></script>
    <script type=\"text/javascript\" src=";
        // line 465
        echo call_user_func_array($this->env->getFunction('resolvePath')->getCallable(), array("model.slabView.js"));
        echo "></script>
    <script type=\"text/javascript\" src=";
        // line 466
        echo call_user_func_array($this->env->getFunction('resolvePath')->getCallable(), array("model.slabV3View.js"));
        echo "></script>
    <script type=\"text/javascript\" src=";
        // line 467
        echo call_user_func_array($this->env->getFunction('resolvePath')->getCallable(), array("model.ppiView.js"));
        echo "></script>
    <script type=\"text/javascript\" src=";
        // line 468
        echo call_user_func_array($this->env->getFunction('resolvePath')->getCallable(), array("model.newPpiView.js"));
        echo "></script>
    <script type=\"text/javascript\" src=";
        // line 469
        echo call_user_func_array($this->env->getFunction('resolvePath')->getCallable(), array("model.priView.js"));
        echo "></script>
    <script type=\"text/javascript\" src=";
        // line 470
        echo call_user_func_array($this->env->getFunction('resolvePath')->getCallable(), array("model.inBillView.js"));
        echo "></script>
    <script type=\"text/javascript\" src=";
        // line 471
        echo call_user_func_array($this->env->getFunction('resolvePath')->getCallable(), array("model.newSlabView.js"));
        echo "></script>
    <script type=\"text/javascript\" src=";
        // line 472
        echo call_user_func_array($this->env->getFunction('resolvePath')->getCallable(), array("template.js"));
        echo "></script>

    
";
    }

    public function getTemplateName()
    {
        return "template.tmpl";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  894 => 472,  890 => 471,  886 => 470,  882 => 469,  878 => 468,  874 => 467,  870 => 466,  866 => 465,  862 => 464,  858 => 463,  854 => 462,  850 => 461,  846 => 460,  838 => 455,  834 => 454,  830 => 453,  826 => 452,  822 => 451,  816 => 448,  812 => 447,  808 => 446,  804 => 445,  800 => 444,  796 => 443,  792 => 442,  788 => 441,  784 => 440,  780 => 439,  775 => 437,  771 => 436,  767 => 435,  763 => 434,  759 => 433,  755 => 432,  751 => 431,  746 => 429,  742 => 428,  738 => 427,  734 => 426,  730 => 425,  723 => 422,  720 => 421,  715 => 419,  674 => 380,  661 => 378,  657 => 377,  651 => 373,  638 => 371,  634 => 370,  622 => 360,  620 => 359,  617 => 358,  615 => 357,  612 => 356,  610 => 355,  607 => 354,  605 => 353,  602 => 352,  600 => 351,  597 => 350,  595 => 349,  592 => 348,  590 => 347,  582 => 341,  573 => 337,  564 => 334,  557 => 332,  545 => 325,  536 => 320,  532 => 319,  528 => 318,  524 => 317,  520 => 315,  516 => 314,  475 => 275,  462 => 273,  458 => 272,  448 => 264,  435 => 262,  431 => 261,  368 => 200,  354 => 199,  347 => 195,  343 => 194,  336 => 192,  330 => 191,  326 => 189,  318 => 186,  313 => 184,  309 => 183,  302 => 181,  296 => 180,  292 => 178,  289 => 177,  272 => 176,  242 => 148,  240 => 147,  234 => 143,  232 => 142,  228 => 140,  226 => 139,  159 => 74,  151 => 68,  149 => 67,  142 => 62,  140 => 61,  133 => 56,  131 => 55,  124 => 50,  122 => 49,  95 => 24,  91 => 22,  89 => 21,  71 => 16,  58 => 13,  56 => 12,  52 => 10,  49 => 9,  43 => 6,  38 => 5,  32 => 3,  11 => 1,);
    }
}
