Event.observe(document, "dom:loaded", function (event) {
//    console.log($$('.category-products').first());
    hackathondnd = new HackathonDnD($$('.category-products').first());
});

var HackathonDnD = Class.create({

    /**
     * Initialize class
     *
     * @listContainer: list items container
     */
    initialize: function(listContainer) {

        console.log(listContainer);
        this.listContainer = listContainer;
        this.markItems();


    },

    // add css classes to all list items
    markItems: function() {

        var self = this;

        // expand section button
        this.listContainer.select('.item').each(function (item) {

            if (!item.hasClassName('dnd-item')) {
                item.addClassName('dnd-item');
            }

//            item.observe('click', function(event) {
//                self.expand(event);
//            });
        });
    }
});