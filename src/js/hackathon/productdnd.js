function changeOrder(productId, neighbourId, ajaxBlockUrl)
{
    new Ajax.Request(ajaxBlockUrl, {
        parameters: {
            productId: productId,
            neighbourId: neighbourId,
            isAjax: 'true',
            form_key: FORM_KEY
        }
    });
}

function processSorting (listId, listTag, ajaxUrl) {
    var productId;
    var listItemId;

    Sortable.create(listId, { tag: listTag,
        onUpdate: function(list) {
            var listSize = list.length;
            var counter = 0;
            list.select('tr').each(function(item) {
                counter++;
                if(item.getAttribute('id') == listItemId) {
                    if (typeof item.next() == 'undefined') {
                        if (listTag == 'tr') {
                            var productId = item.down().next().innerHTML;
                            var neighbourId = item.previous().down().next().innerHTML;
                        } else {
                            var productId = item.getAttribute('id').replace('dnd-item_', '');
                            var neighbourId = item.previous().getAttribute('id').replace('dnd-item_', '');
                        }
                    } else {
                        if (listTag == 'tr') {
                            var productId = item.down().next().innerHTML;
                            var neighbourId = item.next().down().next().innerHTML;
                        } else {
                            var productId = item.getAttribute('id').replace('dnd-item_', '');
                            var neighbourId = item.next().getAttribute('id').replace('dnd-item_', '');
                        }
                    }

                    changeOrder(productId, neighbourId, ajaxUrl);
                    resetListItems(listId, listTag);
                    throw $break;
                }
            })
        },
        onChange: function(item) {
            listItemId = item.getAttribute('id');
        }
    });

}

function resetListItems(listId, listTag) {
    var i = 0;

    $(listId).select(listTag).each(function(item) {
        i++;
        item.setAttribute('id', 'item_' + i);
    });
}