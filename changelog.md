# Receptar Changelog

## 1.3.5

* **Add**: WordPress 4.3 support
* **Add**: Localization: Brazilian Portuguesse - thanks to xapuri (www.xapuri.info)
* **Add**: Localization: French - thanks to WP-Traduction (wp-traduction.com)
* **Add**: Localization: Greek - thanks to Nikolas Branis (kanenas.net)
* **Fix**: Google Fonts URL function subset issue
* **Fix**: Image size setup issue on pages

#### Files changed:

	css/customizer.css
	inc/setup-theme-options.php
	inc/setup.php
	inc/customizer/customizer.php
	inc/lib/core.php
	languages/el_EL.mo
	languages/el_EL.po
	languages/fr_FR.mo
	languages/fr_FR.po
	languages/pt_BR.mo
	languages/pt_BR.po


## 1.3.4

* **Fix**: Fixed position of next/previous post navigation buttons

#### Files changed:

	inc/setup.php


## 1.3.3

* **Update**: Localization

#### Files changed:

	languages/sk_SK.mo
	languages/sk_SK.po
	languages/xx_XX.pot


## 1.3.2

* **Fix**: Fixed issue with next/previous post navigation introduced in version 1.3

#### Files changed:

	inc/setup.php


## 1.3.1

* **Update**: Reset WordPress native image sizes to their pre-theme-activation state after switching the theme

#### Files changed:

	inc/setup.php


## 1.3

* **Update**: Improved file organization
* **Update**: Improved security
* **Update**: Removed tracking URL parameters
* **Update**: Removed obsolete constants, functions and custom Customizer controls
* **Fix**: Donate button is translatable

#### Files changed:

	404.php
	archive.php
	comments.php
	functions.php
	image.php
	index.php
	page.php
	search.php
	searchform.php
	sidebar.php
	single.php
	inc/setup-theme-options.php
	inc/setup.php
	inc/custom-header/custom-header.php
	inc/customizer/customizer.php
	inc/jetpack/jetpack.php
	inc/lib/core.php
	inc/lib/visual-editor.php
	languages/sk_SK.mo
	languages/sk_SK.po
	languages/xx_XX.pot
	template-parts/content-attachment-image.php
	template-parts/content-none.php
	template-parts/loop-banner.php
	template-parts/loop.php


## 1.2.1

* **Update**: Enqueuing `comment-reply.js` the right way
* **Update**: Removing `example.html` Genericons file
* **Update**: Prefixing custom created image sizes
* **Update**: Saving image size setup into theme mod, not individual options
* **Update**: Removing thumbnail preview column in admin posts list screen
* **Update**: Removing obsolete constants
* **Update**: Localization
* **Fix**: Default featured image size

#### Files changed:

	content-featured-post.php
	functions.php
	style.css
	css/customizer.css
	images/featured.jpg
	inc/setup-theme-options.php
	inc/setup.php
	inc/beaver-builder/beaver-builder.php
	inc/lib/core.php
	languages/sk_SK.mo
	languages/sk_SK.po
	languages/xx_XX.pot


## 1.2

* **Update**: Theme description
* **Update**: Beaver Builder support
* **Update**: Starter CSS
* **Update**: Screenshot and default images to be 100% GPL compatible
* **Update**: Renamed functions, classes, hooks, variables and text domain (affects almost all files)
* **Update**: Localization

#### Files changed:

	readme.md
	screenshot.jpg
	style.css
	css/starter.css
	images/featured.jpg
	images/header.jpg
	inc/beaver-builder/beaver-builder.php


## 1.1

* **Update**: Tightening security
* **Update**: Improved code
* **Fix**: Removed obsolete CSS3 transitions
* **Fix**: Responsive page title top margin

#### Files changed:

	style.css
	inc/setup-theme-options.php
	inc/setup.php
	inc/lib/core.php


## 1.0

* Initial release.