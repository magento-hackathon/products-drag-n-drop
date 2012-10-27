function changeOrder(categoryId, productId, neighbourId, ajaxBlockUrl)
{
    new Ajax.Request(ajaxBlockUrl, {
        parameters: {
            categoryId: categoryId,
            productId: productId,
            neighbourId: neighbourId,
            isAjax: 'true',
            form_key: typeof FORM_KEY != undefined ? FORM_KEY : ''
        }
    });
}

function processSorting (categoryId, listId, listTag, ajaxUrl) {
    var listItemId;

    Sortable.create(listId, { tag: listTag,
        onUpdate: function(list) {
            var listSize = list.length;
            var counter = 0;
            list.select('tr').each(function(item) {
                counter++;
                if(item.getAttribute('id') == listItemId) {

                    if(counter == 1) {
                        var delta = 0 - item.getAttribute('id').replace('item_','');
                    } else {
                        var previousItem = item.previous().getAttribute('id').replace('item_','');
                        var delta = previousItem - item.getAttribute('id').replace('item_','');
                    }

                    if (delta > 0) {
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

                    changeOrder(categoryId, productId, neighbourId, ajaxUrl);
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