# Turiknox Home Sliders

## Overview

A Magento 2 module that will allow you to add a jQuery slider to your home page with the ability to upload sliders in the admin.

## Features

The slider library used is FlexSlider 2 (http://flexslider.woothemes.com/) and the following features are available:

- Ability to upload a slider image and set the image label text.
- Ability to add a link to the slider image.
- Ability to add HTML that sits on top of your slider.

You can also edit the following options within the system configuration:

- Choose whether the links on the sliders should open in a new window or tab.
- Choose whether the slider should be automated.
- Set the slider speed.
- Choose whether the directional navigation should show.
- Choose whether the pagination (control) navigation should show.
- Choose whether the slider should be paused on hover.

## Requirements

Magento 2.1.x

## Installation

This module will add a table to your Magento 2 database. As with any third party modules that do this, it is recommended that you backup your database before installation.

Copy the contents of the module into your Magento root directory.

Enable the module via the command line:

/path/to/php bin/magento module:enable Turiknox_HomeSliders

Run the database upgrade via the command line:

/path/to/php bin/magento setup:upgrade

Run the compile command and refresh the Magento cache:

/path/to/php bin/magento setup:di:compile 

/path/to/php bin/magento cache:clean



## Usage

Add sliders within the admin under Content -> Home Sliders

Configure slider settings within Stores -> Configuration -> Turiknox -> Home Sliders
