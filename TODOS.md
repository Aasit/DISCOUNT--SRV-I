Remaining Tasks on New JSON -> Model Mapping
===
1. Create heirarchical visitor pattern to traverse through whole scheme data model structure.
2. Extract execution JSON & execution functions
3. New strategy for execution
3.1 Compute total payout and update in cache as more dealers are simulated
3.2 Resolve QC Satisfy Any process as soon as a dealer data is received
4. Fix exection not completed for all dealers
5. Check if the tplId to be sent for slab template is the `slabDnI->id` or at the top level `id` of the slab template
6. Add qcList generator for lapEntries mapping of slabTpls and ppiTpls
7. Add products marshalling for lapEntries mapping of slabTpls and ppiTpls
8. Add extra entry generation for qcs
9. Generate qcList for Pri Templates

Front-End Issues & Missing Features
-----
1. ~~Add check for console for IE~~ - **_BIKAS_** [ **DONE** ]
2. ~~No Templates rendering properly in IE9 - problems with search boxes, date selection widgets, drop downs, etc.~~ - **_ANURAG / BIKAS_** [ **DONE** ]
2. ~~Rendering view from model~~ - **_ANURAG / BIKAS_** [ **DONE** ]
3. ~~Add pointer cursor to (X) and (V) button in cards~~ - **_ANURAG_** [ **DONE** ]
4. **Alignment for date picker input box not proper in Qualifying Conditions section** - **_ANURAG_**
5. ~~Change text of submit button based on state of scheme (creating, updating, reviewing, approving)~~ - **_ANURAG_** [ **PARTIALLY DONE** ] - When scheme initiated, the initiator and approver should not see any buttons (as they have no actions in this state), only the reviewer should see them, and so on and so forth. [ **DONE** ]
5. ~~Terms and Conditions not being rendered in model -> view rendering~~ - **_ANURAG_** [ **DONE** ]
5. ~~Template names not being rendered in model -> view rendering~~ - **_BIKAS_** [ **DONE** ]
6. ~~Add front-end caching for product searches using select2~~ - **_ANURAG_** [ **DONE** ]
7. ~~Check placeholder for all boxes in Scheme Creation Page. Currently placeholder.js is not used, but a static code exists in template.js to show placeholders for all 'already rendered' element. However this does not work for placeholders of elements which are added after the page is rendered.~~ - **_ANURAG_** [ **DONE** ]
8. ~~Scrolling not working in product search boxes~~ - **_ANURAG_** [ **DONE** ]
9. ~~All date selection widgets to have date displayed in dd-mm-yyyy format~~ - **_ANURAG_** [ **DONE** ]
10. Add POST param to schemeJson being saved to backend using backbone - BIKAS [ **DEFERRED** ]

Back End (PHP) Issues & Missing Features
-----
0. Scheme Simulation Todos:
    - Fix reading of Target data in ::getTargetData(), currently reading product Ids, but target data needs to be filtered by sub brand ids
    - ~~Add product packs to \Akzo\Product\Service::getProductIdsByPid()~~ [ **DONE** ]
    - Store '%' for 'All Products' instead of a list of all product ids [ **DEFERRED** ]
    - Add dealer attributes to \Akzo\Geography\Service::getDealersByGid() 
    - ~~Add filtering by segments to \Akzo\Sales\Service::getTargetData() & \Akzo\Sales\Service::getSalesData()~~ [ **DONE** ]
1. Create APIs to read sales data - **_ANURAG_**:
    - getDealersSales:
        - takes in dealer codes / objects as an array
        - sales data collated at the level of clusters, subbrands & groups filtered by a date range
2. Create APIs to read target data - **_ANURAG_**:
    - getDealersTarget:
        - takes in dealer codes / objects as an array
        - target data collated at the level of clusters, subbrands & groups filtered by a date range
3. Create APIs to create / execute scheme - **_SHAMIK_**
    - **createScheme**:
        - ~~Takes in the scheme json data as returned from the front-end~~
        - **Runs a JSON schema checker on the json data to validate the entries. Waiting on BIKAS to choose one.** - 
        - ~~Sends it to the Rule Engine to create the scheme and return a scheme ID~~ - [ **DONE** ]
        - ~~Stores the same in a local database w/ scheme ID, state, start date, end date and scheme json data~~
    - **listSchemes**:
        - ~~Takes in the scheme state: created, initiated, reviewed, active, concluded, paid_out~~
        - **Takes in a date range for start and end date of the scheme** - **_SHAMIK_** [ **DONE** ]
        - ~~Reads local database and returns scheme ID, state, start date, end date and scheme json data~~
    - **executeScheme:**
        - Takes in the scheme JSON data and scheme ID
        - Reads relevant information as required for execution of the scheme
        - Marshalls it into a JSON structure as is required by the scheme execution API
        - Needs to be a long running service
    - **deleteScheme:**
        - Takes in scheme ID / name
        - ~~deletes the same from the Rules Engine~~
        - delete the same from the database
4. **Need to check on template model for inBill template. Discuss with Ravi that in-Bill template still needs to be stored and executed for simulation of scheme but should be omitted while calculating payout** - **_SHAMIK_**
5. ~~Implement geography filtering on a per user territory basis~~ - **_SHAMIK_** [ **DONE** ]
6. **Implement ordered reading of XML data in import cron job** - **_SHAMIK_**
7. **Discuss with Akzo regarding segment** - **_SHAMIK_**
    - Segment / Sales Division Value in DB from S908 & monthtgt: 70 (70 Trade), 72 (72 Reserved) (no segment during scheme creation), 74 (74 Professional), 76 (76 Direct), 77 (77 MR Trade), 75 (??) (no segment during scheme creation)
    - Segment displayed in Scheme Creation - 70 Trade, 76 Direct, 76 RS (No mapping), 76 Sub Dealer (No mapping), 77 MR Bharat (No mapping), 77 MR Trade, 74 Professional



To be Reviewed
---
1. **All date selection widget in templates & QCs**  - **_ANURAG_**
    - Check all are current dates - in some cases it is still 2013
    - Check that date is rendered in dd-mm-yyyy format
2. **All product/subbrand/group/cluster selection widget in templates & QCs** - **_ANURAG_**
    - Check that codes are being added in braces beside name in all multiselects

--------------
--------------
--------------

Completed TODOs
==========

Post Release Quick fixes
-----
1. ~~Qualifying conditions selection issue to be fixed.~~ - **_ANURAG_** [ **DONE** ]
2. ~~Navigation after saving scheme~~ - **_BIKAS_** [ **DONE** ]
3. ~~Review Placeholders~~ - **_ANURAG / BIKAS_** [ **DONE** ]
4. **Change all instances of dropdown inside the templates to select2** - **_BIKAS_**
5. ~~Change database column `` `ak_users`.`ID` `` to `` `ak_users`.`id` ``. Will also need changes in Scheme Eloquent model~~ - **_SHAMIK_** [ **DONE** ]
6. ~~Changed `start_date` and `end_date` in ```ak_discounts_scheme_details``` table from type `DATE` to `VARCHAR(100)`. No changes made in liquibase schema yet.~~ - **_SHAMIK_** [ **DONE** ]

To Be Completed For Release
---
1. ~~Need to add drop down values for Dealer Attribute as per attributes in dealermast.XML~~ - Sent mail to Sharma for review - **_SHAMIK_** [ **DONE** ]
2. ~~Fix login & navigation from dashboard to create scheme page. Change all controllers to \Akzo\Control\ProtectedController~~ - **_ANURAG_** [ **DONE** ]
3. ~~Having two separate APIs backends - one for login and the other for the Rule Engine~~ - **_SHAMIK / BARRY_** [ **DONE** ]
4. ~~Add scheme segment to JSON - ensure that Rule Engine ignores it~~ - **_RAVI / ANURAG_** [ **DONE** ]
5. ~~Add database DAO for saving schemes and also adding a state variable for the models~~ - **_SHAMIK_** [ **DONE** ]
6. ~~Add geography 'gid' to model being saved to back-end, add the same to rule engine ?~~ - **_ANURAG_** [ **DONE** ]
7. ~~Check on Qualifying Conditions UI - boxing for in-template QCs~~ - **_ANURAG_** [ **DONE** ]
8. ~~There should be no Qualifying Conditions for in-Bill template~~ - **_BIKAS_** [ **DONE** ]
9. ~~Create a 'Step-by-Step' script / User Guide~~ - **_SHAMIK_** [ **FIRST DRAFT DONE** ]
10. ~~Render Scheme Creation Page back from the saved model~~ - **_ANURAG / BIKAS_** [ **DONE** ]
11. ~~Add 404 & 500 error page~~ - **_ANURAG_** [ **DONE** ]
12. ~~Fix Ui on scheme creation page~~ - **_ANURAG_** [ **DONE** ]
    - ~~Convert all drop downs to select2~~
    - ~~Qualifying conditions Products wraps to next line - should be responsive~~
    - ~~Template tables overflow - need to be responsive~~
    - ~~Remove "Temp" button and add a "Save" button on the right which should scroll with the page~~ - **_BIKAS_** [ **DONE** ]
13. ~~Add overlayed progress bar when saving scheme - all fields should be disabled while saving~~ - **_BIKAS_** [ **DONE** ]
14. ~~Call createScheme API in scheme saving controller function~~ - **_SHAMIK / BIKAS_** [ **DONE** ]
15. ~~Change \Akzo\User model to have a polymorphic relation with \Akzo\User\ZM, \Akzo\User\RM & \Akzo\User\SO~~ - **_SHAMIK_** [ **DONE** ]

Inputs by Sharma
---
1. ~~Ie9 problem~~ - BIKAS [ **FIXED REPORTED PROBLEMS** ]
2. ~~Segment should be multiple select~~ - ANURAG [ **DONE** ]
3. ~~Date selection widget does not show the full selected date~~ - ANURAG [ **DONE** ]
4. ~~Qualifying conditions allignment not proper. Drop down overlaps~~ - ANURAG [ **DONE - ALL PUT IN A SINGLE LINE** ]
5. ~~All Products - have an option of selecting 'All Products' and subtract some from them.~~ - ANURAG [ **DONE** ]
6. ~~Correct placeholder in Payout Condition.~~ - ANURAG [ **DONE** ]
7. ~~In-Bill template - only Rs / Ltr as Payout Condition.~~ - BIKAS [ **DONE** ]
8. ~~Allignment for Product Type (Bulk / Retail)~~ - BIKAS [ **DONE** ]
9. ~~PRI needs to have a set of pre-selected products.~~ - ANURAG [ **DONE** ]
10. ~~Slab Template table boxes need to be reduced in width.~~ - BIKAS [ **DONE** ]
11. ~~Slab Template - on selection of more than 1 lap and then selecting 1 lap subsequently only shows lap rate 2, instead of lap rate 1.~~ - BIKAS [ **DONE** ]
12. ~~Use proper Placeholders for template table boxes~~ - BIKAS [ **DONE** ]
13. ~~Select2 dopdowns in place of native5.ui.select~~ - **_ANURAG_** [ **DONE** ]

First set of Fixes
----
1. ~~Check on `->toJson()` problem with Depot model~~ - _**SHAMIK**_ [ **DONE** ]
    - ~~The new accessor `depot_name` does not appear in the Json model~~
2. ~~Update product related models:~~
    - ~~Add a new accessor called 'pid' which should be a combination of a first letter of Group, SubBrand, Brand, Cluster, Product and the `ID` in database~~ - **_ANURAG_** [ **DONE** ]
3. ~~Complete model for the scheme header / scheme details~~ - [ **DONE** ]
    - ~~Need to add drop down values as per mail from Sharma~~
    - ~~Need to add drop down values for Dealer Attribute as per attributes in dealermast.XML~~ - **_SHAMIK_** [ **DONE** ]
4. ~~Complete model for the qualifying conditions~~ - [ **DONE** ]
    - ~~Qualifying conditions listeners have to be programmed for showing up date range selectors and product list selectors~~
    - ~~Model and collection for the qualifying conditions need to be coded~~
        - ~~Needs to adhere to the qualifying conditions structure - **_please send to Ravi to confirm_**~~
    - ~~Complete in-template Qualifying Conditions Functionality~~ - **_ANURAG_**
        - ~~Need to improve UI - enclose all QCs insise a box inside the template box and add Satisfy All buttons~~
        - ~~Confirm that in-template qualifying conditions are being sent to the backend~~ - Will be taken care of by JSON Schema Checker - **_SHAMIK / BIKAS_** [ **DONE** ]
5. ~~Complete the scheme template UI~~ - [ **DONE** ]
6. ~~Change scheme template model / view to adhere to Backbone structure~~ - [ **DONE** ]
    - ~~All scheme templates need to adhere to the scheme template structure as shared by Ravi~~
        - ~~Ravi will only send across structure for Slab, PPI & PRI Template, further you need to decide on the structure for the InBill template model by yourself, model it simillar to the other templates~~
7. ~~Create the top level model for the whole scheme as per the scheme creation structure send across and initiate its saving to the backend - which then in turn calls the createScheme API and saves the scheme~~ - [ **DONE** ]
8. ~~Fix problem with Table UI rendering in templates~~ - **_BIKAS_** [ **DONE** ]
9. ~~Add unique IDs to all sections in model as per sample sent across by RAVI~~ - **_BIKAS_** [ **DONE** ]
10. ~~Link "Create Scheme" button on dashboard to Scheme Creation page~~ [ **DONE** ]


