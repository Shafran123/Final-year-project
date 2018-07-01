/**
 * Sample plugin.
 */
Draw.loadPlugin(function(ui) {

	/**
	 * Basic adds for all backends.
	 */
  	var star = 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAAABHNCSVQICAgIfAhkiAAAAAlwSFlzAAALEgAACxIB0t1+/AAAABx0RVh0U29mdHdhcmUAQWRvYmUgRmlyZXdvcmtzIENTM5jWRgMAAAQRdEVYdFhNTDpjb20uYWRvYmUueG1wADw/eHBhY2tldCBiZWdpbj0iICAgIiBpZD0iVzVNME1wQ2VoaUh6cmVTek5UY3prYzlkIj8+Cjx4OnhtcG1ldGEgeG1sbnM6eD0iYWRvYmU6bnM6bWV0YS8iIHg6eG1wdGs9IkFkb2JlIFhNUCBDb3JlIDQuMS1jMDM0IDQ2LjI3Mjk3NiwgU2F0IEphbiAyNyAyMDA3IDIyOjExOjQxICAgICAgICAiPgogICA8cmRmOlJERiB4bWxuczpyZGY9Imh0dHA6Ly93d3cudzMub3JnLzE5OTkvMDIvMjItcmRmLXN5bnRheC1ucyMiPgogICAgICA8cmRmOkRlc2NyaXB0aW9uIHJkZjphYm91dD0iIgogICAgICAgICAgICB4bWxuczp4YXA9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC8iPgogICAgICAgICA8eGFwOkNyZWF0b3JUb29sPkFkb2JlIEZpcmV3b3JrcyBDUzM8L3hhcDpDcmVhdG9yVG9vbD4KICAgICAgICAgPHhhcDpDcmVhdGVEYXRlPjIwMDgtMDItMTdUMDI6MzY6NDVaPC94YXA6Q3JlYXRlRGF0ZT4KICAgICAgICAgPHhhcDpNb2RpZnlEYXRlPjIwMDktMDMtMTdUMTQ6MTI6MDJaPC94YXA6TW9kaWZ5RGF0ZT4KICAgICAgPC9yZGY6RGVzY3JpcHRpb24+CiAgICAgIDxyZGY6RGVzY3JpcHRpb24gcmRmOmFib3V0PSIiCiAgICAgICAgICAgIHhtbG5zOmRjPSJodHRwOi8vcHVybC5vcmcvZGMvZWxlbWVudHMvMS4xLyI+CiAgICAgICAgIDxkYzpmb3JtYXQ+aW1hZ2UvcG5nPC9kYzpmb3JtYXQ+CiAgICAgIDwvcmRmOkRlc2NyaXB0aW9uPgogICA8L3JkZjpSREY+CjwveDp4bXBtZXRhPgogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIIImu8AAAAAVdEVYdENyZWF0aW9uIFRpbWUAMi8xNy8wOCCcqlgAAAHuSURBVDiNlZJBi1JRGIbfk+fc0ZuMXorJe4XujWoMdREaA23HICj6AQeLINr0C4I27ab27VqOI9+q/sH8gMDceG1RkIwgClEXFMbRc5zTZgZURmG+5fu9PN/7Hg6wZohoh4h21nn4uqXW+q0xZgzg+SrPlTXX73uet+26bp6ICpcGaK1fua57M5vN3tZav7gUgIiSqVTqcRAEm0EQbCaTyQoRXb3Iy4hoG8CT6XSaY4xtMMaSQohMPp8v+r7vAEC3243CMGwqpfoApsaYE8uyfgM45ABOjDEvXdfNlMvlzFINAIDneY7neZVzvdlsDgaDQYtzfsjOIjtKqU+e5+0Wi0V3VV8ACMOw3+/3v3HOX0sp/7K53te11h/S6fRuoVAIhBAL76OUOm2320dRFH0VQuxJKf8BAFu+UKvVvpRKpWe2bYt5fTweq0ajQUKIN1LK43N94SMR0Y1YLLYlhBBKqQUw51wkEol7WmuzoC8FuJtIJLaUUoii6Ljb7f4yxpz6vp9zHMe2bfvacDi8BeDHKkBuNps5rVbr52QyaVuW9ZExttHpdN73ej0/Ho+nADxYCdBaV0aj0RGAz5ZlHUgpx2erR/V6/d1wOHwK4CGA/QsBnPN9AN+llH+WkqFare4R0QGAO/M6M8Ysey81/wGqa8MlVvHPNAAAAABJRU5ErkJggg==';

	var rotate = mxUtils.bind(this, function(elt, html, delay, fn)
	{
		delay = (delay != null) ? delay : 500;
		mxUtils.setPrefixedStyle(elt.style, 'transition', 'all ' + (delay / 1000) + 's ease');
		mxUtils.setPrefixedStyle(elt.style, 'transform', 'scale(0)');
		elt.style.visibility = 'visible';
		elt.style.opacity = '0';
		
		window.setTimeout(function()
		{
			elt.innerHTML = html;
			mxUtils.setPrefixedStyle(elt.style, 'transform', 'scale(1)');
			elt.style.opacity = '1';
			
			if (fn != null)
			{
				fn();
			}
		}, delay);
	});
	
	// Stats for right footer
	var td2 = document.getElementById('geFooterItem1');

	if (td2 != null)
	{
				td2.innerHTML = '<a id="geFooterLink1" title="draw.io for Quip" target="_blank" ' +
						'href="https://appexchange.salesforce.com/appxListingDetail?listingId=a0N3A00000FH8dSUAT">' +
						'<img border="0" width="24" height="24" align="absmiddle" style="padding-right:10px;"' +
						'src="https://www.jgraph.com/assets/img/logo-quip.png"/>Announcing draw.io for Quip</a>';
	}

	// Changes left footer
	var td = document.getElementById('geFooterItem2');
	
	if (td != null && mxClient.IS_SVG)
	{
		var last = [td.innerHTML];
		
		// Restores last message after click
		mxEvent.addListener(td, 'click', function()
		{
			if (last.length > 0)
			{
				rotate(td, last.pop());
			}
		});
		
		// Waits for login with Google account and shows review link
		var userChanged = function()
		{
			var user = ui.drive.getUser();
			
			if (user != null && user.email != null && user.email.substring(user.email.length - 10) != '@gmail.com')
			{
				last.push(td.innerHTML);
				
				window.setTimeout(function()
				{
					rotate(td, '<a title="10pc gsuite discount" href="https://gsuite.seibert-media.net/?utm_source=drawio&utm_medium=footerbutton" target="_blank">' +
						'10% Rabatt auf Google G Suite sichern</a>');
				}, 5000);
			}
		};

		var install = function()
		{
			if (ui.drive != null)
			{
				if (ui.drive.getUser() != null)
				{
					userChanged();
				}
				else
				{
					ui.drive.addListener('userChanged', userChanged);
				}
			}
		};
		
		if (ui.drive != null)
		{
			install();
		}
		else
		{
			ui.addListener('clientLoaded', install);
		}
	}
});
