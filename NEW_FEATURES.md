Refine Scheme Listing
---
* **My Schemes** - Main menu item, with following sections and each list rendered inside cards - should also be navigable using sub menus too
 * _Schemes Initiated by me_
 * _Schemes under Review by me_
 * _Schemes under Approval by me_
 * _Active Schemes_
 * _Draft Schemes_ (to be used for Simulation)

Scheme Approval Workflow
---
1. Add two buttons for scheme initiator - **Save as Draft** & **Initiate (Submit for Review & Approval)** - These buttons should be removed once scheme has been submitted. Once submitted, scheme edition should be disabled
2. Scheme to be non-editable for reviewer - Should show single button till scheme has been reviewed - **Review (Submit for Approval)**
3. Scheme to be non-editable for approver - Should show single button till scheme has been approved - **Approve (Activate Scheme)**
4. Add email notifications for each step in approval flow:

* On Initiation of Scheme:
  * Email to initator - Scheme has been submitted for review (by &lt;Reviewer details&gt;) & subsequent approval (by &lt;Approver details&gt;). You will be intimated as and an actions have been performed on this scheme. You can also login to the Discounts Management Application _link_ to view the status under the _Schemes Pending Approval_ section on your _Dashboard_.
  * Email to reviewer - A scheme has been submitted for your review (by &lt;Initiator details&gt;). Please login to the Discounts Management Application _link_ to & navigate to the _Schemes Pending Approval_ Section on your _Dashboard_ to review and submit the scheme for subsequent approval (by &lt;Approver details&gt;). You will be intimated as and when an action has been performed on this scheme.
  * Email to approver - A scheme has been submitted (by &lt;Initiator details&gt;) for which you are the approver. The scheme is currently being reviewed by &lt;Reviewer Details&gt;. You will be intiated as soon as it has been reviewed and is awaiting your approval. You may also login to the Discounts Management Application _link_ & navigate to the _Schemes Pending Approval_ Section on your _Dashboard_ to view its status. You will be intimated as and when an action has been performed on this scheme.
* Similar mail as above on Review of Scheme
* Similar mail as above on Approval of Scheme
5. Under **Schemes Pending Approval** highlight & put on top schemes which require your immediate attention.
6. Implement In-App Notifications

Scheme Simulation Wordflow
---
1. Trigger simulation from the Drafted Schemes listing.
2. Have a way to create grouping of schemes. UI should allow the following:
* Button to create a simulation group
* On click of the button add a new section / div, and maybe for simplicity place a multi select inside it with all the schemes in the drop down.
3. Scheme simulation should be done just once and then the data saved in the Cache. Maybe it can be even persisted in the DB.
