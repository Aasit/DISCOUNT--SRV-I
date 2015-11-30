<?php

/* slabTemplate.tmpl */
class __TwigTemplate_a4d4b022a13d0ed181f3ef2e077fb9dea82fa36f15a9c6c4e13f629678251059 extends Twig_Template
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
        echo "<script type = \"text/template\" id=\"n5-ui-template-slab-template\">
    <div class =\" n5-template-container\" id=\"n5-ui-slab<%= counter %>\">
        <div class=\"row\">
            <div class=\"col-md-12\">
                <span class=\"col-md-4\" style=\"margin: 10px 0;\">
                    <label class=\"n5-ui-sc-label\" for=\"templateno\">Template Name</label>
                    <input class=\"n5-template-box template-name\" value=\"<%= slabDnI.templateName %>\" placeholder=\"Name\" for=\"templateno\" type=\"text\"/>
                </span>
                
                <span class=\"col-md-4\" style=\"margin: 10px 0;\">
                    <label class=\"n5-ui-sc-label\">Segments</label>
                    <span>
                        <select class=\"template-segment-values\" type=\"text\" multiple readonly=\"true\" ></select>
                    </span>
                </span>

                <span class=\"col-md-4\" style=\"margin: 10px 0; padding-top: 25px;\">
                    <div class=\"n5-radio-toolbar\">
                        <input type=\"radio\" id=\"radio-slab-a\" name=\"radios-slab-val\"value=\"value\" <% if(slabDnI.slabType === \"VALUE\") { %>checked<% } %>>
                        <label for=\"radio-slab-a\">Value</label>
                        <input type=\"radio\" id=\"radio-slab-b\" name=\"radios-slab-val\" value=\"volume\" <% if(slabDnI.slabType === \"VOLUME\") { %>checked<% } %>>
                        <label for=\"radio-slab-b\">Volume</label>
                        <input type=\"radio\" id=\"radio-slab-e\" name=\"radios-slab-val\" value=\"growth\" <% if(slabDnI.slabType === \"GROWTH\") { %>checked<% } %>>
                        <label for=\"radio-slab-e\">Growth</label> 
                    </div>
                </span>
            </div>
        </div>

        <div class=\"row js-growth-row <% if(slabDnI.slabType !== 'GROWTH') { %> hidden <% } %>\">
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
                    <!-- <span id=\"n5-ui-slab-multiple-scheme-product<%= counter %>\" class=\"span-select2-parent\">
                        <input type=\"text\" />
                    </span> -->
                    <button class=\"n5-template-box product-select\">Select Products</button>
                </span>

                <span class=\"col-md-4\" style=\"margin: 10px 0; padding-top: 25px;\">
                    <span class=\"n5-ui-sc-col\">
                        <span class=\"n5-ui-sc-col\">
                            <input type=\"checkbox\" name=\"bulk\" <% if(slabDnI.packs.indexOf(\"BULK\") !== -1) { %>checked<% } %> />
                            <label for=\"bulk\">Bulk &nbsp;&nbsp;</label>
                            <input type=\"checkbox\" name=\"retail\" <% if(slabDnI.packs.indexOf(\"RETAIL\" !== -1)) { %>checked<% } %> />
                            <label for=\"retail\">Retail</label>
                        </span>
                    </span>
                </span>

                <span class=\"col-md-4\" style=\"margin: 10px 0;\">
                    <div class=\"ui-project-sku\">
                        <input class=\"js-project-sku\" type='checkbox' <% if(slabDnI.projectSku) { %>checked <% } %> />
                        <span class=\"js-project-sku-text\">Project SKU<span>
                    </div>
                </span>
            </div>
        </div>

        <div class=\"row\">
            <div class=\"col-md-12\" style=\"margin: 10px 0;\">
                <span class=\"col-md-4\">
                    <label for=\"segment\" class=\"n5-ui-sc-label\">Filter Products by Pack Size</label>
                    <input class='n5-ui-inBill-row-checkbox js-pack-check' type='checkbox' <% if(slabDnI.packCondition.startValue) { %>checked <% } %> /> Filter
                    <select class=\"n5-ui-sc-label-sub select-dropdown js-pack-select <% if(!slabDnI.packCondition.startValue) { %> hidden <% } %>\">
                        <option value=\"greater\" <% if(slabDnI.packCondition.type === \"greater\") { %>selected<% } %>>Greater than or equal to</option>
                        <option value=\"less\" <% if(slabDnI.packCondition.type === \"less\") { %>selected<% } %>>Less than</option>
                        <option value=\"equal\" <% if(slabDnI.packCondition.type === \"equal\") { %>selected<% } %>>Equal to</option>
                        <option value=\"range\" <% if(slabDnI.packCondition.type === \"range\") { %>selected<% } %>>Range</option>
                    </select>
                </span>
                
                <span class=\"col-md-4 js-pack-start-parent <% if(!slabDnI.packCondition.startValue) { %> hidden <% } %>\">
                    <label for=\"segment\" class=\"n5-ui-sc-label js-pack-start-label\"><% if(!slabDnI.packCondition.endValue) { %> Value <% } else { %>Start Value <% } %></label>
                    <input class=\"n5-template-box js-pack-start\" value=\"<%= slabDnI.packCondition.startValue %>\" placeholder=\"Value\"/>
                </span>
                
                <span class=\"col-md-4 js-pack-end-parent <% if(!slabDnI.packCondition.endValue) { %> hidden <% } %>\">
                    <label for=\"segment\" class=\"n5-ui-sc-label\">End Value</label>
                    <input class=\"n5-template-box js-pack-end\" value=\"<%= slabDnI.packCondition.endValue %>\" placeholder=\"Value\"/>
                </span>
            </div>
        </div>

        <div class=\"row\">
            <div class=\"col-md-12\">
                <span class=\"col-md-4\" style=\"margin: 10px 0;\">
                    <label for=\"segment\" class=\"n5-ui-sc-label\">No Of Slabs</label>
                    <select class=\"n5-ui-sc-label-sub select-dropdown\" id=\"noofslabTextStr<%= counter %>\" lastSel=\"<%= slabDnI.numSlabs %>\">
                        <% for(var i = 1; i <= 100; i++) { %>
                            <option <% if(parseInt(slabDnI.numSlabs) === i) { %>selected<% } %> > <%= i %> </option>
                        <% } %>
                    </select>
                </span>

                <span class=\"col-md-4\" style=\"margin: 10px 0;\">
                    <label for=\"segment\" class=\"n5-ui-sc-label\">No Of Laps</label>
                    <select class=\"n5-ui-sc-label-sub select-dropdown\" id=\"nooflapsTextStr<%= counter %>\" lastSel=\"<%= slabDnI.laps.length %>\">
                        <% _.each([1,2,3,4,5,6,7,8,9,10], function(i) { %>
                            <option <% if(slabDnI.laps.length === i) { %>selected<% } %> > <%= i %> </option>
                        <% }); %>
                    </select>
                </span>
            </div>
        </div>

        <div class=\"row\">
            <div class=\"col-md-12 js-calendar-container\">
                <% _.each(slabDnI.laps, function(lap, key, list) { %>
                <span class=\"col-md-4\">
                    <label for=\"first_name\" class=\"n5-ui-sc-label\">Lap <%= key + 1 %> Period</label>
                    <div class=\"input-prepend input-group\">
                        <span class=\"add-on input-group-addon\"><i class=\"glyphicon glyphicon-calendar fa fa-calendar\"></i></span>
                        <input type=\"text\" name=\"reservation\" id=\"n5-date-reservation-slab-table<%= key + 1 %>\" class=\"form-control\" readonly placeholder = \"Select Period\" />
                    </div>
                </span>
                <% }); %>
            </div>
        </div>

        <div class=\"row\">
            <div class=\"col-md-12\">
                <div id=\"n5-Q-cond-table-slab<%= counter %>\">
                    <table class=\"table table-bordered table-striped table-hover\" id=\"dynamicTable\">
                        <% if (slabDnI.laps.length  === 0) { %>
                        <thead>
                            <tr>
                                <th>Slab Start</th>
                                <th>Slab End</th>
                                <th>Payout Type</th>
                                <th>Slab QC</tc>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><input class='n5-template-selectmenu2 n5-ui-qc-input-placeholder' placeholder='Slab Start' type='text'/></td>
                                <td><input class='n5-template-selectmenu2 n5-ui-qc-input-placeholder' placeholder='Slab End' type='text'/></td>
                                <td>
                                    <span id='n5-ui-slab-table-product1'>
                                        <select class='select-dropdown table-dropdown n5-ui-sc-label-sub' id='noofslabsTextStr-slab-payout1'>
                                            <option>RS / Ltr</option>
                                            <option>Abs Amount</option>
                                            <option>Gift</option>
                                            <option>Percentage</option>
                                        </select>
                                    </span>
                                    <input class=\"n5-template-box js-gift-desc1\" style=\"display:none;\" placeholder=\"Gift Description\" />
                                </td>
                                <td><button class=\"n5-table-qc-add btn\">QC</button></td>
                            </tr>
                        </tbody>
                        <% } else { %>
                        <thead>
                            <tr>
                                <th>Slab Start</th>
                                <th>Slab End</th>
                                <% _.each(slabDnI.laps, function(lap, key, list) { %>
                                    <th>Lap Rate<%= key + 1 %></th>
                                <% }); %>
                                <th>Payout Type</th>
                                <th>Slab QC</tc>
                            </tr>
                        </thead>
                        <tbody>
                        <% _.each(tableArr, function(row, key, list) { %>
                            <tr>
                                <td><input class='n5-template-selectmenu2 n5-ui-qc-input-placeholder' value=\"<%=row.slabStartValue%>\" placeholder='Slab Start' type='text'/></td>
                                <td><input class='n5-template-selectmenu2 n5-ui-qc-input-placeholder' value=\"<%=row.slabEndValue%>\" placeholder='Slab End' type='text'/></td>
                                <% _.each(row.lap, function(col, k) { %>
                                <td><input class='n5-template-selectmenu2 n5-ui-qc-input-placeholder lap-rate' placeholder='Lap Rate' type='text' value=\"<%=col%>\" /></td>
                                <% }); %>
                                <td>
                                    <span id='n5-ui-slab-table-product<%= key + 1 %>'>
                                        <select class='select-dropdown table-dropdown n5-ui-sc-label-sub' id='noofslabsTextStr-slab-payout<%= key + 1 %>'>
                                            <option <% if(row.payoutType === \"RSPERLITRE\") { %>selected<% } %>>RS / Ltr</option>
                                            <option <% if(row.payoutType === \"FLATPAYOUT\") { %>selected<% } %>>Abs Amount</option>
                                            <option <% if(row.payoutType === \"GIFT\") { %>selected<% } %>>Gift</option>
                                            <option <% if(row.payoutType === \"PERCENTAGE\") { %>selected<% } %>>Percentage</option>
                                        </select>
                                    </span>
                                    <input class=\"n5-template-box js-gift-desc<%= key + 1 %>\" <% if (row.payoutDescription) { %> value=\"<%= row.payoutDescription %>\" <% } else { %> style=\"display:none;\" <% } %> placeholder=\"Gift Description\" />
                                </td>
                                <% var qcData = JSON.stringify(row.qcList); var qcClass = \" btn-qc-active\"; var satisfyAll = row.satisfyAll %>
                                <% if(qcData === \"null\") { qcData = \"\"; qcClass = \"\" } %>
                                <td><button class=\"n5-table-qc-add btn <%= qcClass %>\" data-qc='<%= qcData %>' data-satisfy='<%= satisfyAll %>'>QC</button></td>
                            </tr>
                        <% }); %>
                        </tbody>
                    <% } %>
                </table>
                </div>
            </div>
        </div>

        <div class = \"slab-qualifying-conditions\">
            <div class = \"qualifying-conditions-list\"></div>
            <button class=\"add-condition button-simple\">Add Qualifying Condition</button>
        </div>
    </div>
</script>
";
    }

    public function getTemplateName()
    {
        return "slabTemplate.tmpl";
    }

    public function getDebugInfo()
    {
        return array (  19 => 1,);
    }
}
