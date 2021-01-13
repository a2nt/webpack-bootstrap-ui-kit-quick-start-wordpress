/**
 * File customizer.js.
 *
 * Theme Customizer enhancements for a better user experience.
 *
 * Contains handlers to make Theme Customizer preview reload changes asynchronously.
 */

function myButtonStyleOptions(styleOptions) {
	return [
		{ label: 'Primary', value: 'btn btn-primary' },
		{ label: 'Warning', value: 'btn btn-warning' },
		{ label: 'Danger', value: 'btn btn-danger' },
		{ label: 'Secondary', value: 'btn btn-secondary' },
	];
}
wp.hooks.addFilter(
	'wpBootstrapBlocks.button.styleOptions',
	'myplugin/wp-bootstrap-blocks/button/styleOptions',
	myButtonStyleOptions,
);

/*(function ($) {
	var el = wp.element.createElement;

	wp.blocks.registerBlockType('bootstrap/btbutton', {
		title: 'Button',
		category: 'common', // Under which category the block would appear
		attributes: {
			// The data this block will be storing

			type: { type: 'string', default: 'primary' }, // Notice box type for loading the appropriate CSS class. Default class is 'default'.
			title: { type: 'string' }, // Notice box title in h4 tag
			href: { type: 'string' }, /// Notice box content in p tag
		},

		edit: function (props) {
			function updateTitle(event) {
				props.setAttributes({ title: event.target.value });
			}

			function updateContent(newdata) {
				props.setAttributes({ content: newdata });
			}

			function updateType(event) {
				props.setAttributes({ type: event.target.value });
			}

			return el(
				'a',
				{
					className: 'btn btn-' + props.attributes.type,
					href: props.attributes.href,
				},
				props.attributes.title,
				el(
					'select',
					{
						onChange: updateType,
						value: props.attributes.type,
					},
					el('option', { value: 'primary' }, 'Primary'),
					el('option', { value: 'success' }, 'Success'),
					el('option', { value: 'danger' }, 'Danger'),
				),
				el('input', {
					type: 'text',
					placeholder: 'Enter title here...',
					value: props.attributes.title,
					onChange: updateTitle,
					style: { width: '100%' },
				}),
				el('input', {
					//wp.editor.RichText
					tagName: 'p',
					onChange: updateContent,
					value: props.attributes.content,
					placeholder: 'Enter link here...',
				}),
			);
		},

		save: function (props) {
			// How our block renders on the frontend

			return el(
				'a',
				{
					className: 'btn btn-' + props.attributes.type,
					href: props.attributes.href,
				},
				props.attributes.title,
			);
		},
	});
})(jQuery);
*/
