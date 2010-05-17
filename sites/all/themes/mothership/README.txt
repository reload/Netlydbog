// $Id$
----------------------------------------
  Möthership
----------------------------------------
The mothership theme is the über "clean up this html that drupal provides" theme - so if you wanna make any sense of this them use it as a parent theme!

The basic idea is to use this theme before other "theme systemes" (zen, basic, studio, 960, whatever)
To implement this just add: base theme = mothership in you .info file, and youre ready to look at the source yet again without getting overwhelmed by a ton of .classes and markup.

The only thing this theme does is to clean up and remove html & classes that I dont think is necessary, and creating a cleaner html code.

Mothership will remove some of the flexibility that cck & views provides out of the box, so please be aware of this!
(read the documentation - to specify what is changed)
If youre not a html nerd that gets high by looking at html and enjoying the cleaner code, well then this theme is NOT for you.

----------------------------------------
  How to get this to work:
----------------------------------------
First of all add this line to your theme info file:
base theme = mothership

Then if you wanna use all the sweet settings (so you can toggle classes on & off the blocks, nodes etc) you need to do a little bit of work:

copy the "_copy_to_your_subtheme_theme-settings.php" file into your subtheme folder and rename the file to "theme-settings.php" 
Now go to your new subtheme and go into the settings (admin/build/themes/settings/THEMENAME), and hit "save configuration!
now you have the configuration ready for use in the theme settings.
I know its not the best way but it will all be changed in D7.
... and this code to get subtheming settings to work is a a clean copy & paste from the zen theme btw, so its really john albin fault if its not working ;) 

Theres an example theme called msdroid that have these settings predefined 

----------------------------------------
  Theme settings
----------------------------------------

modify CSS Classes for page, node, block, comments & views
------------------
In the Theme settings its possible to remove some or all of the css classes that drupal normally adds to the $classes variable in the .tpl files

page.tpl 
---------------
Modifies the <?php print $body_classes;?> which is normaly added to the <body>
this will not remove the following classes
* logged -in
* front status
* page-[NODETYPE]
* sidebar status

node.tpl
---------------
modifies the <?php print $classes ?> normal this is added to the outer <div> in the node.tpl

block.tpl
---------------
modifies the <?php print $classes ?> normal this is added to the outer <div>

comments.tpl
---------------
modifies the <?php print $classes ?> normal this is added to the outer <div>

views:
---------------

cck
---------------

Examples of node, block, page, comments etc can be found in the mothership theme.

----------------------------------------
 Sneaky Features
----------------------------------------
* Add 2 regions to nodes:
  this feature will add 2 regions to your node.tpl.
    <?php print $node_region_two;?>  
    <?php print $node_region_one;?>

* Remove the (not verified) for comments usernames


----------------------------------------
  More stuff
----------------------------------------
cleans up tpls
--------------------
  box.tpl
  user-profile
  search box

* consistency in class names:
  all id & classes are formatted so they follow the dashes name scheming so underscores _ will be changed to dashes-
  "a-class_name_like-this" will be "a-class-name-like-this"

form api:
---------------
* Adds form-item-[FORMELEMENT TYPE] to the outter div around a form element

* Changes the class "description" to "form-description" to keep naming consistent in the forms

* File upload fields size is being removed it to absurd big to work with (size=60 wtf)

Adds "form-image-button" around a form button

item lists (ul/li)
-------------
adds odd / even to the <li>st
new options to the item_liste()
  div
  
  div-span

table
-------------
class names to th so its possible to add widths for the table data
the names for the classes is the same as the content. 


body classes
=========================
modifies the body classes

remove drupals base classes
--------------------
removes 

Add path based class
--------------------
  front/not-front 
  logged-in 
  page-user/page-node 
  one-sidebar sidebar-right sidebar-left 
  
  page-user- $path

Add node actions classes: add, edit, delete
----------------------------------------------------
ads "action-node-edit" / "action-node-delete" / "action-node-add"




----------------------------------------
  links to ref material
----------------------------------------
cck theming
http://drupal.org/node/62462

views formatters
http://views-help.doc.logrus.com/help/views/api-plugins


----------------------------------------
   bug reports
----------------------------------------
project home:
  http://drupal.org/project/mothership

bug reports
  http://drupal.org/project/issues/mothership

----------------------------------------
CONTRIBUTORS
----------------------------------------
morten.dk morten@geekroyale.com

