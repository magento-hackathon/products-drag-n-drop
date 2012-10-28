function changeOrder(categoryId, productId, neighbourId, ajaxBlockUrl, listId, listTag)
{
    var isBackend = typeof FORM_KEY != 'undefined';

    new Ajax.Request(ajaxBlockUrl, {
        parameters: {
            categoryId: categoryId,
            productId: productId,
            neighbourId: neighbourId,
            isAjax: 'true',
            form_key: isBackend ? FORM_KEY : ''
        },
        onSuccess: function(transport) {
            if (isBackend) {
                try {
                    if (transport.responseText.isJSON()) {
                        var response = transport.responseText.evalJSON();
                        if (response.error) {
                            alert(response.message);
                        }
                        if(response.ajaxExpired && response.ajaxRedirect) {
                            setLocation(response.ajaxRedirect);
                        }
                        resetListItems(listId, listTag, response);
                    } else {
                        alert(transport.responseText);
                    }
                }
                catch (e) {
                    alert(transport.responseText);
                }
            }
        }
    });
}

function processSorting (categoryId, listId, listTag, ajaxUrl)
{
    var listItemId;

    Sortable.create(listId, { tag: listTag,
        onUpdate: function(list) {
            var listSize = list.length;
            var counter = 0;
            list.select(listTag).each(function(item) {
                counter++;
                if(item.getAttribute('id') == listItemId) {

                    if(counter == 1) {
                        var delta = 0 - item.getAttribute('id').replace('item_','');
                    } else {
                        var previousItem = item.previous().getAttribute('id').replace('item_','');
                        var delta = previousItem - item.getAttribute('id').replace('item_','');
                    }

                    var productId = getProductId(item, listTag);
                    var neighbourId = getProductId(delta > 0 ? item.previous() : item.next(), listTag);

                    changeOrder(categoryId, productId, neighbourId, ajaxUrl, listId, listTag);
                    resetListItems(listId, listTag);
                    throw $break;
                }
            });
        },
        onChange: function(item) {
            listItemId = item.getAttribute('id');
        }
    });

}

function resetListItems(listId, listTag, newOrder)
{
    var i = 0;
    var changePositions = false;
    if (typeof newOrder == 'object') {
        newOrder = object2array(newOrder);
        changePositions = true;
    }

    $(listId).select(listTag).each(function(item) {
        i++;
        item.setAttribute('id', 'item_' + i);

        if (changePositions && (newId = newOrder[getProductId(item, listTag)])) {
            item.select('input[type=text]').first().setAttribute('value', newId);
       }
    });
}

function getProductId (item, listTag)
{
    if (listTag == 'tr') {
        var productId = item.down().next().innerHTML;
    } else {
        var productId = item.getAttribute('productId');
    }
    return parseInt(productId);
}

function object2array (obj)
{
    var arr = [];
    for (var key in obj) {
        if (obj.hasOwnProperty(key)) {
            arr[key] = obj[key];
        }
    }
    return arr;
}

function resetListItemsFrontend(listId, listTag, dndproducts)
{
    var i = 0;
    var productIds = dndproducts.evalJSON();

    $(listId).select(listTag+'.item').each(function(item) {
        i++;
        item.setAttribute('id', 'item_' + i);
        item.setAttribute('productId', productIds[i - 1]);
        item.addClassName('dnd-item');
    });
}