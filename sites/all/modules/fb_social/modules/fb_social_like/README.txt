
-- Summary -- 

The "facebook social like" integrate the facebook's social like plugin in Drupal
(see http://developers.facebook.com/docs/reference/plugins/like). 

It has the following features:

- Allows site admins to select which content type will use the like widget
- Allows site admins to customize the widget.
- Allows site admins to control the location of the widget:
-- In the node links area
-- In the node content area. In this case the widget becomes a cck-like field and can be moved up and down like any other cck field
- Creates a block which contain the like widget.
- Adds the necessary metadata to your drupal pages (og:title, og:site_name, og:image)

-- Requirements --

- Requires the "facebook social" module which is included in this package
- NOTE: If you want the comment box to appear for the "like" button you must have 
  your connect URL match your website's URL. Go on your facebook app page click 
  "Edit Settings". Then click "Connect". 
  Make sure that the "Connect URL" matches your domain exactly.


-- Installation -- 

- Install as usual, see http://drupal.org/node/70151 for further information.


-- CONFIGURATION -- 

- Administer > Site configuration > Facebook Social > like

 
  
