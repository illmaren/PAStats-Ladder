/*
	Halcyonic by HTML5 UP
	html5up.net | @n33co
	Free for personal and commercial use under the CCA 3.0 license (html5up.net/license)
*/

(function($) {

	skel.init({
		reset: 'full',
		breakpoints: {
			'global':	{ range: '*', href: 'http://beta.paladder.com/css/style.css' },
			'desktop':	{ range: '1000-', href: 'http://beta.paladder.com/css/style-desktop.css', containers: 1200, grid: { gutters: 25 } },
			'1000px':	{ range: '1000-1200', href: 'http://beta.paladder.com/css/style-1000px.css', containers: 1000, grid: { gutters: 20 }, viewport: { width: 1080 } },
			'mobile':	{ range: '-1000', href: 'http://beta.paladder.com/css/style-mobile.css', containers: '100%!', grid: { collapse: true, gutters: 20 } }
		},
		plugins: {
			layers: {
				config: {
					mode: 'transform'
				},
				navPanel: {
					hidden: true,
					breakpoints: 'mobile',
					position: 'top-left',
					side: 'left',
					animation: 'pushX',
					width: '80%',
					height: '100%',
					clickToHide: true,
					html: '<div data-action="navList" data-args="nav"></div>',
					orientation: 'vertical'
				},
				titleBar: {
					breakpoints: 'mobile',
					position: 'top-left',
					side: 'top',
					height: 44,
					width: '100%',
					html: '<span class="toggle" data-action="toggleLayer" data-args="navPanel"></span><span class="title" data-action="copyHTML" data-args="logo"></span>'
				}
			}
		}
	});

})(jQuery);