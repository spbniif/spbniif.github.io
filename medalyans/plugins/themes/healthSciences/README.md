# Health Sciences Theme

An official theme for [OJS 3.1.1+](https://pkp.sfu.ca/ojs/) designed for health science journals or any journal that wants a clean, modern appearance.

Current version: healthSciences v1.0.2

This theme was commissioned and is maintained by the [Public Knowledge Project](https://pkp.sfu.ca/). For all non-technical questions, please visit the [PKP Forum](https://forum.pkp.sfu.ca/).

## Installation

You can install the latest stable release by going to the `Settings` > `Websites` > `Plugins` > `Plugin Gallery` page in your Open Journal Systems website.

If you'd like to use unreleased packages, you can clone this repository or follow these steps:

1. Download the [latest release](https://github.com/pkp/healthSciences/releases).
2. Unpack the .tar.gz file and move the `healthSciences` directory to your OJS installation at `/plugins/themes/healthSciences`.
3. Login to the admin area of your OJS website. Browse to the `Settings` > `Website` > `Plugins` page and enable the Health Sciences theme.
4. Browse to the `Settings` > `Website` > `Appearance` page and select Health Sciences from the theme option and save your change.

## Version Compatibility

* healthSciences theme v1.0.0 is compatible with OJS 3.1.1.
* healthSciences theme v1.0.1 is compatible with OJS 3.1.1-1.
* healthSciences theme v1.0.2 is compatible with OJS 3.1.1-2.

## Contribution

This theme was designed by Sophy Ouch (@sssoz) and built by Nate Wright (@NateWr) and Vitalii Bezsheiko (@Vitaliy-1) using [Bootstrap4](https://getbootstrap.com/).

## Changelog
**healthSciences v1.0.2**  (2018-07-30)
* Add: Styling for authors' list on article landing page (#76)
* Add: Support for pages related to the subscription, authors' search, and several others (#80)
* Add: Orcid image is shown if author has ORCID ID on article landing page (#73)
* Add: Reordering of blocks on article landing page for mobiles according to their priorities (#74)
* Add: Journal description is shown if no issue description is provided (#75)
* Add: Dependencies update: JQuery, Popper, Bootstrap, Fontawesome (#97)
* Add: DOI is shown for each article on issue TOC page if provided (#94)
* Fix: Proper page header aligning for small screens (#87)
* Fix: Unique ID for modal login forms
* Fix: Minor theme-wide restyling 

**healthSciences v1.0.1**  (2018-06-18)
* Add: Support for OJS 3.1.1-1
* Add: Support for reviewer interests input
* Fix: Styling adjustments for article landing page

**healthSciences v1.0.0**  (2018-04-24)
* Fix: Remove bullet points from feed block plugins
* Fix: Implement information for X pages
* Fix: Site-wide font-size modifications

**Beta** (2018-02-13)
* Fix: Plugin can't be installed through plugin upload tool (#2)
* Fix: Issue description box appears when no description exists (#3)
* Fix: Language selector appears when no other languages exist (#4)
* Fix: Login form in modal doesn't work (#6, #7)
* Add: HTML/PDF galley views (#1)

**Alpha1** (2018-01-18)
* Initial release for testing
