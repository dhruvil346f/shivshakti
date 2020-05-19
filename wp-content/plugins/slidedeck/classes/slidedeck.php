<?php
/**
 * SlideDeck Model
 *
 * Model for handling CRUD and other basic functionality for SlideDeck management. Acts
 * as the parent class for all Deck types.
 *
 * @author Hummingbird Web Solutions Pvt. Ltd.
 * @package SlideDeck
 */

/*
Copyright 2012 HBWSL  (email : support@hbwsl.com)

This file is part of SlideDeck.

SlideDeck is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

SlideDeck is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with SlideDeck.  If not, see <http://www.gnu.org/licenses/>.
*/
class SlideDeck {
	var $namespace = 'slidedeck';

	// The current source of SlideDeck being displayed (if any)
	var $current_source = array();

	// Class prefix
	var $prefix = 'sd2-';

	// Default weight (for ordering when sources are shown in a list)
	var $weight = 100;

	// SlideDeck options used by the JavaScript library for output as a JSON formatted object
	var $javascript_options = array(
		'speed'             => 'integer',
		'start'             => 'integer',
		'autoPlay'          => 'boolean',
		'autoPlayInterval'  => 'integer',
		'cycle'             => 'boolean',
		'keys'              => 'boolean',
		'scroll'            => 'boolean',
		'continueScrolling' => 'boolean',
		'activeCorner'      => 'boolean',
		'hideSpines'        => 'boolean',
		'transition'        => 'string',
		'slideTransition'   => 'string',
		'newTransition'     => 'string',
		'touch'             => 'boolean',
		'touchThreshold'    => 'integer',
		'auto_height'       => 'boolean',
	);


	// Default SlideDeck options
	var $options_model = array(
		'Setup'      => array(
			'total_slides'         => array(
				'type'        => 'text',
				'data'        => 'integer',
				'attr'        => array(
					'size'      => 3,
					'maxlength' => 3,
				),
				'value'       => 5,
				'label'       => 'Number of Slides',
				'description' => 'Set how many slides you want in your SlideDeck. Most Content Sources supply up to 10 at a time.',
				'interface'   => array(
					'type'   => 'slider',
					'min'    => 3,
					'max'    => 25,
					'update' => array(
						'option' => 'start',
						'value'  => 'max',
					),
				),
			),
			'size'                 => array(
				'type'        => 'radio',
				'data'        => 'string',
				'values'      => array(
					'small',
					'medium',
					'large',
					'custom',
					'fullwidth',
				),
				'value'       => 'medium',
				'label'       => 'Size',
				'description' => 'Set the dimensions of your SlideDeck. Choose from the predefined sizes or enter a custom size.',
			),
			'width'                => array(
				'type'  => 'text',
				'data'  => 'integer',
				'attr'  => array(
					'size'      => 5,
					'maxlength' => 4,
				),
				'value' => 500,
				'label' => 'Width',
			),
			'height'               => array(
				'type'  => 'text',
				'data'  => 'integer',
				'attr'  => array(
					'size'      => 5,
					'maxlength' => 4,
				),
				'value' => 500,
				'label' => 'Height',
			),
			'overlays'             => array(
				'type'        => 'select',
				'data'        => 'string',
				'value'       => 'hover',
				'label'       => 'Show Overlay',
				'values'      => array(
					'always' => 'Always',
					'hover'  => 'On Hover',
					'never'  => 'Never',
				),
				'description' => 'Overlays allow your users to interact with your content from within the SlideDeck, depending on the Content Source.',
			),
			'overlays_open'        => array(
				'type'        => 'radio',
				'data'        => 'boolean',
				'value'       => false,
				'label'       => 'Overlays Always Open',
				'description' => 'Should overlays always be open when they are visible?',
			),
			/*
			'Select_overlays' => array(
					'type' => 'checkbox',
					'data' => 'string',
					'values' => array("facebook","twitter","pinterest"),
					'label' => "Select Overlay",
					'description' => "Select Overlays from following options."
				),*/
				'show-front-cover' => array(
					'name'  => 'show-front-cover',
					'type'  => 'hidden',
					'data'  => 'boolean',
					'value' => false,
					'label' => 'Show Front Cover',
				),
			'show-back-cover'      => array(
				'name'  => 'show-back-cover',
				'type'  => 'hidden',
				'data'  => 'boolean',
				'value' => false,
				'label' => 'Show Back Cover',
			),
			'auto_height'          => array(
				'type'        => 'radio',
				'data'        => 'boolean',
				'value'       => false,
				'label'       => 'Auto Adjust Slides',
				'description' => 'Should slider auto adjust height?',
			),
			'image_protection'     => array(
				'type'        => 'radio',
				'data'        => 'boolean',
				'value'       => false,
				'label'       => 'Enable Image Protection',
				'description' => 'Disables the mouse right click option for images',
			),
		),
		'Appearance' => array(
			'accentColor'           => array(
				'type'        => 'text',
				'data'        => 'string',
				'attr'        => array(
					'class' => 'color-picker',
					'size'  => 7,
				),
				'value'       => '#3ea0c1',
				'label'       => 'Accent Color',
				'description' => 'Pick a color for the accent elements of your Lens, including links, buttons and titles.',
				'weight'      => 1,
			),
			'titleFont'             => array(
				'type'   => 'select',
				'data'   => 'string',
				'value'  => 'sans-serif',
				'values' => array(),
				'label'  => 'Title Font',
				'weight' => 10,
			),
			'bodyFont'              => array(
				'type'   => 'select',
				'data'   => 'string',
				'value'  => 'sans-serif',
				'values' => array(),
				'label'  => 'Body Font',
				'weight' => 20,
			),
			'hyphenate'             => array(
				'type'        => 'radio',
				'data'        => 'boolean',
				'value'       => false,
				'label'       => 'Hyphenate Content',
				'description' => 'Automatically hyphenate (on some browsers) and break title and excerpt if needed.',
			),
			'activeCorner'          => array(
				'type'        => 'hidden',
				'data'        => 'boolean',
				'value'       => false,
				'label'       => 'Display Active Slide Indicator',
				'description' => 'Visual indicator attached to the slide title bar of the current slide',
			),
			'hideSpines'            => array(
				'type'        => 'hidden',
				'data'        => 'boolean',
				'value'       => true,
				'label'       => 'Hide Slide Title Bars',
				'description' => 'Not all lenses work well with slide title bars turned on',
			),

			'image_scaling'         => array(
				'type'        => 'select',
				'data'        => 'string',
				'value'       => 'cover',
				'values'      => array(
					'none'    => 'Do Not Scale Images',
					'cover'   => 'Scale Proportionally and Crop',
					'contain' => 'Scale Proportionally and Do Not Crop',
				),
				'label'       => 'Image Scaling',
				'description' => 'Changes the way that feature images on a slide are scaled (IE 8 and below do not support proportional scaling)',
			),
			'_caption_position'     => array(
				'type'   => 'radio',
				'data'   => 'string',
				'value'  => 'bottom',
				'values' => array(
					'bottom' => 'Bottom',
					'center' => 'Center',
					'top'    => 'Top',
				),
				'label'  => 'Caption Position',
				'weight' => 900,
			),
			'_preferred_image_size' => array(
				'type'   => 'select',
				'data'   => 'string',
				'value'  => 'auto',
				'values' => array(
					'auto'     => 'Auto (120%)',
					'auto_100' => 'Auto (100%)',
				),
				'label'  => 'Preferred Image Size',
				'weight' => 800,
			),
			'use_global_setting'    => array(
				'type'        => 'radio',
				'data'        => 'boolean',
				'value'       => false,
				'label'       => 'Use Global Settings',
				'description' => 'Use this settings for all slides',
				'weight'      => 1000,
			),
		),
		'Content'    => array(
			'cache_duration'             => array(
				'name'        => 'cache_duration',
				'type'        => 'text',
				'data'        => 'integer',
				'class'       => 'fancy',
				'value'       => 30,
				'label'       => 'Cache Duration',
				'description' => 'How often new data will be refreshed from external content sources',
				'suffix'      => 'minutes',
				'attr'        => array(
					'size'      => 3,
					'maxlength' => 6,
				),
				'interface'   => array(
					'type' => 'slider',
					'min'  => 5,
					'max'  => 2880,
					'step' => 5,
				),
			),
			'show-author'                => array(
				'type'        => 'radio',
				'data'        => 'boolean',
				'label'       => 'Show Author',
				'value'       => true,
				'class'       => 'fancy',
				'description' => 'Show or hide the author of the content, when that info is available.',
				'weight'      => 60,
			),
			'show-author-avatar'         => array(
				'type'        => 'radio',
				'data'        => 'boolean',
				'label'       => 'Show Author Avatar',
				'value'       => true,
				'class'       => 'fancy',
				'description' => "Show the author's avatar image when available",
				'weight'      => 61,
			),
			'linkAuthorName'             => array(
				'type'        => 'radio',
				'data'        => 'boolean',
				'class'       => 'fancy',
				'value'       => false,
				'label'       => 'Link Author Name',
				'description' => 'If the author URL is available',
				'weight'      => 62,
			),
			'show-link-slide'            => array(
				'type'        => 'radio',
				'data'        => 'boolean',
				'label'       => 'Link Entire Slide',
				'value'       => false,
				'class'       => 'fancy',
				'description' => "Make the entire slide a link area so clicking on anything in the SlideDeck (except navigation elements) goes to the slide title's link destination. (does not affect video slides)",
				'weight'      => -1,
			),
			'cta-enable'                 => array(
				'type'        => 'radio',
				'data'        => 'boolean',
				'class'       => 'fancy',
				'label'       => 'Enable CTA',
				'value'       => false,
				'description' => 'Show or hide the CTA(Call To Action) option',
				'weight'      => 90,
			),

			'cta-custom-opt'             => array(
				'type'    => 'radio',
				'data'    => 'string',
				'value'   => 'cimage',
				'class'   => 'fancy',
				'visible' => 'false',
				'values'  => array(
					'cbutton' => 'Custom Button',
					'cimage'  => 'Custom Image',
				),
				'label'   => 'Custom Button Or Image',
				'weight'  => 91,
			),
			'cta-img-upload'             => array(
				'type'        => 'button',
				'data'        => 'button',
				'id'          => 'cta-upload-img-id',
				'class'       => 'cimage-child',
				'label'       => 'Upload Image',
				'attr'        => array(
					'class' => 'fancy cimage-child',
					'size'  => 7,
				),
				'description' => 'Upload Image for CTA',
				'weight'      => 92,
			),
			'cta-custom-img-url'         => array(
				'type'        => 'hidden',
				'data'        => 'string',
				'value'       => false,
				'label'       => 'CTA custom img URL',
				'description' => 'CTA custom img URL',
				'weight'      => 92,
			),
			'cta-css-height'             => array(
				'type'        => 'text',
				'data'        => 'string',
				'attr'        => array(
					'class' => 'text cimage-child',
					'size'  => 2,
				),
				'value'       => '40',
				'label'       => 'Height',
				'class'       => 'cimage-child',
				'description' => 'Enter height for CTA image in % ',
				'weight'      => 94,
			),
			'cta-css-width'              => array(
				'type'        => 'text',
				'data'        => 'string',
				'attr'        => array(
					'class' => 'text cimage-child',
					'size'  => 2,
				),
				'value'       => '40',
				'label'       => 'Width',
				'class'       => 'cimage-child',
				'description' => 'Enter width for CTA image in % ',
				'weight'      => 94,
			),
			'cta-css-left'               => array(
				'type'        => 'text',
				'data'        => 'string',
				'attr'        => array(
					'class' => 'text cimage-child',
					'size'  => 20,
				),
				'value'       => '70',
				'label'       => 'Left',
				'class'       => 'cimage-child',
				'description' => 'Enter Left position for CTA image in % ',
				'weight'      => 95,
			),
			'cta-css-bottom'             => array(
				'type'        => 'text',
				'data'        => 'string',
				'class'       => 'cimage-child',
				'attr'        => array(
					'class' => 'text cimage-child',
					'size'  => 20,
				),
				'value'       => '1',
				'label'       => 'Bottom',
				'description' => 'Enter Bottom position for CTA image in % ',
				'weight'      => 95,
			),

			'ctaBtnTextFont'             => array(
				'type'   => 'select',
				'data'   => 'string',
				'value'  => 'sans-serif',
				'values' => array(),
				'class'  => 'cbutton-child',
				'attr'   => array(
					'class' => 'fancy cbutton-child',
				),
				'label'  => 'CTA Button Title Font',
				'weight' => 92,
			),
			'ctaBtnFontSize'             => array(
				'name'        => 'ctaBtnFontSize',
				'type'        => 'select',
				'values'      => array(
					'12px' => '12',
					'14px' => '14',
					'16px' => '16',
					'18px' => '18',
					'20px' => '20',
					'22px' => '22',
				),
				'class'       => 'cbutton-child',
				'attr'        => array(
					'class' => 'fancy cbutton-child',
				),
				'value'       => '18',
				'label'       => 'CTA Button Font Size',
				'description' => 'Choose CTA Button font size on the slide',
				'weight'      => 93,
			),
			'cta-position'               => array(
				'name'        => 'cta-position',
				'type'        => 'select',
				'values'      => array(
					'cta-pos-lt' => 'Left-Top',
					'cta-pos-lb' => 'Left-Bottom',
					'cta-pos-rt' => 'Right-Top',
					'cta-pos-rb' => 'Right-Bottom',
					'cta-pos-cc' => 'Center',

				),
				'attr'        => array(
					'class' => 'fancy cbutton-child',
				),
				'value'       => 'cta-pos-rb',
				'class'       => 'cbutton-child',
				'label'       => 'CTA Button Position',
				'description' => 'Choose where to place the CTA Button position on the slide',
				'weight'      => 94,
			),
			'cta-btn-text'               => array(
				'type'        => 'text',
				'data'        => 'string',
				'attr'        => array(
					'class' => 'text fancy cbutton-child',
					'size'  => 20,
				),
				'value'       => 'Read Now',
				'class'       => 'cbutton-child',
				'label'       => 'CTA Button Text',
				'description' => 'Enter text for the CTA Button ',
				'weight'      => 95,
			),

			'cta-btn-color'              => array(
				'type'        => 'text',
				'data'        => 'string',
				'attr'        => array(
					'class' => 'color-picker cbutton-child',
					'size'  => 7,
				),
				'value'       => '#3ea0c1',
				'class'       => 'cbutton-child',
				'label'       => 'CTA Button Color',
				'description' => 'Pick a color for the CTA Button ',
				'weight'      => 95,
			),
			'cta-text-color'             => array(
				'type'        => 'text',
				'data'        => 'string',
				'attr'        => array(
					'class' => 'color-picker cbutton-child',
					'size'  => 7,
				),
				'value'       => '#ffffff',
				'class'       => 'cbutton-child',
				'label'       => 'CTA Button Text Color',
				'description' => 'Pick a color for the CTA Button Text',
				'weight'      => 95,
			),

			'date-format'                => array(
				'type'        => 'select',
				'data'        => 'string',
				'label'       => 'Date Format',
				'value'       => 'timeago',
				'class'       => 'fancy',
				'description' => 'Adjust how the date is shown',
				'weight'      => 40,
			),
			'titleLengthWithImages'      => array(
				'type'        => 'text',
				'data'        => 'integer',
				'attr'        => array(
					'size'      => 3,
					'maxlength' => 3,
				),
				'value'       => 50,
				'class'       => 'fancy',
				'label'       => 'Title Length (with Media)',
				'description' => 'Title length when an image or video is displayed',
				'suffix'      => 'chars',
				'weight'      => 1,
				'interface'   => array(
					'type' => 'slider',
					'min'  => 10,
					'max'  => 100,
					'step' => 5,
				),
			),
			'titleLengthWithoutImages'   => array(
				'type'        => 'text',
				'data'        => 'integer',
				'attr'        => array(
					'size'      => 3,
					'maxlength' => 3,
				),
				'value'       => 35,
				'class'       => 'fancy',
				'label'       => 'Title Length (no Media)',
				'description' => 'Title length when no image or video is displayed',
				'suffix'      => 'chars',
				'weight'      => 2,
				'interface'   => array(
					'type' => 'slider',
					'min'  => 10,
					'max'  => 100,
					'step' => 5,
				),
			),
			'show-title'                 => array(
				'type'   => 'radio',
				'data'   => 'boolean',
				'label'  => 'Show Title',
				'value'  => true,
				'class'  => 'fancy',
				'weight' => 3,
			),
			'linkTitle'                  => array(
				'type'        => 'radio',
				'data'        => 'boolean',
				'value'       => true,
				'class'       => 'fancy',
				'label'       => 'Link Title',
				'description' => 'Choose whether to make the title on each slide clickable',
				'weight'      => 10,
			),
			'excerptLengthWithImages'    => array(
				'type'        => 'text',
				'data'        => 'integer',
				'attr'        => array(
					'size'      => 3,
					'maxlength' => 4,
				),
				'value'       => 100,
				'class'       => 'fancy',
				'label'       => 'Excerpt Length (with Media)',
				'description' => 'Excerpt length when an image or video is displayed',
				'suffix'      => 'chars',
				'weight'      => 20,
				'interface'   => array(
					'type' => 'slider',
					'min'  => 10,
					'max'  => 500,
					'step' => 10,
				),
			),
			'excerptLengthWithoutImages' => array(
				'type'        => 'text',
				'data'        => 'integer',
				'attr'        => array(
					'size'      => 3,
					'maxlength' => 4,
				),
				'value'       => 200,
				'class'       => 'fancy',
				'label'       => 'Excerpt Length (no Media)',
				'description' => 'Excerpt length when no image or video is displayed',
				'suffix'      => 'chars',
				'weight'      => 21,
				'interface'   => array(
					'type' => 'slider',
					'min'  => 10,
					'max'  => 1000,
					'step' => 20,
				),
			),
			'show-excerpt'               => array(
				'type'   => 'radio',
				'data'   => 'boolean',
				'label'  => 'Show Excerpt',
				'value'  => true,
				'class'  => 'fancy',
				'weight' => 22,
			),
			'show-readmore'              => array(
				'type'   => 'radio',
				'data'   => 'boolean',
				'label'  => 'Show Read More',
				'value'  => true,
				'class'  => 'fancy',
				'weight' => 24,
			),
			'linkTarget'                 => array(
				'type'        => 'select',
				'data'        => 'string',
				'value'       => '_blank',
				'class'       => 'fancy',
				'values'      => array(
					'_top'   => 'Same Window',
					'_blank' => 'New Window/Tab',
				),
				'label'       => 'Open links in...',
				'description' => 'This will not be reflected in the preview',
				'weight'      => 50,
			),
		),
		'Navigation' => array(
			'display-nav-arrows' => array(
				'type'        => 'select',
				'data'        => 'string',
				'label'       => 'Show Slide Controls',
				'value'       => 'hover',
				'values'      => array(
					'always' => 'Always',
					'hover'  => 'On Hover',
					'never'  => 'Never',
				),
				'description' => 'Adjust when slide controls are shown to your visitors',
				'weight'      => 1,
			),
			'keys'               => array(
				'type'        => 'radio',
				'data'        => 'boolean',
				'value'       => true,
				'label'       => 'Keyboard Navigation',
				'description' => 'Allow users to use the left and right arrow keys to navigate the SlideDeck',
				'weight'      => 1,
			),
			'scroll'             => array(
				'type'        => 'radio',
				'data'        => 'boolean',
				'value'       => false,
				'label'       => 'Mouse Wheel Navigation',
				'description' => 'Allow users to use the mouse wheel to navigate the SlideDeck',
				'weight'      => 2,
			),
			'touch'              => array(
				'type'        => 'radio',
				'data'        => 'boolean',
				'value'       => false,
				'label'       => 'Touch Navigation',
				'description' => 'Allow users to navigate the SlideDeck by swiping left and right on most touchscreen devices',
				'weight'      => 3,
			),
			'continueScrolling'  => array(
				'type'        => 'hidden',
				'data'        => 'boolean',
				'value'       => false,
				'label'       => 'Continue Scrolling',
				'description' => 'Allow scrolling to the next horizontal slide after scrolling to the last vertical slide',
				'weight'      => 10,
			),
			'touchThreshold'     => array(
				'type'        => 'select',
				'data'        => 'integer',
				'value'       => 100,
				'values'      => array(
					30 => 'Tightest',
					40 => 'Tighter',
					50 => 'Average',
					60 => 'Looser',
					70 => 'Loosest',
				),
				'label'       => 'Touch Sensitivity',
				'description' => 'Adjust how responsive the SlideDeck is to touchscreen gestures',
				'weight'      => 20,
				'interface'   => array(
					'type'     => 'slider',
					'min'      => 30,
					'max'      => 70,
					'minLabel' => 'Tightest',
					'maxLabel' => 'Loosest',
					'step'     => 10,
				),
			),
			'indexType'          => array(
				'type'        => 'hidden',
				'data'        => 'string',
				'label'       => 'Index Type',
				'value'       => 'numbers',
				'values'      => array(
					'hide'       => 'Turn off the indices', // sets javascript index option to boolean(false)
					'numbers'    => '1, 2, 3, 4, 5 etc.', // sets javascript index option to boolean(true)
					'lc-letters' => 'a, b, c, d, e etc.',
					'uc-letters' => 'A, B, C, D, E etc.',
					'lc-roman'   => 'i, ii, iii, iv, v etc.',
					'uc-roman'   => 'I, II, III, IV, V etc.',
				),
				'description' => 'Set the index type for your spines.',
			),
		),
		'Playback'   => array(
			'start'            => array(
				'type'        => 'text',
				'data'        => 'integer',
				'attr'        => array(
					'size'      => 2,
					'maxlength' => 2,
				),
				'value'       => 1,
				'label'       => 'Starting Slide',
				'description' => 'Choose which slide to display first',
				'weight'      => 1,
				'interface'   => array(
					'type' => 'slider',
					'min'  => 1,
				),
			),
			'randomize'        => array(
				'type'   => 'radio',
				'data'   => 'boolean',
				'value'  => false,
				'label'  => 'Randomize Slide Order',
				'weight' => 10,
			),
			'autoPlay'         => array(
				'type'        => 'radio',
				'data'        => 'boolean',
				'value'       => false,
				'label'       => 'Autoplay SlideDeck',
				'description' => 'Set the SlideDeck to begin playing automatically',
				'weight'      => 20,
			),
			'autoPlayInterval' => array(
				'type'        => 'text',
				'data'        => 'float',
				'attr'        => array(
					'size'      => 2,
					'maxlength' => 2,
				),
				'value'       => 5,
				'label'       => 'Autoplay Interval',
				'description' => 'Interval between each slide progression in seconds when autoplaying',
				'suffix'      => 'seconds',
				'weight'      => 21,
				'interface'   => array(
					'type'     => 'slider',
					'min'      => 1,
					'max'      => 10,
					'minLabel' => '1sec',
					'maxLabel' => '10secs',
				),
			),
			'cycle'            => array(
				'type'        => 'radio',
				'data'        => 'boolean',
				'value'       => true,
				'label'       => 'Loop Playback',
				'description' => 'Restart the SlideDeck from the first slide when finished',
				'weight'      => 30,
			),
			'slideTransition'  => array(
				'type'        => 'select',
				'data'        => 'string',
				'values'      => array(
					'stack'          => 'Card Stack',
					'fade'           => 'Cross-fade',
					'flipHorizontal' => 'Flip Horizontal (CSS3)',
					'flip'           => 'Flip Vertical (CSS3)',
					'slide'          => 'Slide',
				),
				'value'       => 'slide',
				'label'       => 'Slide Transition',
				'description' => 'Choose an animation for transitioning between slides (CSS3 transitions may not work well with videos or in all browsers)',
				'subtext'     => 'Not all transitions will work with videos or in older browsers. "Slide" transition is the only working option for vertical navigation.',
				'weight'      => 40,
			),
			'speed'            => array(
				'type'        => 'select',
				'data'        => 'integer',
				'value'       => 750,
				'values'      => array(
					2000 => 'Very Slow',
					1000 => 'Slow',
					750  => 'Moderate',
					500  => 'Fast',
					250  => 'Very Fast',
				),
				'label'       => 'Animation Speed',
				'description' => 'Choose how fast the slide transition should animate',
				'weight'      => 50,
				'interface'   => array(
					'type'     => 'slider',
					'min'      => 250,
					'max'      => 2000,
					'step'     => 250,
					'marks'    => true,
					'minLabel' => '250ms',
					'maxLabel' => '2sec',
				),
			),
			'transition'       => array(
				'type'        => 'select',
				'data'        => 'string',
				'value'       => 'swing',
				'values'      => array(
					'easeOutBounce'  => 'Bounce',
					'easeOutElastic' => 'Elastic',
					'linear'         => 'Linear',
					'swing'          => 'Swing',
					'easeOutSine'    => 'Light Ease',
					'easeOutCirc'    => 'Medium Ease',
					'easeOutExpo'    => 'Heavy Ease',
				),
				'label'       => 'Animation Easing',
				'description' => 'Control the style of the animation',
				'weight'      => 60,
			),
		),
	);


	// Default node set for slides
	protected $slide_node_model = array(
		'title'     => '',
		'styles'    => '',
		'classes'   => array(),
		'content'   => '',
		'thumbnail' => '',
		'source'    => '',
		'type'      => 'textonly',
	);

	var $slide_types = array(
		'image'    => 'Image',         // Image only and mixed image/text
		'html'     => 'HTML',           // Raw HTML
		'textonly' => 'Text Only',   // Text only layouts
		'video'    => 'Video',          // Video slides
	);

	// SlideDecks that are being rendered to the page (to prevent duplicate HTML tag IDs)
	var $rendered_slidedecks        = array();
	var $rendered_slidedeck_iframes = array();

	// Base file path for a source
	var $basedir = '';
	// Base URL for a source
	var $baseurl = '';

	function __construct() {
		add_action( 'admin_init', array( &$this, '_admin_init' ) );
		add_action( 'admin_print_scripts-toplevel_page_' . SLIDEDECK_HOOK, array( &$this, '_admin_print_scripts' ) );
		add_action( 'admin_print_styles-toplevel_page_' . SLIDEDECK_HOOK, array( &$this, '_admin_print_styles' ) );

		// Creation cleanup routine
		add_action( "{$this->namespace}_cleanup_create", array( &$this, 'cleanup_create' ) );

		// Modify the SlideDeck form title according to the type being edited
		add_filter( "{$this->namespace}_form_title", array( &$this, '_slidedeck_form_title' ), 10, 3 );

		add_filter( "{$this->namespace}_default_lens", array( &$this, '_slidedeck_default_lens' ), 10, 3 );
		if ( method_exists( $this, 'slidedeck_default_lens' ) ) {
			add_filter( "{$this->namespace}_default_lens", array( &$this, 'slidedeck_default_lens' ), 11, 3 );
		}

		// Filter lenses down to those available for the content type being viewed
		add_filter( "{$this->namespace}_get_lenses", array( &$this, '_slidedeck_get_lenses' ), 10, 2 );
		if ( method_exists( $this, 'slidedeck_get_lenses' ) ) {
			add_filter( "{$this->namespace}_get_lenses", array( &$this, 'slidedeck_get_lenses' ), 11, 2 );
		}

		// Filter lenses down to those available for the content type being viewed
		if ( method_exists( $this, 'slidedeck_get_slides' ) ) {
			add_filter( "{$this->namespace}_get_slides", array( &$this, 'slidedeck_get_slides' ), 10, 2 );
		}

		// Update options_model for default and for sub-classes
		add_filter( "{$this->namespace}_options_model", array( &$this, '_slidedeck_options_model' ), 10, 2 );
		if ( method_exists( $this, 'slidedeck_options_model' ) ) {
			add_filter( "{$this->namespace}_options_model", array( &$this, 'slidedeck_options_model' ), 11, 2 );
		}

		// Define the basedir value for the source
		if ( method_exists( $this, 'slidedeck_get_source_file_basedir' ) ) {
			add_filter( "{$this->namespace}_get_source_file_basedir", array( &$this, 'slidedeck_get_source_file_basedir' ), 10, 2 );
		}

		// Define the baseurl value for the source
		if ( method_exists( $this, 'slidedeck_get_source_file_baseurl' ) ) {
			add_filter( "{$this->namespace}_get_source_file_baseurl", array( &$this, 'slidedeck_get_source_file_baseurl' ), 10, 2 );
		}

		// Update the default options for sub-classes
		add_filter( "{$this->namespace}_default_options", array( &$this, '_slidedeck_default_options' ), 10, 4 );
		if ( method_exists( $this, 'slidedeck_default_options' ) ) {
			add_filter( "{$this->namespace}_default_options", array( &$this, 'slidedeck_default_options' ), 11, 4 );
		}

		// Frame classes
		add_filter( "{$this->namespace}_frame_classes", array( &$this, '_slidedeck_frame_classes' ), 10, 2 );

		if ( method_exists( $this, 'add_hooks' ) ) {
			$this->add_hooks();
		}
	}

	/**
	 * WordPress admin_print_scripts hook-in
	 *
	 * @uses wp_enqueue_script()
	 */
	final public function _admin_print_scripts() {
		global $SlideDeckPlugin;

		if ( $this->is_valid( $this->current_source ) ) {
			wp_enqueue_script( "slidedeck-deck-{$this->name}-admin" );
			$SlideDeckPlugin->loadedSources[] = $this->name;
		}
	}

	/**
	 * WordPress admin_print_styles hook-in
	 *
	 * @uses wp_enqueue_style()
	 */
	final public function _admin_print_styles() {
		global $SlideDeckPlugin;

		if ( $this->is_valid( $this->current_source ) ) {
			wp_enqueue_style( "slidedeck-deck-{$this->name}-admin" );
			$SlideDeckPlugin->loadedSources[] = $this->name;
		}
	}

	private function _sort_by_slidedeck_source_asc( $a, $b ) {
		return ( $a['source'] > $b['source'] );
	}

	private function _sort_by_slidedeck_source_desc( $a, $b ) {
		return ( $a['source'] < $b['source'] );
	}

	private function _sort_by_time( $a, $b ) {
		$a_timestamp = is_numeric( $a['created_at'] ) ? (int) $a['created_at'] : strtotime( $a['created_at'] );
		$b_timestamp = is_numeric( $b['created_at'] ) ? (int) $b['created_at'] : strtotime( $b['created_at'] );

		return ( $a_timestamp < $b_timestamp );
	}

	private function _type_fix( $val, $type ) {
		switch ( $type ) {
			case 'boolean':
				$val = (bool) ( in_array( $val, array( '1', 'true' ) ) ? true : false );
				break;

			case 'float':
				$val = (float) floatval( $val );
				break;

			case 'integer':
				$val = (int) intval( $val );
				break;

			case 'string':
			default:
				$val = (string) $val;
				break;
		}

		return $val;
	}

	/**
	 * WordPress init action hook-in
	 *
	 * @uses add_action()
	 */
	function _admin_init() {
		global $SlideDeckPlugin;

		// Get the type based off the source in the URL
		if ( isset( $_REQUEST['source'] ) ) {
			$this->current_source = array( $_REQUEST['source'] );
		}
		// If that isn't present, try and look up the one associated with the SlideDeck
		elseif ( isset( $_REQUEST['slidedeck'] ) ) {
			$slidedeck            = $this->get( $_REQUEST['slidedeck'] );
			$this->current_source = $slidedeck['source'];
		}

		$this->register_scripts();
		$this->register_styles();
	}

	/**
	 * Get the cache busting increment
	 *
	 * @uses get_option()
	 *
	 * @return int
	 */
	private function _cache_get_buster() {
		$cache_buster = get_option( $this->namespace . '-cache-buster', 1 );

		return $cache_buster;
	}

	/**
	 * Increment the cache buster
	 *
	 * @uses SlideDeck::_cache_get_buster()
	 * @uses update_option()
	 */
	private function _cache_increment_buster() {
		$cache_buster = $this->_cache_get_buster();
		$cache_buster++;

		update_option( $this->namespace . '-cache-buster', $cache_buster );
	}

	/**
	 * SlideDeck Default lens hook-in
	 *
	 * Hook for slidedeck_default_lens filter to change the default, starting lens
	 *
	 * @param string $lens The lens slug
	 * @param string $deprecated DEPRECATED SlideDeck type slug (formerly $type), removed in 2.1
	 * @param string $source SlideDeck source slug
	 *
	 * @return string
	 */
	function _slidedeck_default_lens( $lens, $deprecated, $source ) {
		// Only process for sub-classes with a type
		if ( ! isset( $this->name ) ) {
			return $lens;
		}

		// Make sure this is this SlideDeck type
		if ( $this->is_valid( $source ) ) {
			$default_lens = SLIDEDECK_DEFAULT_LENS;

			if ( isset( $this->default_lens ) ) {
				$default_lens = $this->default_lens;
			}

			$lens = $default_lens;
			/**
			 * What follows is a check for a special kind of bug.
			 * If a content source specifies a lens different than the
			 * default, and the lens is not available, we default to the plugin default.
			 */
			// Get all the loaded lenses
			$SlideDeckLens = new SlideDeckLens();
			$lenses        = $SlideDeckLens->get();
			// Get all the loaded lens slugs
			$available_lenses = array();
			foreach ( $lenses as $l ) {
				$available_lenses[] = $l['slug'];
			}
			// If the requested lens isn't available, revert.
			if ( ! in_array( $lens, $available_lenses ) ) {
				$lens = SLIDEDECK_DEFAULT_LENS;
			}
		}
		return $lens;
	}

	/**
	 * SlideDeck Default Options hook-in
	 *
	 * Hook for slidedeck_default_options filter to add additional options for this deck type.
	 * Merges the array of existing options with the new, additional options.
	 *
	 * @param array  $options The SlideDeck Options
	 * @param string $deprecated DEPRECATED SlideDeck type slug (formerly $type), removed in 2.1
	 * @param string $lens The SlideDeck Lens
	 * @param string $sources The SlideDeck source(s)
	 *
	 * @return array
	 */
	function _slidedeck_default_options( $options, $deprecated, $lens, $sources ) {
		if ( ! isset( $this->name ) ) {
			return $options;
		}

		// Make sure this is this SlideDeck type
		if ( $this->is_valid( $sources ) ) {
			if ( isset( $this->options_model ) ) {
				foreach ( $this->options_model as $options_group ) {
					foreach ( $options_group as $name => $option ) {
						if ( isset( $option['value'] ) ) {
							$options[ $name ] = $option['value'];
						}
					}
				}
			}

			if ( isset( $this->default_options ) ) {
				$options = array_merge( $options, $this->default_options );
			}
		}

		return $options;
	}

	/**
	 * Add appropriate classes for this SlideDeck to the SlideDeck frame
	 *
	 * @param array $slidedeck_classes Classes to be applied
	 * @param array $slidedeck The SlideDeck object being rendered
	 *
	 * @return array
	 */
	function _slidedeck_frame_classes( $slidedeck_classes, $slidedeck ) {
		if ( ! isset( $this->name ) || $this->is_valid( $slidedeck['source'] ) ) {
			foreach ( $this->options_model as $options_group => $options ) {
				foreach ( $options as $name => $properties ) {
					if ( preg_match( '/^(hide|show)/', $name ) ) {
						if ( $slidedeck['options'][ $name ] == true ) {
							$slidedeck_classes[] = $this->prefix . $name;
						}
					}
				}
			}
		}

		$slidedeck_classes[] = 'date-format-' . $slidedeck['options']['date-format'];

		if ( $slidedeck['options']['hyphenate'] == true ) {
			$slidedeck_classes[] = $this->prefix . 'hyphenate';
		}

		return $slidedeck_classes;
	}

	/**
	 * Hook into slidedeck_form_title filter
	 *
	 * Checks if the SlideDeck type being edited matches the sub-class type and updates
	 * the form title to reflect the current type being edited.
	 *
	 * @param string $form_title The form title
	 * @param array  $slidedeck The SlideDeck object
	 * @param string $form_action The action being performed (create|edit)
	 *
	 * @return string
	 */
	function _slidedeck_form_title( $form_title, $slidedeck, $form_action ) {
		if ( $this->is_valid( $slidedeck['source'] ) ) {
			switch ( $form_action ) {
				case 'create':
					$form_title = "Create {$this->label} SlideDeck";
					break;

				case 'edit':
					$form_title = "Edit {$this->label} SlideDeck";
					break;
			}
		}

		return $form_title;
	}

	/**
	 * SlideDeck Lens lookup filter hook-in
	 *
	 * Filters down list of lenses to only those of the particular type SlideDeck type being viewed.
	 * If a user requested a specific lens, this just returns the $lenses array un-modified.
	 *
	 * @param array  $lenses The lenses loaded initially
	 * @param string $slug A slug requested by the user (if any was requested)
	 *
	 * @global $SlideDeckPlugin
	 *
	 * @uses SlideDeckPlugin::is_plugin()
	 */
	function _slidedeck_get_lenses( $lenses, $slug ) {
		global $SlideDeckPlugin;

		if ( ! empty( $slug ) || ! $SlideDeckPlugin->is_plugin() ) {
			return $lenses;
		}

		if ( ! empty( $this->current_source ) ) {
			// Array of filtered lenses
			$filtered = array();

			foreach ( $lenses as $slug => &$lens ) {
				$intersect = array_intersect( $this->current_source, $lens['meta']['sources'] );

				if ( ! empty( $intersect ) ) {
					$filtered[ $slug ] = $lens;
				}
			}

			$lenses = $filtered;
		}

		return $lenses;
	}

	/**
	 * slidedeck_options_model hook-in
	 *
	 * @param array  $options_model The Options Model
	 * @param string $slidedeck The SlideDeck object
	 *
	 * @return array
	 */
	function _slidedeck_options_model( $options_model, $slidedeck ) {
		$slidedeck_fonts = $this->get_fonts( $slidedeck );

		foreach ( (array) $slidedeck_fonts as $key => $font ) {
			$options_model['Appearance']['titleFont']['values'][ $key ]   = $font['label'];
			$options_model['Appearance']['bodyFont']['values'][ $key ]    = $font['label'];
			$options_model['Content']['ctaBtnTextFont']['values'][ $key ] = $font['label'];
		}

		$options_model['Playback']['start']['interface']['max'] = $slidedeck['options']['total_slides'];

		if ( $this->is_valid( $slidedeck['source'] ) ) {
			if ( isset( $this->options_model ) && ! empty( $this->options_model ) ) {
				foreach ( $this->options_model as $options_group => $options ) {
					foreach ( $options as $option_key => $option_params ) {
						// Only merge if this is an override of an existing property
						if ( isset( $options_model[ $options_group ][ $option_key ] ) ) {
							$options_model[ $options_group ][ $option_key ] = array_merge( (array) $options_model[ $options_group ][ $option_key ], $option_params );
						}
						// Else declare the new option model
						else {
							$options_model[ $options_group ][ $option_key ] = $option_params;
						}
					}
				}
			}
		}

		$options_model['Content']['date-format']['values'] = array(
			'none'                       => 'Do not show',
			'timeago'                    => '2 Days Ago',
			'human-readable'             => date( 'F j, Y' ),
			'human-readable-abbreviated' => date( 'M j, Y' ),
			'european'                   => date( 'jS F, Y' ),
			'raw'                        => date( 'm/d/Y' ),
			'raw-eu'                     => date( 'Y/m/d' ),
		);

		return $options_model;
	}

	/**
	 * Add a source to a SlideDeck
	 *
	 * Adds a source to the SlideDeck and returns the updated array of sources
	 *
	 * @param int    $slidedeck_id SlideDeck ID
	 * @param string $source SlideDeck content source to add
	 *
	 * @uses add_post_meta()
	 * @uses SlideDeck::get()
	 * @uses SlideDeck::get_sources()
	 *
	 * @return array
	 */
	function add_source( $slidedeck_id, $source ) {
		$sources = $this->get_sources( $slidedeck_id );

		if ( ! in_array( $source, $sources ) ) {
			add_post_meta( $slidedeck_id, "{$this->namespace}_source", $source );
		}

		// Get the updated array of sources
		$sources = $this->get_sources( $slidedeck_id );

		return $sources;
	}

	/**
	 * Clean up after create
	 *
	 * Many SlideDeck types create an auto-draft upon click of the creation button. If the
	 * user never saves the SlideDeck, it remains an auto-draft.
	 *
	 * @param integer $slidedeck_id The ID of the SlideDeck to cleanup
	 */
	function cleanup_create( $slidedeck_id ) {
		// Try to find this SlideDeck ID with an auto-draft status
		$slidedeck = $this->get( $slidedeck_id, '', '', 'auto-draft' );

		if ( ! empty( $slidedeck ) ) {
			$this->delete( $slidedeck_id );
		}
	}

	/**
	 * Create a new SlideDeck
	 *
	 * Create a new entry in the database for a SlideDeck and returns an array of the
	 * SlideDeck object.
	 *
	 * @deprecated @param string $deprecated DEPRECATED SlideDeck type slug (formerly $type), removed in 2.1
	 * @param array $source The source for the SlideDeck
	 *
	 * @uses wp_insert_post()
	 * @uses apply_filters
	 * @uses update_post_meta()
	 * @uses SlideDeck::get()
	 * @uses do_action()
	 *
	 * @return array
	 */
	final public function create( $deprecated = '', $source = array() ) {
		$form_action          = 'create';    // Set the form action ( referenced when saving the SlideDeck and for interface appearance )
		$default_slide_amount = 3;    // Set the default amount of slides to start with

		$post_status = apply_filters( "{$this->namespace}_default_create_status", 'auto-draft', $source );

		// Insert a new SlideDeck in the database
		$slidedeck_id = wp_insert_post(
			array(
				'post_content'   => '',
				'post_title'     => SLIDEDECK_NEW_TITLE,
				'post_status'    => $post_status,
				'comment_status' => 'closed',
				'ping_status'    => 'closed',
				'post_type'      => SLIDEDECK_POST_TYPE,
			)
		);

		if ( $post_status == 'auto-draft' ) {
			wp_schedule_single_event( time() + 86400, "{$this->namespace}_cleanup_create", array( $slidedeck_id ) );
		}

		// Set SlideDeck source
		if ( is_array( $source ) ) {
			foreach ( $source as $single_source ) {
				add_post_meta( $slidedeck_id, "{$this->namespace}_source", $single_source );
			}
		}

		// Set default SlideDeck lens
		// $type variable deprecated since 2.1
		$lens = apply_filters( "{$this->namespace}_default_lens", SLIDEDECK_DEFAULT_LENS, '', $source );
		update_post_meta( $slidedeck_id, "{$this->namespace}_lens", $lens );

		// Set SlideDeck options
		// $type variable deprecated since 2.1
		$options = apply_filters( "{$this->namespace}_default_options", $this->default_options(), '', $lens, $source );
		update_post_meta( $slidedeck_id, "{$this->namespace}_options", $options );

		$slidedeck = $this->get( $slidedeck_id, null, null, $post_status );

		// Increment the cache buster
		$this->_cache_increment_buster();

		do_action( "{$this->namespace}_after_create", $slidedeck_id, $slidedeck );

		return $slidedeck;
	}



	/**
	 * Default options for a SlideDeck
	 *
	 * Parses through the option model to create an array of default options in a structure
	 * matching that needed for database storage.
	 *
	 * @return array
	 */
	function default_options() {
		global $SlideDeckPlugin;

		$default_options = array();

		foreach ( array( $SlideDeckPlugin->SlideDeck->options_model, $this->options_model ) as $model ) {
			foreach ( $model as $options_group => $options ) {
				foreach ( $options as $key => $val ) {
					// Process as a regular option
					if ( array_key_exists( 'type', $val ) && isset( $val['value'] ) ) {
						$default_options[ $key ] = $val['value'];
					}
					// Process as an option containing sub-options
					else {
						foreach ( $val as $sub_key => $sub_val ) {
							if ( isset( $sub_val ) && isset( $sub_val['value'] ) && ! empty( $sub_val ) && is_array( $sub_val ) ) {
								$default_options[ $key ][ $sub_key ] = $sub_val['value'];
							}
						}
					}
				}
			}
		}

		return $default_options;
	}

	/**
	 * Delete a SlideDeck
	 *
	 * @param integer $id SlideDeck ID
	 *
	 * @uses SlideDeck::get()
	 * @uses wp_delete_post()
	 * @uses do_action()
	 */
	final public function delete( $id ) {
		$slidedeck = $this->get( $id );
		$source    = $slidedeck['source'];

		// Delete the SlideDeck entry
		wp_delete_post( $id, true );

		// Increment the cache buster
		$this->_cache_increment_buster();

		do_action( "{$this->namespace}_after_delete", $id, $source );
	}

	/**
	 *  function to get slidedeck object from id
	 */

	public function getSlidedeckObject( $id ) {
		return $this->get( $id );
	}

	/**
	 * Delete a source from a SlideDeck
	 *
	 * Deletes a source from the SlideDeck
	 *
	 * @param integer $slidedeck_id SlideDeck ID
	 * @param string  $source Source slug
	 *
	 * @uses delete_post_meta()
	 *
	 * @return boolean
	 */
	function delete_source( $slidedeck_id, $source ) {
		// Get the preview ID assocated with this SlideDeck
		$slidedeck_preview_id = $this->get_preview_id( $slidedeck_id );

		// Delete from the primary ID
		delete_post_meta( $slidedeck_id, "{$this->namespace}_source", $source );
		// Delete from the preview SlideDeck ID
		delete_post_meta( $slidedeck_preview_id, "{$this->namespace}_source", $source );
	}

	/**
	 * Duplicate's a SlideDeck
	 *
	 * Takes the ID of an existing deck and duplicates the
	 * deck along with all the settings.
	 *
	 * @param integer $slidedeck_id Source SlideDeck ID
	 *
	 * @uses SlideDeck::get()
	 * @uses wp_insert_post()
	 * @uses SlideDeck::save()
	 *
	 * @return array
	 */
	final public function duplicate_slidedeck( $slidedeck_id ) {
		global $wpdb;

		$slidedeck          = $this->get( $slidedeck_id );
		$slidedeck['title'] = $slidedeck['title'] . ' Copy';

		$post_args         = array(
			'post_status' => 'publish',
			'post_type'   => SLIDEDECK_POST_TYPE,
			'post_title'  => $slidedeck['title'],
		);
		$slidedeck_copy_id = wp_insert_post( $post_args );

		$get_post_meta_sql   = "SELECT * FROM {$wpdb->postmeta} WHERE post_id = %d";
		$slidedeck_postmetas = $wpdb->get_results( $wpdb->prepare( $get_post_meta_sql, $slidedeck_id ) );
		foreach ( $slidedeck_postmetas as $slidedeck_postmeta ) {
			add_post_meta( $slidedeck_copy_id, $slidedeck_postmeta->meta_key, maybe_unserialize( $slidedeck_postmeta->meta_value ) );
		}

		// Increment the cache buster
		$this->_cache_increment_buster();

		do_action( "{$this->namespace}_duplicate_slidedeck", $slidedeck_id, $slidedeck_copy_id );

		return $slidedeck;
	}

	/**
	 * Fetches and sorts the slides
	 */
	function fetch_and_sort_slides( $slidedeck ) {
		// Hook in for any SlideDeck type to control the slide output
		$slides = apply_filters( "{$this->namespace}_get_slides", array(), $slidedeck );

		if ( $slidedeck['options']['randomize'] == true ) {
			shuffle( $slides );
		} else {
			/**
			 * Only sort the SlideDeck by time if this is not a Custom SlideDeck
			 * Also, if there's more than one source, we have to sort it by time. If there's
			 * only one source, then we should do no sorting.
			 */
			if ( ! in_array( 'custom', $slidedeck['source'] ) && ( count( $slidedeck['source'] ) > 1 ) ) {
				usort( $slides, array( &$this, '_sort_by_time' ) );
			}
		}

		$slides = apply_filters( "{$this->namespace}_after_sort", $slides, $slidedeck );

		$total_slides = $slidedeck['options']['total_slides'];
		if ( in_array( 'custom', $slidedeck['source'] ) ) {
			$total_slides = 9999;
		}

		// Filter hook in to override total slide count
		$total_slides = apply_filters( "{$this->namespace}_total_slides", $total_slides, $slidedeck );

		// Truncate the slides down to the limit the user specified
		$slides = array_slice( $slides, 0, $total_slides );

		return $slides;
	}

	/**
	 * Convenience method for loading SlideDecks
	 *
	 * Returns a SlideDeck object if a single SlideDeck was requested or an array of SlideDecks
	 * if no ID or an array of IDs were passed. If no SlideDecks are found, returns an empty
	 * array.
	 *
	 * @param int    $id ID of the SlideDeck to retrieve
	 * @param string $orderby The optional (defaults to "title") column to order by (directly correlates to the orderby option of WP_Query)
	 * @param string $order The optional (defaults to "ASC") direction to order (directly correlates to the order option of WP_Query)
	 * @param string $post_status The option status of the post
	 *
	 * @uses WP_Query
	 * @uses get_option()
	 * @uses get_post_meta()
	 * @uses get_the_title()
	 *
	 * @return object
	 */
	final public function get( $id = null, $orderby = 'post_title', $order = 'ASC', $post_status = 'any', $search = '' ) {
		global $wpdb,$slidedeck_global_settings;

		$sql = $wpdb->prepare( "SELECT {$wpdb->posts}.* FROM $wpdb->posts WHERE 1=1 AND ({$wpdb->posts}.post_type = %s OR {$wpdb->posts}.post_type = %s)", SLIDEDECK2_POST_TYPE, SLIDEDECK_POST_TYPE );

		if ( isset( $id ) ) {
			$sql .= " AND {$wpdb->posts}.ID";
			if ( is_array( $id ) ) {
				// Make sure all IDs are numeric
				array_map( 'intval', $id );

				$sql .= ' IN(' . join( ',', $id ) . ')';
			} else {
				$sql = $wpdb->prepare( $sql . ' = %d', $id );
			}
		}

		/*
		 * Add search parameter in query with regular expression
		 */
		if ( ! '' == $search ) {
			$search = str_replace( '  ', ' ', $search );
			$sql    = $wpdb->prepare( $sql . " AND {$wpdb->posts}.post_title  LIKE %s", '%%' . trim( $search ) . '%%' );
		}

		if ( ! empty( $post_status ) ) {
			if ( is_array( $post_status ) ) {
				foreach ( $post_status as &$post_stat ) {
					$post_stat = "'" . addslashes( $post_stat ) . "'";
				}

				$post_status = implode( ',', $post_status );

				// sprintf() used to combing SQL and values because wpdb::prepare() quotes %s values
				$sql = $wpdb->prepare( $sql . sprintf( " AND {$wpdb->posts}.post_status IN(%s)", $post_status ) );
			} else {
				// Allow querying without specifying post_status filtering
				if ( $post_status != 'any' ) {
					$sql = $wpdb->prepare( $sql . " AND {$wpdb->posts}.post_status = %s", $post_status );
				}
			}
		}

		if ( isset( $orderby ) && ! empty( $orderby ) && isset( $order ) && ! empty( $order ) ) {
			if ( $orderby != 'slidedeck_source' ) {
				$sql .= " ORDER BY $orderby $order";
			}
		}

		$cache_key = $this->namespace . '--' . md5( __METHOD__ . $sql );
		// For group selections of SlideDecks, add the cache buster incremement
		if ( ! isset( $id ) ) {
			$cache_key .= '-' . $this->_cache_get_buster();
		}

		$slidedecks = wp_cache_get( $cache_key, slidedeck_cache_group( 'get' ) );

		if ( $slidedecks == false ) {
			$query_posts = $wpdb->get_results( $sql );

			// Populate the $slidedecks array with SlideDeck entries
			$slidedecks = array();
			foreach ( (array) $query_posts as $post ) {
				$post_id = $post->ID;

				$slidedeck            = array(
					'id'         => $post_id,
					'author'     => $post->post_author,
					'type'       => get_post_meta( $post_id, "{$this->namespace}_type", true ),
					'source'     => $this->get_sources( $post_id ),
					'title'      => get_the_title( $post_id ),
					'lens'       => get_post_meta( $post_id, "{$this->namespace}_lens", true ),
					'created_at' => $post->post_date,
					'updated_at' => $post->post_modified,
				);
				$slidedeck['options'] = $this->get_options( $post_id, '', $slidedeck['lens'], $slidedeck['source'] );

				$slidedecks[]              = $slidedeck;
				$slidedeck_global_settings = $slidedeck;
			}

			wp_cache_set( $cache_key, $slidedecks, slidedeck_cache_group( 'get' ) );
		}

		if ( $orderby == 'slidedeck_source' ) {
			usort( $slidedecks, array( &$this, '_sort_by_slidedeck_source_' . strtolower( $order ) ) );
		}

		// If this was a request for a single SlideDeck, only return the requested ID
		if ( isset( $id ) && ! is_array( $id ) ) {
			foreach ( (array) $slidedecks as $slidedeck ) {
				if ( $slidedeck['id'] == $id ) {
					return apply_filters( "{$this->namespace}_after_get", $slidedeck, $id, $orderby, $order, $post_status );
				}
			}
		}

		return $slidedecks;
	}

	/**
	 * Get the closest SlideDeck class for custom dimensions
	 *
	 * @uses apply_filters()
	 *
	 * @return string
	 */
	function get_closest_size( $slidedeck ) {
		global $SlideDeckPlugin;

		if ( $slidedeck['options']['size'] != 'custom' ) {
			return $slidedeck['options']['size'];
		}

		$width  = $slidedeck['options']['width'];
		$height = $slidedeck['options']['height'];

		$sizes                = apply_filters( 'slidedeck_sizes', $SlideDeckPlugin->sizes, $slidedeck );
		$previous_width_delta = 99999;
		foreach ( $sizes as $size => $properties ) {
			// Ignore the "custom" size since this is what we're trying to accommodate for already
			if ( $size == 'custom' ) {
				continue;
			}

			// Determine the delta between this "size" and the user specified width
			$width_delta = abs( $properties['width'] - $width );
			// The closest delta gets the size class
			if ( $width_delta < $previous_width_delta ) {
				$previous_width_delta = $width_delta;
				$closest_size         = $size;
			}
		}

		return $closest_size;
	}

	/**
	 * Get SlideDeck dimensions
	 *
	 * @param array   $slidedeck The SlideDeck object
	 * @param integer $override_width Width override
	 * @param integer $override_height Height override
	 *
	 * @global $SlideDeckPlugin
	 *
	 * @uses apply_filters()
	 * @uses do_action_ref_array()
	 *
	 * @return array
	 */
	function get_dimensions( $slidedeck, $override_width = false, $override_height = false ) {
		global $SlideDeckPlugin;

		$sizes  = apply_filters( "{$this->namespace}_sizes", $SlideDeckPlugin->sizes, $slidedeck );
		$width  = ( $slidedeck['options']['size'] != 'custom' ? $sizes[ $slidedeck['options']['size'] ]['width'] : $slidedeck['options']['width'] );
		$height = ( ! in_array( $slidedeck['options']['size'], array( 'fullwidth', 'box', 'custom' ) ) ? $sizes[ $slidedeck['options']['size'] ]['height'] : $slidedeck['options']['height'] );
		// Allow for override of dimensions from the $styles option
		if ( $override_width ) {
			$width = $override_width;
		}
		if ( $override_height ) {
			$height = $override_height;
		}

		$outer_width  = $width;
		$outer_height = $height;

		do_action_ref_array( "{$this->namespace}_dimensions", array( &$width, &$height, &$outer_width, &$outer_height, &$slidedeck ) );

		$dimensions = array(
			'width'        => $width,
			'height'       => $height,
			'outer_width'  => $outer_width,
			'outer_height' => $outer_height,
		);
		return $dimensions;
	}

	/**
	 * Get a SlideDeck's parent ID
	 *
	 * Returns the top-most parent of the SlideDeck ID requested. If the ID requested is the top-most
	 * parent, it returns that ID, otherwise, it looks up the parent ID and returns that.
	 *
	 * @param integer $slidedeck_id The SlideDeck ID
	 *
	 * @global $wpdb
	 *
	 * @uses wpdb::get_row()
	 * @uses wpdb::prepare()
	 * @uses wp_get_cache()
	 * @uses wp_set_cache()
	 *
	 * @return integer
	 */
	function get_parent_id( $slidedeck_id ) {
		global $wpdb;

		$sql = $wpdb->prepare( "SELECT * FROM {$wpdb->posts} WHERE {$wpdb->posts}.ID = %d", $slidedeck_id );

		$cache_key = $this->namespace . '--' . md5( $sql );

		$parent_id = wp_cache_get( $cache_key, slidedeck_cache_group( 'get-parent-id' ) );

		if ( $parent_id == false ) {
			$row = $wpdb->get_row( $sql );

			// Get the post_parent column by default
			$parent_id = $row->post_parent;

			// If the parent ID is 0, this is the top-most parent, return the ID instead
			if ( $parent_id == 0 ) {
				$parent_id = $row->ID;
			}

			wp_cache_set( $cache_key, $parent_id, slidedeck_cache_group( 'get-parent-id' ) );
		}

		return $parent_id;
	}

	/**
	 * Get the SlideDeck preview post ID
	 *
	 * Looks up the child post ID of the SlideDeck post entry and returns either
	 * the child post ID or an empty string if not found.
	 *
	 * @param int $slidedeck_id Parent SlideDeck ID
	 *
	 * @global $wpdb
	 *
	 * @uses wpdb::get_var()
	 * @uses wpdb::prepare()
	 *
	 * @return mixed
	 */
	function get_preview_id( $slidedeck_id ) {
		global $wpdb;

		$sql = "SELECT ID FROM {$wpdb->posts} WHERE post_parent = %d AND (post_type = %s OR post_type = %s) AND post_status = %d";

		$post_id = $wpdb->get_var( $wpdb->prepare( $sql, $slidedeck_id, SLIDEDECK2_POST_TYPE, SLIDEDECK_POST_TYPE, 'auto-draft' ) );

		return $post_id;
	}

	/**
	 * Get a SlideDeck's sources
	 *
	 * Looks up all sources associated with a SlideDeck and returns an array of their
	 * source slug names.
	 *
	 * @param integer $slidedeck_id SlideDeck ID
	 *
	 * @return array
	 */
	function get_sources( $slidedeck_id ) {
		$sources = get_post_meta( $slidedeck_id, "{$this->namespace}_source" );

		return $sources;
	}

	/**
	 * Get a file for the source
	 *
	 * Allows for sources to hook into the baseurl filter and apply appropriate source
	 * path properties to get a base url/path and return an array with the appropriate
	 * URL and path data for the file requested within the source's folder.
	 *
	 * @param string $filename File path relative to the source's root folder (ex. /images/thumbnail.png)
	 *
	 * @return array
	 */
	function get_source_file( $filename = '' ) {
		if ( empty( $this->basedir ) ) {
			$this->basedir = apply_filters( "{$this->namespace}_get_source_file_basedir", '', $this->name );
		}

		if ( empty( $this->baseurl ) ) {
			$this->baseurl = apply_filters( "{$this->namespace}_get_source_file_baseurl", '', $this->name );
		}

		$response = array(
			'dir' => untrailingslashit( $this->basedir ) . $filename,
			'url' => untrailingslashit( $this->baseurl ) . $filename,
		);

		return $response;
	}

	/**
	 * Get the title font-stack
	 *
	 * Returns the CSS font-stack for the font-stack key passed in.
	 *
	 * @param string $stack_key The key name for the font-stack to use
	 *
	 * @uses SlideDeck::get_fonts()
	 *
	 * @return string
	 */
	function get_title_font( $slidedeck ) {
		$fonts = $this->get_fonts( $slidedeck );
		$font  = '';
		if ( array_key_exists( $slidedeck['options']['titleFont'], $fonts ) ) {
			$font = $fonts[ $slidedeck['options']['titleFont'] ];
		}

		return $font;
	}

	/**
	 * Get the cta button title font-stack
	 *
	 * Returns the CSS font-stack for the font-stack key passed in.
	 *
	 * @param string $stack_key The key name for the font-stack to use
	 *
	 * @uses SlideDeck::get_fonts()
	 *
	 * @return string
	 */
	function get_ctaBtnText_font( $slidedeck ) {
		$fonts = $this->get_fonts( $slidedeck );
		$font  = '';
		if ( array_key_exists( $slidedeck['options']['ctaBtnTextFont'], $fonts ) ) {
			$font = $fonts[ $slidedeck['options']['ctaBtnTextFont'] ];
		}

		return $font;
	}


	/**
	 * Generate a unique ID for a SlideDeck
	 *
	 * Generates a unique ID string for a SlideDeck for use when being rendered
	 * on a page.
	 *
	 * @param intetger $slidedeck_id SlideDeck ID
	 *
	 * @return string
	 */
	function get_unique_id( $slidedeck_id ) {
		// The unique ID to identify the SlideDeck DL element by
		$slidedeck_unique_id = "SlideDeck-$slidedeck_id";
		if ( isset( $this->rendered_slidedecks[ $slidedeck_id ] ) && $this->rendered_slidedecks[ $slidedeck_id ] > 1 ) {
			$slidedeck_unique_id .= '-' . $this->rendered_slidedecks[ $slidedeck_id ];
		}

		return $slidedeck_unique_id;
	}

	/**
	 * Get Video ID From URL
	 *
	 * @param string $url of a (standard) video from YouTube, Dailymotion or Vimeo
	 *
	 * @return string The ID of the video for the service detected.
	 */
	function get_video_id_from_url( $url ) {

		preg_match( '/(youtube\.com|youtu\.be|vimeo\.com|dailymotion\.com)/i', $url, $matches );
		$domain   = $matches[1];
		$video_id = '';

		switch ( $domain ) {
			case 'youtube.com':
				if ( preg_match( '/^[^v]+v.(.{11}).*/i', $url, $youtube_matches ) ) {
					$video_id = $youtube_matches[1];
				} elseif ( preg_match( '/youtube.com\/user\/(.*)\/(.*)$/i', $url, $youtube_matches ) ) {
					$video_id = $youtube_matches[2];
				}
				break;

			case 'youtu.be':
				if ( preg_match( '/youtu.be\/(.*)$/i', $url, $youtube_matches ) ) {
					$video_id = $youtube_matches[1];
				}
				break;

			case 'vimeo.com':
				preg_match( '/(clip\:)?(\d+).*$/i', $url, $vimeo_matches );
				$video_id = $vimeo_matches[2];
				break;

			case 'dailymotion.com':
				preg_match( '/(.+)\/([0-9a-zA-Z]+)\_?(.*?)/i', $url, $dailymotion_matches );
				$video_id = $dailymotion_matches[2];
				break;
		}

		return $video_id;
	}

	/**
	 * Get video meta from a video source URL
	 *
	 * Parses a video URL and extracts its associated id, service and API meta data
	 *
	 * @param string $url The video source URL
	 *
	 * @uses is_wp_error()
	 * @uses slidedeck_cache_read()
	 * @uses slidedeck_cache_write()
	 * @uses SlideDeck::get_video_provider_slug_from_url()
	 * @uses SlideDeck::get_video_id_from_url()
	 * @uses wp_remote_get()
	 *
	 * @return array
	 */
	function get_video_meta_from_url( $url ) {
		$service  = $this->get_video_provider_slug_from_url( $url );
		$video_id = $this->get_video_id_from_url( $url );

		$video_meta = array(
			'id'      => $video_id,
			'service' => $service,
		);

		// Create a cache key
		$cache_key = "{$this->namespace}-video-meta-{$service}{$video_id}";
		// Attempt to read the cache for the response
		$response = slidedeck_cache_read( $cache_key );
		if ( ! $response ) {
			switch ( $service ) {
				case 'youtube':
					$last_used_youtube_api_key = get_option( $this->namespace . '_last_saved_youtube_api_key' );
					$url                       = 'https://www.googleapis.com/youtube/v3/videos?id=' . $video_id . '&part=snippet&key=' . $last_used_youtube_api_key;
					break;

				case 'vimeo':
					$url = 'http://vimeo.com/api/v2/video/' . $video_id . '.json';
					break;

				case 'dailymotion':
					$url = 'https://api.dailymotion.com/video/' . $video_id . '?fields=id,title,description,views_total,thumbnail_medium_url,thumbnail_large_url,created_time,owner.screenname';
					break;
			}

			$response = wp_remote_get( $url, array( 'sslverify' => false ) );
			// Only update the cache if this is not an error
			if ( ! is_wp_error( $response ) ) {
				slidedeck_cache_write( $cache_key, $response, 30 );
			}
		}

		if ( ! is_wp_error( $response ) ) {
			$response_json = json_decode( $response['body'] );

			if ( ! empty( $response_json ) ) {
				switch ( $service ) {
					case 'youtube':
						if ( isset( $response_json->items[0]->snippet->thumbnails->standard ) ) {
							$video_image = $response_json->items[0]->snippet->thumbnails->standard->url;
						} elseif ( isset( $response_json->items[0]->snippet->thumbnails->high ) ) {
							$video_image = $response_json->items[0]->snippet->thumbnails->high->url;
						} elseif ( isset( $response_json->items[0]->snippet->thumbnails->medium ) ) {
							$video_image = $response_json->items[0]->snippet->thumbnails->medium->url;
						} elseif ( isset( $response_json->items[0]->snippet->thumbnails->default ) ) {
							$video_image = $response_json->items[0]->snippet->thumbnails->default->url;
						}

						$video_meta['title']       = $response_json->items[0]->snippet->title;
						$video_meta['permalink']   = 'http://www.youtube.com/watch?v=' . $video_id;
						$video_meta['description'] = $response_json->items[0]->snippet->description;
						$video_meta['thumbnail']   = $video_image;
						$video_meta['full_image']  = $video_image;
						$video_meta['created_at']  = strtotime( $response_json->items[0]->snippet->publishedAt );

						if ( isset( $response_json->entry->author ) && 0 ) {
							$author                    = reset( $response_json->entry->author );
							$video_meta['author_name'] = $author->name->{'$t'};
							$video_meta['author_url']  = 'http://www.youtube.com/user/' . $author->name->{'$t'};
						}
						break;

					case 'vimeo':
						$video                       = reset( $response_json );
						$video_meta['title']         = $video->title;
						$video_meta['permalink']     = 'http://vimeo.com/' . $video_id;
						$video_meta['description']   = $video->description;
						$video_meta['thumbnail']     = $video->thumbnail_medium;
						$video_meta['full_image']    = $video->thumbnail_large;
						$video_meta['author_name']   = $video->user_name;
						$video_meta['author_url']    = $video->user_url;
						$video_meta['author_avatar'] = $video->user_portrait_small;
						break;

					case 'dailymotion':
						$response_json             = json_decode( $response['body'] );
						$video_meta['created_at']  = $response_json->created_time;
						$video_meta['title']       = $response_json->title;
						$video_meta['permalink']   = 'http://www.dailymotion.com/video/' . $video_id;
						$video_meta['description'] = $response_json->description;
						$video_meta['thumbnail']   = $response_json->thumbnail_medium_url;
						$video_meta['full_image']  = $response_json->thumbnail_large_url;
						$video_meta['author_name'] = @$response_json->{'owner.screenname'};
						$video_meta['author_url']  = 'http://www.dailymotion.com/' . $video_meta['author_name'];
						break;
				}
			}
		}
		return $video_meta;
	}

	/**
	 * Get the body font-stack
	 *
	 * Returns the CSS font-stack for the font-stack key passed in.
	 *
	 * @param string $stack_key The key name for the font-stack to use
	 *
	 * @uses SlideDeck::get_fonts()
	 *
	 * @return string
	 */
	function get_body_font( $slidedeck ) {
		$fonts = $this->get_fonts( $slidedeck );
		$font  = '';
		if ( array_key_exists( $slidedeck['options']['bodyFont'], $fonts ) ) {
			$font = $fonts[ $slidedeck['options']['bodyFont'] ];
		}

		return $font;
	}

	/**
	 * Get all fonts available for use
	 *
	 * Returns a combined array of fonts from the Lens and SlideDeck core
	 *
	 * @param array $slidedeck The SlideDeck object
	 *
	 * @return array
	 */
	function get_fonts( $slidedeck ) {
		global $slidedeck_fonts;

		$fonts = apply_filters( "{$this->namespace}_get_font", $slidedeck_fonts, $slidedeck );

		uksort( $fonts, 'strnatcasecmp' );

		return $fonts;
	}

	/**
	 * Get the options for the SlideDeck
	 *
	 * Gets the options using the default options to fill in the blanks and allows per-deck type
	 * overrides via a filter. Returns a keyed array of options for the SlideDeck.
	 *
	 * @param integer $id The SlideDeck's ID
	 * @deprecated @param string $deprecated DEPRECATED SlideDeck type slug (formerly $type), removed in 2.1
	 * @param string  $source The SlideDeck's source
	 * @param string  $lens The SlideDeck's lens
	 *
	 * @uses get_post_meta()
	 * @uses apply_filters()
	 *
	 * @return array
	 */
	function get_options( $id, $deprecated, $lens, $source ) {
		$cache_key = $this->namespace . '--' . md5( serialize( func_get_args() ) );

		$options = wp_cache_get( $cache_key, slidedeck_cache_group( 'options' ) );

		if ( $options == false ) {
			$stored_options = (array) get_post_meta( $id, "{$this->namespace}_options", true );

			$default_options = apply_filters( "{$this->namespace}_default_options", $this->default_options(), $deprecated, $lens, $source );

			$options = array_merge( (array) $default_options, $stored_options );

			wp_cache_set( $cache_key, $options, slidedeck_cache_group( 'options' ) );
		}

		return $options;
	}

	/**
	 * Get Video Provider Slug From URl
	 *
	 * @param string $url of a (standard) video from YouTube, Dailymotion or Vimeo
	 *
	 * @return string The slug of the video service.
	 */
	function get_video_provider_slug_from_url( $url ) {
		// Return a youtube reference for a youtu.be URL

		if ( preg_match( '/(youtu\.be)/i', $url ) ) {
			return 'youtube';
		}

		// Detect the dotcoms normally.
		preg_match( '/((youtube|vimeo|dailymotion)\.com)/i', $url, $matches );

		// If nothing was detected...
		if ( ! isset( $matches[2] ) ) {
			return 'html5';
		}

		$domain = $matches[2];
		return $domain;
	}

	/**
	 * Get a video's thumbnail
	 *
	 * Extract's a video's ID and provider from the URL and retrieves the URL for the
	 * thumbnail of the video from its video service's thumbnail service.
	 *
	 * @param string $video_url The URL of the video being queried
	 *
	 * @uses is_wp_error()
	 * @uses slidedeck_cache_read()
	 * @uses slidedeck_cache_write()
	 * @uses SlideDeck::get_video_id_from_url()
	 * @uses SlideDeck::get_video_provider_slug_from_url()
	 * @uses wp_remote_get()
	 *
	 * @return string
	 */
	function get_video_thumbnail( $video_url ) {

		$video_id       = $this->get_video_id_from_url( $video_url );
		$video_provider = $this->get_video_provider_slug_from_url( $video_url );

		$thumbnail_url = SLIDEDECK_URLPATH . '/images/icon-invalid.png';

		switch ( $video_provider ) {
			case 'youtube':
				$thumbnail_url = 'http://img.youtube.com/vi/' . $video_id . '/2.jpg';
				break;

			case 'dailymotion':
				$thumbnail_url = 'http://www.dailymotion.com/thumbnail/160x120/video/' . $video_id;
				break;

			case 'vimeo':
				// Create a cache key
				$cache_key = 'video-' . $video_provider . $video_id . 'vimeo-thumbs';

				// Attempt to read the cache
				$_thumbnail_url = slidedeck_cache_read( $cache_key );

				// if cache doesn't exist
				if ( ! $_thumbnail_url ) {
					$response = wp_remote_get( 'http://vimeo.com/api/v2/video/' . $video_id . '.json' );
					if ( ! is_wp_error( $response ) ) {
						$response_json = json_decode( $response['body'] );
						$video         = reset( $response_json );
						$thumbnail_url = $video->thumbnail_small;

						// Write the cache
						slidedeck_cache_write( $cache_key, $thumbnail_url, $this->default_options['cache_duration'] );
					}
				}
				break;
		}

		return $thumbnail_url;
	}

	/**
	 * Enqueue video scripts
	 *
	 * Loads video scripts when a SlideDeck contains videos
	 *
	 * @global $SlideDeckPlugin
	 *
	 * @uses wp_enqueue_script()
	 */
	function load_video_scripts() {
		global $SlideDeckPlugin;

		if ( ! $SlideDeckPlugin->only_has_iframe_decks ) {
			wp_enqueue_script( 'froogaloop' );
			wp_enqueue_script( 'youtube-api' );
			wp_enqueue_script( 'dailymotion-api' );
		}

		$SlideDeckPlugin->load_video_scripts = true;
	}

	/**
	 * Register scripts used by Decks
	 *
	 * @uses wp_register_script()
	 */
	function register_scripts() {
		// Fail silently if this is not a sub-class instance
		if ( ! isset( $this->name ) ) {
			return false;
		}

		$pluginPath     = WP_PLUGIN_DIR . '/slidedeck5addons/slidedeck5addons.php';
		$active_plugins = (array) get_option( 'active_plugins', array() );
		if ( in_array( 'slidedeck5addon/slidedeck5addon.php', $active_plugins ) ) {
			$filename = '/../slidedeck5addon/slidedeck-sources/' . $this->name . '/source.js';
		} else {
			$filename = '/../slidedeck-sources/' . $this->name . '/source.js';
		}

		if ( file_exists( SLIDEDECK_DIRNAME . $filename ) ) {
			wp_register_script( "slidedeck-deck-{$this->name}-admin", SLIDEDECK_URLPATH . $filename, array( 'jquery', 'slidedeck-admin', $this->namespace . '-preview' ), SLIDEDECK_VERSION, true );
		}
	}

	/**
	 * Check if this content source should process
	 *
	 * Validates if the content source's name property is in the array of sources being
	 * rendered in this SlideDeck.
	 *
	 * @param array $sources Sources in this SlideDeck
	 *
	 * @return boolean
	 */
	final protected function is_valid( $sources ) {
		$valid = false;

		if ( ! is_array( $sources ) ) {
			$sources = array( $sources );
		}

		if ( isset( $this->name ) ) {
			if ( in_array( $this->name, $sources ) ) {
				$valid = true;
			}
		}

		return $valid;
	}

	/**
	 * Register styles used by Decks
	 *
	 * @uses wp_register_style()
	 */

	function register_styles() {
		// Fail silently if this is not a sub-class instance
		if ( ! isset( $this->name ) ) {
			return false;
		}

		$pluginPath     = WP_PLUGIN_DIR . '/slidedeck5addons/slidedeck5addons.php';
		$active_plugins = (array) get_option( 'active_plugins', array() );
		if ( in_array( 'slidedeck5addon/slidedeck5addon.php', $active_plugins ) ) {
			$filename = '/../slidedeck5addons/slidedeck-sources/' . $this->name . '/source.css';
		} else {
			$filename = '/../slidedeck-sources/' . $this->name . '/source.css';
		}

		if ( file_exists( SLIDEDECK_DIRNAME . $filename ) ) {
			wp_register_style( "slidedeck-deck-{$this->name}-admin", SLIDEDECK_URLPATH . $filename, array( 'slidedeck-admin' ), SLIDEDECK_VERSION, 'screen' );
		}
	}

	/**
	 * Render a SlideDeck
	 *
	 * Builds HTML markup to render a SlideDeck, including supporting lens file assets unless
	 * specifically requested to be excluded.
	 *
	 * @param integer $id The ID of the SlideDeck to render
	 * @param array   $styles Optional array of styles to apply to the SlideDeck element
	 * @param boolean $include_lens_files Optional argument to include lens file output with the SlideDeck HTML
	 * @param boolean $preview Is this a preview?
	 * @param boolean $echo_js Should we echo or include the JavaScript files?
	 * @param integer $start A potential override for the start slide
	 *
	 * @global $SlideDeckPlugin
	 *
	 * @uses SlideDeck::get()
	 * @uses apply_filters()
	 * @uses SlideDeckLens::get()
	 * @uses do_action()
	 *
	 * @return string
	 */
	final public function render( $id, $styles = array(), $include_lens_files = true, $preview = false, $echo_js = false, $start = false, $post = null, $front_page ) {
		global $SlideDeckPlugin;

		$slidedeck = $this->get( $id );

		$override_width  = isset( $styles['width'] ) ? $styles['width'] : false;
		$override_height = isset( $styles['height'] ) ? $styles['height'] : false;

		// Return an empty string if no SlideDeck was found by the requested ID
		if ( empty( $slidedeck ) ) {
			return '';
		}

		$current_lens = isset( $slidedeck['lens'] ) ? $slidedeck['lens'] : false;

		// Increment the use count for a specific SlideDeck
		if ( array_key_exists( $id, $this->rendered_slidedecks ) ) {
			$this->rendered_slidedecks[ $id ]++;
		} else {
			$this->rendered_slidedecks[ $id ] = 1;
		}

		// Classes for the SlideDeck's frame element
		$frame_classes = array(
			'slidedeck-frame',
			'slidedeck_frame',
		);

		$frame_classes[] = "slidedeck-frame-{$id}";
		$frame_classes[] = "lens-{$slidedeck['lens']}";
		$frame_classes[] = "show-overlay-{$slidedeck['options']['overlays']}";
		$frame_classes[] = "display-nav-{$slidedeck['options']['display-nav-arrows']}";
		foreach ( $slidedeck['source'] as $source ) {
			$frame_classes[] = "content-source-{$source}";
		}

		// Add IE classes
		if ( preg_match( '/msie ([\d]+)\./', strtolower( $_SERVER['HTTP_USER_AGENT'] ), $msie_matches ) ) {
			$frame_classes[] = 'msie';
			$frame_classes[] = 'msie-' . $msie_matches[1];
		}

		if ( isset( $slidedeck['options']['overlays_open'] ) ) {
			if ( $slidedeck['options']['overlays_open'] == true ) {
				$frame_classes[] = $this->prefix . 'overlays-open';
			}
		}

		if ( $slidedeck['options']['randomize'] == true ) {
			$frame_classes[] = 'slidedeck-random-slides';
		}

		if ( $override_width || $override_height ) {
			$slidedeck['options']['size']   = 'custom';
			$slidedeck['options']['width']  = $override_width;
			$slidedeck['options']['height'] = $override_height;
		}

		$frame_classes = apply_filters( "{$this->namespace}_frame_classes", $frame_classes, $slidedeck );

		// Uniquify classes for the frame
		$frame_classes = array_unique( $frame_classes );

		$slidedeck_dimensions = $this->get_dimensions( $slidedeck, $override_width, $override_height );
		extract( $slidedeck_dimensions );
		$lens = $SlideDeckPlugin->Lens->get( $slidedeck['lens'] );
		$slug = isset( $lens['slug'] ) ? $lens['slug'] : false;
		if ( $slidedeck['options']['auto_height'] || $slug === 'titles' || $slug === 'polarad' || $slug === 'prime' || $slug === 'parfocal' || $current_lens === 'parallax' || $current_lens === 'tiled' || $current_lens === 'layerpro' || 'carousel' === $current_lens || $slug === 'carousel' || 'testimonial' === $current_lens || 'testimonial' === $slug || 'trifect' === $current_lens || 'trifect' === $slug ) {
			$frame_classes[] = 'slidedeck-auto-height';
			$frame_height    = 'auto';
		} else {
			$frame_height = $outer_height . 'px';
		}

		// In-line styles to apply to the SlideDeck's frame element
		$frame_styles_arr = array();
		if ( isset( $slidedeck['options']['size'] ) && 'box' == $slidedeck['options']['size'] ) {
			$frame_styles_arr['width'] = 'auto';
		} else {
			$frame_styles_arr['width'] = $outer_width . 'px';
		}
		$frame_styles_arr['height'] = $frame_height;

		$frame_styles_arr['max-width'] = '100%';

		$frame_styles_arr = apply_filters( "{$this->namespace}_frame_styles_arr", $frame_styles_arr, $slidedeck );
		$frame_styles_str = '';
		foreach ( $frame_styles_arr as $property => $value ) {
			$frame_styles_str .= "$property:$value;";
		}

		$slidedeck_unique_id = $this->get_unique_id( $slidedeck['id'] );

		// Classes for the SlideDeck's DL element
		$slidedeck_classes = array(
			'slidedeck',
		);

		$slidedeck_classes[] = "slidedeck-{$slidedeck['id']}";
		$slidedeck_classes   = apply_filters( "{$this->namespace}_classes", $slidedeck_classes, $slidedeck );

		// Uniquify classes for the frame
		$slidedeck_classes = array_unique( $slidedeck_classes );
		if ( isset( $slidedeck['options']['size'] ) && 'fullwidth' == $slidedeck['options']['size'] ) {
			if ( 'trifect' === $slidedeck['lens'] || 'testimonial' === $slidedeck['lens'] ) {
				$slidedeck_styles_arr = array_merge(
					$styles,
					array(
						'width'  => $width . 'px',
						'height' => $height . 'px',
					)
				);
				// $slidedeck_styles_arr = array_merge( $styles, array( 'width' => "33% !important", 'height' => $height . "px" ) );
			} else {
				$slidedeck_styles_arr = array_merge(
					$styles,
					array(
						'width'  => '100%',
						'height' => $slidedeck['options']['height'] . 'px',
					)
				);
			}
		} elseif ( isset( $slidedeck['options']['size'] ) && 'box' == $slidedeck['options']['size'] ) {
			$slidedeck_styles_arr = array_merge(
				$styles,
				array(
					'width'  => 'auto',
					'height' => $slidedeck['options']['height'] . 'px',
				)
			);
		} else {
			$slidedeck_styles_arr = array_merge(
				$styles,
				array(
					'width'  => $width . 'px',
					'height' => $height . 'px',
				)
			);
		}
		$slidedeck_styles_arr = apply_filters( "{$this->namespace}_styles_arr", $slidedeck_styles_arr, $slidedeck, $lens );
		$slidedeck_styles_str = '';
		foreach ( (array) $slidedeck_styles_arr as $property => $value ) {
			$slidedeck_styles_str .= "$property:$value;";
		}

		// Default Lazy Load Padding value
		$default_slidedeck_lazy_load_padding = 1;
		$slidedeck_lazy_load_padding         = apply_filters( "{$this->namespace}_lazy_load_padding", $default_slidedeck_lazy_load_padding, $slidedeck );

		if ( isset( $slidedeck['options']['image_protection'] ) && ! empty( $slidedeck['options']['image_protection'] ) ) {
			$slidedeck_image_protection = $slidedeck['options']['image_protection'];
		} else {
			$slidedeck_image_protection = 0;
		}

		$html = '';
		// add container for full width if fullwidth option is set.
		$show_fullwidth = false;

		if ( isset( $slidedeck['options']['size'] ) && 'fullwidth' == $slidedeck['options']['size'] ) {
			$html           = '<div class="slidedeck-fullwidth-wrapper" style="position: relative; width: inherit; height: auto;">';
			$show_fullwidth = true;
		}
		// if thickbox option is set add wrapper div
		elseif ( isset( $slidedeck['options']['show_lightbox'] ) && $slidedeck['options']['show_lightbox'] ) {
			$html = '<div id="' . $slidedeck_unique_id . '-thickbox">';
		}

		if ( isset( $slidedeck['options']['show_thumbnail'] ) && $slidedeck['options']['show_thumbnail'] ) {
			$slidedeck_classes[] = 'has-thumb-nav';
		}
		// apply filter for slidedeck wrapper for particular lens
		$html .= apply_filters( "{$this->namespace}_render_slidedeck_wrapper_before_{$slidedeck['lens']}", '', $slidedeck, $slidedeck_unique_id, $id, $frame_styles_str, $slidedeck_image_protection, $frame_classes, $slidedeck_lazy_load_padding );
		if ( $current_lens === 'parallax' ) {
			/*
			$html .= "<div id='{$slidedeck_unique_id}' class='slidedeck-parallax-null'></div>";
			$html .= "<div id='slidedeck-{$id}' class='slidedeck-parallax sdp-loading' data-sd3-image_protection='". $slidedeck_image_protection ."'>";
			*/
		} elseif ( $current_lens === 'tiled' ) {
			/*
			$html .= "<div id='{$slidedeck_unique_id}' class='slidedeck-tiled-null'></div>";
			$html .= "<div id='slidedeck-{$id}' style='" . $frame_styles_str . "' class='slidedeck-tiled sdt-loading' data-sd3-image_protection='". $slidedeck_image_protection ."'>";
			 * */
		} elseif ( $current_lens === 'layerpro' ) {
			/*
			$html .= "<div id='{$slidedeck_unique_id}' class='slidedeck-layerpro-null'></div>";
			$html .= "<div id='slidedeck-{$id}' style='" . $frame_styles_str . "' class='slidedeck-layerpro sdl-loading' data-sd3-image_protection='". $slidedeck_image_protection ."'>";
			*/
		} else {
			// $html .= '<div id="' . $slidedeck_unique_id . '-frame" class="' . implode( " ", $frame_classes ) . '" style="' . $frame_styles_str . '" data-sd2-lazy-load-padding="' . $slidedeck_lazy_load_padding . '" data-sd3-image_protection="' . $slidedeck_image_protection . '">';
		}

		$html .= apply_filters( "{$this->namespace}_render_slidedeck_before", '', $slidedeck );
		// change layout if lense is fashion
		$new_layout_lenses = array(
			'prime',
			'fashion',
			'parfocal',
			'parallax',
			'tiled',
			'toolkit',
			'layerpro',
		);

		if ( $current_lens === 'parallax' ) {
			$slidedeck_styles_str = '';
		}
		// apply filter for slidedeck wrapper layout for particular lens
		$html .= apply_filters( "{$this->namespace}_render_slidedeck_wrapper_content_before_{$slidedeck['lens']}", '', $slidedeck, $slidedeck_unique_id, $id, $slidedeck_styles_str, $slidedeck_classes );
		if ( in_array( $slidedeck['lens'], $new_layout_lenses ) ) {
			if ( $current_lens === 'parallax' ) {
				// $html .= "<ul id='slidedeck-paralax-lens-{$id}' class='slidedeck-parallax-lens lens-parallax' >";
			} elseif ( $current_lens === 'tiled' ) {
				// $html .= "<ul id='slidedeck-tiled-lens-{$id}'  class='slidedeck-tiled-lens lens-tiled' >";
			} elseif ( $current_lens === 'layerpro' ) {
				// $html .= "<ul id='slidedeck-layerpro-lens-{$id}' style='" . $slidedeck_styles_str . " max-width:100%;' class='slidedeck-layerpro-lens lens-layerpro' >";
			} else {
				// $html .= '<ul id="' . $slidedeck_unique_id . '" class="' . implode( " ", $slidedeck_classes ) . '" style="' . $slidedeck_styles_str . '">';
			}
		} else {
			// $html .= '<dl id="' . $slidedeck_unique_id . '" class="' . implode( " ", $slidedeck_classes ) . '" style="' . $slidedeck_styles_str . '">';
		}

		$slides = $this->fetch_and_sort_slides( $slidedeck );

		$preview_scale_ratio = $outer_width / 650;
		$preview_font_size   = intval( min( $preview_scale_ratio * 1000, 1139 ) ) / 1000;

		// Check for empty content and render a No Content Found image instead
		if ( empty( $slides ) && $preview ) {
			ob_start();
				$namespace = $this->namespace;
				include SLIDEDECK_DIRNAME . '/views/elements/_no-content-found.php';
				$html = ob_get_contents();
			ob_end_clean();

			return $html;
		}

		// boolean(true) to change orientation of SlideDeck to vertical
		$process_as_vertical = apply_filters( "{$this->namespace}_process_as_vertical", false, $slidedeck );

		if ( $process_as_vertical ) {
			$slides = array( array( 'vertical_slides' => $slides ) );
		}

		// Render the actual inner elements of the <dl>
		$html         .= $this->render_dt_and_dd_elements( $slidedeck, $slides, $preview );
				$html .= apply_filters( "{$this->namespace}_render_slidedeck_wrapper_content_after_{$slidedeck['lens']}", '' );
		if ( in_array( $slidedeck['lens'], $new_layout_lenses ) ) {
			// $html.= '</ul>';
			// check if lightbox is on
			if ( ! $show_fullwidth && isset( $slidedeck['options']['show_lightbox'] ) && $slidedeck['options']['show_lightbox'] ) {
				$slidedeck_unique_id  = $this->get_unique_id( $slidedeck['id'] );
				$slidedeck_dimensions = $this->get_dimensions( $slidedeck );
				$width                = $slidedeck_dimensions['outer_width'];
				$height               = (int) $slidedeck_dimensions['outer_height'] + 30;
				$html                .= '<div class="thickbox-link-wrapper"><a class="thickbox" href="TB_inline?width=' . $width . '&amp;height=' . $height . '&amp;inlineId=' . $slidedeck_unique_id . '-thickbox"></a></div>';
			}

			// check if fullscreen option is set
			if ( isset( $slidedeck['options']['show_fullscreen'] ) && $slidedeck['options']['show_fullscreen'] ) {
				$slidedeck_unique_id = $this->get_unique_id( $slidedeck['id'] );
				$html               .= '<div class="fullscreen-wrapper" id="' . $slidedeck_unique_id . '-fullscreen"><a class="fullscreen" href="#"></a></div>';
			}
		} else {
			// $html.= '</dl>';
		}

		$html .= $this->render_overlays( $slidedeck, $slidedeck_unique_id, $post, $front_page );
		$html .= apply_filters( "{$this->namespace}_render_slidedeck_navigation_content_{$slidedeck['lens']}", '' );
		/*
		// Default navigation
		if( 'parfocal' != $slidedeck['lens'] ) {
			$html .= '<a class="deck-navigation horizontal prev" href="#prev-horizontal"><span>Previous</span></a>';
			$html .= '<a class="deck-navigation horizontal next" href="#next-horizontal"><span>Next</span></a>';
			$html .= '<a class="deck-navigation vertical prev" href="#prev-vertical"><span>Previous</span></a>';
			$html .= '<a class="deck-navigation vertical next" href="#next-vertical"><span>Next</span></a>';
		}
		*/
		$html .= apply_filters( "{$this->namespace}_render_slidedeck_after", '', $slidedeck );
		$html .= apply_filters( "{$this->namespace}_render_slidedeck_wrapper_after_{$slidedeck['lens']}", '' );
		// $html.= '</div>';

		// End of fullwidth container if it is.
		if ( ( $show_fullwidth ) || ( 'toolkit' != $slidedeck['lens'] && 'parfocal' != $slidedeck['lens'] && 'parallax' != $slidedeck['lens'] && 'tiled' != $slidedeck['lens'] && 'layerpro' != $slidedeck['lens'] && isset( $slidedeck['options']['show_lightbox'] ) && $slidedeck['options']['show_lightbox'] ) ) {
			$html .= '</div>';
		}

		// Additional JavaScript for rendering vertical slides
		$vertical_properties = array(
			'speed'             => (int) $slidedeck['options']['speed'],
			'scroll'            => $slidedeck['options']['scroll'],
			'continueScrolling' => (bool) $slidedeck['options']['continueScrolling'],
		);
		$vertical_properties = apply_filters( "{$this->namespace}_vertical_properties", $vertical_properties, $slidedeck );

		$vertical_scripts = '.vertical(' . json_encode( $vertical_properties ) . ')';

		// Filter the JavaScript options into an array for JSON output
		$javascript_options = array();
		foreach ( $slidedeck['options'] as $key => &$val ) {
			if ( in_array( $key, array_keys( $this->javascript_options ) ) ) {
				// Make sure that the response is of the appropriate object type
				if ( is_string( $val ) ) {
					$val = $this->_type_fix( $val, $this->javascript_options[ $key ] );
				} elseif ( is_array( $val ) ) {
					foreach ( $val as $_key => &$_val ) {
						$_val = $this->_type_fix( $_val, $this->javascript_options[ $key ][ $_key ] );
					}
				}
				$javascript_options[ $key ] = $val;
			}
		}

		$javascript_options['touchThreshold'] = array(
			'x' => round( ( $javascript_options['touchThreshold'] / 100 ) * $width ),
			'y' => round( ( $javascript_options['touchThreshold'] / 100 ) * $height ),
		);

		switch ( $slidedeck['options']['indexType'] ) {
			case 'lc-letters':
				$javascript_options['index'] = array( 'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z' );
				break;
			case 'uc-letters':
				$javascript_options['index'] = array( 'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z' );
				break;
			case 'lc-roman':
				$javascript_options['index'] = array( 'i', 'ii', 'iii', 'iv', 'v', 'vi', 'vii', 'viii', 'xi', 'x', 'xi', 'xii', 'xiii', 'xiv', 'xv', 'xvi', 'xvii', 'xviii', 'xix', 'xx', 'xxi', 'xxii', 'xxiii', 'xiv', 'xv' );
				break;
			case 'uc-roman':
				$javascript_options['index'] = array( 'I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII', 'IX', 'X', 'XI', 'XII', 'XIII', 'XIV', 'XV', 'XVI', 'XVII', 'XVIII', 'XIX', 'XX', 'XXI', 'XXII', 'XXIII', 'XXIV', 'XXV' );
				break;
			case 'hide':
				$javascript_options['index'] = false;
				break;
			default:
				$javascript_options['index'] = true;
		}

		$javascript_options['scroll'] = $slidedeck['options']['scroll'];

		/**
		 *  Set image scalling to false
		 */

		$javascript_options['image_scaling'] = 'cover';

		/**
		 * Maybe override the start slide
		 */
		if ( $start !== false ) {
			$javascript_options['start'] = $start;
		}

		/**
		 * This will set the startVertical option for a vertical deck
		 */
		if ( $process_as_vertical ) {
			$javascript_options['startVertical'] = $javascript_options['start'];
			$javascript_options['start']         = 1;
		}

		// Multiple autoPlayInterval by 1000 since it is stored as seconds and the JavaScript library expects milliseconds
		$javascript_options['autoPlayInterval'] = $javascript_options['autoPlayInterval'] * 1000;

				// Progress bar
				$javascript_options['progressBar']         = isset( $slidedeck['options']['progressBar'] ) ? $slidedeck['options']['progressBar'] : '';
				$javascript_options['progressBarPosition'] = isset( $slidedeck['options']['progressBarPosition'] ) ? $slidedeck['options']['progressBarPosition'] : '';
				$javascript_options['progressBarColor']    = isset( $slidedeck['options']['progressBarColor'] ) ? $slidedeck['options']['progressBarColor'] : '';

		// auto hide not for lenses

		$skip_auto_height = array( 'o-town', 'classic', 'polarad', 'reporter', 'carousel', 'trifect', 'testimonial' );
		if ( in_array( $lens['slug'], $skip_auto_height ) ) {
			$javascript_options['auto_height'] = false;
		}

		if ( in_array( $slidedeck['lens'], $new_layout_lenses ) ) {
			$javascript_options['fashion'] = true;
		}

		// create a new array for new lens
		$jquery_cycle_options = array();
				// apply filter for slidedeck javascript options related to particular lens
		// for keyboard navigation
		if ( 'parfocal' != $slidedeck['lens'] ) {
			$jquery_cycle_options['keyboard'] = $javascript_options['keys'];
		}

		// for mousewheel event
		if ( 'parfocal' != $slidedeck['lens'] ) {
			$jquery_cycle_options['mousewheel'] = $javascript_options['scroll'];
		}

		// for slide transition
		$jquery_cycle_options['fx'] = isset( $javascript_options['newTransition'] ) ? $javascript_options['newTransition'] : '';

		if ( $slidedeck['lens'] === 'parallax' || $slidedeck['lens'] === 'layerpro' || $slidedeck['lens'] === 'tiled' ) {
			$jquery_cycle_options['fx'] = 'scrollHorz';
		}

		// for slide easing
		$jquery_cycle_options['easing'] = $javascript_options['transition'];

		// assign autoplay
		if ( ! $javascript_options['autoPlay'] ) {
			$jquery_cycle_options['timeout'] = 0;
		} else {
			$jquery_cycle_options['timeout'] = $javascript_options['autoPlayInterval'];
		}
		if ( 'parfocal' == $slidedeck['lens'] ) {
			$jquery_cycle_options['timeout'] = 10000;
		}
		// assign slide selector
		$jquery_cycle_options['slides'] = 'li';

		// assign nav arrows
		// Added slidedeck unique id in navigation class to identify slider navigation.
		if ( 'parfocal' != $slidedeck['lens'] ) {
			$jquery_cycle_options['next'] = '#' . $slidedeck_unique_id . '-frame .deck-navigation.next';
			$jquery_cycle_options['prev'] = '#' . $slidedeck_unique_id . '-frame .deck-navigation.prev';
		}

		// pager template
		if ( 'parfocal' != $slidedeck['lens'] ) {
			$jquery_cycle_options['pager'] = '#' . $slidedeck_unique_id . '-frame #' . $slidedeck['lens'] . '-custom-pager';
		} elseif ( isset( $slidedeck['options']['show_thumbnail'] ) && $slidedeck['options']['show_thumbnail'] ) {
			$jquery_cycle_options['pager'] = '#' . $slidedeck_unique_id . '-frame #' . $slidedeck['lens'] . '-custom-pager';
		}

		// starting slide
		$jquery_cycle_options['startingSlide'] = (int) $javascript_options['start'] - 1;

		// var_dump(json_encode( $jquery_cycle_options ));
		// die;

		if ( isset( $lens['script_url'] ) && ! empty( $lens['script_url'] ) ) {
			if ( isset( $found_lens_path ) && ! empty( $found_lens_path ) ) {
				// if we found the file path of the JavaScript file we were looking for...
				$SlideDeckPlugin->footer_scripts .= '<script type="text/javascript">' . file_get_contents( $lens_path ) . '</script>';
			} else {
				if ( ! isset( $SlideDeckPlugin->lenses_included[ $lens['slug'] ] ) ) {
					$SlideDeckPlugin->footer_scripts .= '<script type="text/javascript" src="' . $lens['script_url'] . '"></script>';
				}
			}
		}
		// add filter for footer scrips for particular lens
		// $SlideDeckPlugin->footer_scripts .=  apply_filters( "{$this->namespace}_render_slidedeck_footer_scripts_{$slidedeck['lens']}", "", $slidedeck_unique_id, $jquery_cycle_options, $javascript_options, $vertical_scripts );
		// Add the JavaScript commands to render the SlideDeck to the footer_scripts variable for rendering in the footer of the page
		if ( $slidedeck['lens'] === 'prime' || $slidedeck['lens'] === 'parfocal' ) {
					$SlideDeckPlugin->footer_scripts .= apply_filters( "{$this->namespace}_render_slidedeck_footer_scripts_{$slidedeck['lens']}", '', $slidedeck_unique_id, $jquery_cycle_options, $javascript_options, $vertical_scripts );
					// $SlideDeckPlugin->footer_scripts .= '<script type="text/javascript">jQuery("#' . $slidedeck_unique_id . '").SlideDeckNew(' . json_encode( $jquery_cycle_options ) . ');</script>';
		} else {
					$SlideDeckPlugin->footer_scripts .= apply_filters( "{$this->namespace}_render_slidedeck_footer_scripts_{$slidedeck['lens']}", '', $slidedeck_unique_id, $jquery_cycle_options, $javascript_options, $vertical_scripts );
			// $SlideDeckPlugin->footer_scripts .= '<script type="text/javascript">jQuery("#' . $slidedeck_unique_id . '").slidedeck( ' . json_encode( $javascript_options ) . ' )' . $vertical_scripts . ';</script>';
		}
		// add filter script for image protection for particular lens
				$SlideDeckPlugin->footer_scripts .= apply_filters( "{$this->namespace}_render_slidedeck_image_protection_{$slidedeck['lens']}", '', $slidedeck_unique_id, $id );
		if ( $slidedeck['lens'] === 'layerpro' || $slidedeck['lens'] === 'parallax' || $slidedeck['lens'] === 'tiled' ) {
			/*
					 $SlideDeckPlugin->footer_scripts .= '<script type="text/javascript">
			jQuery("#slidedeck-'. $id.' img").bind("contextmenu", function(e){
			var defaultImageProtection = jQuery("#slidedeck-' . $id . '").data("sd3-image_protection");
			if(defaultImageProtection == "0")
				return true;
			else
				return false;
			});
			</script>';
			*/
		} else {
			/*
			$SlideDeckPlugin->footer_scripts .= '<script type="text/javascript">
			jQuery("#' . $slidedeck_unique_id . '-frame img").bind("contextmenu", function(e){
			var defaultImageProtection = jQuery("#' . $slidedeck_unique_id . '-frame").data("sd3-image_protection");
			if(defaultImageProtection == "0")
				return true;
			else
				return false;
			});
			</script>';
			*/
		}

		// Add overrides for fonts and accent colors
		$title_font    = $this->get_title_font( $slidedeck );
		$ctaTitle_font = $this->get_ctaBtnText_font( $slidedeck );
		$body_font     = $this->get_body_font( $slidedeck );
		if ( isset( $body_font['stack'] ) ) {
			$SlideDeckPlugin->footer_styles .= '#' . $slidedeck_unique_id . ' {font-family:' . $body_font['stack'] . ';}';
		}
		$SlideDeckPlugin->footer_styles .= '#' . $slidedeck_unique_id . ' .slide-title,#' . $slidedeck_unique_id . '-frame .sd2-custom-title-font,#' . $slidedeck_unique_id . ' .sd2-slide-title{' . ( isset( $title_font['stack'] ) ? 'font-family:' . $title_font['stack'] : '' ) . ( isset( $title_font['weight'] ) ? ';font-weight:' . $title_font['weight'] : '' ) . ';}';
		$SlideDeckPlugin->footer_styles .= '#' . $slidedeck_unique_id . '-frame .accent-color{color:' . $slidedeck['options']['accentColor'] . '}';
		if ( 'parfocal' != $slidedeck['lens'] ) {
			$SlideDeckPlugin->footer_styles .= '#' . $slidedeck_unique_id . '-frame .activeSlide .' . $slidedeck['lens'] . '-nav-num-wrapper{background-color:' . $slidedeck['options']['accentColor'] . '}';
		} else {
			$SlideDeckPlugin->footer_styles .= '#' . $slidedeck_unique_id . '-frame .' . $slidedeck['lens'] . '-cycle-pager.activeSlide{border: 2px solid ' . $slidedeck['options']['accentColor'] . '}';
			$SlideDeckPlugin->footer_styles .= '#' . $slidedeck_unique_id . '-frame .' . $slidedeck['lens'] . '-cycle-pager.activeSlide .parfocal-nav-num{color: ' . $slidedeck['options']['accentColor'] . '}';
		}
		$SlideDeckPlugin->footer_styles .= '#' . $slidedeck_unique_id . '-frame .accent-color-background{background-color:' . $slidedeck['options']['accentColor'] . '}';

		// for dark lense use accent color to body
		if ( $slidedeck['options']['lensVariations'] === 'dark' ) {
			$SlideDeckPlugin->footer_styles .= '#' . $slidedeck_unique_id . '-frame .sd2-content-wrapper{color:' . $slidedeck['options']['accentColor'] . '}';

		}
				// Code to add background color to the navigation arrows
		if ( isset( $slidedeck['options']['arrowStyleColor'] ) ) {

			$sd2_hex = $slidedeck['options']['arrowStyleColor'];
			// convert the hex to rgb values in order to add opacity to the background
			list($sd2_r, $sd2_g, $sd2_b) = sscanf( $sd2_hex, '#%02x%02x%02x' );
			if ( isset( $slidedeck['options']['arrowStyleBackground'] ) && ! empty( $slidedeck['options']['arrowStyleBackground'] ) ) {
				$sd2_arrowStyleColorCSS = 'background:none;';
			} else {
				$sd2_arrowStyleColorCSS = 'background:rgba(' . $sd2_r . ',' . $sd2_g . ',' . $sd2_b . ',0.4);';
			}

			// add css to the bottom
			$SlideDeckPlugin->footer_styles .= '#' . $slidedeck_unique_id . '-frame a.deck-navigation{' . $sd2_arrowStyleColorCSS . '}';
		}

		$SlideDeckPlugin->footer_scripts .= apply_filters( "{$this->namespace}_footer_scripts", '', $slidedeck );
		$SlideDeckPlugin->footer_styles  .= apply_filters( "{$this->namespace}_footer_styles", '', $slidedeck );

		// Process the SlideDeck's lens assets
		$found_lens_path = false;
		if ( ! isset( $SlideDeckPlugin->lenses_included[ $lens['slug'] ] ) && $include_lens_files === true ) {
			$SlideDeckPlugin->lenses_included[ $lens['slug'] ] = true;
			// Enqueue the SlideDeck Lens
			wp_enqueue_style( "{$this->namespace}-lens-{$lens['slug']}" );

			// We try to echo the JS when asked to...
			if ( $echo_js ) {
				preg_match( '#slidedeck.*lens.js#', $lens['script_url'], $matches );
				if ( ! empty( $matches ) ) {
					$partial_path = reset( $matches );
				}
				$lens_path       = WP_PLUGIN_DIR . '/' . $partial_path;
				$found_lens_path = file_exists( $lens_path );
			}
		}
		return $html;
	}

	/**
	 * Renders the contents of the SlideDeck <dl>
	 */
	function render_dt_and_dd_elements( $slidedeck, $slides ) {
		$output = '';

		foreach ( $slides as $slide ) {

			$slide_model = array(
				'title'           => '',
				'styles'          => '',
				'classes'         => array(),
				'vertical_slides' => array(),
				'thumbnail'       => '',
				'type'            => 'textonly',
			);
			$slide       = array_merge( $slide_model, $slide );
			// Only add type and source classes to the horizontal slide if it isn't supposed to be vertical
			if ( empty( $slide['vertical_slides'] ) ) {
				if ( isset( $slide['type'] ) ) {
					$slide['classes'][] = "slide-type-{$slide['type']}";
				}

				if ( isset( $slide['source'] ) ) {
					$slide['classes'][] = "slide-source-{$slide['source']}";
				}
			}
			$slide['classes'][] = 'slide'; // Addding slide class for every slide.

			$slide_title   = apply_filters( "{$this->namespace}_horizontal_spine_title", $slide['title'], $slidedeck, $slide );
			$spine_classes = (array) apply_filters( "{$this->namespace}_horizontal_spine_classes", array(), $slidedeck, $slide );
			$spine_styles  = apply_filters( "{$this->namespace}_horizontal_spine_styles", '', $slidedeck, $slide );
			$slide_id      = isset( $slide['id'] ) ? $slide['id'] : false;

			// change layout if lense is fashion
			$new_layout_lenses = array(
				'prime',
				'fashion',
				'parfocal',
				'parallax',
				'tiled',
				'layerpro',
			);
			// apply filter for rendering dt elements for particular lens
            $output .= apply_filters( "{$this->namespace}_render_dt_and_dd_elements_before_{$slidedeck['lens']}", '', $slidedeck, $slide, $slide_id, $spine_classes, $spine_styles, $slide_title );
			if ( in_array( $slidedeck['lens'], $new_layout_lenses ) ) {
				// enqueue script
				// wp_enqueue_script( 'cycle-all' );
								/*
				if( $slide['type'] == "video" ){
									if( $slidedeck['lens'] === 'layerpro') {
										$output .= '<li itemscope="" itemtype="http://schema.org/VideoObject" class="slide" data-thumbnail-src="' . $slide['thumbnail'] . '" data-slide-id="'.$slide_id.'" >';
									} else {
										$output .= '<li itemscope="" itemtype="http://schema.org/VideoObject" style="' . $slide['styles'] . '" class="' . implode( " ", $slide['classes'] ) . '" data-thumbnail-src="' . $slide['thumbnail'] . '" data-slide-id="'.$slide_id.'" >';
									}

				} else {
					if( $slidedeck['lens'] === 'parallax'  || $slidedeck['lens'] === 'layerpro' || $slidedeck['lens'] === 'tiled'){
						$output .= '<li itemscope="" itemtype="http://schema.org/ImageObject" class="slide" data-thumbnail-src="' . $slide['thumbnail'] . '" data-slide-id="'.$slide_id.'"  >';
					}
					else{
						$output .= '<li itemscope="" itemtype="http://schema.org/ImageObject" style="' . $slide['styles'] . '" class="' . implode( " ", $slide['classes'] ) . '" data-thumbnail-src="' . $slide['thumbnail'] . '" data-slide-id="'.$slide_id.'" >';
					}

				}
							 */

			} else {
							/*
				$output .= "<dt". ( (!empty( $spine_classes ) ) ? ' class="'. implode( " ", $spine_classes ) . '"' :'') . ( (!empty( $spine_styles ) ) ? ' style="'. $spine_styles . '"' :'') .">{$slide_title}</dt>";
				if( $slide['type'] == "video" ){
					$output .= '<dd itemprop="video" itemscope itemtype="http://schema.org/VideoObject" style="' . $slide['styles'] . '" class="' . implode( " ", $slide['classes'] ) . '" data-thumbnail-src="' . $slide['thumbnail'] . '" data-slide-id="'.$slide_id.'" >';
				} else {
					$output .= '<dd itemscope="" itemtype="http://schema.org/ImageObject" style="' . $slide['styles'] . '" class="' . implode( " ", $slide['classes'] ) . '" data-thumbnail-src="' . $slide['thumbnail'] . '" data-slide-id="'.$slide_id.'" >';
				}
								*/
			}
			// Vertical Slides
			if ( ! empty( $slide['vertical_slides'] ) ) {
				$output .= '<dl class="slidesVertical">';
				foreach ( $slide['vertical_slides'] as $vertical_slide ) {
					$vertical_slide              = array_merge( $slide_model, $vertical_slide );
					$vertical_slide['classes'][] = "slide-type-{$vertical_slide['type']}";
					$vertical_slide['classes'][] = "slide-source-{$vertical_slide['source']}";

					$output .= "<dt>{$vertical_slide['title']}</dt>";
					$output .= '<dd style="' . $vertical_slide['styles'] . '" class="' . implode( ' ', $vertical_slide['classes'] ) . '" data-thumbnail-src="' . $vertical_slide['thumbnail'] . '" data-slide-id="' . $slide_id . '" >';
					$output .= apply_filters( 'slidedeck_slide_content', $vertical_slide['content'], $slide, $slidedeck );
					$output .= '</dd>';

					if ( $vertical_slide['type'] == 'video' ) {
						$this->load_video_scripts();
					}
				}
				$output .= '</dl>';
			}
			// Horizontal Slides
			else {
				if ( isset( $slide['content'] ) ) {
					$output .= apply_filters( 'slidedeck_slide_content', $slide['content'], $slide, $slidedeck );
				}
			}

			$output .= apply_filters( "{$this->namespace}_render_dt_and_dd_elements_after_{$slidedeck['lens']}", '' );
			if ( in_array( $slidedeck['lens'], $new_layout_lenses ) ) {

				// $output .= "</li>";
			} else {
				// $output .= "</dd>";
			}

			if ( $slide['type'] == 'video' ) {
				$this->load_video_scripts();
			}
		}
		return $output;
	}

	/**
	 * Generate Overlay HTML
	 *
	 * @param array  $slidedeck The SlideDeck object
	 * @param string $slidedeck_unique_id Unique SlideDeck ID in the DOM
	 *
	 * @global $SlideDeckPlugin
	 *
	 * @return string
	 */
	function render_overlays( $slidedeck, $slidedeck_unique_id, $post, $front_page ) {
		global $SlideDeckPlugin;

		$html  = '<div class="slidedeck-overlays" data-for="' . $slidedeck_unique_id . '">';
		$html .= '<a href="#slidedeck-overlays" class="slidedeck-overlays-showhide">Overlays<span class="open-icon"></span><span class="close-icon"></span></a>';

		$permalink = '';
		if ( isset( $post->ID ) ) {
			$permalink = get_permalink( $post->ID );
		} elseif ( isset( $_REQUEST['post_id'] ) ) {
			$permalink = get_permalink( slidedeck_sanitize( $_REQUEST['post_id'] ) );
		}

		if ( isset( $_REQUEST['front_page'] ) && slidedeck_sanitize( $_REQUEST['front_page'] ) === 'true' ) {
			$front_page = true;
		}

		if ( $front_page ) {
			$permalink = get_home_url();
		}

		$permalink = trailingslashit( $permalink );

		$permalink .= "#$slidedeck_unique_id";
		$tweet_text = 'Check out this SlideDeck!';

		$overlays = array(
			'facebook'   => array(
				'label' => 'Share',
				'link'  => 'http://www.facebook.com/sharer.php?u=' . esc_url( $permalink ) . '&t=' . urlencode( $slidedeck['title'] ),
				'data'  => array(
					'popup-width'  => 659,
					'popup-height' => 592,
				),
			),
			'twitter'    => array(
				'label'      => 'Tweet',
				'link'       => 'https://twitter.com/intent/tweet',
				'url_params' => array(
					'url'     => esc_url( $permalink ),
					'via'     => 'slidedeck',
					'related' => 'slidedeck',
					'text'    => $tweet_text,
				),
				'data'       => array(
					'popup-width'  => 466,
					'popup-height' => 484,
				),
			),
			'googleplus' => array(
				'label' => 'gplus',
				'link'  => 'https://plus.google.com/share?url=' . esc_url( $permalink ),
				'data'  => array(
					'pin-color'    => 'red',
					'pin-shape'    => 'round',
					'popup-width'  => 466,
					'popup-height' => 484,

				),
			),
			'linkedin'   => array(
				'label' => 'Linkedin',
				'link'  => 'https://www.linkedin.com/shareArticle?mini=true&url=' . esc_url( $permalink ) . '&title=' . urlencode( $slidedeck['title'] ),
				'data'  => array(
					'pin-color'    => 'red',
					'pin-shape'    => 'round',
					'popup-width'  => 466,
					'popup-height' => 484,

				),
			),
			// Parameters for pinterest Pin It button
			'pinterest'  => array(
				'label' => 'Pin It',
				'link'  => 'https://www.pinterest.com/pin/create/button/?url=' . esc_url( $permalink ),
				'data'  => array(
					'pin-color' => 'red',
					'pin-shape' => 'round',
				),
			),

		);

		// Get the configured Twitter User
		$twitter_user = $SlideDeckPlugin->get_option( 'twitter_user' );

		// Add the Twitter User as the via argument if it is set
		if ( ! empty( $twitter_user ) ) {
			$overlays['twitter']['url_params']['via'] = $twitter_user;
		}

		// Build the full Twitter intent link
		$overlays['twitter']['link'] .= '?' . http_build_query( $overlays['twitter']['url_params'] );

		$overlays          = apply_filters( "{$this->namespace}_overlays", $overlays, $slidedeck );
		$slidedeck_options = get_post_meta( $slidedeck['id'], 'slidedeck_options', true );
		$html             .= '<span class="slidedeck-overlays-wrapper">';
		$pinit             = 0;
		if ( isset( $slidedeck_options['overlay_pinterest'] ) && $slidedeck_options['overlay_pinterest'] == 1 ) {
			$pinit = 1;
		}
		$html .= '<input type="hidden" id="overlay_pinterest" class = "overlay_pinterest" name="overlay_pinterest" value="' . $pinit . '"/>';
		$i     = 0;
		foreach ( $overlays as $overlay => $overlay_args ) {
			$i++;

			// Additional data parameters for this overlay
			$datas = '';
			// Define data array if it doesn't exist yet
			if ( ! isset( $overlay_args['data'] ) ) {
				$overlay_args['data'] = array();
			}

			// Define at least a type data key
			$overlay_args['data']['type'] = $overlay;

			// Loop through additional data properties to build a string to append to the A tag
			foreach ( $overlay_args['data'] as $data => $val ) {
				$datas .= ' data-' . $data . '="' . $val . '"';
			}
			if ( ( $overlay == 'facebook' && array_key_exists( 'overlay_facebook', $slidedeck['options'] ) && $slidedeck['options']['overlay_facebook'] == 1 ) || ( $overlay == 'twitter' && array_key_exists( 'overlay_twitter', $slidedeck['options'] ) && $slidedeck['options']['overlay_twitter'] == 1 ) || ( $overlay == 'googleplus' && array_key_exists( 'overlay_googleplus', $slidedeck['options'] ) && $slidedeck['options']['overlay_googleplus'] == 1 ) || ( $overlay == 'linkedin' && array_key_exists( 'overlay_linkedin', $slidedeck['options'] ) && $slidedeck['options']['overlay_linkedin'] == 1 ) || ( $overlay == 'pinterest' && array_key_exists( 'overlay_pinterest', $slidedeck['options'] ) && $slidedeck['options']['overlay_pinterest'] == 1 ) ) {

						$html .= '<a href="' . $overlay_args['link'] . '" target="_blank" class="slidedeck-overlay slidedeck-overlay-type-' . $overlay . ' slidedeck-overlay-' . $i . '"' . $datas . '><span class="slidedeck-overlay-logo"></span><span class="slidedeck-overlay-label">' . $overlay_args['label'] . '</span></a>';
			}
		}
			$html .= '</span>';

		$html .= '</div>';
		if ( $pinit == 1 ) {
			$html .= '<script type="text/javascript"   src="//assets.pinterest.com/js/pinit.js"></script>';
		}
		return $html;
	}

	/**
	 * Processor to save SlideDeck data
	 *
	 * @param object $id The ID of the SlideDeck to save
	 * @param object $params The SlideDeck parameters to save, if none are passed, returns false
	 *
	 * @uses wp_verify_nonce()
	 * @uses SlideDeckPlugin::sanitize()
	 * @uses wp_insert_post()
	 * @uses SlideDeckPlugin::load()
	 * @uses SlideDeckPlugin::load_slides()
	 * @uses update_post_meta()
	 *
	 * @return object $slidedeck Updated SlideDeck object
	 */
	final public function save( $id = null, $params = array() ) {
		global $SlideDeckPlugin;

		// Fail silently if not parameters were passed in
		if ( ! isset( $id ) || empty( $params ) ) {
			return false;
		}

		if ( $SlideDeckPlugin->get_option( 'flush_wp_object_cache' ) ) {
			wp_cache_flush();
		}

		// Clean the data for safe storage
		$data = slidedeck_sanitize( $params );

		// What type of SlideDeck is this
		$source = $data['source'];
		// What lens is this SlideDeck using
		$lens = $data['lens'];

		// Third variable referred to the deprecated $type value, removed in 2.1
		do_action( "{$this->namespace}_before_save", $id, $data, '', $source );

		$options_model = apply_filters( "{$this->namespace}_options_model", $this->options_model, $data );
		// Loop through boolean options and set as false if the value was not passed in
		foreach ( $options_model as $options_group => $options ) {
			foreach ( $options as $key => $properties ) {
				if ( ! isset( $properties['data'] ) ) {
					$properties['data'] = 'string';
				}
				if ( ! isset( $data['options'][ $key ] ) && $properties['data'] == 'boolean' ) {
					$data['options'][ $key ] = false;
				}
			}
		}
		if ( 'parfocal' == $data['lens'] && ! in_array( $data['options']['size'], array( 'fullwidth', 'box' ) ) ) {
			$data['options']['size'] = 'box';
		} elseif ( 'pixel' == $data['lens'] ) { // code added to set the fixed width and height for the frame selected
			$data['options']['size'] = 'custom';
			if ( isset( $data['options']['frame'] ) ) {
				switch ( $data['options']['frame'] ) {
					case 'display':
						$data['options']['width']  = '612';
						$data['options']['height'] = '478';
						break;
					case 'laptop':
						$data['options']['width']  = '645';
						$data['options']['height'] = '458';
						break;
					case 'tablet':
						$data['options']['width']  = '500';
						$data['options']['height'] = '681';
						break;
					case 'tablet-land':
						$data['options']['width']  = '842';
						$data['options']['height'] = '600';
						break;
					case 'flat-tablet':
						$data['options']['width']  = '500';
						$data['options']['height'] = '681';
						break;
					case 'flat-tablet-land':
						$data['options']['width']  = '842';
						$data['options']['height'] = '600';
						break;
					case 'phone':
						$data['options']['width']  = '386';
						$data['options']['height'] = '663';
						break;
					case 'phone-land':
						$data['options']['width']  = '666';
						$data['options']['height'] = '329';
						break;
					case 'flat-phone':
						$data['options']['width']  = '386';
						$data['options']['height'] = '663';
						break;
					case 'flat-phone-land':
						$data['options']['width']  = '666';
						$data['options']['height'] = '329';
						break;
				}
			}
		}

		// Properly store the data as the expected option type
		foreach ( $data['options'] as $key => &$val ) {
			foreach ( $options_model as $options_group => $options ) {
				if ( in_array( $key, array_keys( $options ) ) ) {
					// Make sure that the response is of the appropriate object type
					if ( is_string( $val ) ) {
						$data_type = isset( $options[ $key ]['data'] ) ? $options[ $key ]['data'] : 'string';
						$val       = $this->_type_fix( $val, $data_type );
					} elseif ( is_array( $val ) ) {
						foreach ( $val as $_key => &$_val ) {
							$data_type = isset( $options[ $key ][ $_key ]['data'] ) ? $options[ $key ][ $_key ]['data'] : 'string';
							$_val      = $this->_type_fix( $_val, $data_type );
						}
					}
				}
			}
		}

		// Allow filter hook-in to override values based on Deck type
		// Third variable ($type) passed to filter deprecated since 2.1
		$data['options'] = apply_filters( "{$this->namespace}_options", $data['options'], '', $source );

		$post_args = array(
			'ID'           => $id,
			'post_status'  => 'publish',
			'post_content' => '',
			'post_title'   => $data['title'],
		);

		if ( isset( $data['post_status'] ) && ! empty( $data['post_status'] ) ) {
			$post_args['post_status'] = $data['post_status'];
		}

		if ( isset( $data['post_parent'] ) && ! empty( $data['post_parent'] ) ) {
			$post_args['post_parent'] = $data['post_parent'];
		}

		// Save the primary SlideDeck post
		wp_update_post( $post_args );

		// Save the content source of the SlideDeck
		$sources = $this->get_sources( $id );
		foreach ( $data['source'] as $source ) {
			if ( ! in_array( $source, $sources ) ) {
				add_post_meta( $id, "{$this->namespace}_source", $source );
			}
		}

		// Save the lens used by this SlideDeck
		update_post_meta( $id, "{$this->namespace}_lens", $data['lens'] );
		// Save the options for this SlideDeck
		update_post_meta( $id, "{$this->namespace}_options", $data['options'] );

		// Third variable ($type) deprecated since 2.1
		do_action( "{$this->namespace}_after_save", $id, $data, '', $sources );

		// Return the newly saved SlideDeck
		$slidedeck = $this->get( $id );

		return $slidedeck;
	}

	/**
	 * Save a preview auto-draft
	 *
	 * Saves all passed in data for a SlideDeck in a duplicate auto-draft entry
	 * that is used for the preview. If an auto-draft entry already exists for this
	 * SlideDeck, it will be updated otherwise a new auto-draft entry is created.
	 * Returns the auto-draft SlideDeck object.
	 *
	 * @param integer $slidedeck_id Parent SlideDeck ID
	 * @param array   $params Parameters for the SlideDeck (usually $_REQUEST or $_POST)
	 *
	 * @uses SlideDeck::get()
	 * @uses WP_Query()
	 * @uses wp_insert_post()
	 * @uses SlideDeck::save()
	 *
	 * @return array
	 */
	final public function save_preview( $slidedeck_id, $params ) {
		global $wpdb;

		$slidedeck = $this->get( $slidedeck_id );

		$sql                  = "SELECT ID FROM {$wpdb->posts} WHERE post_status = %s AND post_parent = %d AND (post_type = %s OR post_type = %s)";
		$slidedeck_preview_id = $wpdb->get_var( $wpdb->prepare( $sql, 'auto-draft', $slidedeck_id, SLIDEDECK2_POST_TYPE, SLIDEDECK_POST_TYPE ) );

		// Create a new auto-draft to save previews for
		if ( empty( $slidedeck_preview_id ) ) {
			$post_args            = array(
				'post_status' => 'auto-draft',
				'post_parent' => $slidedeck_id,
				'post_type'   => SLIDEDECK_POST_TYPE,
				'post_title'  => $slidedeck['title'] . ' Preview',
			);
			$slidedeck_preview_id = wp_insert_post( $post_args );
		}

		$params['post_status'] = 'auto-draft';
		$params['post_parent'] = $slidedeck_id;

		$slidedeck_preview = $this->save( $slidedeck_preview_id, $params );

		return $slidedeck_preview;
	}
}
