<?php

/* priTemplate.tmpl */
class __TwigTemplate_0b9b914e74b8dae9702f43a98651e27a4bd463072807eceef3fb04f6d0a6e24d extends Twig_Template
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
        echo "<script type = \"text/template\" id=\"n5-ui-template-pri-template\">
    <div class =\"n5-template-container\" id=\"n5-ui-pri<%= counter %>\">
        <div class=\"row\">
            <div class=\"col-md-12\">
                <span class=\"col-md-4\" style=\"margin: 10px 0;\">
                    <label class=\"n5-ui-sc-label\" for=\"templateno\">Template Name</label>
                    <input class=\"n5-template-box template-name\" value=\"<%= priDnI.templateName %>\" placeholder=\"Name\" for=\"templateno\" type=\"text\"/>
                </span>

                <span class=\"col-md-4\" style=\"margin: 10px 0;\">
                    <label class=\"n5-ui-sc-label\">Segments</label>
                    <span>
                        <select class=\"template-segment-values\" type=\"text\" multiple readonly=\"true\" ></select>
                    </span>
                </span>

                <span class=\"col-md-4\" style=\"margin: 10px 0; padding-top: 25px;\">
                    <div class=\"n5-radio-toolbar\">
                        <input type=\"radio\" id=\"radio-pri-a<%= counter %>\" name=\"radios-pri-val\" value=\"value\" <% if(priDnI.priType === \"VALUE\") { %>checked<% } %>>
                        <label class =\"radio-pri-labela<%= counter %>\" for=\"radio-pri-a<%= counter %>\">Value</label>
                        <input type=\"radio\" id=\"radio-pri-b<%= counter %>\" name=\"radios-pri-val\" value=\"volume\" <% if(priDnI.priType !== \"VALUE\") { %>checked<% } %>>
                        <label class =\"radio-pri-labelb<%= counter %>\" for=\"radio-pri-b<%= counter %>\">Volume</label> 
                    </div>
                </span>
            </div>
        </div>

        <div class=\"row\">
            <div class=\"col-md-12\">                
                <span class=\"col-md-4\" style=\"margin: 10px 0;\">
                    <label for=\"first_name\" class=\"n5-ui-sc-label\">PRI Products</label>
                    <span id=\"n5-ui-pri-multiple-scheme-product<%= counter %>\">
                        <input type=\"text\" />
                    </span>
                    <!-- <button class=\"n5-template-box product-select\">Select Products</button> -->
                </span>

                <span class=\"col-md-4\" style=\"margin: 10px 0;\">
                    <label for=\"first_name\" class=\"n5-ui-sc-label n5-ui-minvalvol\">Minimum Volume</label>
                    <input class=\"n5-template-box input-val-vol\" type=\"text\" value=\"<%= value %>\" />
                </span>
                
                <span class=\"col-md-4\" style=\"margin: 10px 0;\">
                    <div class=\"ui-project-sku\">
                        <input class=\"js-project-sku\" type='checkbox' <% if(priDnI.projectSku) { %>checked <% } %> />
                        <span class=\"js-project-sku-text\">Project SKU<span>
                    </div>
                </span>
            </div>
        </div>

        <div class=\"row\">
            <div class=\"col-md-12\" style=\"margin: 10px 0;\">
                <span class=\"col-md-4\">
                    <label for=\"segment\" class=\"n5-ui-sc-label\">Filter Products by Pack Size</label>
                    <input class='n5-ui-inBill-row-checkbox js-pack-check' type='checkbox' <% if(priDnI.packCondition.startValue) { %>checked <% } %> /> Filter
                    <select class=\"n5-ui-sc-label-sub select-dropdown js-pack-select <% if(!priDnI.packCondition.startValue) { %> hidden <% } %>\">
                        <option value=\"greater\" <% if(priDnI.packCondition.type === \"greater\") { %>selected<% } %>>Greater than or equal to</option>
                        <option value=\"less\" <% if(priDnI.packCondition.type === \"less\") { %>selected<% } %>>Less than</option>
                        <option value=\"equal\" <% if(priDnI.packCondition.type === \"equal\") { %>selected<% } %>>Equal to</option>
                        <option value=\"range\" <% if(priDnI.packCondition.type === \"range\") { %>selected<% } %>>Range</option>
                    </select>
                </span>
                
                <span class=\"col-md-4 js-pack-start-parent <% if(!priDnI.packCondition.startValue) { %> hidden <% } %>\">
                    <label for=\"segment\" class=\"n5-ui-sc-label js-pack-start-label\"><% if(!priDnI.packCondition.endValue) { %> Value <% } else { %>Start Value <% } %></label>
                    <input class=\"n5-template-box js-pack-start\" value=\"<%= priDnI.packCondition.startValue %>\" placeholder=\"Value\"/>
                </span>
                
                <span class=\"col-md-4 js-pack-end-parent <% if(!priDnI.packCondition.endValue) { %> hidden <% } %>\">
                    <label for=\"segment\" class=\"n5-ui-sc-label\">End Value</label>
                    <input class=\"n5-template-box js-pack-end\" value=\"<%= priDnI.packCondition.endValue %>\" placeholder=\"Value\"/>
                </span>
            </div>
        </div>

        <div class=\"row\">
            <div class=\"col-md-12\">
                <span class=\"col-md-4\" style=\"margin: 10px 0;\">
                    <label for=\"segment\" class=\"n5-ui-sc-label\">No Of Slabs</label>
                    <select class=\"n5-ui-sc-label-sub select-dropdown\" id=\"noofprisTextStr<%= counter %>\" lastSel=\"<%= priDnI.numSlabs %>\">
                        <% for(var i = 1; i <= 100; i++) { %>
                            <option <% if(parseInt(priDnI.numSlabs) === i) { %>selected<% } %> > <%= i %> </option>
                        <% } %>
                    </select>
                </span>

                <span class=\"col-md-4\" style=\"margin: 10px 0;\">
                    <label for=\"first_name\" class=\"n5-ui-sc-label\">Sales Period</label>
                    <div class=\"input-prepend input-group\">
                        <span class=\"add-on input-group-addon\"><i class=\"glyphicon glyphicon-calendar fa fa-calendar\"></i></span>
                        <input type=\"text\" name=\"reservation\" id=\"n5-date-reservation-pri<%= counter %>\" class=\"form-control\" readonly placeholder = \"Select Period\" /> 
                    </div>      
                </span>
            </div>
        </div>
        <div class=\"row\">
            <div class=\"col-md-12\">
                <div id=\"n5-Q-cond-table-pri<%= counter %>\">
                    <table class=\"table table-bordered table-striped table-hover\" id=\"dynamicTable\">
                        <thead>
                            <tr>
                                <th>No Of Products</th>
                                <th>Payout Rate</th>
                                <th>Payout Type</th>
                                <th>Slab QC</tc>
                            </tr>
                        </thead>
                        <tbody>
                            <% if (priDnI.priPayouts.length  === 0) { %>
                            <tr>
                                <td><input class='n5-template-selectmenu2 n5-ui-qc-input-placeholder' placeholder='No Of Products' type='text'/></td>
                                <td><input class='n5-template-selectmenu2 n5-ui-qc-input-placeholder' placeholder='Payout Rate' type='text'/></td>
                                <td>
                                    <span id='n5-ui-pri-table-product1'>
                                        <select class='select-dropdown n5-ui-sc-label-sub' id='noofprisTextStr-pri-payout1'>
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
                            <% } else { %>
                            <% _.each(priDnI.priPayouts, function(row, key, list) { %>
                            <tr>
                                <td><input class='n5-template-selectmenu2 n5-ui-qc-input-placeholder' value=\"<%=row.numProducts%>\" placeholder='No Of Products' type='text'/></td>
                                <td><input class='n5-template-selectmenu2 n5-ui-qc-input-placeholder' value=\"<%=row.payoutValue%>\" placeholder='Payout Rate' type='text'/></td>
                                <td>
                                    <span id='n5-ui-pri-table-product<%= key + 1 %>'>
                                        <select class='select-dropdown n5-ui-sc-label-sub' id='noofprisTextStr-pri-payout<%= key + 1 %>'>
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
                            <% } %>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class = \"pri-qualifying-conditions\">
            <div class = \"qualifying-conditions-list\"></div>
            <button class=\"add-condition  button-simple\">Add Qualifying Condition</button>
        </div>
    </div>
</script>
";
    }

    public function getTemplateName()
    {
        return "priTemplate.tmpl";
    }

    public function getDebugInfo()
    {
        return array (  19 => 1,);
    }
}
