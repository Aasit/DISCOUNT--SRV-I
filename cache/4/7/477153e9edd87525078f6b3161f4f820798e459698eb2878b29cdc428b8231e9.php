<?php

/* newSlabTemplate.tmpl */
class __TwigTemplate_477153e9edd87525078f6b3161f4f820798e459698eb2878b29cdc428b8231e9 extends Twig_Template
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
        echo "<script type = \"text/template\" id=\"n5-ui-template-newSlab-template\">
    <div class =\" n5-template-container\" id=\"n5-ui-newSlab<%= counter %>\">
        <div class=\"row\">
            <div class=\"col-md-12\">
                <span class=\"col-md-4\">
                    <label class=\"n5-ui-sc-label\" for=\"templateno\">Template Name</label>
                    <input class=\"n5-template-box template-name\" value=\"<%= slabV2DnI.templateName %>\" placeholder=\"Name\" for=\"templateno\" type=\"text\"/>
                </span>
                
                <span class=\"col-md-4\">
                    <label class=\"n5-ui-sc-label\">Segments</label>
                    <span>
                        <select class=\"template-segment-values\" type=\"text\" multiple readonly ></select>
                    </span>
                </span>

                <span class=\"col-md-4\" style=\"padding-top: 25px;\">
                    <div class=\"n5-radio-toolbar\">
                        <input type=\"radio\" id=\"radio-newSlab-c\" name=\"radios-newSlab-val\" value=\"value\" <% if(slabV2DnI.slabType === \"VALUE\") { %>checked<% } %>>
                        <label for=\"radio-newSlab-c\">Value</label>
                        <input type=\"radio\" id=\"radio-newSlab-d\" name=\"radios-newSlab-val\" value=\"volume\" <% if(slabV2DnI.slabType === \"VOLUME\") { %>checked<% } %>>
                        <label for=\"radio-newSlab-d\">Volume</label>
                        <input type=\"radio\" id=\"radio-newSlab-e\" name=\"radios-newSlab-val\" value=\"growth\" <% if(slabV2DnI.slabType === \"GROWTH\") { %>checked<% } %>>
                        <label for=\"radio-newSlab-e\">Growth</label> 
                    </div>
                </span>
            </div>
        </div>

        <div class=\"row js-growth-row <% if(slabV2DnI.slabType !== 'GROWTH') { %> hidden <% } %>\">
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
                <span class=\"col-md-4\">
                    <label for=\"segment\" class=\"n5-ui-sc-label\">No Of Laps</label>
                    <select class=\"n5-ui-sc-label-sub select-dropdown\" id=\"nooflapsTextStr-newSlab<%= counter %>\" lastSel=\"<%= slabV2DnI.laps.length %>\">
                        <% _.each([1,2,3,4,5,6,7,8,9,10], function(i) { %>
                            <option <% if(slabV2DnI.laps.length === i) { %>selected<% } %> > <%= i %> </option>
                        <% }); %>
                    </select>
                </span>

                <span class=\"col-md-4\">
                    <label for=\"segment\" class=\"n5-ui-sc-label\">No Of Products</label>
                    <select class=\"n5-ui-sc-label-sub select-dropdown\" id=\"noofslabsTextStr-newSlab<%= counter %>\" lastSel=\"<%= slabV2DnI.numProducts %>\">
                        <% for(var i = 1; i <= 100; i++) { %>
                            <option <% if(parseInt(numProducts) === i) { %>selected<% } %> > <%= i %> </option>
                        <% } %>
                    </select>
                </span>

                <span class=\"col-md-4\" style=\"margin: 10px 0;\">
                    <div class=\"ui-project-sku\">
                        <input class=\"js-project-sku\" type='checkbox' <% if(slabV2DnI.projectSku) { %>checked <% } %> />
                        <span class=\"js-project-sku-text\">Project SKU<span>
                    </div>
                </span>
            </div>
        </div>

        <div class=\"row\">
            <div class=\"col-md-12\" style=\"margin: 10px 0;\">
                <span class=\"col-md-4\">
                    <label for=\"segment\" class=\"n5-ui-sc-label\">Filter Products by Pack Size</label>
                    <input class='n5-ui-inBill-row-checkbox js-pack-check' type='checkbox' <% if(slabV2DnI.packCondition.startValue) { %>checked <% } %> /> Filter
                    <select class=\"n5-ui-sc-label-sub select-dropdown js-pack-select <% if(!slabV2DnI.packCondition.startValue) { %> hidden <% } %>\">
                        <option value=\"greater\" <% if(slabV2DnI.packCondition.type === \"greater\") { %>selected<% } %>>Greater than or equal to</option>
                        <option value=\"less\" <% if(slabV2DnI.packCondition.type === \"less\") { %>selected<% } %>>Less than</option>
                        <option value=\"equal\" <% if(slabV2DnI.packCondition.type === \"equal\") { %>selected<% } %>>Equal to</option>
                        <option value=\"range\" <% if(slabV2DnI.packCondition.type === \"range\") { %>selected<% } %>>Range</option>
                    </select>
                </span>
                
                <span class=\"col-md-4 js-pack-start-parent <% if(!slabV2DnI.packCondition.startValue) { %> hidden <% } %>\">
                    <label for=\"segment\" class=\"n5-ui-sc-label js-pack-start-label\"><% if(!slabV2DnI.packCondition.endValue) { %> Value <% } else { %>Start Value <% } %></label>
                    <input class=\"n5-template-box js-pack-start\" value=\"<%= slabV2DnI.packCondition.startValue %>\" placeholder=\"Value\"/>
                </span>
                
                <span class=\"col-md-4 js-pack-end-parent <% if(!slabV2DnI.packCondition.endValue) { %> hidden <% } %>\">
                    <label for=\"segment\" class=\"n5-ui-sc-label\">End Value</label>
                    <input class=\"n5-template-box js-pack-end\" value=\"<%= slabV2DnI.packCondition.endValue %>\" placeholder=\"Value\"/>
                </span>
            </div>
        </div>

        <div class=\"row\">
            <div class=\"col-md-12 js-calendar-container\">
                <% _.each(slabV2DnI.laps, function(lap, key, list) { %>
                <span class=\"col-md-4\" style=\"margin: 10px 0;\">
                    <label for=\"first_name\" class=\"n5-ui-sc-label\">Lap Period <%= key + 1 %></label>
                    <div class=\"input-prepend input-group\">
                        <span class=\"add-on input-group-addon\"><i class=\"glyphicon glyphicon-calendar fa fa-calendar\"></i></span>
                        <input type=\"text\" name=\"reservation\" id=\"n5-date-reservation-newSlab-table<%= key + 1 %>\" class=\"form-control\" readonly placeholder=\"Select Period\" /> 
                    </div>
                </span>
                <% }); %>
            </div>
        </div>

        <div class=\"row\">
            <div class=\"col-md-12\">
                <div id=\"n5-Q-cond-table-newSlab<%= counter %>\">
                    <table class=\"table table-bordered table-striped table-hover\" id=\"dynamicTable\">
                        <% if (slabV2DnI.laps.length  === 0) { %>
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Slab Start</th>
                                <th>PayOut Type</th>
                                <th>Product Type</th>
                                <th>Slab QC</tc>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><button class=\"n5-template-box product-select\">Select Products</button></td>
                                <td><input class=\"n5-template-selectmenu2 n5-ui-qc-input-placeholder js-slab-start\" placeholder=\"Slab Start\" /></td>
                                <td>
                                    <span id='n5-ui-newSlab-table-product1'>
                                        <span class='n5-template-selectmenu2 disabled'>
                                            <span class='n5-ui-sc-label-sub' id='noofslabsTextStr-newSlab-payout1'>Rs / Ltr</span>
                                        </span>
                                    </span>
                                </td>
                                <td>
                                    <div class=\"bulk-retail\"><input class='n5-ui-inBill-row-checkbox' type='checkbox' checked /> Bulk</div>
                                    <div class=\"bulk-retail\"><input class='n5-ui-inBill-row-checkbox' type='checkbox' checked /> Retail</div>
                                </td>
                                <td><button class=\"n5-table-qc-add btn\">QC</button></td>
                            </tr>
                        </tbody>
                        <% } else { %>
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Slab Start</th>
                                <% _.each(slabV2DnI.laps, function(lap, key, list) { %>
                                    <th>Lap Rate<%= key + 1 %></th>
                                <% }); %>
                                <th>PayOut Type</th>
                                <th>Product Type</th>
                                <th>Slab QC</tc>
                            </tr>
                        </thead>
                        <tbody>
                            <% _.each(tableArr, function(row, key, list) { %>
                            <tr>
                                <td><button class=\"n5-template-box product-select\">Select Products</button></td>
                                <td><input class=\"n5-template-selectmenu2 n5-ui-qc-input-placeholder js-slab-start\" placeholder=\"Slab Start\" value=\"<%= row.slabStartValue %>\" /></td>

                                <% _.each(row.lap, function(col, k) { %>
                                <td><input class='n5-template-selectmenu2 n5-ui-qc-input-placeholder lap-rate' placeholder='Lap Rate' type='text' value=\"<%=col%>\" /></td>
                                <% }); %>

                                <td>
                                    <span id='n5-ui-newSlab-table-product<%= key + 1 %>'>
                                        <span class='n5-template-selectmenu2 disabled'>
                                            <span class='n5-ui-sc-label-sub' id='noofslabsTextStr-newSlab-payout<%= key + 1 %>'>Rs / Ltr</span>
                                        </span>
                                    </span>
                                </td>
                                <td>
                                    <div class=\"bulk-retail\"><input class='n5-ui-newSlab-row-checkbox' type='checkbox' <% if(row.packs.indexOf(\"BULK\") !== -1) { %>checked<% } %> /> Bulk</div>
                                    <div class=\"bulk-retail\"><input class='n5-ui-newSlab-row-checkbox' type='checkbox' <% if(row.packs.indexOf(\"RETAIL\") !== -1) { %>checked<% } %> /> Retail</div>
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
        <div class = \"newSlab-qualifying-conditions\">
            <div class = \"qualifying-conditions-list\"></div>
            <button class=\"add-condition  button-simple\">Add Qualifying Condition</button>
        </div>
    </div>
</script>";
    }

    public function getTemplateName()
    {
        return "newSlabTemplate.tmpl";
    }

    public function getDebugInfo()
    {
        return array (  19 => 1,);
    }
}
