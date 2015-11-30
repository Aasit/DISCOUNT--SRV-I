<?php

/* inBillTemplate.tmpl */
class __TwigTemplate_092d81b87341584fb5bdd63020d901029f67c8cb0342d9123fe8cd804c4029be extends Twig_Template
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
        echo "<script type = \"text/template\" id=\"n5-ui-template-inBill-template\">
    <div class =\" n5-template-container\" id=\"n5-ui-inBill<%= counter %>\">
        <div class=\"row\">
            <div class=\"col-md-12\">
                <span class=\"col-md-4\">
                    <label class=\"n5-ui-sc-label\" for=\"templateno\">Template Name</label>
                    <input class=\"n5-template-box template-name\" value=\"<%= inBillDnI.templateName %>\" placeholder=\"Name\" for=\"templateno\" type=\"text\"/>
                </span>
                
                <span class=\"col-md-4\" style=\"margin: 10px 0;\">
                    <label class=\"n5-ui-sc-label\">Segments</label>
                    <span>
                        <select class=\"template-segment-values\" type=\"text\" multiple readonly ></select>
                    </span>
                </span>

                <span class=\"col-md-4\" style=\"margin: 10px 0;\">
                    <div class=\"ui-project-sku\">
                        <input class=\"js-project-sku\" type='checkbox' <% if(inBillDnI.projectSku) { %>checked <% } %> />
                        <span class=\"js-project-sku-text\">Project SKU<span>
                    </div>
                </span>
            </div>
        </div>

        <div class=\"row\">
            <div class=\"col-md-12\">
                <span class=\"col-md-4\" style=\"margin: 10px 0;\">
                    <label for=\"first_name\" class=\"n5-ui-sc-label\">Products</label>
                    <button class=\"n5-template-box product-select-main\">Select Products</button>
                </span>

                <span class=\"col-md-4\">
                    <label for=\"segment\" class=\"n5-ui-sc-label\">No Of Products</label>
                    <select class=\"n5-ui-sc-label-sub select-dropdown\" id=\"noofslabsTextStr-inBill<%= counter %>\" lastSel=\"<%= inBillDnI.numProducts %>\">
                        <% for(var i = 1; i <= 100; i++) { %>
                            <option <% if(parseInt(numProducts) === i) { %>selected<% } %> > <%= i %> </option>
                        <% } %>
                    </select>
                </span>
                
                <span class=\"col-md-4\">
                    <label for=\"segment\" class=\"n5-ui-sc-label\">No Of Laps</label>
                    <select class=\"n5-ui-sc-label-sub select-dropdown\" id=\"nooflapsTextStr-inBill<%= counter %>\" lastSel=\"<%= inBillDnI.inBillLaps.length %>\">
                        <% _.each([1,2,3,4,5,6,7,8,9,10], function(i) { %>
                            <option <% if(inBillDnI.inBillLaps.length === i) { %>selected<% } %> > <%= i %> </option>
                        <% }); %>
                    </select>
                </span>
            </div>
        </div>

        <div class=\"row\">
            <div class=\"col-md-12\" style=\"margin: 10px 0;\">
                <span class=\"col-md-4\">
                    <label for=\"segment\" class=\"n5-ui-sc-label\">Filter Products by Pack Size</label>
                    <input class='n5-ui-inBill-row-checkbox js-pack-check' type='checkbox' <% if(inBillDnI.packCondition.startValue) { %>checked <% } %> /> Filter
                    <select class=\"n5-ui-sc-label-sub select-dropdown js-pack-select <% if(!inBillDnI.packCondition.startValue) { %> hidden <% } %>\">
                        <option value=\"greater\" <% if(inBillDnI.packCondition.type === \"greater\") { %>selected<% } %>>Greater than or equal to</option>
                        <option value=\"less\" <% if(inBillDnI.packCondition.type === \"less\") { %>selected<% } %>>Less than</option>
                        <option value=\"equal\" <% if(inBillDnI.packCondition.type === \"equal\") { %>selected<% } %>>Equal to</option>
                        <option value=\"range\" <% if(inBillDnI.packCondition.type === \"range\") { %>selected<% } %>>Range</option>
                    </select>
                </span>
                
                <span class=\"col-md-4 js-pack-start-parent <% if(!inBillDnI.packCondition.startValue) { %> hidden <% } %>\">
                    <label for=\"segment\" class=\"n5-ui-sc-label js-pack-start-label\"><% if(!inBillDnI.packCondition.endValue) { %> Value <% } else { %>Start Value <% } %></label>
                    <input class=\"n5-template-box js-pack-start\" value=\"<%= inBillDnI.packCondition.startValue %>\" placeholder=\"Value\"/>
                </span>
                
                <span class=\"col-md-4 js-pack-end-parent <% if(!inBillDnI.packCondition.endValue) { %> hidden <% } %>\">
                    <label for=\"segment\" class=\"n5-ui-sc-label\">End Value</label>
                    <input class=\"n5-template-box js-pack-end\" value=\"<%= inBillDnI.packCondition.endValue %>\" placeholder=\"Value\"/>
                </span>
            </div>
        </div>

        <div class=\"row\">
            <div class=\"col-md-12 js-calendar-container\">
                <% _.each(inBillDnI.inBillLaps, function(lap, key, list) { %>
                <span class=\"col-md-4\">
                    <label for=\"first_name\" class=\"n5-ui-sc-label\">Lap Period <%= key + 1 %></label>
                    <div class=\"input-prepend input-group\">
                        <span class=\"add-on input-group-addon\"><i class=\"glyphicon glyphicon-calendar fa fa-calendar\"></i></span>
                        <input type=\"text\" name=\"reservation\" id=\"n5-date-reservation-inBill-table<%= key + 1 %>\" class=\"form-control\" readonly placeholder=\"Select Period\" /> 
                    </div>
                </span>
                <% }); %>
            </div>
        </div>

        <div class=\"row\">
            <div class=\"col-md-12\">
                <div id=\"n5-Q-cond-table-inBill<%= counter %>\">
                    <table class=\"table table-bordered table-striped table-hover\" id=\"dynamicTable\">
                        <% if (inBillDnI.inBillLaps.length  === 0) { %>
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>PayOut Type</th>
                                <th>Product Type</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <!-- <td><span id='n5-ui-inBill-multiple-scheme-product-table1'><input /></span></td> -->
                                <td><button class=\"n5-template-box product-select\">Select Products</button></td>
                                <td>
                                    <span id='n5-ui-inBill-table-product1'>
                                        <span class='n5-template-selectmenu2 disabled'>
                                            <span class='n5-ui-sc-label-sub' id='noofslabsTextStr-inBill-payout1'>Rs / Ltr</span>
                                        </span>
                                    </span>
                                </td>
                                <td>
                                    <div class=\"bulk-retail\"><input class='n5-ui-inBill-row-checkbox' type='checkbox' checked /> Bulk</div>
                                    <div class=\"bulk-retail\"><input class='n5-ui-inBill-row-checkbox' type='checkbox' checked /> Retail</div>
                                </td>
                            </tr>
                        </tbody>
                        <% } else { %>
                        <thead>
                            <tr>
                                <th>Product</th>
                                <% _.each(inBillDnI.inBillLaps, function(lap, key, list) { %>
                                    <th>Lap Rate<%= key + 1 %></th>
                                <% }); %>
                                <th>PayOut Type</th>
                                <th>Product Type</th>
                            </tr>
                        </thead>
                        <tbody>
                            <% _.each(tableArr, function(row, key, list) { %>
                            <tr>
                                <!-- <td><span id='n5-ui-inBill-multiple-scheme-product-table<%= key + 1 %>'><input /></span></td> -->
                                <td><button class=\"product-select\">Select Products</button></td>

                                <% _.each(row.lap, function(col, k) { %>
                                <td><input class='n5-template-selectmenu2 n5-ui-qc-input-placeholder lap-rate' placeholder='Lap Rate' type='text' value=\"<%=col%>\" /></td>
                                <% }); %>

                                <td>
                                    <span id='n5-ui-inBill-table-product<%= key + 1 %>'>
                                        <span class='n5-template-selectmenu2 disabled'>
                                            <span class='n5-ui-sc-label-sub' id='noofslabsTextStr-inBill-payout<%= key + 1 %>'>Rs / Ltr</span>
                                        </span>
                                    </span>
                                </td>
                                <td>
                                    <div class=\"bulk-retail\"><input class='n5-ui-inBill-row-checkbox' type='checkbox' <% if(row.packs.indexOf(\"BULK\") !== -1) { %>checked<% } %> /> Bulk</div>
                                    <div class=\"bulk-retail\"><input class='n5-ui-inBill-row-checkbox' type='checkbox' <% if(row.packs.indexOf(\"RETAIL\") !== -1) { %>checked<% } %> /> Retail</div>
                                </td>
                            </tr>
                            <% }); %>
                        </tbody>
                        <% } %>
                    </table>
                </div>
            </div>
        </div>
    </div>
</script>";
    }

    public function getTemplateName()
    {
        return "inBillTemplate.tmpl";
    }

    public function getDebugInfo()
    {
        return array (  19 => 1,);
    }
}
