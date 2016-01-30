﻿=== Tickera - WordPress Event Ticketing ===
Contributors: tickera
Tags: event ticketing, ticketing, ticket, e-tickets, sell tickets, event, event management, event registration, wordpress events, booking, events, venue, e-commerce, payment, registration, concert, conference
Requires at least: 4.1
Tested up to: 4.3
Stable tag: trunk
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Transform your WordPress site into a full-featured event ticketing system

== Description ==

If you want to sell tickets on your site and deliver them to your buyers digitally, Tickera is exactly what you need. When you use the Tickera plugin to sell and send tickets, you are essentially setting up your own hosted solution wherein you control the profits with no requirement to send a cut to a third party. Tickera allows you to check in attendees easily by using a simple and free [iPhone](https://itunes.apple.com/us/app/ticket-checkin/id958838933?ls=1&mt=8 "Tickera iPhone check-in app") and [Android](https://play.google.com/store/apps/details?id=com.tickera.android&hl=en "Tickera Android check-in app") applications as well as [Barcode readers](http://tickera.com/addons/barcode-reader/ "Tickera Barcode Reader Add-on") to speed up the whole check-in process.

= PAYMENT GATEWAYS =

Tickera plugin comes with a lot of payment gateways including:

* [Mijireh](http://tickera.com/addons/mijireh-checkout/ "Mijireh payment gateway for Tickera") (80+ Gateways included)
* [Mollie](http://tickera.com/addons/mollie-payment-gateway/ "Mollie payment gateway for Tickera") (iDeal, Credit Card, Bancontact / Mister Cash, SOFORT Banking, Overbooking, Bitcoin, PayPal, paysafecard and   AcceptEmail)
* PayPal Standard
* PayPal PRO
* 2Checkout
* Stripe
* Paymill
* Authorize.net
* PIN Payments
* Vogue Pay
* iPay88
* PayGate
* Braintree
* PayUMoney
* PayTabs
* White Payments
* Custom Offline Payments
* Free Orders.

= CART =
Your customers will be able to purchase unlimited number of tickets from more than one event at once!

= TICKET BUILDER =
Ticket builder allows you to create ticket templates which could be selected for each ticket type. So each ticket type (Standard, VIP, etc.) may look totally different and you can achieve that easily by dragging and dropping elements, reordering, changing font sizes and colors, ticket paper size and its orientation or even put a full-background image if you want fully custom design of the ticket.

= WHITE LABEL =
Tickera plugin is ready for white-labeling. By changing just one line of code, you'll rename the plugin by your own or client's preference

= MULTISITE SUPPORT =
Do you have WordPress multisite installed with a number of subsites and clients? Awesome! Give your clients option to create their own events and sell tickets!

= PURCHASE FORM =
Purchase form includes info from each ticket owner. New hooks allows you to add new fields for buyer or ticket owners. It would be useful if you want to add, for instance, additional field where your customers may choose food preference, set their age, sex, etc. In addition, buyers are able to download tickets directly from a purchase confirmation page – no more lost emails which have to be sent manually, lost attachments or server issues which prevent tickets to reach your clients.
Check [Custom Forms](http://tickera.com/addons/custom-forms/ "PayPal Chained Payments gateway for Tickera") add-on and create beautiful forms which will fit into your theme's design. Control order of the elements, number of columns, set required and optional fields in an easy way.

= TAKE A CUT =
Check out [Stripe Connect](http://tickera.com/addons/stripe-connect/ "Stripe Connect gateway for Tickera") and [PayPal Chained Payments](http://tickera.com/addons/paypal-chained-payments/ "PayPal Chained Payments gateway for Tickera") Tickera add-ons which will allow you to take a percentage per each sale on your WordPress multisite network

= TRANSLATION READY =
You'll be able to translate every possible word in a [WordPress way](http://www.tickera.com/blog/translating-tickera-plugin/ "Translate Tickera plugin").

= TAX ADMINISTRATION =
Collect taxes with Tickera. Administrators can set up and manage tax rate easily!

= COMPATIBILITY =
Tickera works well and look good with almost every WordPress theme out there

= MULTIPLE TICKET TYPES =
Create multiple ticket types for one or more events, set ticket quantity limits (ticket quantity per purchase, available check-ins per ticket...)

= TICKET FEES =
Add additional fee per ticket in order to cover payment gateway, service or any other type of cost

= DISCOUNT CODES =
Create unlimited number of discount codes available for all or just certain ticket type

= CUSTOMIZABLE =
Tickera is developer friendly. Customize any aspect of Tickera with actions and filters! Extend its functionality by creating great add-ons!

= ADD-ONS & EXTENSTIONS =

[Extend Tickera](http://tickera.com/tickera-events-add-ons/ "Tickera Add-ons and Extensions") with a number of add-ons.

= DOCUMENTATION =
Stuck? Check out the [plugin documentation](http://tickera.com/documentation-category/tickera/ "Tickera Documentation") 

== Installation ==

= To Install =

* Download the Tickera plugin file
* Unzip the file into a folder on your hard drive
* Upload the /tickera/ folder to the /wp-content/plugins/ folder on your site
* Visit your Dashboard -> Plugins and Activate it there.

= To Set Up And Configure Tickera = 

You can find [setup instructions here >](http://tickera.com/documentation-category/tickera/ "Tickera plugin installation and usage help")

== Changelog ==

= 3.2.2.1 - 22/JAN/2015 =
- Add new session path if session is not writable
- Added upcoming events widget
- Added standard widget classes to widgets

= 3.2.2 - 21/JAN/2015 =
- Fixed issue with enqueuing scripts via http

= 3.2.1.9 - 18/JAN/2015 =
- Added additional feature for auto-creating API Keys for event (upon creating an event)
- Show "Check in" option for the admin user in the Attendees & Tickets details screen by default
- Trimmed payment gateway value fields in order to avoid errors with copy/paste gateways's API keys
- Added tooltips, conditional show/hide and input validation on the settings page in the admin
- Added input validation for ticket types and discount codes
- Fixed issue with Ticket Type search and permissions in the admin

= 3.2.1.8 - 15/JAN/2015 =
- Fixed issue with radio and checkbox labels

= 3.2.1.7 - 11/JAN/2015 =
- Added Global Fee Scope option

= 3.2.1.6 - 06/JAN/2015 =
- Show buyer name in the attendees & tickets list (in the admin) if ticket owner name is not set
- Added additional hooks for developers

= 3.2.1.5 - 05/JAN/2015 =
- Fixed issue with jQuery validation causing issues on some WooCommerce themes
- Fixed display of the inclusive tax amount

= 3.2.1.4 - 22/DEC/2015 =
- Fixed issue with ticket templates close button not working in FF
- Added additional CSS style to the event calendar in the admin area
- Fixed issue with PayPal PRO (multiple clicks on the checkout)

= 3.2.1.3 - 17/DEC/2015 =
- Check-in API improvements
- Fixed issue with event edit link located on the orders admin page
- Added additional capabilities for controlling event management
- Fixed conflict with WooCommerce Add to Cart action

= 3.2.1.2 - 25/NOV/2015 =
- Added itemized description on the checkout (included ticket type titles)
- Improvements in the check-in API
- Added new hooks for developers
- Fixed issue with creating empty orders when visiting process payment page with empty cart

= 3.2.1.1 - 23/NOV/2015 =
- Added "Admin Order Placed E-Mail" notifications
- Added ORDER_TOTAL and BUYER_NAME placeholders to the offline payments payment Instructions field
- Added "Multipage Ticket Template" option
- Added additional field and options to the Authorize.net payment gateway
- If none gateways are active, set FREE Orders by default

= 3.2.1.0 - 20/NOV/2015 =
- Fixed permission error on the orders admin page when clicking on an event link under the "Ticket(s)" column
- Fixed issue with invalid user id when clicking on a user link on the admin order page
- Fixed notices on the order details page shown if settings are not yet saved
- Set first value as default on for the radio button element if default value is not set (works for the buyer and attendee data including custom forms)
- PayUMoney args typo fix


= 3.2.0.9 - 19/NOV/2015 =
- Added support for 2D barcode readers
- Added extra fields to Authorize.net payment gateway (required by the European merchants)
- Fixed issue issues with check-ins when orders are pending

= 3.2.0.8 - 17/NOV/2015 =
- Fixed issue with download links and permissions when using ORDER_DETAILS e-mail placeholder

= 3.2.0.7 - 12/NOV/2015 =
- Added new option "Show Tickets Automatically" under Event administration screen
- Fixed CSS issue for "Create New" menu item in the admin
- Fixed notices in the check-in API

= 3.2.0.6 - 06/NOV/2015 =
- Fixed issue with post statuses

= 3.2.0.5 - 06/NOV/2015 =
- Fixed issue with ticket ID alignment in ticket template 
- Fixed issue with Buyer Name in the e-mails when payments are processed via on-site payment gateways (like Stripe, PayPal pro, Paymill etc)
- Fixed issue with order search page permissions
- Added additional hooks for developers
- Fixes issues with check-in API
- Fixed issue with expiry date id (conflict with WooCommerce)
- Fixed issue with PIN Payments display errors
 
= 3.2.0.4 - 30/OCT/2015 =
- Fixed issues with the cart.js

= 3.2.0.3 - 22/OCT/2015 =
- Added better support for Events (added visual part for the front-end, native post type look and functionality)
- Added additional shortcodes to the shortcode builder
- Fixed issue with PayUMoney redirect loop
- Added Ticket ID ticket template element
- Added new hooks, filters and helpers for developers
- Redesigned interface for ticket templates
- Ticket code element bug fix
- Fixed issue with deleted checkins showing in the stats (in mobile apps)

= 3.2.0.2 - 14/OCT/2015 =
- Optimized PDF library and removed unused fonts
- Added additional shortcode arguments (added button type for tc_event shortcode)
- Fixed issue with API Keys pagination in the admin
- Fixed issue with discounts display (when discount value is greater than total)
- Added option for IPN page to be a physical page (instead of virtual)
- Added notice in the settings for servers which don't support at least 5.3 version of PHP
- Automatically disable certain payment gateways (Optimal Payments / Netbanx and Beanstream) on servers which has PHP version bellow 5.3 
- Added additional hooks and filters for developers
- Added Global ticket fees option

= 3.2.0.1 - 13/OCT/2015 =
- Added new hooks and filters for developers
- Compatibility with Event Calendar add-on (https://tickera.com/addons/tickera-event-calendar/) 
- Compatibility with Event Role Based Prices add-on (https://tickera.com/addons/role-based-prices/)

= 3.2 - 07/OCT/2015 =
- Added event end date
- Added OptimalPayments / Netbanx payment gateway
- Added new hooks and filters for developers
- Added login link to the order history shortcode / page

= 3.1.9.9 - 06/OCT/2015 =
- Added Order Details placeholder for order completed client email
- Added ORDER_ID placeholder to the offline payments
- Add option for process payment page to be created as physical page
- Consolidated hooks & filters names and added basic documentation (https://tickera.com/tickera-documentation/hooks-and-filters/)
- Fixed issues with slashes in some input fields in the admin
- Fixed issues with check-in API when API Key is limited to a single event

= 3.1.9.8 - 01/OCT/2015 =
- Added option to recreate deleted tickets from order details page
- Added option for controlling e-mail sending type (wp_mail or PHP mail) under plugin e-mail settings
- Added additional shortcode [tc_order_history] which shows order / purchase history for logged-in users
- Added Ticket Order History on the user profile page in the admin
- Added additional column for ticket orders count on the user list page in the admin
- Added default fields value to the buyer form (user first name, last name and the email will be automatically pulled and shown in the input fields by default)
- Fixed JS issues with cart validation (conflict with some themes)

= 3.1.9.7 - 30/SEP/2015 =
- Added Beanstream payment gateway
- Added additional order status: trash
- Added order status filters in the admin area
- Fixed issue with event date and time shown on the ticket


= 3.1.9.6 - 28/SEP/2015 =
- Change Free Order gateway (redirect to the confirmation page automatically and skip the payment page)
- Added option for controlling "Order Details Pretty Links" in order to avoid conflicts (404 not found order details pages) with some third-party plugins and themes
- Added "Skip Payment Confirmation Page" option in each payment gateway settings
- Fixed issue with not clearing "Delete Pending Orders" cron job correctly

= 3.1.9.5 - 17/SEP/2015 =
- Added option for changing locale for Komoju payment gateway
- Removed unnecessary decimals from the price amount (you can override the logic / number of decimal places by using the tc_cart_amount_decimals filter) 

= 3.1.9.4 - 10/SEP/2015 =
- Added additional currencies in the Braintree Payment Gateway
- Fixed issues with Payu Money payment gateway
- Fixed issue with display date and time based on different time zones
- Fixed issue with extra slashes added to the payment gateway fields
- Fixed issue not being able to click bottom pallete of color picker
- Ticket code not aligning fixed
- Fixed issues with clearing session and cookie data after confirmation

= 3.1.9.2 - 02/SEP/2015 =
- Added PayU Latam Payment Gateway integration
- Added Komoju Payment Gateway integration
- Added inline edit option for the attendee info (First Name, Last Name and E-mail fields) on the order details page (admin side)
- Added Malaysia locale for PayPal standard and additional filters for developers
- Added JavaScript validation for buyer email field on the front-end
- Added option to control sending of Stripe Receipt automatically after completed purchase (receipt_email)
- Fixed issues with white-labeling of "Tickera" in the shortcode builder (when TICKET_PLUGIN_TITLE is defined)
- Fixed issues with open comments (in some themes) on the tickera pages

= 3.1.9.1 - 19/AUG/2015 =
- Revamp of the payment gateway API and all payment gateways code (IMPORTANT: if you're using payment gateway add-ons, please update them)
- Added Form Field API (beta)
- Added Simplify Payment Gateway
- Fixed issues with WordPress 4.3 (construct for Widgets)
- Removed White Payments payment gateways (their service is discontinued)


= 3.1.9 - 17/AUG/2015 =
- Added shortcode builder
- Fixed issues with attendee list in the mobile apps / check-in API
- Fixed admin notices on the event and ticket type page
- Added message when order id is not specified on the order details page

= 3.1.8.8 - 03/AUG/2015 =
- Added "Ticketing Store at a Glance" dashboard widget

= 3.1.8.6 - 31/JUL/2015 =
- Added toggle controls for event and ticket visibility
- Added delete pending orders functionality
- Removed uppercase from buttons
- Fixed Ipay label
- Removed align right from credit card tables

= 3.1.8.5 - 27/JUL/2015 =
- Added new plugin updater

= 3.1.8.4 - 27/JUL/2015 =
- Added missing div

= 3.1.8.3 - 02/JUL/2015 =
- Added quantity column option to the events shortcode. Example: [event id="53" quantity="true"]

= 3.1.8.2 - 01/JUL/2015 =
- Check-in API improvements (added additional filters used by custom fields add-on)

= 3.1.8.1 - 26/JUN/2015 =
- Fixed conflict with Divi theme (2.4.3) which caused fatal error when downloading a PDF ticket

= 3.1.8 - 25/JUN/2015 =
- Added price inclusive of tax option

= 3.1.7.9 - 23/JUN/2015 =
- Added support for ANSI A (216x279 mm) US paper size for ticket templates
- Fixed issue with ticket template not showing

= 3.1.7.8 - 17/JUN/2015 =
- Added wp editors instead of textareas for ticket description and event terms and conditions

= 3.1.7.7 - 16/JUN/2015 =
- CSS fixes for select boxes in the admin (to avoid theme issues)
- Code improvements and added additional options for discount codes (for developers)

= 3.1.7.6 - 06/JUN/2015 =
- Added option for API KEYs to have access to all events at once
- Check-in API improvements

= 3.1.7.5 - 06/JUN/2015 =
- Added new user capabilities

= 3.1.7.4 - 29/MAY/2015 =
- Added Cell Alignment and Element Break Lines control to the Sponsor Logos ticket template element
- Added BUYER_NAME email confirmation placeholder
- Fixed e-mail formatting for order confirmation e-mails
- Fixed typo in PayPal Pro payment gateway (admin)

= 3.1.7.3 - 26/MAY/2015 =
- Improved check-in API

= 3.1.7.2 - 21/MAY/2015 =
- Updated language file

= 3.1.7.1 - 05/MAY/2015 =
- Added automatic Stripe receipt sending option
- Extended mobile check-in API

= 3.1.7 - 29/APR/2015 =
- Fixed issue with ticket sold count displayed in orders table
- Fixed issue with custom forms add-on 
- Added new hooks for developers (tc_2d_code_params)

= 3.1.6.9 - 28/APR/2015 =
- Fixed issues with Custom Forms on the front (cart page) in Firefox

= 3.1.6.8 - 20/APR/2015 =
- Added additional hooks for developers
- Various code improvements

= 3.1.6.7 - 17/APR/2015 =
- Fixed issue with admin discount code page pagination
- Added additional hooks for developers (for skipping payment confirmation page)

= 3.1.6.6 - 15/APR/2015 =
- Added additional shortcodes (event_tickets_sold, event_tickets_left, tickets_sold, tickets_left)
- Fixed issue with incorrect total amount shown on the 2checkout.com

= 3.1.6.5 - 09/APR/2015 =
- Added quantity sold field on ticket types screen in the admin

= 3.1.6.4 - 08/APR/2015 =
- Added option to control availability of the payment gateways for all subsites from within a multisite admin panel
- Added additional hooks for developers

= 3.1.6.3 - 04/APR/2015 =
- Fixed issue with payment gateway public name shown on front (was admin_name instead)

= 3.1.6.2 - 31/MAR/2015 =
- Hide cart menu by default
- Removed unnecessary plugin menu items
- Fixed issue with owner required fields

= 3.1.6.1 - 27/MAR/2015 =
- Fixed issue with discount limit

= 3.1.6 - 26/MAR/2015 =
- Added iPay88 payment gateway

= 3.1.5.9 - 23/MAR/2015 =
- Added PayGate payment gateway

= 3.1.5.8 - 20/MAR/2015 =
- Fixed translation string
- Added additional hooks for developers
- Other code improvements

= 3.1.5.7 - 11/MAR/2015 =
- Fixed issues caused by forcing json content type (fixed potential conflicts with other plugins and themes)

= 3.1.5.6 - 10/MAR/2015 =
- Fixed issue with barcode scan
- Fixed issue with order confirmation mail with Offline Payments

= 3.1.5.5 - 09/MAR/2015 =
- Fixed issues with comment form when tickera is activated

= 3.1.5.4 - 06/MAR/2015 =
- Fixed issue with update cart check control on the cart page

= 3.1.5.3 - 05/MAR/2015 =
- Fixed issue caused by output buffering when downloading a ticket (on some servers) 
- Added customer front order detail page link on the order details page in the admin

= 3.1.5.2 - 05/MAR/2015 =
- Fixed issue with the HTML characters in the email body

= 3.1.5.1 - 05/MAR/2015 =
- Fixed issue with broken images in the content editors in admin (in order messages, offline payments and free orders editors)

= 3.1.5 - 04/MAR/2015 =
- Fixed issue with output buffering when downloading a ticket

= 3.1.4.9 - 04/MAR/2015 =
- Added option to hide discount code field from the cart page
- Added option to control number of result rows displayed in the admin tables

= 3.1.4.8 - 03/MAR/2015 =
- Added additional control on the cart page (force cart update)

= 3.1.4.7 - 25/FEB/2015 =
- Added new hooks for developers
- Other code improvements

= 3.1.4.6 - 16/FEB/2015 =
- Added additional charge parameters in the White Payments gateway
- Fixed VoguePay process payment content type issue

= 3.1.4.5 - 08/FEB/2015 =
- Added White Payments payment gateway (https://whitepayments.com/)
- Improved cart performance when checking out a lot of tickets (few hundreds)

= 3.1.4.4 - 03/FEB/2015 =
- Fixed issues with saving custom offline payments fields in the admin
- Fixed issue with including JS files on the payment page in Stripe payment gateway

= 3.1.4.3 - 02/FEB/2015 =
- Added option for e-mail payment instructions upon placing an order in custom / offline payments gateway
- Added customer e-mail field on the order details in the admin
- Fixed text domain issue in Free Order and Custom Offline payments gateways

= 3.1.4.2 - 30/JAN/2015 =
- Fixed issues with ticket quantity limits
- Fixed issue with post author upon creating default tickera pages

= 3.1.4.1 - 27/JAN/2015 =
- Resolved issues with permalinks (with custom post types)

= 3.1.4 - 20/JAN/2015 =
- Fixed issue with Android app check in response error

= 3.1.3.9 - 20/JAN/2015 =
- Added Thai Baht currency in PayPal Standar gateway

= 3.1.3.8 - 14/JAN/2015 =
- Added new ticket template elements (ticket code and buyer name)
- Added changes to the check-in API required for the upcoming iPhone app

= 3.1.3.7 - 12/JAN/2015 =
- Fixed issue with discount code limit with percentage discount code type (not being applying on more than one ticket)

= 3.1.3.6 - 09/JAN/2015 =
- IMPORTANT: Added physical pages instead of virtual pages
- PayTabs payment gateway update (to reflect new API changes)
- Improvements in the checkout process on front (changed in the both design and code)

= 3.1.3.5 - 30/DEC/2014 =
- Improvements in the check-in API

= 3.1.3.4 - 29/DEC/2014 =
- Added PayTabs payment gateway (Africa, Middle East and Asia)

= 3.1.3.3 - 27/DEC/2014 =
- Resolved notices and issues with the previous version

= 3.1.3.2 - 26/DEC/2014 =
- Added: PayUMoney payment gateway (India)
- Added: automatic redirect to the gateway's payment page for 2Checkout, VoguePay and PayPal Standard
- Added: additional ticket shortcode argument (type="buynow") for automatic redirection to the cart page
- Changed: show payment gateway even in case that only one is active
- Fixed: small rounding issues with comparing payment amounts

= 3.1.3.1 - 18/DEC/2014 =
- Fixed Internet Explorer issues with payment gateway selection
- Code improvements with the ticket download section

= 3.1.3 - 11/DEC/2014 =
- Fixed small JS issues on the payment gateways screen in the admin

= 3.1.2.9 - 11/DEC/2014 =
- Admin UX improvements

= 3.1.2.8 - 03/DEC/2014 =
- Added attendee list PDF export feature

= 3.1.2.7 - 29/NOV/2014 =
- VoguePay payment gateway update (to reflect API changes)
- Resolved issue with all select boxed in the admin (display more than 10 records)

= 3.1.2.6 - 28/NOV/2014 =
- Resolved issue with pagination class (not displaying more than 10 pages)

= 3.1.2.5 - 25/NOV/2014 =
- Added White Payments gateway (beta)
- Fixed issue with Ticket Types pagination in the admin

= 3.1.2.4 - 20/NOV/2014 =
- IMPORTANT: after installing this version of Tickera, you must save plugin General Settings once again
- Reworked all payment gateways code
- Resolved issues with emails not being sent after payment confirmation (on some servers)

= 3.1.2.3 - 14/NOV/2014 ==
- Fixed issues with discount code being applied even if it's deleted

= 3.1.2.2 - 12/NOV/2014 =
- Added option to hide owner info fields from the cart page

= 3.1.2.1 - 08/NOV/2014 =
- Resolved issue with incorrectly date and time on tickets
- Fixed bug with not setting QR code size

= 3.1.2.0 - 05/NOV/2014 =
- Resolved issues with "Checked-in Tickets" count shown in mobile apps

= 3.1.1.9 - 31/OCT/2014 =
- Resolved issues with plugin updater

= 3.1.1.8 - 30/OCT/2014 =
- Resolved output buffering issues with ticket PDF preview (occurred only on some servers)

= 3.1.1.7 - 28/OCT/2014 =
- Removed deprecated jQuery function 'live' and changed to 'on'
- Added additional hooks for owner fields

= 3.1.1.6 - 28/OCT/2014 =
- Fixed bug with all ticket types deletion when a event is deleted
- Added plugin update option from within the WordPress administration panel

= 3.1.1.5 - 27/OCT/2014 =
- Fixed bug with clearfix

= 3.1.1.4 - 27/OCT/2014 =
- Fixed text domain issues and generated default language files

= 3.1.1.3 - 26/OCT/2014 =
- Added output buffering error description and instructions for fixing it (shown only on some servers when trying to generate a ticket)
- Resolved issues with confirmation screen (only on some servers) after payment via PayPal Standard payment gateway

= 3.1.1.2 - 20/OCT/2014 =
- Fixed unclosed div on front-end forms
- Added tc_event shortcode in order to avoid clash with other themes and plugins

= 3.1.1.1 - 19/OCT/2014 =
- Fixed PHP notices on the cart page

= 3.1.1.0 - 18/OCT/2014 =
- Resolved issues with non-selectable select boxes on ticket templates page in Firefox 

= 3.1.0.9 - 18/OCT/2014 =
- Resolved issues with e-mails (incorrect email headers, client e-mails not being sent)
- Added option to send completed order e-mail confirmation to clients upon changing order status to order paid

= 3.1.0.8 - 17/OCT/2014 =
- Added Braintree payment gateway

= 3.1.0.7 - 16/OCT/2014 =
- Added VoguePay payment gateway

= 3.1.0.6 - 16/OCT/2014 =
- Resolved issue with Cart page

= 3.1.0.5 - 15/OCT/2014 =
- Fixed issue with incorrectly closed html tags on the cart page

= 3.1.0.4 - 15/OCT/2014 =
- Removed reset CSS from front.css

= 3.1.0.3 - 14/OCT/2014 =
- Fixed issue with proceed button on the cart page

= 3.1.0.2 - 08/OCT/2014 =
- Fixed issue with anonymous functions which caused fatal PHP errors (before PHP 5.3.0) upon installation
- Added option for custom cart URL
- Various code improvements

= 3.1.0.1 - 06/OCT/2014 =
- Fixed issue with PayPal Standard payment gateway and its selected mode (sandbox / live)
- Fixed issue with wp_mail email content type (set to 'text/html')
- Fixed issue with incorrect link to order page in the notification emails
- Added classes for input fields and wrapping divs on front-end

= 3.1.0 - 04/OCT/2014 =
- Added PayPal PRO payment gateway

= 3.0.1 - 01/OCT/2014 =
- Fixed issue with PDF preview
- Resolved bug (PHP fatal error) with FREE Orders gateway

= 3.0 - 29/SEP/2014 =
----------------------------------------------------------------------
- Plugin built from the ground up