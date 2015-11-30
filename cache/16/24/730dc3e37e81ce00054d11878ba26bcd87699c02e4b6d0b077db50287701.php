<?php

/* newPpiTemplate.tmpl */
class __TwigTemplate_1624730dc3e37e81ce00054d11878ba26bcd87699c02e4b6d0b077db50287701 extends Twig_Template
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
        echo "<script type = \"text/template\" id=\"n5-ui-template-newPpi-template\">
    <div class =\" n5-template-container\" id=\"n5-ui-newPpi<%= counter %>\">
        <div class=\"row\">
            <div class=\"col-md-12\">
                <span class=\"col-md-4\" style=\"margin: 10px 0;\">
                    <label class=\"n5-ui-sc-label\" for=\"templateno\">Template Name</label>
                    <input class=\"n5-template-box template-name\" value=\"<%= ppiDnI.templateName %>\" placeholder=\"Name\" for=\"templateno\" type=\"text\"/>
                </span>

                <span class=\"col-md-4\" style=\"margin: 10px 0;\">
                    <label class=\"n5-ui-sc-label\">Segments</label>
                    <span>
                        <select class=\"template-segment-values\" type=\"text\" multiple readonly=\"true\" ></select>
                    </span>
                </span>

                <span class=\"col-md-4\" style=\"margin: 10px 0; padding-top: 25px;\">
                    <div class=\"n5-radio-toolbar\">
                        <input type=\"radio\" id=\"radio-newPpi-c\" name=\"radios-newPpi-val\" value=\"value\" <% if(ppiDnI.ppiType === \"VALUE\") { %>checked<% } %>>
                        <label for=\"radio-newPpi-c\">Value</label>
                        <input type=\"radio\" id=\"radio-newPpi-d\" name=\"radios-newPpi-val\" value=\"volume\" <% if(ppiDnI.ppiType === \"VOLUME\") { %>checked<% } %>>
                        <label for=\"radio-newPpi-d\">Volume</label> 
                        <input type=\"radio\" id=\"radio-newPpi-e\" name=\"radios-newPpi-val\" value=\"growth\" <% if(ppiDnI.ppiType === \"GROWTH\") { %>checked<% } %>>
                        <label for=\"radio-newPpi-e\">Growth</label>
                    </div>
                </span>
            </div>
        </div>

        <div class=\"row js-growth-row <% if(ppiDnI.slabType !== 'GROWTH') { %> hidden <% } %>\">
            <div class=\"col-md-12\">
                <span class=\"col-md-4\" style=\"margin: 10px 0;\">
                    <label for=\"first_name\" class=\"n5-ui-sc-label\">Previous Period</label>
                    <div class=\"input-prepend input-group\">
                        <span class=\"add-on input-group-addon\"><i class=\"glyphicon glyphicon-calendar fa fa-calendar\"></i></span>
                        <input type=\"text\" class=\"form-control js-period-prev\" readonly placeholder = \"Select Period\" /> 
                    </div>
                </span>

                <span class=\"col-md-4\" style=\"margin: 10px 0;\">
                    <label for=\"first_name\" class=\"n5-ui-sc-label\">Current Period</label>
                    <div class=\"input-prepend input-group\">
                        <span class=\"add-on input-group-addon\"><i class=\"glyphicon glyphicon-calendar fa fa-calendar\"></i></span>
                        <input type=\"text\" class=\"form-control js-period-curr\" readonly placeholder = \"Select Period\" /> 
                    </div>
                </span>
            </div>
        </div>

        <div class=\"row\">
            <div class=\"col-md-12\">
                <span class=\"col-md-4\" style=\"margin: 10px 0;\">
                    <label for=\"first_name\" class=\"n5-ui-sc-label\">Scheme Product</label>
                    <!-- <span id=\"n5-ui-newPpi-multiple-scheme-product<%= counter %>\" class=\"span-select2-parent\">
                        <input type=\"text\" />
                    </span> -->
                    <button class=\"n5-template-box product-select\">Select Products</button>
                </span>

                <span class=\"col-md-4\" style=\"margin: 10px 0; padding-top: 25px;\">
                    <span class=\"n5-ui-sc-col\">
                        <input type=\"checkbox\" class=\"css-checkbox\" name=\"bulk\" <% if(ppiDnI.packs.indexOf(\"BULK\") !== -1) { %>checked<% } %> />
                        <label class=\"css-label\" for=\"bulk\">Bulk &nbsp;&nbsp;</label>
                        <input type=\"checkbox\" class=\"css-checkbox\" name=\"retail\" <% if(ppiDnI.packs.indexOf(\"RETAIL\") !== -1) { %>checked<% } %> />
                        <label class=\"css-label\" for=\"retail\">Retail</label>
                    </span>
                </span>

                <span class=\"col-md-4\" style=\"margin: 10px 0;\">
                    <div class=\"ui-project-sku\">
                        <input class=\"js-project-sku\" type='checkbox' <% if(ppiDnI.projectSku) { %>checked <% } %> />
                        <span class=\"js-project-sku-text\">Project SKU<span>
                    </div>
                </span>
            </div>
        </div>

        <div class=\"row\">
            <div class=\"col-md-12\" style=\"margin: 10px 0;\">
                <span class=\"col-md-4\">
                    <label for=\"segment\" class=\"n5-ui-sc-label\">Filter Products by Pack Size</label>
                    <input class='n5-ui-inBill-row-checkbox js-pack-check' type='checkbox' <% if(ppiDnI.packCondition.startValue) { %>checked <% } %> /> Filter
                    <select class=\"n5-ui-sc-label-sub select-dropdown js-pack-select <% if(!ppiDnI.packCondition.startValue) { %> hidden <% } %>\">
                        <option value=\"greater\" <% if(ppiDnI.packCondition.type === \"greater\") { %>selected<% } %>>Greater than or equal to</option>
                        <option value=\"less\" <% if(ppiDnI.packCondition.type === \"less\") { %>selected<% } %>>Less than</option>
                        <option value=\"equal\" <% if(ppiDnI.packCondition.type === \"equal\") { %>selected<% } %>>Equal to</option>
                        <option value=\"range\" <% if(ppiDnI.packCondition.type === \"range\") { %>selected<% } %>>Range</option>
                    </select>
                </span>
                
                <span class=\"col-md-4 js-pack-start-parent <% if(!ppiDnI.packCondition.startValue) { %> hidden <% } %>\">
                    <label for=\"segment\" class=\"n5-ui-sc-label js-pack-start-label\"><% if(!ppiDnI.packCondition.endValue) { %> Value <% } else { %>Start Value <% } %></label>
                    <input class=\"n5-template-box js-pack-start\" value=\"<%= ppiDnI.packCondition.startValue %>\" placeholder=\"Value\"/>
                </span>
                
                <span class=\"col-md-4 js-pack-end-parent <% if(!ppiDnI.packCondition.endValue) { %> hidden <% } %>\">
                    <label for=\"segment\" class=\"n5-ui-sc-label\">End Value</label>
                    <input class=\"n5-template-box js-pack-end\" value=\"<%= ppiDnI.packCondition.endValue %>\" placeholder=\"Value\"/>
                </span>
            </div>
        </div>

        <div class=\"row\">
            <div class=\"col-md-12\">
                <span class=\"col-md-4\" style=\"margin: 10px 0;\">
                    <label for=\"segment\" class=\"n5-ui-sc-label\">No Of Slabs</label>
                    <select class=\"n5-ui-sc-label-sub select-dropdown\" id=\"noofnewPpiTextStr<%= counter %>\" lastSel=\"<%= ppiDnI.numSlabs %>\">
                        <% for(var i = 1; i <= 100; i++) { %>
                            <option <% if(parseInt(ppiDnI.numSlabs) === i) { %>selected<% } %> > <%= i %> </option>
                        <% } %>
                    </select>
                </span>

                <span class=\"col-md-4\" style=\"margin: 10px 0;\">
                    <label for=\"first_name\" class=\"n5-ui-sc-label\">Sales Period</label>
                    <div class=\"input-prepend input-group\">
                        <span class=\"add-on input-group-addon\"><i class=\"glyphicon glyphicon-calendar fa fa-calendar\"></i></span><input type=\"text\" name=\"reservation\" id=\"n5-date-reservation<%= counter %>\" class=\"form-control\" readonly placeholder = \"Select Period\" /> 
                    </div>
                </span>
            </div>
        </div>

        <div class=\"row\">
            <div class=\"col-md-12\">
                <div id=\"n5-Q-cond-table-newPpi<%= counter %>\">
                    <table class=\"table table-bordered table-striped table-hover\" id=\"dynamicTable\">
                        <thead>
                            <tr>
                                <th>Slab Start</th>
                                <th>Slab End</th>
                                <th>Payout Rate</th>
                                <th>Payout Type</th>
                                <!-- <th>Slab QC</tc> -->
                            </tr>
                        </thead>
                        <tbody>
                            <% if (ppiDnI.slabPayouts.length  === 0) { %>
                            <tr>
                                <td><input class='n5-template-selectmenu2 n5-ui-qc-input-placeholder' placeholder='Slab Start' type='text'/></td>
                                <td><input class='n5-template-selectmenu2 n5-ui-qc-input-placeholder' placeholder='Slab End' type='text'/></td>
                                <td><input class='n5-template-selectmenu2 n5-ui-qc-input-placeholder' placeholder='Lap Rate' type='text'/></td>
                                <td>
                                    <span id='n5-ui-newPpi-table-product1'>
                                        <select class='select-dropdown n5-ui-sc-label-sub' id='noofnewPpisTextStr-newPpi-payout1'>
                                            <option>RS / Ltr</option>
                                            <option>Abs Amount</option>
                                            <option>Gift</option>
                                            <option>Percentage</option>
                                        </select>
                                    </span>
                                    <input class=\"n5-template-box js-gift-desc1\" style=\"display:none;\" placeholder=\"Gift Description\" />
                                </td>
                                <!-- <td><button class=\"n5-table-qc-add btn\">QC</button></td> -->
                            </tr>
                            <% } else { %>
                            <% _.each(ppiDnI.slabPayouts, function(row, key, list) { %>
                                <% if(key < (ppiDnI.slabPayouts.length - totalRows)) { %>
                                    <tr>
                                        <td><input class='n5-template-selectmenu2 n5-ui-qc-input-placeholder' value=\"<%=row.slabStartValue%>\" placeholder='Slab Start' type='text'/></td>
                                        <td><input class='n5-template-selectmenu2 n5-ui-qc-input-placeholder' value=\"<%=row.slabEndValue%>\" placeholder='Slab End' type='text'/></td>
                                        <td><input class='n5-template-selectmenu2 n5-ui-qc-input-placeholder' value=\"<%=row.payoutValue%>\" placeholder='Lap Rate' type='text'/></td>
                                        <td>
                                            <span id='n5-ui-newPpi-table-product<%= key + 1 %>'>
                                                <select class='select-dropdown n5-ui-sc-label-sub' id='noofnewPpisTextStr-newPpi-payout<%= key + 1 %>'>
                                                    <option <% if(row.payoutType === \"RSPERLITRE\") { %>selected<% } %>>RS / Ltr</option>
                                                    <option <% if(row.payoutType === \"FLATPAYOUT\") { %>selected<% } %>>Abs Amount</option>
                                                    <option <% if(row.payoutType === \"GIFT\") { %>selected<% } %>>Gift</option>
                                                    <option <% if(row.payoutType === \"PERCENTAGE\") { %>selected<% } %>>Percentage</option>
                                                </select>
                                            </span>
                                            <input class=\"n5-template-box js-gift-desc<%= key + 1 %>\" <% if (row.payoutDescription) { %> value=\"<%= row.payoutDescription %>\" <% } else { %> style=\"display:none;\" <% } %> placeholder=\"Gift Description\" />
                                        </td>
                                    </tr>
                                <% } %>
                            <% }); %>
                            <% } %>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class=\"row\">
            <div class=\"col-md-12 js-repeat-box\" style=\"margin-top: 20px;\">
                <div class=\"col-md-12\">
                    <label class=\"n5-ui-sc-label\"><b>Fill in the following if you want rows to be repeated</b></label>
                </div>

                <div class=\"col-md-4\">
                    <label class=\"n5-ui-sc-label\">Repeat Slab Values</label>
                    <input class=\"n5-template-box js-slab-value\" placeholder=\"Slab Range\" value=\"<%= ppiDnI.repeatData.slabRange %>\" />
                </div>
                <div class=\"col-md-4\">
                    <label class=\"n5-ui-sc-label\">Increase in Lap Rate</label>
                    <input class=\"n5-template-box js-lap-rate\" placeholder=\"Lap Rate change\" value=\"<%= ppiDnI.repeatData.lapChange %>\" />
                </div>
                <div class=\"col-md-4\">
                    <label class=\"n5-ui-sc-label\">Repeat Slabs</label>
                    <input class=\"n5-template-box js-repeat\" placeholder=\"Number of rows\" value=\"<%= ppiDnI.repeatData.rowRepeat %>\" />
                </div>
            </div>
            <!-- <div class=\"col-md-12\" style=\"margin-top: 20px;\">
                <div class=\"col-md-4\">
                    <button class=\"button-simple js-repeat-rows-btn\">Repeat Rows</button>
                </div>
            </div> -->
        </div>

        <div class = \"newPpi-qualifying-conditions\">
            <div class = \"qualifying-conditions-list\"></div>
            <button class=\"add-condition  button-simple\">Add Qualifying Condition</button>
        </div>
    </div>
</script>
";
    }

    public function getTemplateName()
    {
        return "newPpiTemplate.tmpl";
    }

    public function getDebugInfo()
    {
        return array (  19 => 1,);
    }
}
