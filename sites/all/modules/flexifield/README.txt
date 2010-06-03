// $Id: README.txt,v 1.1.2.6 2009/03/04 02:33:42 effulgentsia Exp $

This module is in early development and still needs a lot of work before it's ready for prime time. But please check it out as a proof of concept.

Create some node types. For example, "Text and Node" (add a text field and a nodereference field to it), and "Text and User" (add a text field and a userreference field to it). 

Create another node type (for example "Flexifield Tester"). Add a flexifield to it, give it "unlimited" for its "number of values" setting. Set one or more node types to use for each flexifield field item. Create a node of this type, and notice how each flexifield field item is the combination of fields defined in the configured types.

This module can work with the tinymce module used on textareas. However, to do so, you need to download and enable the tinymce_ahah and tinymce_dragdrop modules. Also, the page needs to start off with tiny_mce.js loaded, which is already the case if flexifield is set to only use a single type for its items, or if the "body" field of the content type on which flexifield is added is also using tinymce. If neither of these conditions are true, a work-around is to create a custom module with the following code in its hook_init() function:

--------------------------
if (module_exists('tinymce') && user_access('access tinymce')) {
  drupal_add_js(drupal_get_path('module', 'tinymce') . '/tinymce/jscripts/tiny_mce/tiny_mce.js');
}
--------------------------

If you have a multi-valued field using drag-and-drop and the "Add another item" button inside of a flexifield that is also multi-valued, you should set the "disable drag-and-drop for this field" checkbox on the flexifield's field configuration form.

This module has not yet been tested with fieldgroup, content permissions, or file/media fields. It's probably buggy in all of these circumstances.
