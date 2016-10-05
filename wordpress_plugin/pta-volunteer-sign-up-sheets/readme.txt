=== PTA Volunteer Sign Up Sheets ===
Contributors: DBAR Productions
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=R4HF689YQ9DEE
Tags: Volunteer,Sign Up, Events
Requires at least: 3.3
Tested up to: 4.6.1
Stable tag: trunk

Easily create and manage sign-up sheets for volunteer activities, while protecting the privacy of the volunteers' personal information.

== Description ==

**PLEASE DO NOT USE THE SUPPORT FORUM FOR FEATURE REQUESTS!!**
You may submit new features here:
https://stephensherrardplugins.com/support/forum/feature-requests/

This plugin allows you to easily create and manage volunteer sign up sheets for your school or organization. You can define four different types of events:  Single, Recurring, Multi-Day, or Ongoing events. Single events are for events that take place on just a single date. Recurring events are events that happen more than once (such as a weekly function), but have the same needs for each date. Multi-Day events are events that are spread across more than one day, but have different needs for each day. Ongoing events do not have any dates associated with them, but are for committees or helpers that are needed on an ongoing basis.

For each of these types of events, you can create as many tasks or items as needed. For each of these tasks/items, you can specify how many items or people are needed, a start and end time, the date (for multi-day events), and whether or not item details are needed (for example, if you want the volunteer to enter the type of dish they are bringing for a luncheon). The order of tasks/items can easily be sorted by drag and drop.

Each sign-up sheet can be set to visible or hidden, so that you can create sign-up sheets ahead of time, but only make them visible to the public when you are ready for them to start signing up. There is also a test mode which will only show sign-up sheets on the public side to admin users or those who you give the "manage_signup_sheets" capability. Everyone else will see a message of your choosing while you are in test mode. When not in test mode, admins and users with the "manage_signup_sheets" capability can still view hidden sheets on the public side (for testing those sheets without putting the whole system into test mode).

In the settings, you can choose to require that users be logged in to view or sign-up for any volunteer sign-up sheets, and pick the message they will see if they are not logged in. Even if you keep the sheets open to the public, no personal information is shown for any slots that have already been filled. Only a first name and last initial is shown for filled slots, along with any item descriptions. Contact info is only shown on the admin side.  Version 1.3 adds an option to simply show "Filled" for filled spots.

There is also a hidden spambot field to prevent signup form submission from spambots.

If a user is logged in when they sign up, the system will keep track of the user ID, and on the main volunteer sign-ups page, they will also see a list of items/tasks that they have signed up for, and it will give them a link to clear each sign up if they need to cancel or reschedule. If they are not logged in when they sign up, but they use the same email as a registered user, that sign-up will be linked to that user's account.

There is a shortcode for a main sign-up sheet page - [pta_sign_up_sheet] - that will show a list of all active (and non-hidden) sign-up sheets, showing the number of open volunteer slots with links to view each individual sheet. Individual sheets have links next to each open task/item for signing up.  When signing up, if the user is already logged in, their name and contact info (phone and email) will be pre-filled in the sign-up page form if that info exists in the user's meta data. You can also enter shortcode arguments to display a specific sign-up sheet on any page.

There is a sidebar widget to show upcoming volunteer events and how many spots still need to be filled for each, linked to each individual sign-up sheet. You can choose whether or not to show Ongoing type events in the widget, and if they should be at the top or bottom of the list (since they don't have dates associated with them).

Admin users can view sign-ups for each sheet, and clear any spots with a simple link. Each sheet can also be exported to a CSV format file for easy import into Excel or other spreadsheet programs.

Committee/Event contact info can be entered for each sheet, or, if you are using the PTA Member Directory plugin, you can select one of the positions from the directory as the contact. When a user signs up, a confirmation email is sent to the user as well as a notification email to the contacts for that event.

Automatic Email reminders can be set for each sign-up sheet. You can specify the number of days before the event to send the reminder emails, and there can be two sets of reminders for each sheet (for example, first reminder can be sent 7 days before the event, and the second reminder can be sent the day before the event). You can set an hourly limit for reminder emails in case your hosting account limits the number of outgoing emails per hour.

Simple to use custom email templates for sign-up confirmations and reminders.

Features:

*   Version 1.12.3 now supports the calendar display extension: https://stephensherrardplugins.com/plugins/pta-volunteer-sign-up-sheets-calendar-display/
*   New in version 1.10, you can now specify any type of sheet as a "No Signup Event". This allows you to create non-volunteer events for display only (no signup links or available spots will be shown). You can still create tasks/items with dates, start and end times for these sheets, which could be useful for showing the schedule/agenda for an event, but you won't be able to specify quantity or other normal task options. This is useful for a combination volunteer sign-up and event calendar type of list/display (monthly calendar view add-on coming soon!).
*   Also new in version 1.10, thanks to a code contributor, you can now move tasks from one sheet (they will be deleted from that sheet) to another sheet that you specify (they will be merged/added-to the selected sheet). Useful for merging two or more sheets into one for easier management.
*	New features added in version 1.6 include the ability to allow duplicate signups on a per task basis, changing the label for the item details form field on a per task/item basis, as well as allowing volunteers to specify quanitites on a per task/item basis.
*   Easily create volunteer sign-up sheets with unlimited number of tasks/items for each
*	Supports Single, Recurring, Ongoing or Multi-Day Events
*  	All Sheets can be hidden from the public (visible only to logged in users)   
*   No volunteer last names or contact info are shown to the public. Default public view shows only first name and last name for filled spots.  Version 1.3 introduces an option to simply show "Filled" for filled spots.
*   Hidden spambot field helps prevent automatic spambot form submissions
*	Up to 2 automatic reminder emails can be set up at individually specified intervals for each sheet (e.g., 7 days and 1 day before event)
*   Shortcodes for all sheets, or use argument to show a specific sheet on a page
*   Widget to show upcoming events that need volunteers in page sidebars (with version 1.5, can specify a group in the Widget)
*   CSV Export for each sheet on admin side. Version 1.12.2 adds the ability to export ALL data at once (all sheets and signups)
*   Individual sheets can be set to hidden until you are ready to have people sign up (useful for testing individual sheets)
*   Test Mode for entire volunteer system, which displays a message of your choosing to the public while you test the system
*   "manage_signup_sheets" capability so you can set up other users who can create and manage sign-up sheets without giving them full admin level access.
*	Integration with the PTA Member Directory & Contact Form plugin to quickly specify contacts for each sign-up sheet, linked to the contact form with the proper recipient already selected. http://wordpress.org/plugins/pta-member-directory/
*	Use the free PTA Shortcodes extension to easily generate shortcodes with all possible arguments ( available at https://stephensherrardplugins.com )
*	Version 1.4 adds Wordpress Multisite compatibility
*	Version 1.4.2 adds Spanish translation by Simon Samson at http://sitestraduction.com -- half-price translation services for non-profits
*	Version 1.4.5 Includes French translation, and updated Spanish translation, by Simon Samson at http://sitestraduction.com

== Installation ==

Extract the zip file and just drop the contents in the wp-content/plugins/ directory of your WordPress installation and then activate the Plugin from Plugins page.

== Frequently Asked Questions ==

**Can this plugin do (insert a feature request here)?**
**Can you add (insert a feature request here)?**

PLEASE DO NOT USE THE SUPPORT FORUM FOR FEATURE REQUESTS!!

This plugin has a lot of options and features, but I have been getting overwhelmed with feature requests recently. This plugin already does MUCH more than I originally intended, and more than we needed for our own school PTA web site. I have created some extensions that I thought would be helpful to the largest number of people, which you can find at:
https://stephensherrardplugins.com

PLEASE USE THE FEATURE REQUEST FORUM TO REQUEST NEW FEATURES!!
https://stephensherrardplugins.com/support/forum/feature-requests/

**Is there any documentation or help on how to use this?**

Documentation can be found at:
https://stephensherrardplugins.com/docs/pta-volunteer-sign-up-sheets-documentation/

**How do I display the signup sheets?**

Use the shortcode [pta_sign_up_sheet] to display the sign-up sheets on a page. There are also shortcode arguments for id (specific sheet id), date (specific date), and list_title (change the title of the main list of signup sheets). To make generating shortcodes with arguments easier, download the free PTA Shortcodes plugin extension from: 
https://stephensherrardplugins.com

**Can I display the sheets in a calendar view?**

Yes, now you can! Calendar display extension can be found here:
https://stephensherrardplugins.com/plugins/pta-volunteer-sign-up-sheets-calendar-display/

**Can signup sheets be assigned to and displayed by groups or categories?**

This was not something we needed for our own school PTA web site, so that wasn't part of the original plugin. However, since several people have asked about incorporating BuddyPress Groups in some way, I have created an extension to allow sheets to be assigned to groups. Groups can be created manually, or, if you are using BuddyPress, you can choose to import as many of the BuddyPress groups as you want. This is a paid extension that can be found at: https://stephensherrardplugins.com/plugins/pta-volunteer-sign-up-sheet-groups/


== Screenshots ==

Screenshots and extended description can be found at:
https://stephensherrardplugins.com/pta-volunteer-sign-up-sheets/

Documentation can be found at:
https://stephensherrardplugins.com/docs/pta-volunteer-sign-up-sheets-documentation/


== Changelog ==
**Version 1.13.0.2**

*   Re-factored code so that clear links will work on pages where a sheet id argument was used in the shortcode to show only a specific sheet

**Version 1.13.0.1**

*   Updated French translations

**Version 1.13.0**

*   Added new "Login Required for Signup" option. If you un-check the regular "Login Required?" option, but then check this new option, guests can view the sign-up sheets, but they will not be able to sign-up. Includes option to specify the "Login to Signup" message text.
*   Added new "Hide Details and Quantities" option. Checking this will not show the item details or quantity columns in the tasks list (single sheet display). Useful if you are using the details field to collect info from the volunteer that you don't want shown to anyone else. This will affect all sheets.
*   Added new "Redirect Sign Ups to Main Page" option, which will be checked by default to be compatible with previous versions behavior. If you un-check this, sign-up links will NOT go to the main volunteer page, but will stay on the current page. Useful if you are using different shortcodes on different pages to display specific sheets and want to keep volunteers on that page when signing up.
*   Added an email volunteers form page (admin) where you can send an email message to either all volunteers, or volunteers for a specific sheet.
*   Additional code to allow multiple groups and restricted access when using the soon to be updated PTA Volunteer Sign Up Sheet Groups extension at: https://stephensherrardplugins.com/plugins/pta-volunteer-sign-up-sheet-groups/
*   Database update to allow MANY more dates to be added to recurring dates field.
*   Added phone number template tag for emails
*   Email template tags can now also be used in subjects
*   New option added in Email Settings to send all CC/BCC emails as separate TO emails, potentially bypassing issues on some servers that do not like the default formatting of multiple CC/BCC emails in the header when using default server Sendmail (wp_mail) function, as opposed to bypassing Sendmail by using an SMTP plugin to send all WordPress emails via SMTP (much more reliable)
*   Updated French translations, including France and Canada versions

**Version 1.12.5**

*   Updated French translation files
*   Missing file for Admin Add Ons page added to WordPress.org repository.

**Version 1.12.4**

*   Fixed output display of text strings in admin side text input fields when certain characters were used.
*   Admin Add Ons page added, with quick links to available add on extensions.

**Version 1.12.3**

*   Added ORDER BY clause to database query that gets the list of user signups (on public side main volunteer list page), so that they will now be displayed in chronological order.
*   Tweaked the function that checks for overlapping time tasks to allow volunteers to sign-up for a task that starts at the same time that another task ends (e.g., shift 1 from 8AM to 10AM and shift 2 from 10AM to 12PM).

**Version 1.12.2**

*   NEW feature to Export ALL Data as CSV. You can find the button at the top of the admin All Sheets page. All sheet, task, and signup data from the database is exported in one simple CSV format (even expired signups if you didn't delete them).
*   Added additional output filters for public side text, including # of Open Spots in main sheet list, and # Filled on individual sheet task list. If you are using the Customizer extension to modify or hide text fields, be sure you update that plugin to version 1.1.8 for compatibility with the new filters. If you previously used the Customizer to modify the "Filled" text, please note that you'll need to update your modified text to know include the placeholder for the # of filled spots.
*   Moved remaining &laquo; and &raquo; characters inside text filters so they can be changed by translators or with the Customizer extension (translations will need updating)
*   Added extra filter hooks for the soon to be released Calendar display extension (almost finished!)
*   Updated Danish translation files
*   Added separate .pot and updated template file for translators (instead of working from en_US .po file)

**Version 1.12.1**

*   Modified overlapping time range function to allow for and properly check overnight tasks (where end time is earlier than start time)
*   Added integration functions for soon to be released Calendar display extension
*   Fixed sign-up query arguments when you are on a page that is NOT the main volunteer page set in the settings
*   Fixed validation for Quantity input on sign-up forms. Broken in previous release.

**Version 1.12.0**

*   Add new sheet option and function to check for overlapping time ranges for tasks when a user signs up. By default, a person will not be able to sign up for a task if it overlaps with the time frame for another task they have signed up for on the same sheet and same date. Note that this only works if both start time AND end time are entered for tasks (if either time is blank for a task, it will be skipped when checking for overlaps).
*   Fixed text input validation so it will not return an error if there are extra (multiple) spaces anywhere in the entered text field
*   Minor code improvements

**Version 1.11.0**

*   Minor change to get_signups function to sort by the order that users signed up.
*   Added option to make the name and email sign-up form fields "read only" when login is required (except for volunteer admin).
*   Better logic to show initials for a name
*   Added a second CSV export function to show the info transposed (simplified output), with rows for tasks and columns for dates and signed up names only in the cells.

**Version 1.10.3**

*   Fixed the remaining spots display option to not show when there are no remaining spots
*   Fixed logic for number of remaining slots to show when not consolidating, and for bottom border classes
*   Added extra code logic to consolidate the sign-ups and the remaining spots into one simple row, IF you are not showing names AND there are no item details needed for the task AND you have it set to consolidate remaining spots. In that case, the row will be something like "10 Filled, 5 Remaining" and then the sign-up link.
*   Added extra CSS class names to rows/cells for consolidated/remaining to make it easier to style these elements separately.

**Version 1.10.2**

*   Added a new "Consolidate remaining slots" option. When enabled, instead of showing a separate row for each remaining slot for tasks, they will all be consolidated to a single row showing the remaining quantity and a single sign-up link. Makes your list a lot shorter if you have large quantities for your tasks/items.
*   Added an option to show a login link under the login required message. After login, user will be redirected back to the same page.
*   CSS image file path fix for error/success messages
*   Fix for undefined jQuery autocomplete on sign-up form after signup submitted
*   Added additional check in reminders function to ensure no reminders are sent for expired events.

**Version 1.10.1**

*   CSV Exporter fix to resolve PHP notice for undefined variable

**Version 1.10.0**

*   Added a "No Signup Event?" option to the sheets, which allows you to create non-volunteer events for display only (no signup links or available spots will be shown). You can still create tasks/items with start and end times for these sheets, which could be useful for showing the schedule/agenda for an event, but you won't be able to specify quantity or other normal task options. This is useful for a combination volunteer sign-up and event calendar type of list/display (monthly calendar view add-on coming soon!).
*   Updated widget with new option to show just volunteer events (those that have sign-ups), no sign-up events, or both.
*   Confirmation email field added to sign-up form (enter email twice to make sure there are no typos)
*   Don't send mails if subject or content are empty (set the email subject or content area blank in the email settings if you don't want an email sent)
*   Allow tasks to be moved to another sheet. The tasks will be deleted from the current sheet and merged with the tasks in the sheet you select to move them to. Further editing and re-saving the tasks on the sheet they were moved to will be required. Useful if you want to merge two or more sheets into one.
*   Added some additional class elements for easier custom styling
*   Refactored and improved CSV exporter function (code contribution)
*   Minor code clean-up

**Version 1.9.0**

*   Added option show_time to the shortcode pta_sign_up_sheet, to hide all start and end time info from sheets/tasks if not needed. Add show_time="no" to the shortcode to hide times.
*   Live search and auto-complete of user/volunteer fields on sign-up form if you are admin, sign-up sheet manager, or have the manage_signup_sheets capability. Allows admin/managers to quickly sign-up other users from front end.
*   New options in Main Settings section to enable live search on sign-up forms (default is disabled), and to select which tables are searched (Sign-ups table, WordPress Users table, or both)
*   Clear links added to tasks lists on individual sign-up sheets to allow users to clear themselves from there (instead of from just the main sign-up sheet list page). Admin and Sign-up Sheet Managers can see clear links for all sign-ups to allow them to clear sign-ups from the front end.
*   Minor fix to avoid a php notice if you hide the phone field from the signup form

**Version 1.8.13**

*	Added Italian translation from Jacopo Belluz, founder and member of OpenRing.net. Thanks Jacopo!

**Version 1.8.12**

*	One more minor fix for tasks lists to use WordPress date/time instead of PHP date function (server time) to decide if a task has expired or not.

**Version 1.8.11**

*	Modified SQL database queries to use WordPress current date/time instead of the SQL NOW() function so that sign-up sheets or tasks won't be hidden early when the server's time is different than the WordPress time (such as when the server is in a different time zone).

**Version 1.8.10**

*	Minor Fix to use the WordPress current time as opposed to the PHP/Server time when calculating when to show sheets and tasks
*	Added German translation

**Version 1.8.9**

*	Fix capability check in CSV exporter class to allow Sign-Up Sheet Manager role users to export sheets

**Version 1.8.8**

*	Fix settings page to allow deletion of CC email field

**Version 1.8.7**

*	Added manage_signup_sheets capability to super admin users, due to rare conflict where super admin could not access the settings or menu pages for the plugin
*   Add public accessor functions for other extensions


**Version 1.8.6**

*   Confirmed compatibility with WordPress 4.2.1
*   Confirmed that all public side URLs generated with add_query_arg were already being properly escaped, so no public side issues with the recently discovered XSS vulnerability with the add_query_arg function.
*   Properly escaped the URLs in two locations for the admin side of the plugin to address the XSS vulnerability, but would only be an issue if someone else had access to your admin dashboard.

**Version 1.8.5**

*	Fix an issue with the "Show Clear Links" checkbox field not saving when unchecked. 
*	Updated/Corrected Dutch translation files
*	A few additional action/filter hooks for extensions
*	Renamed CSV exporter action to avoid conflict with another plugin

**Version 1.8.4**

*	Minor fix in the admin all sheets list table file that was causing dates to show up in the ID column.

**Version 1.8.3**

*	Translation files update. Updated Croatian translation by Sanjin at http://www.astromagicraven.com/

**Version 1.8.2**

*	Add div wrapper around sign-up sheet form so output elements can be more easily targeted with custom CSS for styling, and cleaned up the text output formatting a bit.
*	Fixed a couple of minor CSS class declaration typos
*	Updated the admin sheets list table so that the Event Type for each sheet can be translated
*	Includes Croatian translation files. THANKS to vipteam!!
*	PLEASE send me any other language translations and help me keep them up to date!! 

**Version 1.8.1**

*	Changed parameters passed to the Wordpress Editor to fix issue with Wordpress stripping paragraph and line break tags out of the text of the Sheet Details.
*	Updated English translation file. Other translation files are outdated, and I would be very happy to receive any up to date translation files for other languages!!

**Version 1.8**

*	You can now specify, on a per sheet basis, if you want to let volunteers clear their own signups. Additionally, you can specify a minimum number of days before the event after which they can no longer clear their signups. Note that this will only work if your volunteers have user accounts on your site and are either logged in when they sign up, or use the same email associated with their user account (if not logged in when they sign up).
*	Added option to remove chair contact info from public sheets display
*	Database table update to explicity specify character set as set in Wordpress, and to add new fields for the new signup clear options.

**Version 1.7.1**

*	Missed version number update

**Version 1.7**

*	Added option to remove the phone field from the public sign-up forms
* 	Updated jquery-datepick to latest version (5.0) and changed the way it is registered/enqueued to resolve conflict other plugins using the same script.

**Version 1.6.6**

* 	Missed an updated script file

**Version 1.6.5**

* 	Minor validation bug fix for sheet trash value on admin side
*	Minor jQuery script updates
*	Put div wrappers around the tables the plugin generates so that you can target them more easily with CSS, or add some custom responsive CSS to change the way the tables are displayed on small screens
*	If you're using a responsive theme that doesn't handle tables well on small screens, you can create your own CSS styles to restyle the plugin tables using the CSS table classes and the new div containers. If that doesn't work for you, I have created a simple and lightweight plugin that simply loads the jQuery Stacktable plugin from John Polacek and applies that to ALL tables on the public side of your site (it automatically stacks table columns on smaller screens). You can download that for free at my plugins site.

**Version 1.6.4**

* 	Main sheet list will now show Ongoing events at the bottom when that setting is checked (main settings). Setting text was wrong as initially the ability to show Ongoing events at the bottom was intended just for the widget. Now that setting will affect the main sheet list as well (to reflect the wording of the setting).

**Version 1.6.3**

* 	Fixed broken nonce check for visibility toggle on admin sheets list
*	Added Dutch translation
*	Additional filter hooks for extensions

**Version 1.6.2.2**

* 	Minor change to properly sort dates on sheet date/task list

**Version 1.6.2.1**

* 	Minor changes/fixes.
*	Added/Updated filters for all public side output text to allow easy changing of default text using the customizer extension, or by adding your own filter hooks in your theme's functions.php file.

**Version 1.6.2**

*	Added email notifications when a user clears themselves from a volunteer spot. There is now a custom email subject and email templated for these cleared signup emails in the email settings. These emails will be copied to the event chairs as well as the new global CC Email (see below) so that they will be immediately informed when someone clears themselves from a signup.
* 	Added CC Email in the Email Settings. Here you can specify an email address to CC for all signup notifications as well as when a user clears one of their signups. This email will be IN ADDITION to the chair contact emails you specify for each sign-up sheet. This was added so the admin or head volunteer coordinator can receive sign-up/clear notifications without having to enter their email for every sheet you add.
*	Fixed issue of Ongoing type events that others have signed up for showing up in user's list of signups
*	The "Disable Login Notices?" option in the main settings will now also turn off the "Please login..." message at the bottom of the main list of volunteer sheets. If you are not using user accounts for your site, you should probably disable these notices to avoid volunteers asking how to login.

**Version 1.6.1.1**

* 	Another Small logic fix to allow there to be only one contact name, but more than one contact email, for a sheet without getting the "No Event Chair contact info provided" message on the public side.

**Version 1.6.1**

* 	Small logic fix to make sure the PTA Member Directory is actually activated before trying to display contact info from the member directory. If you had integration features and Member Directory contact info set for a sheet, but then deactivated the PTA Member Directory, it would give you the message that No Event Chair contact info was provided, even if you type in a name and email on the edit sheet page.

**Version 1.6**

* 	New "Allow Duplicates" task checkbox field to allow more than one signup from the same user for a task. Set per task.
*	New "Enable Quantities" task checkbox field to allow volunteers to specify quantity of items they are bringing
*	New task field to enter label for "Needs Details" field of each task to prompt volunteer on what to enter
*	Updated email template tags for new fields and options
*	Added option to turn off the "strongly recommended" login notice on the sign-up page

**Version 1.5.6**

* 	Updated database table setup to fix an issue that could occur with null field values on some servers.

**Version 1.5.5**

* 	Renamed admin style sheet to avoid conflict with a theme that used the same name.

**Version 1.5.4**

* 	Changed how current time is retrieved in email reminders CRON functions, in case the server is in a different time zone than the Wordpress site is set to.  Current time is now taken from Wordpress site time.

**Version 1.5.3**

* 	Fixed bug with duplicate task signups check for recurring events

**Version 1.5.2**

* 	Fixed translation function for dates in widget
*	Added check to prevent duplicate signups for a task. Checks first and last name fields against other signups for same task.
*	Updated French translation

**Version 1.5.1**

* 	Fixed bad nonce checked that wouldn't allow you to clear a signup on admin side

**Version 1.5**

* 	Fixed additional validation fields to allow foreign language characters
*	Added additional nonce/security checks on admim side forms
*	Additional hooks and filters for extensions

**Version 1.4.7**

* 	Fixed text input validation to allow foreign language characters
*	Fixed display bug that tried to show a date for Ongoing event types on individual sheets

**Version 1.4.6**

* 	Changed the way the signup form is processed to prevent double sign-ups that can happen in rare cases with certain themes or plugins

**Version 1.4.5**

* 	Changed the way the signup input form and signup form error messages are displayed to fix issues with certain themes.
*	Includes French & Spanish translations by Simon Samson at http://sitestraduction.com

**Version 1.4.4**

* 	Fix corrupted directory structure in the repository

**Version 1.4.2**

*	Added option to append reminder emails content to admin notifications when reminder emails have been sent
*	Settings pages now include a link to the documentation at: https://stephensherrardplugins.com/docs/pta-volunteer-sign-up-sheets-documentation/
*	Several code fixes for translation
*	Includes Spanish translation by Simon Samson at http://sitestraduction.com -- half-price translation services for non-profits

**Version 1.4.1**

*	Remove some debug code accidentally left in the email function

**Version 1.4**

*	After a user signs up, save the firstname, lastname, and phone in user's meta if it doesn't exist so it will be pre-filled on future signups
*	Modified to work with Wordpress Multisite installations
*	Added reply-to email option for confirmation & reminder emails
*	Minor bug fixes and tweaks

**Version 1.3.4**

*	Tweak for admin side permissions

**Version 1.3.3**

*	Fixed bug dealing with sheet visibility & trash settings

**Version 1.3.2**

*	Patch for people with PHP versions < 5.3 who were getting fatal errors for str_getcsv function

**Version 1.3.1**

*	Small rework/fix to ensure reminder emails function is run every hour with the CRON job

**Version 1.3**

*	Added Wordpress editor for sheet details textarea to allow rich text formatting.
*	Added option to show "Filled" instead of the volunteer's first name and last initial for filled spots on a sign-up sheet.
*	Small change for compatibility with older PHP versions
*	Added hooks, filters, and CSS classes for easier extension & customizing
*	Additional translation coding prep

**Version 1.2.2**

*	First public release

== Additional Info ==

This plugin is a major fork and and almost a complete rewrite of the Sign-Up Sheets plugin by DLS software (now called Sign-Up Sheets Lite). We needed much more functionality than their plugin offered for our PTA web site, so I started with the Sign-Up Sheets plugin and added much more functionality to it, and eventually ended up rewriting quite a bit of it to fit our needs. If you need a much more simple sign-up sheets system, you may want to check out their plugin.

**PLEASE USE THE FEATURE REQUEST FORUM TO REQUEST NEW FEATURES!!**
https://stephensherrardplugins.com/support/forum/feature-requests/
