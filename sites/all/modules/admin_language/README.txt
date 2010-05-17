Admin Language
================================================================================

Summary
--------------------------------------------------------------------------------

The Admin Language module makes sure all administration pages are displayed in
the preferred language of the administrator. Which pages are considered admin
pages can be configured. Users with the right permissions can choose to use
either the global administration language or a language of their choice.


Requirements
--------------------------------------------------------------------------------

The Admin Language module requires the Locale (core) module.


Installation
--------------------------------------------------------------------------------

1. Copy the admin_language folder to sites/all/modules or to a site-specific
   modules folder.

2. Go to Administer > Site building > Modules and enable the Admin Language
   module.


Configuration
--------------------------------------------------------------------------------

1. Go to Administer > Site configuration > Languages and choose the language
   you want to use as the administration language.

2. Go to Administer > Users > Permissions and make grant your administrator role
   the 'display admin pages in another language' permission.

3. (Optional) Go to Administer > Settings > Administration language and select
   which paths should use the selected administration language. By default, all
   pages on the site are affected.

4. (Optional) Go to Administer > Settings > Administration language and select
   whether you want to remove the administration language in the language
   dropdown on the node edit form (requires that the Content translation module
   is enabled).

5. (Optional) Enable the 'Language switcher (without administration language)'
   block if you need a language switcher block which doesn't display the
   administration language.

6. (Optiona) Go to My account or another user/<uid>/edit page to choose a
   different admin language than the global default.


Support
--------------------------------------------------------------------------------

Please post bug reports and feature requests in the issue queue:

  http://drupal.org/project/admin_language


Credits
--------------------------------------------------------------------------------

Author: Morten Wulff <wulff@ratatosk.net>

Initial development sponsored by Morten.dk.


$Id: README.txt,v 1.1.2.6 2009/12/01 10:52:46 wulff Exp $