Event.observe(document, "dom:loaded", function (event) {
    hackathondnd = new HackathonDnD($('products-list'), 'li');
});

var HackathonDnD = Class.create({

    /**
     * Initialize class
     *
     * @listContainer: list items container
     */
    initialize: function(listContainer, dndElement) {

        var self = this;
        this.currentItemId = 0;

        if (typeof dndproducts != "undefined" && typeof dndcategory != "undefined") {

            this.productIds = dndproducts.evalJSON();
            this.categoryId = dndcategory;

            // add drag and drop functionality
            Sortable.create(listContainer, { tag: dndElement });

            Sortable.create(listContainer, { tag: dndElement,
                onChange: function(item) {
                    self.currentItemId = item.readAttribute('id').replace('dnd-item_','');
                    console.log(self.currentItemId);
                },

                onUpdate: function(list) {
    console.log(Sortable.sequence(list, '').map());
console.log(self.productIds);
console.log(self.productIds[self.currentItemId]);
                    new Ajax.Request("/magento-1.7.0.2/frontend_productdnd/sort/changeProductPosition/", {
                        method: "post",
                        onLoading: function(){$('activityIndicator').show()},
                        onLoaded: function(){$('activityIndicator').hide()},
                        parameters: {categoryId:self.categoryId,productId:self.currentItemId}
                    });
                }
            });

            this.listContainer = listContainer;

            this.markItems();
            this.handleMouseEvents();
        }


    },

    // add css classes to all list items
    markItems: function() {

        var self = this;
        var counter = 0;

        // add css class
        this.listContainer.select('.item').each(function (item) {
            if (!item.hasClassName('dnd-item')) {
                item.addClassName('dnd-item');
//                item.setAttribute('id','dnd-item_' + self.productIds[counter] + '-' + counter);
                item.setAttribute('id','dnd-item_' + self.productIds[counter]);
                counter++;
//                item.setAttribute('id','dnd-item_' + counter++);
            }
        });
    },

    handleMouseEvents: function() {

        this.listContainer.select('.dnd-item').each(function (item) {
            item.observe('mousedown', function(target) {
                item.addClassName('dnd-active-drag');
            });

            item.observe('mouseup', function(target) {
                item.removeClassName('dnd-active-drag');
            });
        });
    }

});