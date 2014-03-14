document.observe("dom:loaded", function() {
	if ($$('.t3-page-columns .t3-page-column').length > 0) {
			// use default columns
		var columnContainer = $$('.t3-page-columns .t3-page-column');
	} else {
			// use backend layout
		var columnContainer = $$('div.t3-gridContainer .t3-gridCell');
	}

	columnContainer.each(function(container){
		if (container.id !== '' || container.hasClassName('t3-gridCell-unassigned')) {
			return true;
		}

		var column = parseInt(container.className.replace(/.*t3-page-column-(\d*).*/gi, '$1'));
		var dragdropContainer = new Element('div', {id: 'tx_dragdrop_container_' + column});
		dragdropContainer.addClassName('tx_dragdrop_container');

		container.insert(dragdropContainer);

		var contentElements = container.getElementsBySelector('div.t3-page-ce');

			// check for access rights to move content elements
		if (contentElements.length === 0 || contentElements[0].getElementsBySelector('.t3-page-ce-header .t3-page-ce-icons-move').length === 0) {
			return false;
		}

		contentElements.each(function(contentElement){
			if (contentElement.up(0).hasClassName('contentElement')) {
					// multicolum extension is not supported
				contentElement.addClassName('tx_dragdrop_notsupported');
				return true;
			}

			var t3Icon = contentElement.getElementsBySelector('.t3-page-ce-body a span.t3-icon')[0];
			if (t3Icon) {
				var uid = parseInt(t3Icon.title.replace(/.*?id=(\d*).*/g, '$1'));
				contentElement.id = 'tx_dragdrop_element_' + uid;

				var h4 = contentElement.down('h4.t3-page-ce-header');
				var rowHeader = h4.down('div.t3-row-header').cloneNode(true).setStyle({
					position: 'absolute',
					zIndex: 500
				});
				h4.observe('mousedown', function(){ $$('.tx_dragdrop_container').each(function(container){container.addClassName('highlight');}); });
				h4.observe('mouseup', function(){ $$('.tx_dragdrop_container').each(function(container){container.removeClassName('highlight');}); });
				h4.insert({before: rowHeader});

				dragdropContainer.insert(contentElement);
			}
		});
	});

	var tx_dragdrop_containers = $$('div.tx_dragdrop_container');
	tx_dragdrop_containers.each(function(tx_dragdrop_container){
		Sortable.create(tx_dragdrop_container, {
			tag: 'div',
			handle: 't3-page-ce-header',
			containment: tx_dragdrop_containers,
			dropOnEmpty: true,
			onUpdate: function(dragdropContainer) {
				var ajaxID = 'ajaxID=Dragdrop::changeOrderAction&';
				var column = 'col=' + dragdropContainer.id.split('_')[3] + '&';
				var uidOrder = Sortable.serialize(dragdropContainer, {
					name: 'uidOrder'
				});

				new Ajax.Request('/typo3/ajax.php', {
					postBody: ajaxID + column + uidOrder,
					onFailure: function(err) { alert('Error saving content positions (drag & drop)'); }
				});
			}
		});
	});
});